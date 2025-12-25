<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Models\User;

use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\PositionController as AdminPositionController;
use App\Http\Controllers\Admin\AdminUserController;

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

// Public Gallery
Route::get('/galeri', [App\Http\Controllers\Public\GalleryController::class, 'index'])->name('gallery');
Route::get('/galeri/{gallery:slug}', [App\Http\Controllers\Public\GalleryController::class, 'show'])->name('gallery.show');

// Public Blog
Route::get('/blog', [App\Http\Controllers\Public\BlogController::class, 'index'])->name('blog');
Route::get('/blog/{article:slug}', [App\Http\Controllers\Public\BlogController::class, 'show'])->name('blog.show');

// Global Search
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::get('/api/search', [App\Http\Controllers\SearchController::class, 'instant'])->name('search.instant');

// Registration (Public membership registration - different from account registration)
Route::get('/daftar', [RegistrationController::class, 'create'])->name('register');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('register.store');

// Admin Routes (protected by auth middleware)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Members CRUD
    Route::resource('members', AdminMemberController::class)->except(['show']);
    Route::get('members/{member}/replace', [AdminMemberController::class, 'replaceForm'])->name('members.replace');
    Route::post('members/{member}/replace', [AdminMemberController::class, 'replace'])->name('members.replace.store');
    
    // Divisions CRUD
    Route::resource('divisions', AdminDivisionController::class)->except(['show']);
    
    // Positions CRUD
    Route::resource('positions', AdminPositionController::class)->except(['show']);
    
    // Activities CRUD
    Route::resource('activities', AdminActivityController::class)->except(['show']);
    
    // Registrations Management
    Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('registrations/export', [AdminRegistrationController::class, 'export'])->name('registrations.export');
    Route::get('registrations/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::post('registrations/{registration}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
    Route::delete('registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');
    
    // Users Management (Account CRUD)
    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Quiz History (Admin only - role check)
    Route::get('quiz-history', [App\Http\Controllers\Admin\QuizHistoryController::class, 'index'])->name('quiz-history.index');
    Route::get('quiz-history/user/{user}', [App\Http\Controllers\Admin\QuizHistoryController::class, 'userHistory'])->name('quiz-history.user');
    
    // Exports
    Route::get('exports', [App\Http\Controllers\Admin\ExportController::class, 'index'])->name('exports.index');
    Route::post('exports', [App\Http\Controllers\Admin\ExportController::class, 'store'])->name('exports.store');
    Route::get('exports/{export}/download', [App\Http\Controllers\Admin\ExportController::class, 'download'])->name('exports.download');
    
    // Announcements
    Route::resource('announcements', App\Http\Controllers\Admin\AnnouncementController::class);
    Route::post('announcements/{announcement}/toggle', [App\Http\Controllers\Admin\AnnouncementController::class, 'togglePublish'])->name('announcements.toggle');
    
    // Schedules
    Route::resource('schedules', App\Http\Controllers\Admin\ScheduleController::class);
    Route::get('schedules-calendar', [App\Http\Controllers\Admin\ScheduleController::class, 'calendar'])->name('schedules.calendar');
    
    // Galleries
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class);
    Route::post('galleries/{gallery}/photos', [App\Http\Controllers\Admin\GalleryController::class, 'uploadPhotos'])->name('galleries.photos.upload');
    Route::delete('gallery-photos/{photo}', [App\Http\Controllers\Admin\GalleryController::class, 'deletePhoto'])->name('galleries.photos.delete');
    
    // Articles (Blog)
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
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
    
    // Group
    Route::get('/group', [App\Http\Controllers\Member\GroupController::class, 'index'])->name('group.index');
    
    // Analytics
    Route::get('/analytics', [App\Http\Controllers\Member\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::post('/analytics/refresh', [App\Http\Controllers\Member\AnalyticsController::class, 'refresh'])->name('analytics.refresh');
    
    // Leaderboard
    Route::get('/leaderboard', [App\Http\Controllers\Member\LeaderboardController::class, 'index'])->name('leaderboard.index');
    
    // Materials (Materi Belajar)
    Route::get('/materials', [App\Http\Controllers\Member\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material:slug}', [App\Http\Controllers\Member\MaterialController::class, 'show'])->name('materials.show');
    Route::post('/materials/{material}/progress', [App\Http\Controllers\Member\MaterialController::class, 'markProgress'])->name('materials.progress');
    
    // Forum Discussions
    Route::get('/forum', [App\Http\Controllers\Member\ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [App\Http\Controllers\Member\ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [App\Http\Controllers\Member\ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{discussion:slug}', [App\Http\Controllers\Member\ForumController::class, 'show'])->name('forum.show');
    Route::post('/forum/{discussion}/reply', [App\Http\Controllers\Member\ForumController::class, 'reply'])->name('forum.reply');
    Route::delete('/forum/{discussion}', [App\Http\Controllers\Member\ForumController::class, 'destroy'])->name('forum.destroy');
    
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Member\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\Member\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\Member\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Member\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread', [App\Http\Controllers\Member\NotificationController::class, 'unread'])->name('notifications.unread');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - FIXED VERSION
|--------------------------------------------------------------------------
| BUG FIXES:
| 1. Login GET: No middleware - anyone can access login page
| 2. Login POST: Properly handles already-logged-in users by logging them out first
| 3. Register GET/POST: No guest middleware - allows switching accounts
| 4. Logout: Uses GET for easy logout link, POST still works
| 5. Session handling: Proper order of invalidate/regenerate
|--------------------------------------------------------------------------
*/

// LOGIN - GET (Show login form)
// No middleware - anyone can access, even logged-in users who want to switch accounts
Route::get('/login', function () {
    // If user is logged in and doesn't intend to switch, redirect to their dashboard
    // But we show the form anyway to allow account switching
    return view('auth.login');
})->name('login');

// LOGIN - POST (Process login)
Route::post('/login', function (Request $request) {
    // Validate input
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // CRITICAL FIX: If user is already logged in, we need to logout properly BEFORE
    // invalidating the session to avoid CSRF token mismatch issues
    if (Auth::check()) {
        $previousEmail = auth()->user()->email;
        
        // Logout current user
        Auth::logout();
        
        // We do NOT invalidate session here yet - we need the CSRF token to remain valid
        // for the current request. Session will be regenerated after successful login.
        
        \Log::info('User switching accounts', [
            'from' => $previousEmail, 
            'to' => $credentials['email']
        ]);
    }

    // Attempt login with new credentials
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // IMPORTANT: Regenerate session AFTER successful login
        // This prevents session fixation attacks
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        \Log::info('User logged in successfully', [
            'email' => $user->email, 
            'role' => $user->role,
            'user_id' => $user->id
        ]);
        
        // Redirect based on role (case-insensitive)
        return redirectUserByRole($user);
    }

    // Login failed
    \Log::warning('Failed login attempt', ['email' => $credentials['email']]);
    
    return back()
        ->withInput($request->only('email'))
        ->withErrors([
            'email' => 'Email atau password salah.',
        ]);
});

// REGISTER - GET (Show registration form)
// No guest middleware - allows logged-in users to access for account switching
Route::get('/register-account', function () {
    return view('auth.register');
})->name('auth.register');

// REGISTER - POST (Process registration)
Route::post('/register-account', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'role' => 'nullable|in:public,member,core,admin', // Made nullable with default
    ]);

    // If user is already logged in, logout first
    if (Auth::check()) {
        Auth::logout();
        // Don't invalidate session yet - need CSRF token
    }

    // Create the new user with default role if not specified
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'] ?? 'public', // Default to 'public'
        'email_verified_at' => now(),
    ]);

    // Log in the new user
    Auth::login($user);
    
    // Regenerate session for security
    $request->session()->regenerate();

    \Log::info('New user registered and logged in', [
        'email' => $user->email,
        'role' => $user->role,
        'user_id' => $user->id
    ]);

    // Redirect based on role
    return redirectUserByRole($user)->with('success', 'Akun berhasil dibuat! Selamat datang di BANZAI.');
})->name('auth.register.store');

// LOGOUT - POST (Standard secure logout)
Route::post('/logout', function (Request $request) {
    $email = auth()->user()?->email;
    
    Auth::logout();
    
    // Invalidate the session to prevent session reuse
    $request->session()->invalidate();
    
    // Regenerate CSRF token
    $request->session()->regenerateToken();
    
    \Log::info('User logged out', ['email' => $email]);
    
    return redirect('/')->with('success', 'Anda telah berhasil logout.');
})->name('logout')->middleware('auth');

// LOGOUT - GET (Convenience method for logout links)
// This is useful for simple logout links without forms
// NOTE: No auth middleware - allows logout even with expired sessions to prevent 419 errors
Route::get('/logout', function (Request $request) {
    $email = auth()->user()?->email;
    
    // Log out if user is authenticated
    if (Auth::check()) {
        Auth::logout();
    }
    
    // Safely invalidate session (handles already invalidated sessions)
    try {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    } catch (\Exception $e) {
        // Session might already be invalid, just continue
        \Log::debug('Session invalidation issue during logout', ['error' => $e->getMessage()]);
    }
    
    \Log::info('User logged out via GET', ['email' => $email]);
    
    return redirect('/')->with('success', 'Anda telah berhasil logout.');
})->name('logout.get'); // No auth middleware - prevents 419 errors

/*
|--------------------------------------------------------------------------
| HELPER FUNCTION: Redirect User By Role
|--------------------------------------------------------------------------
*/
function redirectUserByRole($user)
{
    $role = strtolower($user->role ?? 'public');
    
    switch ($role) {
        case 'admin':
            return redirect()->intended('/admin');
        case 'core':
            return redirect()->intended('/core');
        case 'member':
            return redirect()->intended('/member');
        default:
            return redirect()->intended('/home');
    }
}
