<?php

namespace App\Models;

use App\Helpers\ProjectHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';

    public const STATUS_PENDING = 1;
    public const STATUS_RECRUITING = 2;
    public const STATUS_ACTIVE = 3;
    public const STATUS_END = 4;

    public const RESULT_DISSOLUTION = 1;
    public const RESULT_LEGALIZATION = 2;
    public const STATUS_UNLEGALIZATION = 0;
    public const STATUS_LEGALIZATION = 1;

    public const MAX_SALE = 202000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no',
        'user_id',
        'title',
        'city_id',
        'address',
        'm_contact_period_id',
        'recruitment_quantity_min',
        'recruitment_quantity_max',
        'recruitment_number',
        'work_time',
        'work_content',
        'work_desc',
        'special',
        'business_development_incorporation',
        'employment_incorporation',
        'status',
        'result',
        'published_at',
        'legalization_status',
        'start_date',
        'end_date',
        'target_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'recruitment_quantity' => 'array',
        'available_date' => 'array',
    ];

    /**
     * @return HasMany
     */
    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function banner()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'banner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function detailImages()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'detail');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the tags for the post.
     */
    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'project_m_industries');
    }

    /**
     * Get all of the tags for the post.
     */
    public function contactPeriod()
    {
        return $this->belongsTo(ContactPeriod::class, 'm_contact_period_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function availableDate()
    {
        return $this->hasMany(ProjectAvailableDate::class);
    }

    /**
     * @return mixed|void
     */
    public function getStatusStrAttribute()
    {
        $status = $this->status;

        return ProjectHelper::getStatusStr($status);
    }

    /**
     * @return string|null
     */
    public function getStatusColorAttribute()
    {
        $status = $this->status;

        return ProjectHelper::getClassColor($status);
    }
    /**
     * @return mixed|void
     */
    public function getIndustryAttribute()
    {
        $industries = $this->industries()->pluck('name')->toArray();

        return implode('/', $industries);
    }

    public function getIndustryMypageAttribute()
    {
        $industries = $this->industries()->pluck('name')->toArray();

        return implode('、', $industries);
    }

    public function getResultStrAttribute()
    {
        $result = $this->result;
        $status = $this->status;

        return ProjectHelper::getResult($status, $result);
    }

    /**
     * @return HasOne
     */
    public function founder()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function turnovers()
    {
        return $this->hasMany(Turnover::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function costs()
    {
        return $this->hasMany(Cost::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function dedications()
    {
        return $this->hasMany(Dedication::class, 'project_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'project_id', 'id');
    }

    public function getCountMemberAttribute()
    {
        return ProjectHelper::countMember($this->id, $this->status);
    }

    public static function listStatus()
    {
        return [
            self::STATUS_PENDING => trans('project.status.pending'),
            self::STATUS_RECRUITING => trans('project.status.recruiting'),
            self::STATUS_ACTIVE => trans('project.status.active'),
            self::STATUS_END => trans('project.status.end'),
        ];
    }

    public static function showChangeListStatus()
    {
        return [
            self::STATUS_PENDING => trans('project.show_status.pending'),
            self::STATUS_RECRUITING => trans('project.show_status.recruiting'),
            self::STATUS_ACTIVE => trans('project.show_status.active'),
            self::STATUS_END => trans('project.show_status.active'),
        ];
    }

    public static function showChangeBackListStatus()
    {
        return [
            self::STATUS_PENDING => trans('project.back_status.recruiting'),
            self::STATUS_RECRUITING => trans('project.back_status.recruiting'),
            self::STATUS_ACTIVE => trans('project.back_status.recruiting'),
            self::STATUS_END => trans('project.back_status.recruiting'),
        ];
    }
}
