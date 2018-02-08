<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Fetch all threads that were created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Recored that the user has read the given thread.
     *
     * @return Thread $thread
     */
     public function read($thread)
     {
         cache()->forever(
             $this->visitedThreadCacheKey($thread),
             Carbon::now()
         );
     }

    /**
     * Get the cache key for when a user read a thread
     *
     * @param Thread $thread
     * @return string
     */
     public function visitedThreadCacheKey($thread)
     {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
     }

    /**
     * Fetch the last publlished reply for the user
     *
     */
     public function lastReply()
     {
        return $this->hasOne(Reply::class)->latest();
     }


     public function getAvatarPathAttribute($avatar)
     {
         return asset($avatar ?: 'images/avatars/default.png');
     }
}
