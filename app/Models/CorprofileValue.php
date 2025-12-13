<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorprofileValue extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    protected $table = 'corprofile_values';
    protected $fillable = [
        'corprofile_page_id',
        'text',
        'order', 
    ];

    protected $casts = [  
    ];

    public function page()
    {
        return $this->belongsTo(CorprofilePage::class, 'corprofile_page_id');
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
}