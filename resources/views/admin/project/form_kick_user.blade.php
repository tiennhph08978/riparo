<div class="modal fade" id="{{ 'kick-user-' . $projectUser->user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <b class="modal-title" id="exampleModalLabel" style="font-size: 20px">{{ trans('project.system.kick_user') }}</b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-auto">
                    <span>{{ $projectUser->user->getFullNameAttribute() }}</span>
                    <span>{{ trans('project.system.kick_user_qt') }}</span>
                </div>
                <div class="modal-footer border-0">
                    <form action="{{ route('admin.projects.kick.member', ['project' => $project, 'user' => $projectUser->user]) }}" method="post">
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

@push('script')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.modal-footer form', function() {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
@endpush