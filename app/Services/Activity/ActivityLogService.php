<?php

namespace App\Services\Activity;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity
     */
    public function log(
        string $action,
        ?Model $subject = null,
        ?array $properties = null,
        ?int $userId = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => $userId ?? Auth::id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
    
    /**
     * Log create action
     */
    public function logCreated(Model $subject, ?array $properties = null): ActivityLog
    {
        return $this->log('created', $subject, $properties ?? [
            'attributes' => $subject->toArray(),
        ]);
    }
    
    /**
     * Log update action
     */
    public function logUpdated(Model $subject, array $oldValues = []): ActivityLog
    {
        return $this->log('updated', $subject, [
            'old' => $oldValues,
            'new' => $subject->getChanges(),
        ]);
    }
    
    /**
     * Log delete action
     */
    public function logDeleted(Model $subject): ActivityLog
    {
        return $this->log('deleted', $subject, [
            'attributes' => $subject->toArray(),
        ]);
    }
    
    /**
     * Log view action
     */
    public function logViewed(Model $subject): ActivityLog
    {
        return $this->log('viewed', $subject);
    }
    
    /**
     * Log login action
     */
    public function logLogin(?int $userId = null): ActivityLog
    {
        return $this->log('login', null, null, $userId);
    }
    
    /**
     * Log logout action
     */
    public function logLogout(?int $userId = null): ActivityLog
    {
        return $this->log('logout', null, null, $userId);
    }
    
    /**
     * Log export action
     */
    public function logExport(string $type, ?array $filters = null): ActivityLog
    {
        return $this->log('exported', null, [
            'type' => $type,
            'filters' => $filters,
        ]);
    }
    
    /**
     * Log custom action
     */
    public function logCustom(string $action, ?Model $subject = null, ?array $data = null): ActivityLog
    {
        return $this->log($action, $subject, $data);
    }
    
    /**
     * Get recent activities for a user
     */
    public function getRecentForUser(int $userId, int $limit = 20)
    {
        return ActivityLog::byUser($userId)
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get activities for a subject
     */
    public function getForSubject(Model $subject, int $limit = 50)
    {
        return ActivityLog::forSubject($subject)
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get all activities with filters
     */
    public function getAll(array $filters = [], int $perPage = 25)
    {
        $query = ActivityLog::with('user')->latest('created_at');
        
        if (!empty($filters['user_id'])) {
            $query->byUser($filters['user_id']);
        }
        
        if (!empty($filters['action'])) {
            $query->action($filters['action']);
        }
        
        if (!empty($filters['from']) && !empty($filters['to'])) {
            $query->between($filters['from'], $filters['to']);
        }
        
        if (!empty($filters['subject_type'])) {
            $query->where('subject_type', $filters['subject_type']);
        }
        
        return $query->paginate($perPage);
    }
}
