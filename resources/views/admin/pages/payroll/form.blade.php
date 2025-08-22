<form action="{{ isset($payroll) ? route('payroll.update', $payroll->id) : route('payroll.store') }}"
    method="POST" id="form-create">

    @csrf
    @if (isset($payroll))
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
                                    <h5>Thông tin bảng lương <span class="text-danger">*</span></h5>
                                </a>
                            </li>
                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-save"></i> @lang(isset($payroll) ? 'Cập nhật' : 'Lưu')
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">

                                    {{-- Mã nhân viên --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Mã nhân viên') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="employee_id"
                                                value="{{ old('employee_id', $payroll->employee_id ?? '') }}"
                                                placeholder="@lang('Nhập mã nhân viên')" required>
                                            @error('employee_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tháng --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Tháng') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="month"
                                                value="{{ old('month', $payroll->month ?? '') }}"
                                                placeholder="@lang('YYYY-MM')" pattern="\d{4}-\d{2}" required>
                                            @error('month')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Hỗ trợ xăng xe, điện thoại, vé xe --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Hỗ trợ xăng xe, điện thoại, vé xe')</label>
                                            <input type="number" step="0.01" class="form-control" name="travel_phone_ticket"
                                                value="{{ old('travel_phone_ticket', $payroll->travel_phone_ticket ?? '') }}"
                                                placeholder="@lang('Nhập hỗ trợ xăng xe, điện thoại, vé xe')">
                                            @error('travel_phone_ticket')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Hỗ trợ cơm thứ 7 --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Hỗ trợ cơm thứ 7')</label>
                                            <input type="number" step="0.01" class="form-control" name="saturday_meal_support"
                                                value="{{ old('saturday_meal_support', $payroll->saturday_meal_support ?? '') }}"
                                                placeholder="@lang('Nhập hỗ trợ cơm thứ 7')">
                                            @error('saturday_meal_support')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div> <!-- row -->
                            </div> <!-- tab-pane -->
                        </div> <!-- tab-content -->
                    </div> <!-- nav-tabs-custom -->

                    <div class="box-footer">
                        <a href="{{ route('payroll.index') }}">
                            <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                        </a>
                    </div>
                </div> <!-- box-body -->
            </div> <!-- box -->
        </div> <!-- col-lg-12 -->
    </div> <!-- row -->
</form>
