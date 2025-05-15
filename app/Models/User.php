<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function assignedChats()
    {
        return $this->belongsToMany(Chat::class, 'chat_teams');
    }


    public function packages()
    {
        return $this->belongsToMany(Package::class, 'client_package', 'client_id', 'package_id')
            ->withTimestamps()
            ->withPivot(['start_date', 'end_date']);
    }


    public function bonuses()
    {
        return $this->hasMany(BonusItem::class, 'client_id');
    }

    /**
     * Get the user's role
     * 
     * @return string|null
     */
    public function getRole()
    {
        return $this->roles->first()?->name;
    }

    /**
     * Assign a role to the user
     * 
     * @param string $role
     * @return void
     */
    public function setRole($role)
    {
        $this->syncRoles([$role]);
    }
}
