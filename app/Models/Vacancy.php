<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacancy extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'vacancies';

    protected $fillable = [
        'title',
        'posted_date',
        'due_date',
        'salary',
        'vacancylocation_id',
        'url',
        'status', 
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
        'posted_date' => 'date',
        'due_date' => 'date',
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function location()
    {
        return $this->belongsTo(VacancyLocation::class, 'vacancylocation_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->on('mysql');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->on('mysql');
    }
    
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by')->on('mysql');
    }
    
    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by')->on('mysql');
    }

    // Accessors
    public function getIsExpiredAttribute()
    {
        return Carbon::now()->isAfter($this->due_date);
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_expired ? 'Expired' : 'Active';
    }

    public function getPostedTimeAgoAttribute()
    {
        return $this->posted_date->diffForHumans();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('due_date', '>=', Carbon::now());
    }

    public function scopeExpired($query)
    {
        return $query->where('due_date', '<', Carbon::now());
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('posted_date', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('location', function($q) use ($search) {
                      $q->where('location_name', 'like', '%' . $search . '%');
                  });
            });
        }
        return $query;
    }

    // Boot method to auto-update status
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($vacancy) {
            $vacancy->status = Carbon::now()->isAfter($vacancy->due_date) ? 'expired' : 'active';
        });
    }
}