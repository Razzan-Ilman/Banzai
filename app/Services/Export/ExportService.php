<?php

namespace App\Services\Export;

use App\Models\ExportLog;
use App\Jobs\ProcessExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExportService
{
    /**
     * Available export types
     */
    protected array $exportTypes = [
        'users' => \App\Exports\UsersExport::class,
        'attendance' => \App\Exports\AttendanceExport::class,
        'quiz_results' => \App\Exports\QuizResultsExport::class,
        'events' => \App\Exports\EventsExport::class,
        'registrations' => \App\Exports\RegistrationsExport::class,
    ];
    
    /**
     * Queue an export job
     */
    public function queueExport(string $type, array $filters = []): ExportLog
    {
        if (!isset($this->exportTypes[$type])) {
            throw new \InvalidArgumentException("Unknown export type: {$type}");
        }
        
        $exportLog = ExportLog::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'status' => 'pending',
            'filters' => $filters,
        ]);
        
        // Dispatch job
        ProcessExport::dispatch($exportLog);
        
        return $exportLog;
    }
    
    /**
     * Process export synchronously (for small datasets)
     */
    public function processSync(ExportLog $exportLog): ExportLog
    {
        $exportLog->update(['status' => 'processing']);
        
        try {
            $exportClass = $this->exportTypes[$exportLog->type];
            $export = new $exportClass($exportLog->filters);
            
            $filename = $this->generateFilename($exportLog);
            $path = "exports/{$filename}";
            
            $export->store($path, 'local');
            
            $exportLog->update([
                'status' => 'completed',
                'file_path' => $path,
                'completed_at' => now(),
            ]);
        } catch (\Exception $e) {
            $exportLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
        
        return $exportLog->fresh();
    }
    
    /**
     * Generate unique filename for export
     */
    protected function generateFilename(ExportLog $exportLog): string
    {
        $date = now()->format('Y-m-d_His');
        $random = Str::random(8);
        return "{$exportLog->type}_{$date}_{$random}.xlsx";
    }
    
    /**
     * Get export history for current user
     */
    public function getHistory(int $limit = 20)
    {
        return ExportLog::where('user_id', Auth::id())
            ->latest()
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get all exports (admin)
     */
    public function getAllExports(int $perPage = 25)
    {
        return ExportLog::with('user')
            ->latest()
            ->paginate($perPage);
    }
    
    /**
     * Get available export types
     */
    public function getAvailableTypes(): array
    {
        return array_keys($this->exportTypes);
    }
    
    /**
     * Check if export is ready for download
     */
    public function isReady(ExportLog $exportLog): bool
    {
        return $exportLog->status === 'completed' && $exportLog->file_path;
    }
    
    /**
     * Get download path
     */
    public function getDownloadPath(ExportLog $exportLog): ?string
    {
        if (!$this->isReady($exportLog)) {
            return null;
        }
        
        return storage_path("app/{$exportLog->file_path}");
    }
}
