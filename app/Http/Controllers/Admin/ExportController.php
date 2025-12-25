<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Export\ExportService;
use App\Models\ExportLog;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(
        protected ExportService $exportService
    ) {}

    /**
     * Show export dashboard
     */
    public function index()
    {
        $history = $this->exportService->getHistory(10);
        $types = $this->exportService->getAvailableTypes();
        
        return view('admin.exports.index', [
            'history' => $history,
            'types' => $types,
        ]);
    }
    
    /**
     * Queue an export
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', $this->exportService->getAvailableTypes()),
            'filters' => 'nullable|array',
        ]);
        
        $export = $this->exportService->queueExport(
            $validated['type'],
            $validated['filters'] ?? []
        );
        
        return redirect()->route('admin.exports.index')
            ->with('success', 'Export sedang diproses. Refresh halaman untuk melihat status.');
    }
    
    /**
     * Download an export
     */
    public function download(ExportLog $export)
    {
        if ($export->user_id !== auth()->id()) {
            abort(403);
        }
        
        $path = $this->exportService->getDownloadPath($export);
        
        if (!$path || !file_exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
        
        return response()->download($path);
    }
}
