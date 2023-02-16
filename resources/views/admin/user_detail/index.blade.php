@extends('admin.layouts.index')

@section('title', trans('admin.title.manager_user'))

@section('content')

<div class="card-body">
    <section class="bg-light">
            <div class="row">
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div class="card card-style1 border-0">
                        <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="{{ route('admin.manager-user.index') }}"><i class="fa-solid fa-circle-arrow-left back-icon"></i></a>

                                @if($result['user']->status == config('manager_user.status_user.inactive'))
                                    <a class="disabled">
                                        <i class="fa-solid fa-user-slash fa-2xl"></i>
                                    </a>
                                @else
                                    <a class="click" data-toggle="modal"
                                        data-target="#modal-ban-">
                                        <i class="fa-solid fa-user-slash text-danger fa-2xl"></i>
                                    </a>
                                @endif

                                <div class="modal fade" id="modal-ban-" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="vertical-alignment-helper">
                                        <div class="modal-dialog vertical-align-center" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <b class="modal-title" id="exampleModalLabel">{{ trans('admin.modal.title') }}</b>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body m-auto">
                                                    {{ trans('admin.modal.question') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.manager-user.update', $result['user']->id) }}" method="post">
                                                        @csrf
                                                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            {{ trans('admin.modal.yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col mb-lg-0">
                                    <h4 class="font-weight-bold">{{ trans('admin.user_detail.head') }}</h4>
                                </div>
                            </div>
                            <div class="row align-items-center mb-4">
                                <div class="col-xl-2 col-lg-3 mb-4 mb-lg-0">
                                    @if ($result['user']->avatar)
                                        <img src="{{ \App\Helpers\FileHelper::getFullUrl($result['user']->avatar) }}" alt="" width="100%">
                                    @else
                                        <img src="{{ asset('assets/img/default.png') }}" alt="" width="180px">
                                    @endif
                                </div>
                                <div class="col-xl-10 col-lg-9 px-xl-10">
                                    <div class="py-1-9 px-1-9 px-sm-6 mb-4 d-flex align-items-center">
                                        <div class="name">{{ $result['user']->fullName }}</div>
                                        <div class="name-furigana">（{{ $result['user']->full_name_furigana }}）</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row mb-4">
                                            <div class="col col-lg-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope-fill {{ $result['user']->status == config('manager_user.status_user.active') ? 'text-success' : '' }}" viewBox="0 0 16 16">
                                                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                                </svg>
                                                {{ $result['user']->email }}
                                            </div>
                                            <div class="col col-lg-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-telephone-fill {{ $result['user']->status == config('manager_user.status_user.active') ? 'text-success' : '' }}" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                </svg>
                                                {{ $result['user']->phone_number }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col address-admin">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill {{ $result['user']->status == config('manager_user.status_user.active') ? 'text-danger' : '' }}" viewBox="0 0 16 16">
                                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                </svg>
                                                {{ $result['user']->fullAddress }}
                                            </div>
                                            <div class="col">
                                                <img src="{{ asset('assets/icon/calendar.png') }}" alt="" width="24">
                                                {{ $result['user']->birth }}
                                            </div>
                                            <div class="col">
                                                @if ($result['user']->gender)
                                                <i class="fa-solid fa-venus-mars"></i>
                                                {{ $result['user']->gender ? \App\Models\User::getListGender()[$result['user']->gender] : '' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($result['user']->desc)
                                <div class="row align-items-center mb-4">
                                    <div class="col">
                                        <p><strong>{{ trans('admin.user_detail.intro') }}</strong></p>
                                        <p>{{ $result['user']->desc }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="row align-items-center mb-4">
                                <div class="col">
                                    <p><strong>{{ trans('admin.user_detail.project_list') }}</strong></p>
                                    <table id="table-list-detail" class="table table-bordered dataTable dtr-inline">
                                        <thead class="{{ $result['user']->status == 0 ? 'bg-secondary' : 'bg-success' }}">
                                            <tr>
                                                <th class="sorting sorting_asc" rowspan="1" aria-sort="ascending">ID</th>
                                                <th class="sorting" rowspan="1">{{ trans('admin.user_detail.project_name') }}</th>
                                                <th class="sorting" rowspan="1">{{ trans('admin.user_detail.status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($result['projects'] as $key => $project)
                                                <tr class="even">
                                                    <td class="sorting_1 dtr-control">{!! \App\Helpers\ProjectHelper::formatId($project->id) !!}</td>
                                                    <td>{{ $project->title }}</td>
                                                    <td>
                                                        @if($project->projectUsers->count())
                                                            @foreach($project->projectUsers as $prj)
                                                                <p class="{{ config('manager_user.text_color')[$prj->status] }}">
                                                                    {{ $statusText[$prj->status] }}</p>
                                                            @endforeach
                                                        @else
                                                            <p class="{{ config('master_data.class_m_projects')[$project->status] }}">
                                                                {{ config('master_data.m_projects.' . $project->status) }}</p>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@stop

@push('script')
<script>
    $(document).ready(function() {
        $(document).on('submit', '.modal-footer form', function() {
            $('button').attr('disabled', 'disabled');
        });
    });
</script>
@endpush
