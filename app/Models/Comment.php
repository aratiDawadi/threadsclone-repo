<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';

    protected $fillable = [
        'content_id',
        'user_id',
        'comment_body',
        'parent_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            foreach ($comment->replies as $reply) {
                $reply->delete();
            }
        });
    }
}
