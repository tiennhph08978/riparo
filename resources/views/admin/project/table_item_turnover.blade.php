<tr class="item-turnover" data-id="{{ @$dataInput['data-id'] }}">
    @csrf
    <input type="hidden" value="{{ @$dataInput['id'] }}" name="id">
    <input type="hidden" value="{{ @$dataInput['project_id'] }}" name="project_id">
    <td class="table-edit-turnover">
        <div>
            <input class="form-control show-edit input-date" readonly value="{{ @$dataInput['date'] }}" type="text" name="date" />
            <span class="show-detail form-data-date">{{ @$dataInput['date'] }}</span>
        </div>
    </td>
    <td class="table-edit-turnover">
        <div>
            <input class="show-edit form-control" maxlength="16" value="{{ @$dataInput['name'] }}" type="text" name="name" />
            <span class="show-detail form-data-name">{{ @$dataInput['name'] }}</span>
        </div>
    </td>
    <td class="table-edit-turnover">
        <div>
            <input class="show-edit form-control" maxlength="9" value="{{ @$dataInput['quantity'] }}" type="number" name="quantity">
            <span class="show-detail form-data-quantity">{{ $dataInput['quantity'] ? number_format(@$dataInput['quantity']): '' }}</span>
        </div>
    </td>
    <td class="table-edit-turnover">
        <div>
            <input class="show-edit form-control" maxlength="9" value="{{ @$dataInput['unit_price'] }}" type="number" name="unit_price">
            <div class="show-detail">
                <div class="d-flex justify-content-between">
                    <span class="form-data-unit_price">{{ $dataInput['unit_price'] ? number_format(@$dataInput['unit_price']): '' }}</span>
                    <span>{{ trans('project.turnover.yen') }}</span>
                </div>
            </div>
        </div>
    </td>
    <td>
        <div class="d-flex justify-content-between">
            <span class="form-data-total">{{ $dataInput['total'] ? number_format(@$dataInput['total']): '' }}</span>
            <span>{{ trans('project.turnover.yen') }}</span>
        </div>
    </td>
    <td class="action_edit">
        <div class="d-flex justify-content-center">
            @if($isFounder)
                <img class="button-edit-turnover show-detail mr-2" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                <img class="button-delete-turnover show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalTurnoverDelete">
                <p class="button-save-turnover show-edit text_save_cost">{{ trans('common.show_edit') }}</p>
                <img class="button-cancel-turnover show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
            @endif
        </div>
    </td>
</tr>

