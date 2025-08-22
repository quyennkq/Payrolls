<form
    action="{{ isset($leave_balance) ? route('leave_balance.update', $leave_balance->id) : route('leave_balance.store') }}"
    method="POST" id="form-create">

    @csrf
    @if (isset($leave_balance))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    <h5>Thông tin đơn xin nghỉ phép <span class="text-danger">*</span></h5>
                                </a>
                            </li>
                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-save"></i> @lang('Save')
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">

                                    {{-- Tên nhân viên --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Tên nhân viên') <small class="text-red">*</small></label>
                                            <select class="form-control select2" name="employee_id" required>
                                                <option value="">-- Chọn nhân viên --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('employee_id', $leave_balance->employee_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Năm --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Năm áp dụng') <small class="text-red">*</small></label>
                                            <input type="number" class="form-control" name="year"
                                                value="{{ old('year', $leave_balance->year ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- tháng --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Tháng áp dụng') <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="month"
                                                value="{{ old('month', $leave_balance->month ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Tổng số phép được cấp --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Tổng số phép được cấp') <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="total_leave"
                                                value="{{ old('total_leave', $leave_balance->total_leave ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Số phép đã sử dụng --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Số phép đã sử dụng') <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="used_leave"
                                                value="{{ old('used_leave', $leave_balance->used_leave ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Số phép còn lại (có thể tự động tính) --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Số phép còn lại (có thể tự động tính)') <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="remaining_leave"
                                                value="{{ old('remaining_leave', $leave_balance->remaining_leave ?? '') }}"
                                                required>
                                        </div>
                                    </div>

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
