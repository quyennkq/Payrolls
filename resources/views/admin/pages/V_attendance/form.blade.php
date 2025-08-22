<form action="{{ isset($attendance) ? route('attendance.update', $attendance->id) : route('attendance.store') }}"
    method="POST" id="form-create">

    @csrf
    @if (isset($attendance))
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">


                @csrf
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    <h5>Thông tin chấm công <span class="text-danger">*</span></h5>
                                </a>
                            </li>
                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-save"></i> @lang('Save')
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="d-flex-wap">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Mã nhân viên')<small class="text-red">*</small></label>
                                            <input type="text" class="form-control" name="employee_id"
                                                value="{{ old('employee_id', $attendance->employee_id ?? '') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Giờ vào')</label>
                                            <input type="text" class="form-control" name="check_in"
                                                value="{{ old('check_in', $attendance->check_in ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Giờ ra')</label>
                                            <input type="text" class="form-control" name="check_out"
                                                value="{{ old('check_out', $attendance->check_out ?? '') }}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Thời gian làm việc')</label>
                                            <input type="number" class="form-control" name="work_hours"
                                                value="{{ old('work_hours', $attendance->work_hours ?? '') }}">
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Ngày công chuẩn')</label>
                                            <input type="number" class="form-control" name="standard_working_days"
                                                value="{{ old('standard_working_days', $attendance->standard_working_days ?? '') }}">
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Công thử việc')</label>
                                            <input type="number" class="form-control" name="probation_days"
                                                value="{{ old('probation_days', $attendance->probation_days ?? '') }}">
                                        </div>
                                    </div> --}}

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Công chính thức')</label>
                                            <input type="number" class="form-control" name="official_days"
                                                value="{{ old('official_days', $attendance->official_days ?? '') }}">
                                        </div>
                                    </div> --}}

                                </div>
                            </div> <!-- tab-pane -->
                        </div> <!-- tab-content -->
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route(Request::segment(2) . '.index') }}">
                        <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</form>
