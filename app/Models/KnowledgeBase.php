<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $table = 'knowledge_base';

    protected $fillable = [
        'title',
        'content',
        'category',
        'tags',
        'source',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Search knowledge base by query
     */
    public static function search($query)
    {
        return self::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->orWhere('tags', 'LIKE', "%{$query}%")
            ->get();
    }
}
