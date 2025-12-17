<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Display the registration form.
     */
    public function create(): View
    {
        $divisions = Division::active()->get();

        return view('public.register', compact('divisions'));
    }

    /**
     * Store a new registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'class' => 'required|string|max:20',
            'major' => 'required|string|max:100',
            'preferred_division' => 'required|string|max:50',
            'reason' => 'required|string|min:20|max:1000',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'class.required' => 'Kelas wajib dipilih.',
            'major.required' => 'Jurusan wajib dipilih.',
            'preferred_division.required' => 'Pilih divisi yang diminati.',
            'reason.required' => 'Alasan bergabung wajib diisi.',
            'reason.min' => 'Alasan bergabung minimal 20 karakter.',
        ]);

        Registration::create($validated);

        return redirect()
            ->route('register')
            ->with('success', 'Terima kasih! Pendaftaran Anda telah diterima. Kami akan menghubungi Anda segera.');
    }
}
