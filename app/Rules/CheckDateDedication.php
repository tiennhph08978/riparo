<?php

namespace App\Rules;

use App\Models\Cost;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckDateDedication implements Rule
{
    protected $project;
    protected $id;
    protected $userId;
    protected $model;

  /**
   * Create a new rule instance.
   *
   * @param $project
   * @param $id
   */
    public function __construct($project, $id, $userId, $model)
    {
        $this->project = $project;
        $this->id = $id;
        $this->userId = $userId;
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cost = $this->model::where('date', Carbon::createFromFormat('Y年m月d日', $value)->toDateString())
          ->where('id', '<>', $this->id)
          ->where('user_id', $this->userId)
          ->where('project_id', $this->project)->first();
        if ($cost) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('project.cost.duplicate_date');
    }
}
