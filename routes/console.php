<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateLeaderboardSnapshot;
use App\Jobs\AggregateDailyStats;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * BANZAI Scheduled Jobs
 * 
 * Run scheduler: php artisan schedule:work (development)
 *            or: php artisan schedule:run (production cron)
 */

// Generate leaderboard snapshots daily at midnight
Schedule::job(new GenerateLeaderboardSnapshot('alltime'))->daily();
Schedule::job(new GenerateLeaderboardSnapshot('monthly'))->daily();
Schedule::job(new GenerateLeaderboardSnapshot('weekly'))->daily();

// Aggregate daily statistics at 1 AM
Schedule::job(new AggregateDailyStats)->dailyAt('01:00');

// Clean old export files (older than 7 days)
Schedule::command('model:prune', [
    '--model' => 'App\Models\ExportLog',
])->daily();
