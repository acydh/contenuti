<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    public function articles()
    {
        return $this->hasMany(Article::class, "author_id");
    }

    /**
     * Model accessors
     */

    public function isSameAs(User $user)
    {
        return $this->id == $user->id;
    }

    public function getIsEditorAttribute()
    {
        return $this->hasRole('Editor');
    }

    public function getIsWriterAttribute()
    {
        return $this->hasRole('Writer');
    }

    public function getIsNotEditorAttribute()
    {
        return !$this->hasRole('Editor');
    }

    public function getIsNotWriterAttribute()
    {
        return !$this->hasRole('Writer');
    }
}
