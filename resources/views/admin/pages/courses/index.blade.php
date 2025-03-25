@extends('admin.layouts.app')

@section('title')
    @lang($module_name)
@endsection
@php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }
@endphp
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang($module_name)
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a>
        </h1>
        {{-- <div class="box_excel">
            <a href="{{ route('product.excel.export') }}">
                <button class="btn btn-sm btn-primary "><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    @lang('Export Excel')</button>
            </a>
            <button class="btn btn-sm btn-danger" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                data-target="#import_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> @lang('Import Excel')</button>
        </div> --}}
    </section>
@endsection

@section('content')


<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Danh sách lớp đang học khóa học <span class="title_course"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Level')</th>
                            <th>@lang('Syllabus')</th>
                            <th>@lang('Course')</th>
                            <th>@lang('Sĩ số')</th>
                        </tr>
                    </thead>
                    <tbody id="post_available">

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        {{-- Search form --}}
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title">@lang('Filter')</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="{{ route(Request::segment(2) . '.index') }}" method="GET">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Keyword') </label>
                                <input type="text" class="form-control" name="keyword" placeholder="@lang('keyword_note')"
                                    value="{{ isset($params['keyword']) ? $params['keyword'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Level')</label>
                                <select name="level_id" id="level_id" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($levels as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($params['level_id']) && $params['level_id'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Syllabus')</label>
                                <select name="syllabus_id" id="syllabus_id" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($syllabus as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($params['syllabus_id']) && $params['syllabus_id'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Loại')</label>
                                <select name="type" id="type" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($course_type as $key=> $value)
                                        <option value="{{ $key }}"
                                            {{ isset($params['type']) && $params['type'] == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Filter')</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm mr-10">@lang('Submit')</button>
                                    <a class="btn btn-default btn-sm" href="{{ route(Request::segment(2) . '.index') }}">
                                        @lang('Reset')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        {{-- End search form --}}

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('List')</h3>

            </div>
            <div class="box-body table-responsive">
                @if (session('errorMessage'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('errorMessage') }}
                    </div>
                @endif
                @if (session('successMessage'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('successMessage') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach

                    </div>
                @endif
                @if (count($rows) == 0)
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @lang('not_found')
                    </div>
                @else
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Tổng số lớp học')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Ngày khai giảng')</th>
                                <th>@lang('Loại')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <form action="{{ route(Request::segment(2) . '.destroy', $row->id) }}" method="POST"
                                    onsubmit="return confirm('@lang('confirm_action')')">
                                    <tr class="valign-middle">
                                        <td>
                                            <strong
                                                style="font-size: 14px">{{ $row->json_params->name->{$lang} ?? $row->name }}</strong>
                                        </td>
                                        <td>
                                            {{$row->classs->count()}}
                                        </td>
                                        <td>
                                            @lang($row->status)
                                        </td>
                                        <td>
                                            {{ $row->day_opening ?? 'Chưa cập nhật'}}
                                        </td>
                                        <td>
                                            {{ $row->type!=""?App\Consts::SYLLABUS_TYPE[$row->type] : 'Chưa cập nhật'}}
                                        </td>

                                        <td>
                                            <button data-course='{{ $row->id }}' type="button" class="btn btn-primary btn-sm view_class" data-toggle="modal" data-target="#exampleModal">Xem danh sách lớp</button>
                                            <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                title="@lang('Update')" data-original-title="@lang('Update')"
                                                href="{{ route(Request::segment(2) . '.edit', $row->id) }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip"
                                                title="@lang('Delete')" data-original-title="@lang('Delete')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-5">
                        Tìm thấy {{ $rows->total() }} kết quả
                    </div>
                    <div class="col-sm-7">
                        {{ $rows->withQueryString()->links('admin.pagination.default') }}
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div id="import_excel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang('Import Excel')</h4>
                </div>
                <form role="form" action="{{ route(Request::segment(2) . '.store') }}" method="POST"
                    id="form_product" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row">
                        <input type="hidden" name="import" value="true">
                        <input type="hidden" name="name" value="import">
                        <input type="hidden" name="is_type" value="{{ App\Consts::TAXONOMY['product'] }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Language')</label>
                                <select name="lang" class="form-control select2" style="width: 100%;">
                                    @isset($languages)
                                        @foreach ($languages as $item)
                                            <option value="{{ $item->lang_locale }}"
                                                {{ $item->is_default == 1 ? 'selected' : '' }}>
                                                {{ $item->lang_name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Route Name')</label>
                                <small class="text-red">*</small>
                                <select name="route_name" id="route_name" required class="form-control select2"
                                    style="width:100%" required autocomplete="off">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($route_name as $key => $item)
                                        <option value="{{ $item['name'] }}"
                                            {{ isset($detail->json_params->route_name) && $detail->json_params->route_name == $item['name'] ? 'selected' : '' }}>
                                            {{ __($item['title']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Template')</label>
                                <small class="text-red">*</small>
                                <select name="template" id="template" required class="form-control select2"
                                    style="width:100%" required autocomplete="off">
                                    <option value="">@lang('Please select')</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Paramater')</label>
                                <ul class="list-relation">
                                    @foreach ($parents as $item)
                                        @if ($item->parent_id == 0 || $item->parent_id == null)
                                            <li>
                                                <label for="page-{{ $item->id }}">
                                                    <input id="page-{{ $item->id }}" name="relation[]"
                                                        {{ isset($relationship) && collect($relationship)->firstWhere('taxonomy_id', $item->id) != null ? 'checked' : '' }}
                                                        type="checkbox" value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </label>
                                                <ul class="list-relation row">
                                                    @foreach ($parents as $item1)
                                                        @if ($item1->parent_id == $item->id)
                                                            <li class="col-md-6">
                                                                <label for="page-{{ $item1->id }}">
                                                                    <input id="page-{{ $item1->id }}"
                                                                        name="relation[]" type="checkbox"
                                                                        {{ isset($relationship) && collect($relationship)->firstWhere('taxonomy_id', $item1->id) != null ? 'checked' : '' }}
                                                                        value="{{ $item1->id }}">
                                                                    {{ $item1->name }}
                                                                </label>
                                                                <ul class="list-relation">
                                                                    @foreach ($parents as $item2)
                                                                        @if ($item2->parent_id == $item1->id)
                                                                            <li>
                                                                                <label for="page-{{ $item2->id }}">
                                                                                    <input id="page-{{ $item2->id }}"
                                                                                        name="relation[]" type="checkbox"
                                                                                        {{ isset($relationship) && collect($relationship)->firstWhere('taxonomy_id', $item2->id) != null ? 'checked' : '' }}
                                                                                        value="{{ $item2->id }}">
                                                                                    {{ $item2->name }}
                                                                                </label>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('File') <a href="{{ url('data/images/Import_excel.png') }}"
                                        target="_blank">(@lang('Sample file structure'))</a></label>
                                <small class="text-red">*</small>
                                <input id="file" class="form-control" type="file" required name="file"
                                    placeholder="@lang('Select File')" value="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"
                                aria-hidden="true"></i> @lang('Import')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Routes get all
            var routes = @json(App\Consts::ROUTE_NAME ?? []);
            $(document).on('change', '#route_name', function() {
                let _value = $(this).val();
                let _targetHTML = $('#template');
                let _list = filterArray(routes, 'name', _value);
                let _optionList = '<option value="">@lang('Please select')</option>';
                if (_list) {
                    _list.forEach(element => {
                        element.template.forEach(item => {
                            _optionList += '<option value="' + item.name + '"> ' + item
                                .title + ' </option>';
                        });
                    });
                    _targetHTML.html(_optionList);
                }
                $(".select2").select2();
            });

            $('.view_class').click(function(){
                let _targetHTML = $('#post_available');
                var course_id =$(this).attr('data-course');
                let url = "{{ route('cms_course.search') }}/";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        course_id: course_id,
                    },
                    success: function(response) {
                        if (response.message == 'success') {
                            let list = response.data || null;
                            let _item = '';
                            if (list.length > 0) {
                                list.forEach(item => {
                                    _item += '<tr>';
                                    _item += '<td><a target="_blank" href="/admin/classs/'+item.id+'/edit">' + item.name + '</a></td>';
                                    _item += '<td><a target="_blank" href="/admin/levels/'+item.level_id+'/edit">' + item.level.name + '</a></td>';
                                    _item += '<td><a target="_blank" href="/admin/syllabuss/'+item.syllabus_id+'/edit">' + item.syllabus.name + '</a></td>';
                                    _item += '<td><a target="_blank" href="/admin/courses/'+item.course_id+'/edit">' + item.course.name + '</a></td>';
                                    _item += '<td>' +item.student_quanty+ '</td>';
                                    _item += '</tr>';
                                });
                                _targetHTML.html(_item);
                            }
                        } else {
                            _targetHTML.html('<tr><td colspan="5">' + response.message +
                                '</td></tr>');
                        }
                    },
                    error: function(response) {
                        // Get errors
                        let errors = response.responseJSON.message;
                        _targetHTML.html('<tr><td colspan="5">' + errors + '</td></tr>');
                    }
                });
            })



        });
    </script>
@endsection
