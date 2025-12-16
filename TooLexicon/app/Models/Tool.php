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

    // 検索用のスコープを定義
    public function scopeSearch($query, $keyword)
    {
    // キーワードが空の場合は全件取得
    if (empty($keyword)) {
        return $query;
    }
    // 名前で部分一致検索
    return $query->where('official_name', 'like', "%{$keyword}%");
    }

    // tool : tool_name
    public function toolNames()
    {
        return $this->hasMany(ToolName::class);
    }
}
