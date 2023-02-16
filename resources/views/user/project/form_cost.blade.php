<div class="modal fade" id="modalCost" tabindex="-1" role="dialog" aria-labelledby="modalCostLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modalRejectLabel">{{ trans('project.cost.title_modal') }}</span>
                <button id="close-button-cost" type="button" data-dismiss="modal" class="close" aria-label="Close">
                    <img src="{{ asset('assets/icon/close-modal.svg') }}" alt="">
                </button>
            </div>
            <div class="modal-body" id="cost-table-modal">
                <div class="show-pc">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="cost-date" scope="col">{{ trans('project.cost.date') }}</th>
                            <th class="cost-desc" scope="col">{{ trans('project.cost.desc') }}</th>
                            <th class="cost-quantity" scope="col">{{ trans('project.cost.quantity') }}</th>
                            <th class="cost-price" scope="col">{{ trans('project.cost.price') }}</th>
                            <th scope="col">{{ trans('project.cost.total_amount') }}</th>
                            <th class="cost-action" scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cost-total">
                            <td>{{ trans('project.cost.sales_input') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <span id="total-cost-table">{{ number_format($project->totalCost) }}</span>
                                    <span>{{ trans('project.cost.yen') }}</span>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        @foreach($project->costs as $cost)
                            @include('user.project.table_item_cost', ['dataInput' => [
                                'id' => $cost->id,
                                'data-id' => $cost->id,
                                'project_id' => $project->id,
                                'date' => \App\Helpers\DateTimeHelper::formatDateJapan($cost->date),
                                'quantity' => $cost->quantity,
                                'name' => $cost->name,
                                'unit_price' => $cost->unit_price,
                                'total' => $cost->unit_price * $cost->quantity,
                            ]])
                        @endforeach
                        <tr id="button-add-cost">
                            <td colspan="6">
                                @if($isFounder)
                                    <div class="button-add-cost" id="addRowDefault">
                                        <img src="{{ asset('assets/icon/icon_add.svg') }}" alt="">
                                        <span>{{ trans('project.cost.to_add') }}</span>
                                    </div>
                                @endif
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
                                <span id="total-cost-table-sp">{{ number_format($project->totalCost) }}</span>
                                <span>{{ trans('project.cost.yen') }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="form-content-cost" class="form-content-sp">
                        @foreach($project->costs as $cost)
                            @include('user.project.table_item_cost_sp', ['dataInput' => [
                                'id' => $cost->id,
                                'data-id' => $cost->id,
                                'project_id' => $project->id,
                                'date' => \App\Helpers\DateTimeHelper::formatDateJapan($cost->date),
                                'quantity' => $cost->quantity,
                                'name' => $cost->name,
                                'unit_price' => $cost->unit_price,
                                'total' => $cost->unit_price * $cost->quantity,
                            ]])
                        @endforeach
                    </div>
                    <div>
                        @if($isFounder)
                            <div class="button-add-cost" id="addRowCostDefaultSp">
                                <img src="{{ asset('assets/icon/icon_add.svg') }}" alt="">
                                <span>{{ trans('project.cost.to_add') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCostSave" tabindex="-1" role="dialog" aria-labelledby="modalCostSaveLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="modalRejectLabel">{{ trans('project.cost.title_modal') }}</span>
                </div>
                <div class="modal-body">
                    {{ trans('project.cost.confirm_cancel') }}
                    <form id="form-save-cost" action="">
                        @csrf
                        <input id="delete-item-id" type="hidden" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button-cancel-close" class="btn btn-outline-success">{{ trans('common.button.no') }}</button>
                    <button id="button-form-cost" type="button" class="btn btn-success" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCostDelete" tabindex="-1" role="dialog" aria-labelledby="modalCostDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="modalRejectLabel">{{ trans('project.cost.title_modal') }}</span>
            </div>
            <div class="modal-body">
                {{ trans('message.confirm_delete') }}
                <form id="form-delete-cost" action="">
                    @csrf
                    <input id="form-cost-delete-id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button id="button-cancel-delete-cost" type="button" class="btn btn-outline-success" data-dismiss="modal" onclick="openModal()">{{ trans('common.button.no') }}</button>
                <button id="button-delete-cost" type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('common.button.yes') }}</button>
            </div>
        </div>
    </div>
</div>
