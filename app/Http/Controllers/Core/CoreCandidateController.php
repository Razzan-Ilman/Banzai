<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CoreCandidateController extends Controller
{
    public function index()
    {
        $candidates = User::where('role', 'candidate')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('core.candidates.index', compact('candidates'));
    }

    public function approve(User $candidate)
    {
        $candidate->update(['role' => 'member']);

        return redirect()->route('core.candidates.index')
            ->with('success', 'Candidate berhasil diverifikasi menjadi Member!');
    }

    public function reject(User $candidate)
    {
        $candidate->delete();

        return redirect()->route('core.candidates.index')
            ->with('success', 'Candidate ditolak dan dihapus dari sistem.');
    }
}
