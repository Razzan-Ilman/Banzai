<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        
        return view('member.notifications.index', [
            'notifications' => $notifications,
        ]);
    }
    
    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }
    
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
    
    public function destroy(string $id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();
        
        return back()->with('success', 'Notifikasi dihapus');
    }
    
    /**
     * API endpoint for notification bell
     */
    public function unread()
    {
        $notifications = auth()->user()->unreadNotifications()->take(5)->get();
        
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'notifications' => $notifications->map(fn($n) => [
                'id' => $n->id,
                'title' => $n->data['title'] ?? 'Notifikasi',
                'message' => $n->data['message'] ?? '',
                'type' => $n->data['type'] ?? 'info',
                'time' => $n->created_at->diffForHumans(),
                'action_url' => $n->data['action_url'] ?? null,
            ]),
        ]);
    }
}
