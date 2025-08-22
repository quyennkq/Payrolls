@extends('admin.layouts.app')

@section('title')
    @lang($module_name)
@endsection

@push('style')
    <style>
        .table>tbody>tr>td {
            vertical-align: middle;
        }
        .table th, .table td {
            padding: 10px;
        }
        .select2.select2-container {
            width: 100% !important;
        }
        .box-body {
            padding: 15px;
        }
        .nav-tabs-custom {
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content-header')
    <section class="content-header">
        <h1>
            @lang($module_name)
            <a class="btn btn-sm btn-warning pull-right" href="{{ route('extracurricular.create') }}">
                <i class="fa fa-plus"></i> @lang('Thêm mới chương trình ngoại khóa')
            </a>
        </h1>
    </section>
@endsection

@section('content')
    <div id="loading-notification" class="loading-notification">
        <p>@lang('Please wait')...</p>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="box_alert">
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
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab">
                                        <h5 class="fw-bold">Thông tin chính</h5>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab">
                                        <h5 class="fw-bold">Danh sách học sinh</h5>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab">
                                        <h5 class="fw-bold">Danh sách giáo viên</h5>
                                    </a>
                                </li>
                                <a class="" href="{{ route('extracurricular.index') }}">
                                    <button type="submit" class="btn btn-info btn-sm pull-right">
                                        <i class="fa fa-save"></i> @lang('Save')
                                    </button>
                                </a>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 200px">@lang('Tên chương trình')</th>
                                                        <td>{{ $rows->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Mô tả')</th>
                                                        <td>{{ $rows->description ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Ngày bắt đầu')</th>
                                                        <td>{{ $rows->first_date ? date('d/m/Y', strtotime($rows->first_date)) : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Ngày kết thúc')</th>
                                                        <td>{{ $rows->last_date ? date('d/m/Y', strtotime($rows->last_date)) : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Thời gian bắt đầu')</th>
                                                        <td>{{ $rows->start_time ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Thời gian kết thúc')</th>
                                                        <td>{{ $rows->end_time ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Địa điểm tổ chức')</th>
                                                        <td>{{ $rows->location ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Hình thức tham gia')</th>
                                                        <td>{{ $rows->form_participation ? __($rows->form_participation) : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Hình thức tổ chức')</th>
                                                        <td>{{ $rows->form_organizational ? __($rows->form_organizational) : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('Giá tiền')</th>
                                                        <td>{{ number_format($rows->expense ?? 0, 0, ',', '.') }} VNĐ</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box" style="border-top: 3px solid #d2d6de;">
                                                <div class="box-header">
                                                    <h3 class="box-title">@lang('Danh sách học sinh')</h3>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-hover sticky">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('Mã Học Viên')</th>
                                                                <th>@lang('Họ tên')</th>
                                                                <th>@lang('Nickname')</th>
                                                                <th>@lang('Ngày vào')</th>
                                                                <th>@lang('Ngày ra')</th>
                                                                <th>@lang('Trạng thái')</th>
                                                                <th>@lang('Loại')</th>
                                                                <th>@lang('Action')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="box_student">
                                                               @foreach ($students as $student)
                                                                <tr class="valign-middle">
                                                                    <td>{{ $student->student_code }}</td>
                                                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                                                    <td>{{ $student->sex == 'male' ? 'Nam' : 'Nữ' }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($student->birthday)->age }}</td>
                                                                    <td>{{ $student->phone }}</td>
                                                                    <td>{{ $student->email }}</td>
                                                                    <td>{{ $student->status }}</td>
                                                                    <td>
                                                                        <input type="checkbox" name="is_checked" value="1" {{ old('is_checked', $student->is_checked ?? false) ? 'checked' : '' }}>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title">@lang('Danh sách giáo viên')</h3>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-hover sticky">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>@lang('Giáo viên')</th>
                                                                <th>@lang('Ngày bắt đầu')</th>
                                                                <th>@lang('Ngày kết thúc')</th>
                                                                <th>@lang('GVCN')</th>
                                                                <th>@lang('Status')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="box_teacher">
                                                            @isset($detail->teacher)
                                                                @foreach ($detail->teacher as $item)
                                                                    @if ($item->pivot->status != 'delete')
                                                                        <tr class="item_teacher" data-id="{{ $item->id }}">
                                                                            <td>{{ $item->name ?? 'N/A' }}</td>
                                                                            <td>{{ optional($item->pivot)->start_at ? date('d/m/Y', strtotime($item->pivot->start_at)) : 'N/A' }}</td>
                                                                            <td>{{ optional($item->pivot)->stop_at ? date('d/m/Y', strtotime($item->pivot->stop_at)) : 'N/A' }}</td>
                                                                            <td>{{ $item->pivot->is_teacher_main == 1 ? __('Yes') : __('No') }}</td>
                                                                            <td>{{ $item->pivot->status ? __($item->pivot->status) : 'N/A' }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="5" class="text-center">@lang('Không có giáo viên')</td>
                                                                </tr>
                                                            @endisset
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-success btn-sm" href="{{ route('extracurricular.index') }}">
                                <i class="fa fa-bars"></i> @lang('List')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
