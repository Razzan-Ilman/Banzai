<?php

namespace App\Traits;

use App\Services\Activity\ActivityLogService;

/**
 * Trait untuk auto-logging model events
 * 
 * Usage: use LogsActivity in your model
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        // Log when created
        static::created(function ($model) {
            if ($model->shouldLogActivity('created')) {
                app(ActivityLogService::class)->logCreated($model);
            }
        });
        
        // Log when updated
        static::updated(function ($model) {
            if ($model->shouldLogActivity('updated') && $model->wasChanged()) {
                app(ActivityLogService::class)->logUpdated(
                    $model, 
                    $model->getOriginal()
                );
            }
        });
        
        // Log when deleted
        static::deleted(function ($model) {
            if ($model->shouldLogActivity('deleted')) {
                app(ActivityLogService::class)->logDeleted($model);
            }
        });
    }
    
    /**
     * Tentukan apakah event ini harus di-log
     * Override di model untuk customize
     */
    public function shouldLogActivity(string $event): bool
    {
        // Default: log semua events
        // Override di model: return in_array($event, ['created', 'deleted']);
        return true;
    }
    
    /**
     * Get the attributes that should be logged
     * Override untuk exclude sensitive data
     */
    public function getLoggableAttributes(): array
    {
        $attributes = $this->toArray();
        
        // Exclude sensitive fields by default
        $exclude = $this->excludeFromLog ?? ['password', 'remember_token'];
        
        return array_diff_key($attributes, array_flip($exclude));
    }
}
