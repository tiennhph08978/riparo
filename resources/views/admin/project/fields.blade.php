<div class="content-project">
    @csrf
    <div class="import-image row">
        <div class="image-banner input-image col col-md-9 col-sm-12">
            <label for="project-banner" class="custom-file-upload">
                <div class="m-auto">
                    <img class="icon-upload-file" src="{{ asset('assets/icon/icon_upload.svg') }}" alt=""><span>{{ trans('common.upload_image') }}</span>
                </div>
                <img id="upload-banner-image"
                     class="show-image {{ $project ? 'show-default-image' : '' }}"
                     src="{{ $project ? App\Helpers\FileHelper::getFullUrl(@$project->banner->url) : '' }}" alt="your image" />
            </label>
            <input id="project-banner" name="image_banner" type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this, 'upload-banner-image');this.oldvalue = this.value;"/>
        </div>
        <div class="col col-md-3 col-sm-12 form-image-detail">
            <div class="row list-image-detail">
                <div class="input-image col col-md-12 col-sm-4">
                    <label for="project-deatail1" class="custom-file-upload">
                        <div class="m-auto">
                            <img src="{{ asset('assets/icon/icon_upload.svg') }}" alt="">
                        </div>
                        <img id="upload-deatail1-image"
                             class="show-image {{ $project ? (@$project->detailImages[0] ? 'show-default-image' : '') : '' }}"
                             src="{{ $project ? (@$project->detailImages[0] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[0]->url) : '') : '' }}" alt="your image" />
                    </label>
                    <input id="project-deatail-old1" type="hidden" name="image_detail_id[]" value="{{ @$project->detailImages[0] ? $project->detailImages[0]->id : '' }}"/>
                    <input id="project-deatail1" name="image_detail[]" type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this, 'upload-deatail1-image')" hidden/>
                </div>
                <div class="input-image col col-md-12 col-sm-4">
                    <label for="project-deatail2" class="custom-file-upload">
                        <div class="m-auto">
                            <img src="{{ asset('assets/icon/icon_upload.svg') }}" alt="">
                        </div>
                        <img id="upload-deatail2-image"
                             class="show-image {{ $project ? (@$project->detailImages[1] ? 'show-default-image' : '') : '' }}"
                             src="{{ $project ? (@$project->detailImages[1] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[1]->url) : '') : '' }}"
                             alt="your image" />
                    </label>
                    <input id="project-deatail-old2" type="hidden" name="image_detail_id[]" value="{{ @$project->detailImages[1] ? $project->detailImages[1]->id : '' }}"/>
                    <input id="project-deatail2" name="image_detail[]" type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this, 'upload-deatail2-image')" hidden/>
                </div>
                <div class="input-image col col-md-12 col-sm-4">
                    <label for="project-deatail3" class="custom-file-upload">
                        <div class="m-auto">
                            <img src="{{ asset('assets/icon/icon_upload.svg') }}" alt="">
                        </div>
                        <img id="upload-deatail3-image"
                             class="show-image {{ $project ? ( @$project->detailImages[2] ? 'show-default-image' : '') : '' }}"
                             src="{{ $project ? (@$project->detailImages[2] ? App\Helpers\FileHelper::getFullUrl($project->detailImages[2]->url) : '') : '' }}"/>
                    </label>
                    <input id="project-deatail-old3" type="hidden" name="image_detail_id[]" value="{{ @$project->detailImages[2] ? $project->detailImages[2]->id : '' }}"/>
                    <input id="project-deatail3" name="image_detail[]" type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this, 'upload-deatail3-image')" hidden/>
                </div>
            </div>
        </div>
        @error('image_banner')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.title'),
                'required' => true,
                'name' => 'title',
                'maxlength' => 50,
                'value' => old('title') ? old('title') : @$project->title,
                'placeholder' => trans('project.placeholder.title'),
                'row' => 2,
            ]
        ])
    </div>
    <div class="form-group form-select form-industry" >
        <label for="">{{ trans('project.attribute.industry') }}<span class="required">{{ trans('common.required') }}</span></label>
        <div class="multiselect" id="checkbox-industry">
            <div class="selectBox selectBoxCustom form-control @error('industry_type') input-invalid @enderror" onclick="showCheckboxes()">
                <select id="select-industry" class="non-select">
                    <option value="non-select">{{ trans('project.placeholder.industry') }}</option>
                    <option id="option-selected" value="select"></option>
                </select>
                <div class="overSelect"></div>
            </div>
            <div id="checkboxes">
                @foreach($industries as $key => $type)
                    <div class="d-flex form-checkbox-custom">
                        <div class="input-form-checkbox">
                            <input class="input-checkbox-custom"
                                   id="trigger{{ $key }}"
                                   type="checkbox"
                                   name="industry_type[]"
                                   data-label="{{ $type }}"
                                   value="{{ $key }}"
                                   @if(in_array($key, old('industry_type') ? old('industry_type') : ($project ? $project->industry_type : []))) checked @endif
                            >
                            <label for="trigger{{ $key }}" class="checker"></label>
                        </div>
                        <label class="label-checkbox" for="trigger{{ $key }}">{{ $type }}</label>
                    </div>
                @endforeach
            </div>
            @error('industry_type')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-sm-12 form-group-sm">
                <label for="">{{ trans('project.attribute.address') }}<span class="required">{{ trans('common.required') }}</span></label>
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <select class="form-control" name="city_id">
                            @foreach(config('master_data.provinces') as $key => $type)
                                <option value="{{ $key }}" @if($key == (old('city_id') ? old('city_id') : @$project->city_id)) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                @include('user.form.textarea', [
                    'dataInput' => [
                    'title' => trans('project.attribute.more_detail_area'),
                    'required' => false,
                    'name' => 'address',
                    'maxlength' => 32,
                    'value' => old('address') ? old('address') : @$project->address,
                    'placeholder' => trans('project.placeholder.more_detail_area'),
                    'row' => 2,
                    ]
                ])
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <label for="">{{ trans('project.attribute.target_amount') }}<span class="required">{{ trans('common.required') }}</span></label>
                <div class="row recruitment-number-money">
                    <div class="col-12">
                        <input name="target_amount"
                               maxlength="12"
                               class="form-control format_number"
                               oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                               placeholder="{{ trans('project.attribute.target_amount') }}"
                               value="{{ (old('target_amount') ? old('target_amount') : @$project->target_amount) }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">円</span>
                        </div>
                        @error('target_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 contract_period_reach">
                <label for="">{{ trans('project.attribute.contract_period_reach') }}<span class="required">{{ trans('common.required') }}</span></label>
                <div class="row">
                    <div class="col-12">
                        <select class="form-control" name="m_contact_period_id">
                            @foreach($contactPeriods as $key => $type)
                                <option value="{{ $key }}" @if($key == (old('m_contact_period_id') ? old('m_contact_period_id') : @$project->m_contact_period_id)) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('contract_period_reach')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group form-recruitment-number">
        <div class="row">
            <input type="hidden" name="check_recruitment" id="check-recruitment" value="1">
            <div class="col-md-4 col-sm-12 form-group-sm">
                <label for="">{{ trans('project.attribute.recruitment_quantity') }}<span class="required">{{ trans('common.required') }}</span></label>
                <div class="d-flex recruitment-quantity">
                    <div class="recruitment-quantity-number">
                        <input type="number"
                               name="recruitment_quantity_min"
                               onkeydown="return event.key != 'Enter';"
                               min="0"
                               max="50"
                               class="form-control change-recruitment number_share @error('recruitment_quantity_min') input-invalid @enderror"
                               value="{{ old('recruitment_quantity_min') ? old('recruitment_quantity_min') : ($project ? $project->recruitment_quantity_min : 1) }}">
                        @error('recruitment_quantity_min')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="to-from-data">~</div>
                    <div class="recruitment-quantity-number">
                        <input type="number"
                               name="recruitment_quantity_max"
                               onkeydown="return event.key != 'Enter';"
                               min="0"
                               max="50"
                               class="form-control change-recruitment number_share @error('recruitment_quantity_max') input-invalid @enderror"
                               value="{{ old('recruitment_quantity_max') ? old('recruitment_quantity_max') : ($project ? $project->recruitment_quantity_max : 2) }}">
                        @error('recruitment_quantity_max')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <label for="">{{ trans('project.attribute.recruitment_number') }}<span class="required">{{ trans('common.required') }}</span></label>
                <div class="row recruitment-number">
                    <div class="col-sm-6 col-xl-4 input-stock-distribution">
                        <div class="input-group flex-column">
                            <input type="number"
                                   onkeydown="return event.key != 'Enter';"
                                   name="recruitment_number"
                                   value="{{ old('recruitment_number') ? old('recruitment_number') : ($project ? $project->recruitment_number : 5) }}"
                                   min="0"
                                   max="100"
                                   class="form-control change-recruitment number_share @error('recruitment_number') input-invalid @enderror"
                                   aria-describedby="inputGroupPrepend" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">%</span>
                            </div>
                            @error('recruitment_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-8 stock-distribution">
                        {{ trans('project.attribute.stock_distribution') }}
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-12" id="founder-share-ratio">
                <span class="founder-share-ratio"></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.work_time'),
                'required' => true,
                'name' => 'work_time',
                'maxlength' => 255,
                'value' => old('work_time') ? old('work_time') : @$project->work_time,
                'placeholder' => trans('project.placeholder.work_time'),
                'row' => 2,
            ]
        ])
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
               'title' => trans('project.attribute.work_content'),
               'required' => true,
               'name' => 'work_content',
               'maxlength' => 255,
               'value' => old('work_content') ? old('work_content') : @$project->work_content,
               'placeholder' => trans('project.placeholder.work_content'),
                'row' => 3,
            ]
        ])
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.work_desc'),
                'required' => false,
                'can_enter' => true,
                'name' => 'work_desc',
                'maxlength' => 1000,
                'value' => old('work_desc') ? old('work_desc') : @$project->work_desc,
                'placeholder' => trans('project.placeholder.work_desc'),
                'row' => 7,
            ]
        ])
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.special'),
                'required' => false,
                'can_enter' => true,
                'name' => 'special',
                'maxlength' => 1000,
                'value' => old('special') ? old('special') : @$project->special,
                'placeholder' => trans('project.placeholder.special'),
                'row' => 7,
            ]
        ])
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.business_development_incorporation'),
                'required' => false,
                'can_enter' => true,
                'name' => 'business_development_incorporation',
                'maxlength' => 1000,
                'value' => old('business_development_incorporation') ? old('business_development_incorporation') : @$project->business_development_incorporation,
                'placeholder' => trans('project.placeholder.business_development_incorporation'),
                'row' => 7,
            ]
        ])
    </div>
    <div class="form-group">
        @include('user.form.textarea', [
            'dataInput' => [
                'title' => trans('project.attribute.employment_incorporation'),
                'required' => false,
                'can_enter' => true,
                'name' => 'employment_incorporation',
                'maxlength' => 1000,
                'value' => old('employment_incorporation') ? old('employment_incorporation') : @$project->employment_incorporation,
                'placeholder' => trans('project.placeholder.employment_incorporation'),
                'row' => 7,
            ]
        ])
    </div>
</div>
