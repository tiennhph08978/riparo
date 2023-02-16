@extends('admin.layouts.index')

@section('title', trans('project.system.main_title'))

@section('content')
<div class="card-body container-fluid border-bottom-0">
    <div class="card card-outline-secondary p-2 border shadow-sm">
        <div class="card-body">
            <form method="get">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="page-title-box search-wrapper">
                            <div class="position-relative align-middle search-input-wrapper">
                                <div class="d-flex align-items-center small">
                                    <img src="{{ asset("assets/img/search-icon.svg") }}" alt="cover" class="text-muted position-absolute pl-3">
                                    <input type="search" name="search" class="form-control form-control-sm input-search pl-5 pt-3 pb-3"
                                        placeholder="{{ trans('project.system.admin_search') }}" value="{{ $search }}">
                                </div>
                            </div>

                            <div class="page-title-right">
                                <select class="select-input" name="status" id="status">
                                    <option value="">{{ trans('project.system.all_status') }}</option>
                                    @foreach(\App\Models\Project::listStatus() as $key => $value)
                                        <option value="{{ $key }}" @if($status == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="d-none"></button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="position-relative">
                            <div class="page-title-box d-flex align-items-center project-total">
                                <span>{{ trans('project.system.total_project') }}</span>&ensp;
                                <span class="detail">{{ $projects->total() . trans('project.system.record') }}</span>
                            </div>
                            @if ($projects->count())
                                <div style="overflow-x:auto;">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap m-0 table-list"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th class="text-center align-middle id">{{ trans('project.system.numerical_order') }}</th>
                                            <th class="text-center align-middle title">{{ trans('project.system.title') }}</th>
                                            <th class="text-center align-middle status">{{ trans('project.system.status') }}</th>
                                            <th class="text-center align-middle"></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($projects as $project)
                                            <tr>
                                                <td class="text-center align-middle">{{ \App\Helpers\ProjectHelper::formatId($project['id']) }}</td>
                                                <td class="align-middle text-title">{{ $project['title'] }}</td>
                                                <td class="text-center align-middle text-title {{ config('master_data.class_m_projects.' . $project['status']) }}">
                                                    {{ \App\Models\Project::listStatus()[$project['status']] }}
                                                </td>
                                                <td class="align-middle text-center action-wrapper">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href="{{ route('admin.projects.detail', $project) }}" class="text-center align-middle detail">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </a>

                                                        <a class="text-center align-middle delete" data-toggle="modal" data-target="#delete-{{ $project->id }}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                @include('admin.project.form_delete_project')
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3 float-right">
                                    {{ $projects->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @else
                                <div class="empty">
                                    <img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('.select-input').on("change", function(e) {
                $(this).closest("form").submit();
            });
        });
    </script>
@endpush
