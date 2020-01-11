<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Get the category that owns the image.
     */
    public function category()
    {
        return $this->belongsTo (Category::class);
    }

    /**
     * Get the user that owns the image.
     */
    public function user()
    {
        return $this->belongsTo (User::class);
    }

    /**
     * Scope a query eager load users and order query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLatestWithUser($query)
    {
        $user = auth()->user();

        if($user && $user->adult) {
            return $query->with ('user')->latest ();
        }

        return $query->with ('user')->whereAdult(false)->latest ();
    }

    public function albums()
    {
        return $this->belongsToMany (Album::class);
    }
}
