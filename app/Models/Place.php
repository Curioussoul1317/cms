<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Place extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'places';
    protected $fillable = [
        'location_id',
        'name',
        'slug',
        'opening_hours',
        'phone_number',
        'email',
        'address', 
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_published',
        'published_by',
        'published_at',
    ];

    protected $casts = [
        'opening_hours' => 'array', 
        'sort_order' => 'integer', 
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

   /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($place) {
            if (empty($place->slug)) {
                $place->slug = Str::slug($place->name);
            }
        });

        static::updating(function ($place) {
            if ($place->isDirty('name') && !$place->isDirty('slug')) {
                $place->slug = Str::slug($place->name);
            }
        });
    }

    /**
     * Get the location that owns this place
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Scope for active places
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered places
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the route key name for route model binding
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get formatted opening hours
     */
    public function getFormattedOpeningHoursAttribute(): array
    {
        if (empty($this->opening_hours)) {
            return [];
        }

        return $this->opening_hours;
    }

    /**
     * Check if place is open now
     */
    public function isOpenNow(): bool
    {
        if (empty($this->opening_hours)) {
            return false;
        }

        $currentDay = strtolower(date('l'));
        $currentTime = date('H:i');

        foreach ($this->opening_hours as $schedule) {
            $days = array_map('strtolower', $schedule['days'] ?? []);
            
            if (in_array($currentDay, $days)) {
                if (isset($schedule['closed']) && $schedule['closed']) {
                    return false;
                }

                if (isset($schedule['open']) && isset($schedule['close'])) {
                    return $currentTime >= $schedule['open'] && $currentTime <= $schedule['close'];
                }
            }
        }

        return false;
    }

    /**
     * Get today's hours
     */
    public function getTodayHoursAttribute(): ?string
    {
        if (empty($this->opening_hours)) {
            return null;
        }

        $currentDay = strtolower(date('l'));

        foreach ($this->opening_hours as $schedule) {
            $days = array_map('strtolower', $schedule['days'] ?? []);
            
            if (in_array($currentDay, $days)) {
                if (isset($schedule['closed']) && $schedule['closed']) {
                    return 'Closed';
                }

                if (isset($schedule['open']) && isset($schedule['close'])) {
                    return $schedule['open'] . ' - ' . $schedule['close'];
                }
            }
        }

        return null;
    }
}




