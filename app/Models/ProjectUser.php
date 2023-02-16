<?php

namespace App\Models;

use App\Helpers\ProjectUserHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project_users';

    public const REQUEST_TYPE_RESEARCH = 0;
    public const REQUEST_TYPE_JOIN_NOW = 1;

    public const CONTACT_TYPE_EMAIL = 0;
    public const CONTACT_TYPE_PHONE = 1;
    public const CONTACT_TYPE_BOTH = 2;

    public const PARTICIPATION_STATUS_CONTACT = 1;
    public const PARTICIPATION_STATUS_SIGN_CONTRACT = 2;
    public const PARTICIPATION_STATUS_ACTIVE = 3;

    public const APPLICATION_STATUS_2_INTERVIEW = 1;
    public const APPLICATION_STATUS_3_INTERVIEW = 2;
    public const APPLICATION_STATUS_WAITING_RESULT = 3;

    public const STATUS_PENDING = 1;
    public const STATUS_WAITING_INTERVIEW = 2;
    public const STATUS_APPROVED = 3;
    public const STATUS_END = 4;

    public const ROLE_GUEST = 0;
    public const ROLE_OWNER = 1;
    public const ROLE_MEMBER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'request_type',
        'contact_type',
        'participation_status',
        'application_status',
        'status',
    ];

    /**
     * @return belongsToMany
     */
    public function projectsUsers()
    {
        return $this->belongsToMany(Project::class, 'project_users', 'user_id', 'project_id');
    }

    /**
     * @return BelongsTo
     */
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string|null
     */
    public function getStatusColorAttribute()
    {
        $status = $this->status;
        if ($this->projects->status === Project::STATUS_END) {
            $status = Project::STATUS_END;
        }

        return ProjectUserHelper::getClassColor($status);
    }

    /**
     * @return mixed|null
     */
    public function getStatusStrAttribute()
    {
        if ($this->projects->status === Project::STATUS_END) {
            return trans('project.status.end');
        }
        if ($this->status === self::STATUS_PENDING) {
            return self::listApplicationStatus()[$this->application_status];
        }
        return self::listAllParticipationStatus()[$this->participation_status];
    }

    public static function listAllParticipationStatus()
    {
        return [
            self::PARTICIPATION_STATUS_CONTACT => trans('project.participation_status.waiting_for_contact'),
            self::PARTICIPATION_STATUS_SIGN_CONTRACT => trans('project.participation_status.sign_contract'),
            self::PARTICIPATION_STATUS_ACTIVE => trans('project.participation_status.in_action'),
        ];
    }

    public function getResultStrAttribute()
    {
        $status = $this->status;

        return ProjectUserHelper::getResult($status);
    }

    public static function listRequestType()
    {
        return [
            self::REQUEST_TYPE_RESEARCH => trans('project.request_type.research'),
            self::REQUEST_TYPE_JOIN_NOW => trans('project.request_type.join_now'),
        ];
    }

    public static function listContactType()
    {
        return [
            self::CONTACT_TYPE_EMAIL => trans('project.contact_type.email'),
            self::CONTACT_TYPE_PHONE => trans('project.contact_type.phone'),
            self::CONTACT_TYPE_BOTH => trans('project.contact_type.both'),
        ];
    }

    public static function listParticipationStatus()
    {
        return [
            self::PARTICIPATION_STATUS_CONTACT => trans('project.participation_status.waiting_for_contact'),
            self::PARTICIPATION_STATUS_SIGN_CONTRACT => trans('project.participation_status.sign_contract'),
        ];
    }

    public static function listApplicationStatus()
    {
        return [
            self::APPLICATION_STATUS_2_INTERVIEW => trans('project.application_status.2_interview'),
            self::APPLICATION_STATUS_3_INTERVIEW => trans('project.application_status.3_interview'),
            self::APPLICATION_STATUS_WAITING_RESULT => trans('project.application_status.waiting_result'),
        ];
    }
}
