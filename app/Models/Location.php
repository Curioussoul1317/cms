<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'locations';
    protected $fillable = [
        'name',
        'slug',
        'map_id',
        'color',
        'description',
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
        'is_active' => 'boolean',
        'sort_order' => 'integer', 
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->name);
            }
        });

        static::updating(function ($location) {
            if ($location->isDirty('name') && !$location->isDirty('slug')) {
                $location->slug = Str::slug($location->name);
            }
        });
    }

    /**
     * Get the places for this location
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class)->orderBy('sort_order');
    }

    /**
     * Get active places for this location
     */
    public function activePlaces(): HasMany
    {
        return $this->hasMany(Place::class)->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope for active locations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered locations
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
     * Get places count attribute
     */
    public function getPlacesCountAttribute(): int
    {
        return $this->places()->count();
    }
}