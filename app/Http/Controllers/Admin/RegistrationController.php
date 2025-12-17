<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}
