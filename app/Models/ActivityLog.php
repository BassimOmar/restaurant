<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'description', 'old_values', 'new_values', 'ip_address'
    ];

    protected $casts = [
        'old_values' => 'array', // Auto convert JSON
        'new_values' => 'array',
    ];

    // RELATIONSHIPS
    
    // Log belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic - log can be for any model
    public function model()
    {
        return $this->morphTo();
    }
}

// TRAIT to auto-log activities
// app/Traits/LogsActivity.php
trait LogsActivity
{
    // Boot the trait
    protected static function bootLogsActivity()
    {
        // Log when model is created
        static::created(function ($model) {
            $model->logActivity('created', 'Created ' . class_basename($model));
        });

        // Log when model is updated
        static::updated(function ($model) {
            $model->logActivity('updated', 'Updated ' . class_basename($model));
        });

        // Log when model is deleted
        static::deleted(function ($model) {
            $model->logActivity('deleted', 'Deleted ' . class_basename($model));
        });
    }

    // Method to create log entry
    public function logActivity($action, $description, $oldValues = null, $newValues = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
        ]);
    }
}
