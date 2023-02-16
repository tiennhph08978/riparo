<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAvailableDate extends Model
{
    use HasFactory;

    protected $table = 'project_available_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'date',
        'start_time',
        'end_time',
    ];
}
