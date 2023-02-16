<div class="modal fade" id="modalDedication" tabindex="-1" role="dialog" aria-labelledby="modalDedicationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modalRejectLabel">{{ trans('project.dedication.title_modal') }}</span>
                <button id="close-button-dedication" type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <img src="{{ asset('assets/icon/close-modal.svg') }}" alt="">
                </button>
            </div>
            <div id="dedication-table-modal" class="modal-body">
                <div class="change-user-id">
                    <select id="change-user-dedication-form" class="form-control">
                        @foreach($project->projectUserApprove as $key => $value)
                            <option value="{{ $value->user_id }}">{{ $value->user->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="show-pc">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="dedication-date" scope="col">{{ trans('project.dedication.date') }}</th>
                            <th class="dedication-item" scope="col">{{ trans('project.dedication.item') }}</th>
                            <th class="dedication-desc" scope="col">{{ trans('project.dedication.desc') }}</th>
                            <th class="dedication-member_check" scope="col">{{ trans('project.dedication.member_check') }}</th>
                            <th class="dedication-founder_check" scope="col">{{ trans('project.dedication.founder_check') }}</th>
                            <th class="dedication-action" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody id="dedication-table-modal-pc">
                        @foreach($project->dedications as $dedication)
                            @include('user.project.table_item_dedication', ['dataInput' => [
                                'id' => $dedication->id,
                                'data-id' => $dedication->id,
                                'project_id' => $project->id,
                                'date' => \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date),
                                'item' => $dedication->item,
                                'content' => $dedication->content,
                                'is_member_check' => $dedication->is_member_check,
                                'is_founder_check' => $dedication->is_founder_check,
                            ]])
                        @endforeach
                        </tbody>
                        <tbody>
                        <tr id="button-add-dedication">
                            <td colspan="6">
                                <div class="button-add-dedication" id="addRowDedication">
                                    <img src="{{ asset('assets/icon/icon_add.svg') }}" alt="">
                                    <span>{{ trans('project.dedication.to_add') }}</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="show-sp">
                    <div id="form-content-dedication" class="form-content-sp">
                        @foreach($project->dedications as $dedication)
                            @include('user.project.table_item_dedication_sp', ['dataInput' => [
                               'id' => $dedication->id,
                               'data-id' => $dedication->id,
                               'project_id' => $project->id,
                               'date' => \App\Helpers\DateTimeHelper::formatDateJapan($dedication->date),
                               'item' => $dedication->item,
                               'content' => $dedication->content,
                               'is_member_check' => $dedication->is_member_check,
                               'is_founder_check' => $dedication->is_founder_check,
                           ]])
                        @endforeach
                    </div>
                    <div>
                        <div class="button-add-cost" id="addRowDedicationSp">
                            <img src="{{ asset('assets/icon/icon_add.svg') }}" alt="">
                            <span>{{ trans('project.cost.to_add') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDedicationSave" tabindex="-1" role="dialog" aria-labelledby="modalDedicationSaveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="modalRejectLabel">{{ trans('project.dedication.title_modal') }}</span>
                </div>
                <div class="modal-body">
                    {{ trans('project.dedication.confirm_cancel') }}
                    <form id="form-save-dedication" action="">
                        @csrf
                        <input id="delete-item-id" type="hidden" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button-cancel-close" class="btn btn-outline-success">{{ trans('common.button.no') }}</button>
                    <button id="button-form-dedication" type="button" class="btn btn-success" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDedicationDelete" tabindex="-1" role="dialog" aria-labelledby="modalDedicationDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">{{ trans('project.dedication.title_modal') }}</span>
            </div>
            <div class="modal-body">
                {{ trans('message.confirm_delete') }}
                <form id="form-delete-dedication" action="">
                    @csrf
                    <input id="form-dedication-delete-id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button id="button-cancel-delete-dedication" type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="openModal()">{{ trans('common.button.no') }}</button>
                <button id="button-delete-dedication" type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
            </div>
        </div>
    </div>
</div>
