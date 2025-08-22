@extends('admin.layouts.app')

@section('title')
    @lang($module_name)
@endsection
@push('style')
@endpush
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang($module_name)
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Thêm mới trương trình ngoại khóa')</a>
        </h1>
    </section>
@endsection

@section('content')
    <div id="loading-notification" class="loading-notification">
        <p>@lang('Please wait')...</p>
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
            <form action="" id="form_filter" method="GET">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Keyword') </label>
                                <input type="text" class="form-control" name="keyword" placeholder="@lang('Lọc theo mã học sinh, họ tên hoặc email')"
                                    value="{{ isset($params['keyword']) ? $params['keyword'] : '' }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Area')</label>
                                <select name="area_id" id="area_id" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    {{-- @foreach ($area as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($params['area_id']) && $value->id == $params['area_id'] ? 'selected' : '' }}>
                                            {{ __($value->name) }}
                                            (Mã: {{ $value->code }})
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Lớp học ')</label>
                                <select name="current_class_id" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    {{-- @foreach ($list_class as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($params['current_class_id']) && $value->id == $params['current_class_id'] ? 'selected' : '' }}>
                                            {{ __($value->name) }}
                                            - {{ optional($value->area)->name ?? '' }}
                                            (Mã: {{ $value->code }})
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Trạng thái ')</label>
                                <select name="status" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    {{-- @foreach ($list_status as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($params['status']) && $key == $params['status'] ? 'selected' : '' }}>
                                            {{ __($value) }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Filter')</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm mr-10">@lang('Submit')</button>
                                    <a class="btn btn-default btn-sm mr-10"
                                        href="">
                                        @lang('Reset')
                                    </a>

                                    {{-- <button type="button" data-toggle="modal" data-target="#create_crmdata_student"
                                        class="btn btn-success btn-sm">@lang('Import Excel')</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- <a href="{{route('student.add_service_yearly')}}" class="btn btn-sm btn-warning">@lang('Thêm dịch vụ hàng năm cho học sinh')</a> --}}
            {{-- <div class="import_excel ">
                <div style="display: flex; margin-left:10px; max-width: 500px; margin-top: 15px;">
                    <input class="form-control" type="file" name="files" id="importPromotion"
                        placeholder="@lang('File Import Promotion')">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="importFile('importPromotion','{{ route('student.import_promotion') }}')">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('Import Khuyến mãi')</button>
                </div>
                <div style="display: flex; margin-left:10px; max-width: 500px; margin-top: 15px;">
                    <input class="form-control" type="file" name="files" id="importPolicy"
                        placeholder="@lang('File Import Policy')">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="importFile('importPolicy','{{ route('student.import_policy') }}')">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('Import Chính sách')</button>
                </div>
                <div style="display: flex; margin-left:10px; max-width: 500px; margin-top: 15px;">
                    <input class="form-control" type="file" name="files" id="importService"
                        placeholder="@lang('File Import Service')">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="importFile('importService','{{ route('student.import_service') }}')">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('Import dịch vụ')</button>
                </div>
                <div style="display: flex; margin-left:10px; max-width: 500px; margin-top: 15px;">
                    <input class="form-control" type="file" name="files" id="importReceipt"
                        placeholder="@lang('File Import Receipt')">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="importFile('importReceipt','{{ route('student.import_receipt') }}')">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('Import TBP')</button>
                </div>
                <div style="display: flex; margin-left:10px; max-width: 500px; margin-top: 15px;">
                    <input class="form-control" type="file" name="files" id="imporBalancetReceipt"
                        placeholder="@lang('File Import Receipt')">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="importFile('imporBalancetReceipt','{{ route('student.import_balance_receipt') }}')">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('Import Số dư kỳ trước')</button>
                </div>
            </div> --}}

        </div>
        {{-- End search form --}}
        <div id="create_crmdata_student" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Import học sinh</h4>
                    </div>
                    <form action="{{ route('data_student.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Chọn tệp') <a href="{{ url('themes\admin\img\data_student.xlsx') }}"
                                            target="_blank">(@lang('Minh họa file excel'))</a></label>
                                    <small class="text-red">*</small>
                                    <div style="display: flex" class="d-flex">
                                        <input id="file" class="form-control" type="file" required name="file"
                                            placeholder="@lang('Select File')" value="">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"
                                                aria-hidden="true"></i> @lang('Import')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('List')</h3>
            </div>
            <div class="box-body ">
                @if (session('errorMessage'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('errorMessage') !!}
                    </div>
                @endif
                @if (session('successMessage'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('successMessage') !!}
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
                {{-- @if (count($rows) == 0)
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @lang('not_found')
                    </div>
                @else --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Tên trương trình')</th>
                                    <th>@lang('Mô tả')</th>
                                    <th>@lang('Ngày bắt đầu')</th>
                                    <th>@lang('Ngày kết thúc')</th>
                                    <th>@lang('THời gian bắt đầu')</th>
                                    <th>@lang('Thời gian kết thúc')</th>
                                    <th>@lang('Địa điểm tổ chức')</th>
                                    <th>@lang('Hình thức tham gia')</th>
                                    <th>@lang('Hình thức tổ chức')</th>
                                    <th>@lang('Giá tiền')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <form action="" method="POST"
                                        onsubmit="return confirm('@lang('confirm_action')')">
                                        <tr class="valign-middle">

                                                <td>{{ $loop->index + 1 }}</td>

                                            <td>
                                                {{ $row->name}}
                                            </td>
                                            {{-- <td>
                                                {{ $row->student->student_id}}
                                            </td> --}}

                                            <td>
                                                {{ $row->description}}
                                            </td>

                                            <td>
                                                {{ $row->first_date}}
                                            </td>
                                            <td>
                                                {{ $row->last_date}}
                                            </td>
                                            <td>
                                                {{ $row->start_time}}
                                            </td>
                                            <td>
                                                {{ $row->end_time}}
                                            </td>
                                            <td>
                                                {{ $row->location}}
                                            </td>
                                            <td>
                                                {{ $row->form_organizational}}
                                            </td>
                                            <td>
                                                {{ $row->form_participation}}
                                            </td>
                                            <td>
                                                {{ $row->expense}}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('extracurricular.show', ['id' => $row->id]) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                {{-- <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                    title="@lang('Update')" data-original-title="@lang('Update')"
                                                    href="{{ route(Request::segment(2) . '.edit', $row->id) }}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    data-toggle="tooltip" title="@lang('Delete')"
                                                    data-original-title="@lang('Delete')">
                                                    <i class="fa fa-trash"></i>
                                                </button> --}}
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                {{-- @endif --}}
            </div>
            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-5">
                        {{-- Tìm thấy {{ $rows->total() }} kết quả --}}
                    </div>
                    <div class="col-sm-7">
                        {{-- {{ $rows->withQueryString()->links('admin.pagination.default') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function importFile(_form, _url) {
            show_loading_notification();
            var formData = new FormData();
            var file = $('#' + _form)[0].files[0];
            if (file == null) {
                alert('Cần chọn file để Import!');
                return;
            }
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: _url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    hide_loading_notification();
                    if (response.data != null) {
                        console.log(response.data);;
                    } else {
                        var _html = `<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Bạn không có quyền thao tác chức năng này!
                            </div>`;
                        $('.table-responsive').prepend(_html);
                        $('html, body').animate({
                            scrollTop: $(".alert-warning").offset().top
                        }, 1000);
                        setTimeout(function() {
                            $('.alert-warning').remove();
                        }, 3000);
                    }
                },
                error: function(response) {
                    // Get errors
                    hide_loading_notification();
                    var errors = response.responseJSON.message;
                    console.log(errors);
                }
            });
        }
    </script>
@endsection
