<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    /**
     * Get the comments associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    /**
     * Get the likes associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the post is liked by the user.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function checkLikeByUser($user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
