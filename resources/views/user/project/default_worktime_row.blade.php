<div class="row form-date-work">
    <div class="form-candidate col-xl-12 col-12">
        <div class="title-candidate">{{ trans('project.attribute.candidate_first') }} <span class="candidate-number">1</span> {{ trans('project.attribute.candidate_last') }}</div>
        <div class="content-candidate">
            <input type="hidden" name="available_id[]" value="{{ @$dataInput['id'] }}">
            <div class="input-date-worktime">
                <input class="form-control input-date"
                       data-date=""
                       data-date-format="YYYY年MM月DD日"
                       type="text" lang="ja" name="available_date[]"
                       value="{{ @$dataInput['date'] }}"
                       readonly='true'
                       placeholder="{{ trans('project.placeholder.work_content') }}" />
            </div>
            <div>
                <select class="form-control" name="available_start_time[]">
                    @for($i = 10; $i < 19; $i++)
                        <option value="{{ $i }}" @if($i == @$dataInput['startTime']) selected @endif>{{ ($i < 10 ? '0'.$i : $i) }}:00</option>
                    @endfor
                </select>
            </div>
            <div class="to-from-data">~</div>
            <div>
                <select class="form-control" name="available_end_time[]">
                    @for($i = 10; $i < 19; $i++)
                        <option value="{{ $i }}" @if($i == @$dataInput['endTime']) selected @endif>{{ ($i < 10 ? '0'.$i : $i) }}:00</option>
                    @endfor
                </select>
            </div>
            <div>
                <div class="img-date-work" onclick="removeRow(this)">
                    <img src="{{ asset('assets/icon/icon_close.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
