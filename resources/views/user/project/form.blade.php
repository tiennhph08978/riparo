<form id="recruitment-form-{{ $project->id }}" action="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}" method="post">
    @csrf
    <div class="recruitment-form {{ 'recruitment-' . $project->id }}">
        <div class="content">
            <span class="close">&times;</span>
            <h3>{{ trans('project.system.apply') }}</h3>
            <div class="project-title">
                <h3 class="title">
                    <div class="text-title">{{ $project->title }}</div>
                    @if (\App\Helpers\ProjectHelper::isNew($project))
                        <div class="div-new">
                            <span class="new">{{ trans('project.system.new') }}</span>
                        </div>
                    @endif
                </h3>
                <div class="d-flex">
                    <p class="m-0 category">{{ trans('project.attribute.industry') }}:</p>
                    <p class="m-0 category type">{{ $project->industry }}</p>
                </div>
            </div>
            <div class="option">
                <div class="option-name">{{ trans('project.system.interview') }}</div>
                <div class="select-option">
                    <div class="position-relative">
                        <input type="radio" name="request_type" value="0">
                        <span class="checkmark"></span>
                        <span>{{ trans('project.request_type.' . config('project.request_type.' . \App\Models\ProjectUser::REQUEST_TYPE_RESEARCH)) }}</span>
                    </div>
                    <div class="position-relative">
                        <input type="radio" name="request_type" value="1" checked>
                        <span class="checkmark"></span>
                        <span>{{ trans('project.request_type.' . config('project.request_type.' . \App\Models\ProjectUser::REQUEST_TYPE_JOIN_NOW)) }}</span>
                    </div>
                </div>
            </div>
            <div class="option pt-2">
                <div class="option-name">{{ trans('project.system.contact') }}</div>
                <div class="select-option">
                    <div class="position-relative">
                        <input type="radio" name="contact_type" value="0">
                        <span class="checkmark"></span>
                        <span>{{ trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_EMAIL)) }}</span>
                    </div>
                    <div class="position-relative">
                        <input type="radio" name="contact_type" value="1">
                        <span class="checkmark"></span>
                        <span>{{ trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_PHONE)) }}</span>
                    </div>
                    <div class="position-relative">
                        <input type="radio" name="contact_type" value="2" checked>
                        <span class="checkmark"></span>
                        <span>{{ trans('project.contact_type.' . config('project.contact_type.' . \App\Models\ProjectUser::CONTACT_TYPE_BOTH)) }}</span>
                    </div>
                </div>
            </div>

            <button id="{{ $project->id }}" type="submit" class="btn btn-block submit-recruitment">
                <img src="{{ asset('assets/img/project/email-icon.svg') }}">{{ trans('project.system.submit_form') }}
            </button>
        </div>
    </div>
</form>
