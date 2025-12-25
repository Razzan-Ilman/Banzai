<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('creator');
        
        if ($request->filled('type')) {
            $query->byType($request->type);
        }
        
        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }
        
        $schedules = $query->orderBy('start_date', 'desc')->paginate(15);
        $upcoming = Schedule::upcoming()->limit(5)->get();
        
        return view('admin.schedules.index', [
            'schedules' => $schedules,
            'upcoming' => $upcoming,
            'types' => ['meeting', 'event', 'practice', 'other'],
        ]);
    }
    
    public function create()
    {
        return view('admin.schedules.create', [
            'types' => ['meeting', 'event', 'practice', 'other'],
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:meeting,event,practice,other',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_recurring' => 'boolean',
            'recurrence_rule' => 'nullable|string',
        ]);
        
        Schedule::create([
            ...$validated,
            'is_recurring' => $validated['is_recurring'] ?? false,
            'created_by' => auth()->id(),
        ]);
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat!');
    }
    
    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', [
            'schedule' => $schedule,
            'types' => ['meeting', 'event', 'practice', 'other'],
        ]);
    }
    
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:meeting,event,practice,other',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_recurring' => 'boolean',
            'recurrence_rule' => 'nullable|string',
        ]);
        
        $schedule->update([
            ...$validated,
            'is_recurring' => $validated['is_recurring'] ?? false,
        ]);
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }
    
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
    
    /**
     * API endpoint untuk calendar
     */
    public function calendar(Request $request)
    {
        $start = $request->get('start', now()->startOfMonth());
        $end = $request->get('end', now()->endOfMonth());
        
        $schedules = Schedule::whereBetween('start_date', [$start, $end])
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'start' => $s->start_date->toIso8601String(),
                'end' => $s->end_date?->toIso8601String(),
                'color' => $s->type_color,
                'type' => $s->type,
            ]);
        
        return response()->json($schedules);
    }
}
