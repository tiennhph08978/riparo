<div class="modal fade" id="modalTurnover" tabindex="-1" role="dialog" aria-labelledby="modalTurnoverLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modalTurnoverLabel">{{ trans('project.turnover.title_modal') }}</span>
                <button id="close-button-turnover" type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <img src="{{ asset('assets/icon/close-modal.svg') }}" alt="">
                </button>
            </div>
            <div class="modal-body" id="turnover-table-modal">
                <div class="show-pc">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="turnover-date" scope="col">{{ trans('project.turnover.date') }}</th>
                            <th class="turnover-desc" scope="col">{{ trans('project.turnover.desc') }}</th>
                            <th class="turnover-quantity" scope="col">{{ trans('project.turnover.quantity') }}</th>
                            <th class="turnover-price" scope="col">{{ trans('project.turnover.price') }}</th>
                            <th scope="col">{{ trans('project.turnover.total_amount') }}</th>
                            <th class="turnover-action" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="turnover-total">
                            <td>{{ trans('project.turnover.sales_input') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span id="total-turnover-table">{{ number_format($project->totalTurnover) }}</span>
                                    <span>{{ trans('project.turnover.yen') }}</span>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        @foreach($project->turnovers as $turnover)
                            @include('user.project.table_item_turnover', ['dataInput' => [
                                'id' => $turnover->id,
                                'data-id' => $turnover->id,
                                'project_id' => $project->id,
                                'date' => \App\Helpers\DateTimeHelper::formatDateJapan($turnover->date),
                                'quantity' => $turnover->quantity,
                                'name' => $turnover->name,
                                'unit_price' => $turnover->unit_price,
                                'total' => $turnover->unit_price * $turnover->quantity,
                            ]])
                        @endforeach
                        <tr id="button-add-turnover">
                            <td colspan="6">
                                <div class="button-add-turnover" id="addRowTurnover">
                                    <img src="{{ asset('assets/icon/icon_add.svg') }}" alt="">
                                    <span>{{ trans('project.turnover.to_add') }}</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="show-sp">
                    <div class="form-content-modal">
                        <div class="d-flex justify-content-between">
                            <div>{{ trans('project.cost.sales_input_sp') }}</div>
                            <div>
                                <span id="total-turnover-table-sp">{{ number_format($project->totalTurnover) }}</span>
                                <span>{{ trans('project.cost.yen') }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="form-content-turnover" class="form-content-sp">
                        @foreach($project->turnovers as $turnover)
                            @include('user.project.table_item_turnover_sp', ['dataInput' => [
                                 'id' => $turnover->id,
                                 'data-id' => $turnover->id,
                                 'project_id' => $project->id,
                                 'date' => \App\Helpers\DateTimeHelper::formatDateJapan($turnover->date),
                                 'quantity' => $turnover->quantity,
                                 'name' => $turnover->name,
                                 'unit_price' => $turnover->unit_price,
                                 'total' => $turnover->unit_price * $turnover->quantity,
                             ]])
                        @endforeach
                    </div>
                    <div>
                        <div class="button-add-cost" id="addRowTurnoverSp">
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
    <div class="modal fade" id="modalTurnoverSave" tabindex="-1" role="dialog" aria-labelledby="modalTurnoverSaveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="modalRejectLabel">{{ trans('project.turnover.title_modal') }}</span>
                </div>
                <div class="modal-body">
                    {{ trans('project.turnover.confirm_cancel') }}
                    <form id="form-save-turnover" action="">
                        @csrf
                        <input id="delete-item-id" type="hidden" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button-cancel-close" class="btn btn-outline-success">{{ trans('common.button.no') }}</button>
                    <button id="button-form-turnover" type="button" class="btn btn-success" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTurnoverDelete" tabindex="-1" role="dialog" aria-labelledby="modalTurnoverDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modalTurnoverLabel">{{ trans('project.turnover.title_modal') }}</span>
            </div>
            <div class="modal-body">
                {{ trans('message.confirm_delete') }}
                <form id="form-delete-turnover" action="">
                    @csrf
                    <input id="form-turnover-delete-id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button id="button-cancel-delete-turnover" type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="openModal()">{{ trans('common.button.no') }}</button>
                <button id="button-delete-turnover" type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
            </div>
        </div>
    </div>
</div>
