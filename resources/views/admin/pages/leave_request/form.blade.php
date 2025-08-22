<form
    action="{{ isset($leave_request) ? route('leave_request.update', $leave_request->id) : route('leave_request.store') }}"
    method="POST" id="form-create">

    @csrf
    @if (isset($leave_request))
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

                                    {{-- Mã nhân viên --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Tên nhân viên') <small class="text-red">*</small></label>
                                            <select class="form-control select2" name="employee_id" required>
                                                <option value="">-- Chọn nhân viên --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('employee_id', $leave_request->employee_id ?? '') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Ngày nghỉ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Ngày nghỉ') <small class="text-red">*</small></label>
                                            <input type="date" class="form-control" name="leave_date"
                                                value="{{ old('leave_date', $leave_request->leave_date ?? '') }}"
                                                required>
                                        </div>
                                    </div>

                                    {{-- Loại nghỉ --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Loại nghỉ') <small class="text-red">*</small></label>
                                            <select class="form-control" id="leave_type" name="leave_type">
                                                <option value="">-- Chọn kiểu nghỉ --</option>
                                                <option value="paid"
                                                    {{ old('leave_type', $leave_request->leave_type ?? '') == 'paid' ? 'selected' : '' }}>
                                                    Nghỉ phép (có lương)
                                                </option>
                                                <option value="unpaid"
                                                    {{ old('leave_type', $leave_request->leave_type ?? '') == 'unpaid' ? 'selected' : '' }}>
                                                    Nghỉ không phép
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Lý do --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Lý do')</label>
                                            <textarea class="form-control" name="reason" maxlength="100">{{ old('reason', $leave_request->reason ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Trạng thái --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Trạng thái')</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="pending"
                                                    {{ old('status', $leave_request->status ?? '') == 'pending' ? 'selected' : '' }}>
                                                    Chờ duyệt</option>
                                                <option value="approved"
                                                    {{ old('status', $leave_request->status ?? '') == 'approved' ? 'selected' : '' }}>
                                                    Đã duyệt</option>
                                                <option value="rejected"
                                                    {{ old('status', $leave_request->status ?? '') == 'rejected' ? 'selected' : '' }}>
                                                    Từ chối</option>
                                            </select>
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
