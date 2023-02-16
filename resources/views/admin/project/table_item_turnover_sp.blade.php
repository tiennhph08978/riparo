<div class="item-turnover-sp form-content-modal" data-id="{{ @$dataInput['data-id'] }}">
    @csrf
    <input type="hidden" value="{{ @$dataInput['id'] }}" name="id">
    <input type="hidden" value="{{ @$dataInput['project_id'] }}" name="project_id">
    <div class="d-flex justify-content-between table-edit-cost-sp">
        <div class="d-flex">
            <span class="text-bold">{{ trans('project.turnover.date') }}:</span>
            <div>
                <input class="form-control show-edit input-date" readonly value="{{ @$dataInput['date'] }}" type="text" name="date" />
                <span class="show-detail form-data-date">{{ @$dataInput['date'] }}</span>
            </div>
        </div>
        <div class="d-flex justify-content-between button-action-img">
            @if($isFounder)
                <img class="button-edit-turnover show-detail" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                <img class="button-delete-turnover show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalTurnoverDelete">
                <img class="button-save-turnover show-edit" src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                <img class="button-cancel-turnover show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
            @endif
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.turnover.desc') }}:</span>
        <div>
            <input class="show-edit form-control" maxlength="16" value="{{ @$dataInput['name'] }}" type="text" name="name" />
            <span class="show-detail form-data-name">{{ @$dataInput['name'] }}</span>
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.turnover.quantity') }}:</span>
        <div>
            <input class="show-edit form-control" maxlength="9" value="{{ @$dataInput['quantity'] }}" type="number" name="quantity">
            <span class="show-detail form-data-quantity">{{ $dataInput['quantity'] ? number_format(@$dataInput['quantity']): '' }}</span>
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.turnover.price') }}:</span>
        <div>
            <input class="show-edit form-control" maxlength="9" value="{{ @$dataInput['unit_price'] }}" type="number" name="unit_price">
            <div class="show-detail">
                <div class="d-flex justify-content-between">
                    <span class="form-data-unit_price">{{ $dataInput['unit_price'] ? number_format(@$dataInput['unit_price']): '' }}</span>
                    <span>{{ trans('project.turnover.yen') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="table-edit-cost-sp">
        <div class="d-flex">
            <span class="text-bold">{{ trans('project.cost.total_amount') }}:</span>
            <span class="form-data-total">{{ $dataInput['total'] ? number_format(@$dataInput['total']): '' }}</span>
            <span>{{ trans('project.cost.yen') }}</span>
        </div>
    </div>
</div>
