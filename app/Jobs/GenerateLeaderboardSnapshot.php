<?php

namespace App\Jobs;

use App\Services\Leaderboard\LeaderboardService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateLeaderboardSnapshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public string $period = 'alltime'
    ) {}

    public function handle(LeaderboardService $service): void
    {
        Log::info("Generating leaderboard snapshot for period: {$this->period}");
        
        $snapshot = $service->generateSnapshot($this->period);
        $service->clearCache();
        
        Log::info("Leaderboard snapshot generated: ID {$snapshot->id}");
    }
}
