<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'title', 
        'description',
        'order',
        'is_active',
        'is_approved'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_approved'=> 'boolean'
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // public function contents()
    // {
    //     return $this->hasMany(LinkContent::class)->orderBy('order');
    // }

    public function contents()
    {
        return $this->morphMany(LinkContent::class, 'contentable')->orderBy('order');
    }
    
}