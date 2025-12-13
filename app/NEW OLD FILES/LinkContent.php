<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'contentable_type',
        'contentable_id',
        'link_id',
        'template_name',
        'data',
        'order',
        'is_active',
        'is_approved'
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
        'is_approved'=> 'boolean'
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
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

    public function contentable()
    {
        return $this->morphTo();
    }
    
}