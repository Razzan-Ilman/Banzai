<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page (Root)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Public Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profile'])->name('profile');
Route::get('/divisi', [HomeController::class, 'divisions'])->name('divisions');

// Individual Division Pages
Route::get('/divisi/bahasa', function () {
    return view('public.division-bahasa');
})->name('division.bahasa');

Route::get('/divisi/budaya', function () {
    return view('public.division-budaya');
})->name('division.budaya');

Route::get('/divisi/medsos', function () {
    return view('public.division-medsos');
})->name('division.medsos');

Route::get('/anggota', [HomeController::class, 'members'])->name('members');
Route::get('/kegiatan', [HomeController::class, 'activities'])->name('activities');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');

// Registration
Route::get('/daftar', [RegistrationController::class, 'create'])->name('register');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('register.store');

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Members CRUD
    Route::resource('members', AdminMemberController::class)->except(['show']);
    
    // Activities CRUD
    Route::resource('activities', AdminActivityController::class)->except(['show']);
    
    // Registrations Management
    Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::post('registrations/{registration}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
    Route::delete('registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');
});

// CORE Routes (protected by auth + core middleware)
Route::prefix('core')->middleware(['auth', App\Http\Middleware\EnsureUserIsCore::class])->name('core.')->group(function () {
    Route::get('/', [App\Http\Controllers\Core\CoreDashboardController::class, 'index'])->name('dashboard');
    
    // Member Management
    Route::get('/members', [App\Http\Controllers\Core\CoreMemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [App\Http\Controllers\Core\CoreMemberController::class, 'show'])->name('members.show');
    
    // Candidate Verification
    Route::get('/candidates', [App\Http\Controllers\Core\CoreCandidateController::class, 'index'])->name('candidates.index');
    Route::post('/candidates/{candidate}/approve', [App\Http\Controllers\Core\CoreCandidateController::class, 'approve'])->name('candidates.approve');
    Route::post('/candidates/{candidate}/reject', [App\Http\Controllers\Core\CoreCandidateController::class, 'reject'])->name('candidates.reject');
});

// MEMBER Routes (protected by auth + member middleware)
Route::prefix('member')->middleware(['auth', App\Http\Middleware\EnsureUserIsMember::class])->name('member.')->group(function () {
    Route::get('/', [App\Http\Controllers\Member\MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Member\MemberProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [App\Http\Controllers\Member\MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Member\MemberProfileController::class, 'update'])->name('profile.update');
    
    // Attendance
    Route::get('/attendance', [App\Http\Controllers\Member\MemberAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/checkin', [App\Http\Controllers\Member\MemberAttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::post('/attendance', [App\Http\Controllers\Member\MemberAttendanceController::class, 'store'])->name('attendance.store');
    
    // Events
    Route::get('/events', [App\Http\Controllers\Member\MemberEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [App\Http\Controllers\Member\MemberEventController::class, 'show'])->name('events.show');
    
    // Quiz
    Route::get('/quiz', [App\Http\Controllers\Member\QuizController::class, 'index'])->name('quiz.index');
    Route::post('/quiz', [App\Http\Controllers\Member\QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/result/{id}', [App\Http\Controllers\Member\QuizController::class, 'result'])->name('quiz.result');
});

// Auth Routes (simplified login/logout)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $user = auth()->user();
        
        // Debug: Log the user role
        \Log::info('User logged in', ['email' => $user->email, 'role' => $user->role]);
        
        // Redirect based on role - case insensitive
        $role = strtolower($user->role);
        
        switch ($role) {
            case 'admin':
                \Log::info('Redirecting to admin dashboard');
                return redirect('/admin');
            case 'core':
                \Log::info('Redirecting to core dashboard');
                return redirect('/core');
            case 'member':
                \Log::info('Redirecting to member dashboard');
                return redirect('/member');
            default:
                \Log::info('Redirecting to public home', ['role' => $user->role]);
                return redirect('/');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
});

// Register Routes
Route::get('/register-account', function () {
    return view('auth.register');
})->name('auth.register')->middleware('guest');

Route::post('/register-account', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:public,member,core,admin',
    ]);

    $user = App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Illuminate\Support\Facades\Hash::make($validated['password']),
        'role' => $validated['role'],
        'email_verified_at' => now(),
    ]);

    Illuminate\Support\Facades\Auth::login($user);

    // Redirect based on role
    if ($user->role === 'admin') {
        return redirect('/admin')->with('success', 'Akun admin berhasil dibuat!');
    }

    return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat datang di BANZAI.');
})->name('auth.register.store')->middleware('guest');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

