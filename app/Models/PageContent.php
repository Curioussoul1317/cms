<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;
    protected $connection = 'mysql_cms';
    
    protected $table = 'page_contents';

    protected $fillable = [
        'page_id',
        'template_name', 
        'data',  
        'order',  
        'created_by',
        'updated_by',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_published',
        'published_by',
        'published_at'
    ];

    protected $casts = [
        'data'=> 'array',    
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
    ];

  
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

  
    public function getTemplateConfig()
    {
        return config("templates.{$this->template_name}", []);
    }

 
    public function getTemplateName()
    {
        $config = $this->getTemplateConfig();
        return $config['name'] ?? $this->template_name;
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