@extends('user.layouts.landing_page')

@section('title', trans('project.system.main_title'))

@section('content')
    <div id="project-list" class="wrapper">
        @include('sweetalert::alert')

        <img src="{{ asset("assets/img/project/cover.svg") }}" alt="project-cover" class="project-cover">

        <div id="project-list" class="project-list">
            <form id=search class="form-search" method="get">
                <div class="search-filter">
                    <input name="search" class="search-input" placeholder="{{ trans('project.system.user_search') }}" value="{{ $searchRequest }}">
                    <img src="{{ asset("assets/img/search-icon.svg") }}" alt="cover" class="search-icon">
                    <div class="custom-select select-input-long">
                        <select id="industries" name="industry_type" id="industryType">
                            <option id="selected" selected="selected" value="{{ $industryTypeRequest }}">
                                {{ config('master_data.industries.' . $industryTypeRequest) ?? trans('project.system.all_categories') }}
                            </option>

                            <option value="">{{ trans('project.system.all_categories') }}</option>
                            @foreach($industries as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="custom-select select-input-long">
                        <select id="provinces" name="city_id">
                            <option selected="selected" value="{{ $cityIdRequest }}">
                                {{ config('master_data.provinces.' . $cityIdRequest) ?? trans('project.system.all_cities') }}
                            </option>

                            <option value="">{{ trans('project.system.all_cities') }}</option>
                            @foreach($cities as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-block btn-search submit-form-data">{{ trans('project.system.search') }}</button>

                <div class="project-head">
                    <h3 class="amount-title">{{ trans('project.system.total') }}：<span class="amount-title amount">{{ $projects->total() }}{{ trans('project.system.record') }}</span></h3>
                    <div class="project-filter">
                        <img src="{{ asset("assets/img/filter-icon.svg") }}" alt="cover" class="filter-icon">
                        <div class="custom-select select-input-short m-0">
                            <select id="filters" name="filter_type">
                                @if($filterTypeRequest)
                                    <option selected="selected" value="{{ $filterTypeRequest }}">
                                        {{ trans('project.filter.' . config('project.filter.' . $filterTypeRequest)) }}
                                    </option>
                                @else
                                    <option selected="selected" value="">{{ trans('project.filter.type') }}</option>
                                @endif
                                <option value="1">{{ trans('project.filter.recent_time') }}</option>
                                <option value="2">{{ trans('project.filter.shortest_time') }}</option>
                                <option value="3">{{ trans('project.filter.stock_ratio') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="project-row-list">
                @if(count($projects))
                    @foreach($projects as $project)
                        <div class="row">
                            <div class="project-wrapper">
                                <div class="d-flex project-title-wrapper">
                                    @if($project->banner)
                                    <div>
                                        <img src="{{ App\Helpers\FileHelper::getFullUrl($project->banner->url) }}" alt="cover" class="project-thumb">
                                    </div>
                                    @endif
                                    <div class="project-title">
                                        <h3 class="title">
                                            <span class="text-title">{{ $project->title}}</span>
                                            @if (\App\Helpers\ProjectHelper::isNew($project))
                                                <div class="div-new">
                                                    <span class="new">{{ trans('project.system.new') }}</span>
                                                </div>
                                            @endif
                                        </h3>

                                        <div class="d-flex">
                                            <span class="category mb-0">{{ trans('project.attribute.industry') }}:</span>
                                            <span class="category type mb-0">{{ ' ' . $project->industry }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="project-info-wrapper">
                                    <div class="project-info-col">
                                        <div class="project-info-line  col-left">
                                            <img src="{{ asset("assets/img/project/people-icon.svg") }}" alt="cover" class="project-icon">
                                            <p class="project-info-title">{{ trans('project.attribute.recruitment_quantity') }}:
                                                <span class="project-info-content">
                                                {{ $project->recruitment_quantity_min }}人〜{{ $project->recruitment_quantity_max }}人
                                            </span>
                                            </p>
                                        </div>
                                        <div class="project-info-line">
                                            <img src="{{ asset("assets/img/project/location-icon.svg") }}" alt="location" class="project-icon">
                                            <p class="project-info-title">{{ trans('project.attribute.address') }}:
                                                <span class="project-info-content">{{ config('master_data.provinces.' . $project->city_id) }}</span>
                                                <span class="project-info-content">{{ $project->address }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="project-info-col">
                                        <div class="project-info-line col-left">
                                            <img src="{{ asset("assets/img/project/percent-icon.svg") }}" alt="percent" class="project-icon">
                                            <p class="project-info-title">{{ trans('project.attribute.recruitment_number') }}: <span class="project-info-content">{{ $project->recruitment_number }}%</span></p>
                                        </div>
                                        <div class="project-info-line">
                                            <img src="{{ asset("assets/img/project/calendar-icon.svg") }}" alt="calendar" class="project-icon">
                                            <p class="project-info-title">{{ trans('project.attribute.contract_period_reach') }}:
                                                <span class="project-info-content">{{ $project->contactPeriod->name }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="project-info-line">
                                        <img src="{{ asset("assets/img/project/time-icon.svg") }}" alt="time" class="project-icon">
                                        <p class="project-info-title">
                                            <span class="project-info-content-min">{{ trans('project.attribute.work_time') }}: </span>
                                            <span class="project-info-content">{{ $project->work_time }}</span></p>
                                    </div>

                                    <div class="project-info-line mb-0">
                                        <img src="{{ asset("assets/img/project/desc-icon.svg") }}" alt="desc" class="project-icon">
                                        <p class="project-info-title">
                                            <span class="project-info-content-min">{{ trans('project.attribute.work_content') }}:</span>
                                            <span class="project-info-content">{{ $project->work_content }}</span></p>
                                    </div>
                                </div>

                                <div class="project-btn">
                                    <a href="{{ \App\Helpers\UrlHelper::getProjectUrl($project) }}" class="login-link p-link">{{ trans('project.system.detail') }}</a>
                                    @if($user)
                                        @if(\App\Helpers\ProjectHelper::getProjectRole($project, $user) == \App\Models\ProjectUser::ROLE_GUEST)
                                            <a id="{{ $project->id }}" href="{{ '?recruitment-' . $project->id }}" class="p-btn recruitment-btn {{ 'project-' . $project->id }}">{{ trans('project.system.recruitment') }}</a>
                                            @include('user.project.form')
                                        @endif
                                    @else
                                        <a href="{{ route('user.auth.login') . '?next_page_url=' . route('user.project.list') . '?recruitment-' . $project->id}}" class="p-btn">
                                            {{ trans('project.system.recruitment') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div id="project-append"></div>
                @else
                    <img src="{{ asset("assets/img/empty.svg") }}" alt="cover" class="empty-img">
                @endif

                <div class="div-load-more">
                    <a id="load-more" class="load-more">{{ trans('project.system.load_more') }}</a>
                </div>

                {{ $projects->appends(request()->input())->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $( document ).ready(function() {
        $('#search .select-input-short').bind('DOMSubtreeModified', function(e) {
            $(this).closest('form').submit();
        });
        $('.submit-form-data').click(function(e) {
            e.preventDefault()
            $(this).prop('disabled', true)
            $('#search').submit()
        });
        $('.submit-recruitment').click(function(e) {
            e.preventDefault()
            $(this).prop('disabled', true)
            $('#recruitment-form-' + $(this).attr('id')).submit()
            window.history.replaceState(null, null, $(location).attr('origin') + '/project');
        });
    });
</script>

<script>
    const fullUrl = $(location).attr('protocol') + '//' + $(location).attr('hostname') + '/project';
    const projectListUrl = $(location).attr('href');
    const path = projectListUrl.split(fullUrl).join('');
    const span = $('.close');
    $(document).ready(function() {
        const formClass = $('.'+path.slice(path.search('recruitment')));

        if (path.search('recruitment') > 0) {
            formClass.addClass('d-flex');

            span.click(function () {
                formClass.removeClass('d-flex');
                window.history.replaceState(null, null, fullUrl);
            });
            $(window).on('click', function (e) {
                if ($(e.target).is('.recruitment-form')) {
                    formClass.removeClass('d-flex');
                    window.history.replaceState(null, null, fullUrl);
                }
            });
        }
    });

    $('.recruitment-btn').click(function(e) {
        let projectId = $(this).attr('id');

        $('.recruitment-' + projectId).addClass('d-flex');
        if (path.search('page') > 0) {
            window.history.replaceState(null, null, path + '&recruitment-' + projectId);
        } else {
            window.history.replaceState(null, null, '?recruitment-' + projectId);
        }

        span.click(function () {
            $('.recruitment-' + projectId).removeClass('d-flex');
            window.history.replaceState(null, null, projectListUrl);
        });
        $(window).on('click', function (e) {
            if ($(e.target).is('.recruitment-form')) {
                $('.recruitment-' + projectId).removeClass('d-flex');
                window.history.replaceState(null, null, projectListUrl);
            }
        });
        e.preventDefault();
    });
</script>

<script>
    let x, i, j, l, ll, selElmnt, a, b, c;
    x = document.getElementsByClassName('custom-select');
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName('select')[0];
        ll = selElmnt.length;
        a = document.createElement('DIV');
        a.setAttribute('class', 'select-selected');
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        b = document.createElement('DIV');
        b.setAttribute('class', 'select-items select-hide');
        for (j = 1; j < ll; j++) {
            c = document.createElement('DIV');
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.setAttribute('class', 'items');
            c.addEventListener('click', function(e) {
                let y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName('select')[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName('same-as-selected');
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute('class');
                        }
                        this.setAttribute('class', 'same-as-selected');
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener('click', function(e) {
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle('select-hide');
            this.classList.toggle('select-arrow-active');
            this.parentNode.classList.add('border-primary');
        });
    }
    function closeAllSelect(elmnt) {
        let x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName('select-items');
        y = document.getElementsByClassName('select-selected');
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove('select-arrow-active');
                y[i].parentNode.classList.remove('border-primary');
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add('select-hide');
            }
        }
    }
    document.addEventListener('click', closeAllSelect);
</script>

<script>
    $(document).ready(function() {
        let industry = $.trim($("#industries option:selected").text());
        let province = $.trim($("#provinces option:selected").text());
        let filter = $.trim($("#filters option:selected").text());

        $( ".items" ).each(function( e ) {
            let selectedItem = this.innerText.toLowerCase();
            if (selectedItem == industry || selectedItem == province || selectedItem == filter) {
                $(this).addClass('same-as-selected');
            };
        });
    });
</script>

<script>
    let paginate = 2;
    checkPaginate(paginate);

    $('#load-more').click(function() {
        loadMoreData(paginate);
        paginate++;
    });

    function loadMoreData(paginate) {
        $.ajax({
            url: '{{ route('user.project.list.mobile') }}' + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text(' 。。。');
            }
        })
        .done(function(response) {
            if (response.length === 0) {
                $('#load-more').hide();
            } else {
                $('#load-more').text('{{ trans('project.system.load_more') }}');
                $('#project-append').append(response);
                window.history.replaceState(null, null, '?page=' + paginate);
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
        checkPaginate(paginate + 1);
    }

    function checkPaginate(paginate) {
        $.ajax({
            url: '{{ route('user.project.list.mobile') }}' + '?page=' + paginate,
            type: 'get',
            datatype: 'html',
        })
            .done(function(response) {
                if (!response) {
                    $('#load-more').hide();
                }
            })
    }
</script>
@endpush
