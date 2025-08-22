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

            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create', ['id' => $student->id]) }}"><i
                    class="fa fa-plus"></i> @lang('Thêm mới thông tin khám')</a>
        </h1>
    </section>
@endsection

@section('content')

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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('Keyword') </label>
                                <input type="text" class="form-control" name="keyword"
                                    placeholder="{{ __('họ tên') . ', ' . __('bệnh lý') . ', ' . __('ghi chú') . '...' }}"
                                    value="{{ $params['keyword'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('From date')</label>
                                <input name="created_at_from" id="created_at_from" class="form-control datepicker"
                                    value="{{ $params['created_at_from'] ?? '' }}" placeholder="@lang('dd/mm/yyyy')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('To date')</label>
                                <input name="created_at_to" id="created_at_to" class="form-control datepicker"
                                    value="{{ $params['created_at_to'] ?? '' }}" placeholder="@lang('dd/mm/yyyy')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Status')</label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach (App\Consts::CONTACT_STATUS as $key => $value)
                                        <option value="{{ $key }}" {{ isset($params['status']) && $key == $params['status'] ? 'selected' : '' }}>
                                            {{ __($value) }}
                                        </option>
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
            <div class="box-body box_alert">
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

                <table class="table table-hover table-bordered">
                    <thead>
                                <tr>
                                    <th style="width:20px;">@lang('STT')</th>
                                    <th>@lang('Full name')</th>
                                    <th style="width:75px;">@lang('Gender')</th>
                                    <th>@lang('Địa chỉ')</th>
                                    <th style="width:85px;">@lang('Số điện thoại')</th>
                                    <th style="width:85px;">@lang('Email')</th>
                                    <th style="width:85px;">@lang('Trạng thái')</th>
                                    <th style="width:85px;">@lang('Chiều cao')</th>
                                    <th style="width:85px;">@lang('Cân nặng')</th>
                                    <th style="width:85px;">@lang('Nhịp tim')</th>
                                    <th style="width:85px;">@lang('Huyết áp')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                    </thead>
                    <tbody>
                        @foreach ($healths as $health)
                            <form action="{{ route(Request::segment(2) . '.destroy', $health->id) }}" method="POST"
                                onsubmit="return confirm('@lang('confirm_action')')">
                                <tr class="valign-middle">
                                    <td>
                                        {{ $health->tb_students->student_code }}
                                    </td>
                                    <td>
                                        {{ $health->tb_students->first_name }} {{ $health->tb_students->last_name }}
                                    </td>
                                    <td>
                                        {{ $health->tb_students->sex == 'male' ? 'Nam' : 'Nữ' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($health->tb_students->birthday)->age  }}
                                    </td>
                                    <td>
                                        {{ $health->tb_students->phone }}
                                    </td>
                                    <td>
                                        {{ $health->tb_students->email }}
                                    </td>
                                    <td>
                                        {{ $health->tb_students->status }}
                                    </td>
                                    <td>
                                        {{ $health->height }} cm
                                    </td>
                                    <td>
                                        {{ $health->weight }} kg
                                    </td>
                                    <td>
                                        {{ $health->health_rate }} / phút
                                    </td>
                                    <td>
                                        {{ $health->blood_pressure }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="@lang('Update')"
                                            data-original-title="@lang('update')"
                                            href="{{ route(Request::segment(2) . '.edit', $health->id) }}">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip"
                                            title="@lang('Delete')" data-original-title="@lang('delete')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            </form>
                        @endforeach

                    </tbody>

                </table>
                <div class="box-footer">
                    <a href="{{ route(Request::segment(2) . '.index') }}">
                        <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                    </a>
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
                success: function (response) {
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
                        setTimeout(function () {
                            $('.alert-warning').remove();
                        }, 3000);
                    }
                },
                error: function (response) {
                    // Get errors
                    hide_loading_notification();
                    var errors = response.responseJSON.message;
                    console.log(errors);
                }
            });
        }
    </script>
@endsection
