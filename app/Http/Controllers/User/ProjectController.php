<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\Project\CreateRequest;
use App\Http\Requests\User\Project\RecruitmentRequest;
use App\Http\Requests\User\Project\SearchRequest;
use App\Http\Requests\User\Project\UpdateRequest;
use App\Models\ContactPeriod;
use App\Models\Cost;
use App\Models\Dedication;
use App\Models\Industry;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Turnover;
use App\Rules\CheckDate;
use App\Rules\CheckDateDedication;
use App\Services\User\ProjectService;
use App\Services\User\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class ProjectController extends BaseController
{
    protected $projectService;
    protected $userService;

    /**
     * ProjectController constructor.
     * @param ProjectService $projectService
     * @param UserService $userService
     */
    public function __construct(ProjectService $projectService, UserService $userService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
    }

    /**
     * List project
     *
     * @param SearchRequest $request
     * @return Application|Factory|View
     */
    public function list(SearchRequest $request)
    {
        $agent = new Agent;
        $user = $this->guard()->user();
        $inputs = ['search', 'industry_type', 'city_id', 'filter_type'];
        $projects = ProjectService::getInstance()->withUser($user)->list($request->only($inputs), $agent);

        return view('user.project.index')->with([
            'projects' => $projects,
            'industries' => config('master_data.industries'),
            'cities' => config('master_data.provinces'),
            'searchRequest' => $request->search,
            'industryTypeRequest' => $request->industry_type,
            'cityIdRequest' => $request->city_id,
            'filterTypeRequest' => $request->filter_type,
        ]);
    }

    /**
     * List project for mobile
     *
     * @param SearchRequest $request
     * @return string
     */
    public function listMobile(SearchRequest $request)
    {
        $agent = new Agent;
        $user = $this->guard()->user();
        $inputs = ['search', 'industry_type', 'city_id', 'filter_type'];
        $projects = ProjectService::getInstance()->withUser($user)->list($request->only($inputs), $agent);

        return ProjectService::getInstance()->withUser($user)->listMobile($projects);
    }

    /**
     * Detail project
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function detail(Project $project)
    {
        $user = $this->guard()->user();
        $data = ProjectService::getInstance()->withUser($user)->detail($project);
        if ($user) {
            $check = $project->projectUsers->where('user_id', $user->id)->whereIn('status', [ProjectUser::STATUS_APPROVED, ProjectUser::STATUS_END]);
            if (($project->user_id === $user->id) || (count($check))) {
                $isFounder = ($project->user_id === $user->id);
                return view('user.project.show_founder')->with([
                    'project' => $data['project'],
                    'mainImage' => $data['mainImage'],
                    'images' => $data['images'],
                    'isFounder' => $isFounder,
                ]);
            }
        }
        return view('user.project.show')->with([
            'project' => $data['project'],
            'mainImage' => $data['mainImage'],
            'images' => $data['images'],
        ]);
    }

    /**
     * Recruitment request to project
     *
     * @param Project $project
     * @param RecruitmentRequest $request
     * @return RedirectResponse
     */
    public function postDetail(Project $project, RecruitmentRequest $request)
    {
        $user = $this->guard()->user();
        $inputs = $request->only(['request_type', 'contact_type']);
        ProjectService::getInstance()->withUser($user)->postDetail($project, $inputs);

        return redirect()->back()->with('success', trans('project.success_message.recruitment'));
    }

    /**
     * Create project
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request)
    {
        $industries = Industry::all()->pluck('name', 'id');
        $contactPeriods = ContactPeriod::all()->pluck('name', 'id');
        return view('user.project.create', compact('industries', 'contactPeriods'));
    }

    /**
     * Store project
     *
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $project = $this->projectService->create($request->all());
        if ($project) {
            return redirect(route('user.project.complete'));
        }
        return redirect()->back();
    }

    /**
     * edit project
     *
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id)
    {
        $project = $this->projectService->find($id);
        if ($project === false) {
            return redirect()->to(route('user.my_page.index'));
        }
        if ($project->status !== Project::STATUS_PENDING) {
            return redirect()->to(route('user.my_page.index'));
        }
        $industries = Industry::all()->pluck('name', 'id');
        $contactPeriods = ContactPeriod::all()->pluck('name', 'id');
        return view('user.project.edit', compact('project', 'industries', 'contactPeriods'));
    }

    /**
     * edit project
     *
     * @param UpdateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $project = $this->projectService->update($request->except('_token'), $id);
        $request->session()->flash('success', trans('message.WORK013_I001'));
        if ($project) {
            return redirect(route('user.project.detail', [$project, rawurlencode($project->title)]));
        }
        return redirect()->back();
    }

    /**
     * Recruiting project
     *
     * @param $id
     * @return RedirectResponse
     */
    public function recruiting($id)
    {
        $project = $this->projectService->recruiting($id);
        return redirect()->to(route('user.project.detail', [$project, rawurlencode($project->title)]) . '#project-management');
    }


    /**
     * Complete project
     *
     * @return Application|Factory|View
     */
    public function complete()
    {
        return view('user.project.complete');
    }

    /**
     * UpdateCost project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateCost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'name' => 'required|max:16',
            'quantity' => 'required|numeric|min:0|digits_between:1,9',
            'unit_price' => 'required|numeric|min:0|digits_between:1,9',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $project = $this->projectService->updateCost($request->except(['_token']));
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }
    /**
     * UpdateCost project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteCost(Request $request, $id)
    {
        $project = $this->projectService->deleteCost($request->all(), $id);
        if ($project['status']) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }
    /**
     * UpdateTurnover project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateTurnover(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'name' => 'required|max:16',
            'quantity' => 'required|numeric|min:0|digits_between:1,9',
            'unit_price' => 'required|numeric|min:0|digits_between:1,9',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $project = $this->projectService->updateTurnover($request->except(['_token']));
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * DeleteTurnover project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteTurnover(Request $request, $id)
    {
        $project = $this->projectService->deleteTurnover($request->all(), $id);
        if ($project['status']) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * ListDedication project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function listDedication(Request $request, $id)
    {
        $project = $this->projectService->listDedication($request->get('user_id'), $id);
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * UpdateDedication project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateDedication(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'item' => 'required|max:16',
            'content' => 'required|max:255',
            'is_member_check' => 'nullable',
        ]);
        $data = $request->except(['_token', 'is_member_check', 'is_founder_check']);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }
        $project = $this->projectService->updateDedication($data);
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * UpdateDedicationMember project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateDedicationMember(Request $request, $id)
    {
        $project = $this->projectService->updateDedicationCheck($request->only(['id', 'is_member_check']));
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * UpdateDedicationFounder project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateDedicationFounder(Request $request, $id)
    {
        $project = $this->projectService->updateDedicationCheck($request->only(['id', 'is_founder_check']));
        if ($project) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * DeleteDedication project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteDedication(Request $request, $id)
    {
        $project = $this->projectService->deleteDedication($request->all(), $id);
        if ($project['status']) {
            return response()->json(['status' => true, 'data' => $project, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * DeleteDedication project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function projectUser(Request $request, $id)
    {
        $user = $this->userService->detail($request->get('user_id'));
        if ($user) {
            return response()->json(['status' => true, 'data' => $user, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * DeleteDedication project
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function projectUserUpdate(Request $request, $id)
    {
        $user = $this->projectService->updateStatusProjectUser($request->get('project_user_id'), $request->except(['project_user_id', '_token']));
        if ($user) {
            return response()->json(['status' => true, 'data' => $user, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    public function projectUserDelete(Request $request, $id)
    {
        $user = $this->projectService->rejectProjectUser($request->get('project_user_id'));
        if ($user) {
            return response()->json(['status' => true, 'data' => $user, 'message' => trans('message.update_success')]);
        }
        return response()->json(['status' => false, 'message' => trans('message.error')]);
    }

    /**
     * Send email legalization
     *
     * @param $id
     * @return RedirectResponse
     */
    public function legalization($id)
    {
        $project = $this->projectService->legalization($id);
        return redirect()->to(route('user.project.detail', [$project, rawurlencode($project->title)]) . '#project-management');
    }
}
