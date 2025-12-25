<?php

namespace App\Jobs;

use App\Models\DailyStat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AggregateDailyStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ?string $date = null
    ) {
        $this->date = $date ?? Carbon::yesterday()->toDateString();
    }

    public function handle(): void
    {
        Log::info("Aggregating daily stats for: {$this->date}");
        
        $date = Carbon::parse($this->date);
        
        // Calculate stats
        $stats = [
            'date' => $this->date,
            'total_users' => DB::table('users')->count(),
            'active_users' => DB::table('users')
                ->whereDate('updated_at', $date)
                ->count(),
            'new_users' => DB::table('users')
                ->whereDate('created_at', $date)
                ->count(),
            'attendance_count' => DB::table('attendances')
                ->whereDate('created_at', $date)
                ->count(),
            'quiz_count' => DB::table('quiz_results')
                ->whereDate('created_at', $date)
                ->count(),
            'event_registrations' => DB::table('event_registrations')
                ->whereDate('created_at', $date)
                ->count(),
        ];
        
        // Upsert
        DailyStat::updateOrCreate(
            ['date' => $this->date],
            $stats
        );
        
        Log::info("Daily stats aggregated for: {$this->date}");
    }
}
