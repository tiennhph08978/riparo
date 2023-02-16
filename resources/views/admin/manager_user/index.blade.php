@extends('admin.layouts.index')

@section('title', trans('admin.title.manager_user'))

@section('content')
<div class="card-body">
    <div class="card card-outline-secondary p-2 pt-0">
        <div class="card-body">
            <div class="dataTables_wrapper dt-bootstrap4 w-50 pb-2">
                <div class="d-flex align-items-center small w-75">
                    <img src="{{ asset("assets/img/search-icon.svg") }}" alt="cover" class="text-muted position-absolute pl-3">
                    <input type="search" class="form-control form-control-sm input-search pl-5 pt-3 pb-3" placeholder="{{ trans('admin.search') }}"
                        name="search" onkeypress="redirectSearch(this)" value="{{ $search }}" max="255" maxlength="255">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-flex align-items-center project-total">
                        <span>{{ trans('project.system.total_people') }}</span>&ensp;
                        <span class="detail">{{ $results->total() . trans('project.system.people') }}</span>
                    </div>
                    <table id="table-list" class="table table-bordered dataTable dtr-inline font-size-13" style="table-layout: fixed; word-wrap: break-word;">
                        <thead class="bg-success">
                            <tr>
                                <th style="width: 50px" class="text-center align-middle">No.</th>
                                <th style="width: 130px" class="text-center align-middle">{{ trans('admin.table.avatar') }}</th>
                                <th style="width: 20%" class="text-center align-middle">{{ trans('admin.table.information') }}</th>
                                <th style="width: 20%" class="text-center align-middle">{{ trans('admin.table.address') }}</th>
                                <th style="width: 24%" class="text-center align-middle">{{ trans('admin.table.project_name') }}</th>
                                <th style="width: 24%" class="text-center align-middle">{{ trans('admin.table.memo') }}</th>
                                <th class="text-center align-middle action"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($results->count())
                            @foreach($results as $result)
                                @if($result->status == config('manager_user.status.active'))
                                    <tr class="even bg-secondary text-dark">
                                        @endif
                                        <td class="text-center align-middle">{{ $result->id }} </td>
                                        <td class="align-middle" style="width: 140px">
                                            @if ($result->avatar)
                                                <img src="{{ \App\Helpers\FileHelper::getFullUrl($result->avatar) }}" alt="">
                                            @else
                                                <img src="{{ asset('assets/img/default.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="full-name">{{ $result->fullName }}</span><br/>
                                            <lable>{{ trans('admin.table.td_email') }}</lable>{{ $result->email }}<br/>
                                            <lable>{{ trans('admin.table.td_phone_number') }}</lable>{{ $result->phone_number }}
                                        </td>
                                        <td class="align-middle">{{ $result->fullAddress }}</td>
                                        <td class="fit">
                                            @foreach ($result->projectUsers as $project_user)
                                                <li>{{ $project_user->title }}</li>
                                            @endforeach
                                            @foreach ($result->projects as $project)
                                                <li>{{ $project->title }}</li>
                                            @endforeach
                                        </td>
                                        <td class="align-middle form-memo">
                                            <div class="form-edit-memo">
                                                <form action="" method="POST">
                                                    @csrf
                                                    <textarea class="memo-textarea form-control" maxlength="1000" name="memo" placeholder="{{ trans('admin.table.memo') }}">{{ old('memo', $result->memo) ?? '' }}</textarea>
                                                    <div class="d-flex">
                                                        <div class="save-memo" data-route="{{ route('admin.manager-user.updateUser', $result->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" color="#13b67b" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="cancel-memo">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" color="#ff3030" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="form-show-memo">
                                                <div class="content-memo">{!! \App\Helpers\StringHelper::formatContent($result->memo) !!}</div>
                                                <div class="edit-memo">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center action-wrapper fit">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a style="font-size: 24px; padding-right: 5px" href="{{ route("admin.manager-user.detail",[$result->id]) }}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </a>

                                                @if($result->status == config('manager_user.status_user.active'))
                                                    <a class="click" data-toggle="modal"
                                                            data-target="#modal-ban-{{ $result->id }}">
                                                        <i class="fa-solid fa-user-slash text-danger fa-xl"></i>
                                                    </a>
                                                @else
                                                    <a class="disabled">
                                                        <i class="fa-solid fa-user-slash fa-xl"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>

                                            <div class="modal fade" id="modal-ban-{{ $result->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="vertical-alignment-helper">
                                                    <div class="modal-dialog vertical-align-center" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-0">
                                                                <b class="modal-title" id="exampleModalLabel">{{ trans('admin.modal.title') }}</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body m-auto">
                                                                {{ trans('admin.modal.question') }}
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <form action="{{ route('admin.manager-user.update', $result->id) }}" method="post">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">{{ trans('admin.modal.no') }}</button>
                                                                    <button type="submit" class="btn btn-danger"
                                                                    >{{ trans('admin.modal.yes') }}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class="no-data justify-content-center">
                                        <td class="text-center" colspan="7">{{ trans('admin.table.no_data') }}</td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if($results->total() > config('magager_user.total.10'))
                <div class="float-right">
                    {!! $results->withQueryString()->links() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@stop
@push('script')
    <script type="text/javascript">
        function redirectSearch(e) {
            var keycode = event.keyCode || event.which;
            if(keycode == '13') {
                window.location.search = '?search=' + e.value
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '.modal-footer form', function() {
                $('button').attr('disabled', 'disabled');
            });
            $('.edit-memo').on('click', function (e) {
                let formEdit = $(this).parent().parent()
                formEdit.find('.form-show-memo').hide()
                formEdit.find('.form-edit-memo').show()
                let memo = formEdit.find('.content-memo').html()
                formEdit.find('.memo-textarea').val(memo)
            })
            $('.cancel-memo').on('click', function (e) {
                let formEdit = $(this).parent().parent().parent().parent()
                formEdit.find('.form-edit-memo').hide()
                formEdit.find('.form-show-memo').show()
            })
            $('.save-memo').on('click', function (e) {
              let formEdit = $(this).parent().parent().parent().parent()
              let url = $(this).data().route
              let data = {};
              let dataArray = $(this).parent().parent().serializeArray();
              for(let i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
              }
              $.ajax({
                url : url,
                type : "post",
                data : data,
                success : function (result){
                  if (result.status) {
                    formEdit.find('.content-memo').html(data.memo)
                    formEdit.find('.form-edit-memo').hide()
                    formEdit.find('.form-show-memo').show()
                    toastr.success(result.message);
                  } else {
                    toastr.error(result.message);
                  }
                }
              });
            })
        });
    </script>
@endpush
