<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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

    /**
     * Получить идентификатор, который будет храниться в subject claim токена JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Вернуть массив ключ-значение, содержащий любые кастомные claims для добавления в JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function technicians()
    {
        return self::whereHas('roles', function ($query) {
            $query->where('slug', 'technician');
        });
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_technician')
            ->withPivot('id', 'date', 'start_time', 'end_time', 'payment_amount', 'paid_at', 'payment_status')
            ->withTimestamps();
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

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function statusChanges()
    {
        return $this->hasMany(StatusChange::class);
    }
}
