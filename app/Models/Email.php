<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    public const TYPE_FORGOT_PASSWORD = 1;
    public const TYPE_START_PROJECT = 2;
    public const TYPE_USER_BAN = 3;
    public const TYPE_FAILURE_PROJECT = 5;
    public const TYPE_SUCCESSFUL_PROJECT = 6;
    public const TYPE_RECRUITMENT_USER = 17;
    public const TYPE_RECRUITMENT_ADMIN = 18;
    public const TYPE_MEMBER_BAN = 9;
    public const TYPE_MEMBER_APPROVED = 10;
    public const TYPE_CREATE_PROJECT = 12;
    public const TYPE_RECRUITING_ADMIN = 13;
    public const TYPE_LEGALIZATION = 14;
    public const TYPE_TO_USER_BAN = 15;
    public const TYPE_DELETE_PROJECT = 16;
    public const TYPE_VERIFY_EMAIL = 19;
    public const TYPE_CREATE_PROJECT_FOUNDER = 20;
    public const MAIL_ADMIN = [12, 13, 14, 18];
    protected $table = 'emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'header',
        'content',
        'contact',
        'type',
    ];
}
