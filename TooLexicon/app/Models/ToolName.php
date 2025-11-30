<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolName extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tool_id',
        'name',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    //tool : tool_name
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    //user : tool_name
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
