<?php

namespace App\Models;

use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    public const STATUS_INACTIVATED = 0;
    public const STATUS_ACTIVATED = 1;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'first_name_furigana',
        'last_name',
        'last_name_furigana',
        'email',
        'password',
        'phone_number',
        'post_code',
        'avatar',
        'token',
        'city',
        'address',
        'desc',
        'status',
        'birth',
        'gender',
        'memo',
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

    /**
     * @return belongsToMany
     */
    public function projectUsers()
    {
        return $this->belongsToMany(Project::class, 'project_users')->withPivot('status');
    }

    /**
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function getFullNameFuriganaAttribute()
    {
        return $this->first_name_furigana .' '. $this->last_name_furigana;
    }

    public function getFullAddressAttribute()
    {
        return $this->address;
    }

    public static function getListGender()
    {
        return [
            self::GENDER_MALE => trans('edit-personal.form.male'),
            self::GENDER_FEMALE => trans('edit-personal.form.female'),
            self::GENDER_OTHER => trans('edit-personal.form.other'),
        ];
    }
}
