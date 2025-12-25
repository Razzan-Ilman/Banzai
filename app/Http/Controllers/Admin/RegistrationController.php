<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    /**
     * Display a listing of registrations.
     */
    public function index(Request $request): View
    {
        $query = Registration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Display registration details.
     */
    public function show(Registration $registration): View
    {
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Approve a registration.
     */
    public function approve(Registration $registration): RedirectResponse
    {
        $registration->update(['status' => 'approved']);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil disetujui.');
    }

    /**
     * Reject a registration.
     */
    public function reject(Request $request, Registration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran ditolak.');
    }

    /**
     * Remove the specified registration.
     */
    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }

    /**
     * Export registrations to CSV/Excel.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Registration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $statusLabel = $request->status ?? 'semua';
        $filename = "pendaftaran_{$statusLabel}_" . date('Y-m-d') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($handle, [
                'No',
                'Nama Lengkap',
                'Kelas',
                'Jurusan',
                'Divisi Pilihan',
                'WhatsApp',
                'Email',
                'Alasan Bergabung',
                'Status',
                'Tanggal Daftar',
            ]);

            // Data rows
            $no = 1;
            foreach ($registrations as $reg) {
                fputcsv($handle, [
                    $no++,
                    $reg->name,
                    $reg->class,
                    $reg->major,
                    ucfirst($reg->preferred_division),
                    $reg->phone ?? '-',
                    $reg->email ?? '-',
                    $reg->reason,
                    $reg->status_label,
                    $reg->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}

