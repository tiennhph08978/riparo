<tr class="item-dedication" data-id="{{ @$dataInput['data-id'] }}">
    @csrf
    <input type="hidden" value="{{ @$dataInput['id'] }}" name="id">
    <input type="hidden" value="{{ @$dataInput['project_id'] }}" name="project_id">
    <td class="table-edit-dedication">
        <div>
            <input class="form-control show-edit input-date" readonly value="{{ @$dataInput['date'] }}" type="text" name="date" />
            <span class="show-detail form-data-date">{{ @$dataInput['date'] }}</span>
        </div>
    </td>
    <td class="table-edit-dedication">
        <div>
            <input class="show-edit form-control" maxlength="16" value="{{ @$dataInput['item'] }}" type="text" name="item" placeholder="{{ trans('project.dedication.item_name') }}"/>
            <span class="show-detail form-data-item">{{ @$dataInput['item'] }}</span>
        </div>
    </td>
    <td class="table-edit-dedication">
        <div>
            <input class="show-edit form-control" maxlength="255" value="{{ @$dataInput['content'] }}" type="text" name="content" placeholder="{{ trans('project.dedication.content') }}">
            <span class="show-detail form-data-content">{{ @$dataInput['content'] }}</span>
        </div>
    </td>
    <td>
        <div class="d-flex justify-content-center">
            <div class="form-data-member-check">
                @if(@$dataInput['is_member_check'])
                    <img src="{{ asset('assets/img/icon_checked.svg') }}" alt="">
                @endif
            </div>
        </div>
    </td>
    <td>
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
    </td>
    <td>
        <div class="d-flex justify-content-between">
            @if($isFounder)
                <img class="button-edit-dedication show-detail" src="{{ asset('assets/img/icon_edit.svg') }}" alt="">
                <img class="button-delete-dedication show-detail" src="{{ asset('assets/img/icon_delete.svg') }}" alt="" data-toggle="modal" data-target="#modalDedicationDelete">
                <p class="button-save-dedication show-edit text_save_cost">{{ trans('common.show_edit') }}</p>
                <img class="button-cancel-dedication show-edit" src="{{ asset('assets/img/icon_cancel.svg') }}" alt="">
            @endif
        </div>
    </td>
</tr>

