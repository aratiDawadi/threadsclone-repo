<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    protected $fillable = ['profile_picture', 'user_id', 'firstname', 'lastname', 'username', 'bio'];

    protected static function booted()
    {
        static::saving(function ($profile) {
            $user = $profile->user;
            if ($user) {
                $user->firstname = $profile->firstname;
                $user->lastname  = $profile->lastname;
                $user->save();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->belongsToMany(Content::class, 'likes')->withTimestamps();
    }
}
