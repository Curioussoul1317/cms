<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cms';

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
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
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(NewsImage::class)->orderBy('sort_order');
    }

    public function activeImages(): HasMany
    {
        return $this->hasMany(NewsImage::class)
                    ->where('is_active', true)
                    ->orderBy('sort_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePublic($query)
    {
        return $query->active()->approved()->published();
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    // Helper Methods
    public function approve(): bool
    {
        $this->is_approved = true;
        $this->approved_by = auth()->id();
        $this->approved_at = now();
        return $this->save();
    }

    public function unapprove(): bool
    {
        $this->is_approved = false;
        $this->approved_by = null;
        $this->approved_at = null;
        $this->is_published = false;
        $this->published_by = null;
        $this->published_at = null;
        return $this->save();
    }

    public function publish(): bool
    {
        if (!$this->is_approved) {
            return false;
        }
        $this->is_published = true;
        $this->published_by = auth()->id();
        $this->published_at = now();
        return $this->save();
    }

    public function unpublish(): bool
    {
        $this->is_published = false;
        $this->published_by = null;
        $this->published_at = null;
        return $this->save();
    }

    public function getStatusAttribute(): string
    {
        if ($this->is_published) {
            return 'published';
        }
        if ($this->is_approved) {
            return 'approved';
        }
        return 'draft';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'published' => '<span class="badge bg-success">Published</span>',
            'approved' => '<span class="badge bg-info">Approved</span>',
            default => '<span class="badge bg-warning">Draft</span>',
        };
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }
}