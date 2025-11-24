<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolName extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_type',
        'category',
    ];

    protected $casts = [
        //
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
