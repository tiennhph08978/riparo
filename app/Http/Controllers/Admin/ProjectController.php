<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Project\SearchRequest;
use App\Http\Requests\Admin\Project\UpdateEndDateRequest;
use App\Http\Requests\Admin\Project\UploadPdfRequest;
use App\Http\Requests\User\Project\UpdateRequest;
use App\Models\ContactPeriod;
use App\Models\Industry;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\Admin\ProjectService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class ProjectController extends BaseController
{
    protected $projectService;

    /**
     * ProjectController constructor.
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->middleware($this->authMiddleware());
        $this->projectService = $projectService;
    }

    /**
     * Project list
     *
     * @param SearchRequest $request
     * @return Application|Factory|View
     */
    public function index(SearchRequest $request)
    {
        $inputs = ['search', 'status'];
        $data = ProjectService::getInstance()->index($request->only($inputs));

        return view('admin.project.index')->with([
            'projects' => $data,
            'search' => $request->search,
            'status' => $request->status,
        ]);
    }

    /**
     * Detail project
     *
     * @param Project $project
     * @return Application|Factory|View
     */
    public function detail(Project $project)
    {
        $data = ProjectService::getInstance()->detail($project);

        return view('admin.project.show')->with([
            'isFounder' => true,
            'project' => $data['project'],
            'projectUsers' => $data['projectUsers'],
            'mainImage' => $data['mainImage'],
            'images' => $data['images'],
            'contracts' => $data['contracts'],
            'startDate' => $data['startDate'],
            'endDate' => $data['endDate'],
            'endDateEditFormat' => $data['endDateEditFormat'],
            'isProjectUserContract' => $data['isProjectUserContract'],
        ]);
    }

    public function isProjectUserContract(Project $project)
    {
        $isProjectUserContract = $project->projectUsers->where('participation_status', ProjectUser::PARTICIPATION_STATUS_CONTACT)->first();

        return response()->json(['data' => $isProjectUserContract]);
    }

    /**
     * Delete project
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project)
    {
        $response = ProjectService::getInstance()->destroy($project);

        if ($response) {
            return redirect()->route('admin.projects.index')->with('success', '「' . $project->title . '」' . trans('project.system.delete_project_success'));
        }

        return redirect()->back()->with('error', $project->title . ' ' . trans('project.system.delete_error'));
    }

    /**
     * Upload image contract
     *
     * @param Project $project
     * @param UploadPdfRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadContract(Project $project, UploadPdfRequest $request)
    {
        $data = ProjectService::getInstance()->uploadContract($project, $request->file('pdf'));

        $now = null;
        if ($data['contract_old']) {
            $now = \App\Helpers\ProjectHelper::convertDateToJapan($data['contract_old']->created_at);
        }

        if ($data) {
            return response()->json(['data' => $data, 'now' => $now, 'success' => trans('project.system.upload_success')]);
        }

        return response()->json(['success' => $data]);
    }

    /**
     * @param Project $project
     * @param User $user
     * @return RedirectResponse
     */
    public function kickMember(Project $project, User $user)
    {
        ProjectService::getInstance()->kickMember($project, $user);

        return Redirect::to(URL::previous() . '#detail')->with('success', '「' . $user->getFullNameAttribute() . '」' . ' ' . trans('project.system.delete_success'));
    }

    /**
     * User dedications
     *
     * @param Project $project
     * @param Request $request
     * @return array
     */
    public function userDedications(Project $project, Request $request)
    {
        return ProjectService::getInstance()->userDedications($project, $request->get('user_id'));
    }

    /**
     * Change status project
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function changeStatus(Project $project)
    {
        $message = ProjectService::getInstance()->changeStatus($project);
        $tabActive = \request()->tab_active;
        if ($message['status']) {
            return Redirect::to(URL::previous() . $tabActive)->with('success', $message['message']);
        }

        return Redirect::to(URL::previous() . $tabActive)->with('error', $message['message']);
    }

    public function changeStatusAboutRecruiting(Project $project)
    {
        $tabActive = \request()->tab_active;
        if ($project) {
            ProjectService::getInstance()->changeStatusAboutRecruiting($project);

            return Redirect::to(URL::previous() . $tabActive)->with('success', trans('project.status_recruiting'));
        }

        return Redirect::to(URL::previous() . $tabActive)->with('error', trans('validation.update_error'));
    }

    /**
     * edit project
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $project = $this->projectService->find($id);
        $industries = Industry::all()->pluck('name', 'id');
        $contactPeriods = ContactPeriod::all()->pluck('name', 'id');
        return view('admin.project.edit', compact('project', 'industries', 'contactPeriods'));
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
            return redirect(route('admin.projects.detail', $project));
        }
        return redirect()->back();
    }

    /**
     * Update end date
     *
     * @param Project $project
     * @param UpdateEndDateRequest $request
     * @return RedirectResponse
     */
    public function endDateUpdate(Project $project, UpdateEndDateRequest $request)
    {
        $response = ProjectService::getInstance()->endDateUpdate($project, $request->get('date'));

        if (!$response) {
            return Redirect::to(URL::previous() . '#detail')->withInput()->withErrors($response);
        }

        return Redirect::to(URL::previous() . '#detail')->with('success', '「' . $project->title . '」' . trans('project.system.update_date'));
    }

    /**
     * projectUserUpdate project
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function projectUserUpdate(Request $request)
    {
        $response = $this->projectService->updateStatusProjectUser($request->get('project_user_id'), $request->except(['project_user_id', '_token', 'id']));

        if (!$response) {
            return Redirect::to(URL::previous() . '#detail')->withInput()->withErrors($response);
        }
        $message = trans('project.system.accept_user', ['user' => $response->user->first_name . ' ' . $response->user->last_name, 'project' => $response->projects->title]);

        return Redirect::to(URL::previous() . '#detail')->with('success', $message);
    }

    public function projectUserDelete(Request $request)
    {
        $response = $this->projectService->rejectProjectUser($request->get('project_user_id'));
        if (!$response) {
            return Redirect::to(URL::previous() . '#detail')->withInput()->withErrors($response);
        }

        $message = trans('project.system.accept_user', ['user' => $response->user->first_name . ' ' . $response->user->last_name, 'project' => $response->projects->title]);

        return Redirect::to(URL::previous() . '#detail')->with('success', $message);
    }
}
