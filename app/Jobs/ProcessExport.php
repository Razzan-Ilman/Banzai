<?php

namespace App\Jobs;

use App\Models\ExportLog;
use App\Services\Export\ExportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 120;
    public int $timeout = 300;

    public function __construct(
        public ExportLog $exportLog
    ) {}

    public function handle(ExportService $service): void
    {
        Log::info("Processing export: ID {$this->exportLog->id}, Type: {$this->exportLog->type}");
        
        $service->processSync($this->exportLog);
        
        Log::info("Export completed: ID {$this->exportLog->id}");
    }
    
    public function failed(\Throwable $exception): void
    {
        $this->exportLog->update([
            'status' => 'failed',
            'error_message' => $exception->getMessage(),
        ]);
        
        Log::error("Export failed: ID {$this->exportLog->id}", [
            'error' => $exception->getMessage(),
        ]);
    }
}
