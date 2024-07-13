<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
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
        'password' => 'hashed',
    ];

    public static function technicians()
    {
        return self::whereHas('roles', function ($query) {
            $query->where('slug', 'technician');
        });
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_technician', 'user_id', 'schedule_id')
            ->withPivot('area_id')
            ->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'schedule_technician', 'user_id', 'area_id')
            ->withTimestamps();
    }
}
