<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dedication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dedications';

    public const CHECK_PENDING = 0;
    public const CHECK_APPROVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'content',
        'item',
        'is_member_check',
        'is_founder_check',
        'date',
    ];
}
