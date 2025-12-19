<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->memberProfile;
        $currentGroup = $user->currentGroup;
        $medals = $user->medals;
        
        return view('member.profile.index', compact('user', 'profile', 'currentGroup', 'medals'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->memberProfile;
        
        return view('member.profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->memberProfile;

        $validated = $request->validate([
            'bio' => 'nullable|string|max:500',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            
            // Store new photo
            $path = $request->file('photo')->store('member-photos', 'public');
            $profile->photo = $path;
        }

        $profile->bio = $validated['bio'] ?? $profile->bio;
        $profile->save();

        return redirect()->route('member.profile.index')
            ->with('success', 'Profil berhasil diupdate!');
    }
}
