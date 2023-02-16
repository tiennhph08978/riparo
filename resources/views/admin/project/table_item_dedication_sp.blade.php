<div class="item-dedication-sp form-content-modal" data-id="{{ @$dataInput['data-id'] }}">
    @csrf
    <input type="hidden" value="{{ @$dataInput['id'] }}" name="id">
    <input type="hidden" value="{{ @$dataInput['project_id'] }}" name="project_id">
    <div class="d-flex justify-content-between table-edit-cost-sp">
        <div class="d-flex">
            <span class="text-bold">{{ trans('project.dedication.date') }}:</span>
            <div>
                <input class="form-control show-edit input-date" readonly value="{{ @$dataInput['date'] }}" type="text" name="date" />
                <span class="show-detail form-data-date">{{ @$dataInput['date'] }}</span>
            </div>
        </div>
        <div class="d-flex justify-content-between button-action-img">
            @if($isFounder)
                <img class="button-edit-dedication show-detail" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                <img class="button-delete-dedication show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalDedicationDelete">
                <img class="button-save-dedication show-edit" src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                <img class="button-cancel-dedication show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
            @endif
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.dedication.item') }}:</span>
        <div>
            <input class="show-edit form-control" value="{{ @$dataInput['item'] }}" type="text" name="item" />
            <span class="show-detail form-data-item">{{ @$dataInput['item'] }}</span>
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold title-mobile">{{ trans('project.dedication.desc') }}:</span>
        <div>
            <input class="show-edit form-control" value="{{ @$dataInput['content'] }}" type="text" name="content">
            <span class="show-detail form-data-content">{{ @$dataInput['content'] }}</span>
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.dedication.member_check') }}:</span>
        <div class="d-flex justify-content-center">
            <div class="form-data-member-check">
                @if(@$dataInput['is_member_check'])
                    <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                @endif
            </div>
        </div>
    </div>
    <div class="d-flex table-edit-cost-sp">
        <span class="text-bold">{{ trans('project.dedication.founder_check') }}:</span>
        <div class="d-flex justify-content-center">
            <div class="show-detail form-checkbox-custom-dedication">
                <div class="input-form-checkbox text-center">
                    <input class="input-checkbox-custom input-founder-check"
                           type="checkbox"
                           name="is_founder_check"
                           value="1"
                           data-label="is_founder_check"
                           data-id="{{ @$dataInput['id'] }}"
                           data-user_id="{{ @$dataInput['data-id'] }}"
                           @if(@$dataInput['is_founder_check']) checked @endif
                    >
                </div>
            </div>
            <div class="show-edit form-data-founder-check">
                @if(@$dataInput['is_founder_check'])
                    <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                @endif
            </div>
        </div>
    </div>
</div>
