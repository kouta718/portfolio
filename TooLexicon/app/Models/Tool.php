<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_name',
        'category',
        'image_url',
        'amazon_url',
        'monotaro_url',
        'usage',
        'safety_notes',
    ];

    protected $casts = [
        //
    ];

    // tool : tool_name
    public function toolNames()
    {
        return $this->hasMany(ToolName::class);
    }
}
