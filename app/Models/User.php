<?php

namespace App\Models;
use \Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function friendsTo()
    {
        return $this->belongsToMany(User::class, 'friendships', 'requester_id', 'user_requested')
            ->withPivot('status')
            ->withTimestamps();
    }
 
    public function friendsFrom()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_requested', 'requester_id')
            ->withPivot('status')
            ->withTimestamps();
    }
    public function pendingFriendsTo()
{
    return $this->friendsTo()->wherePivot('status', false);
}
 
public function pendingFriendsFrom()
{
    return $this->friendsFrom()->wherePivot('status', false);
}
 
public function acceptedFriendsTo()
{
    return $this->friendsTo()->wherePivot('status', true);
}
 
public function acceptedFriendsFrom()
{
    return $this->friendsFrom()->wherePivot('status', true);
}



public function friends()
{
    return $this->mergedRelationWithModel(User::class, 'friends_view');
}
}
