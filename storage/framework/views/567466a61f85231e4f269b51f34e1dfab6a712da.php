<form action="<?php echo e(isset($attendance) ? route('attendance.update', $attendance->id) : route('attendance.store')); ?>"
    method="POST" id="form-create">

    <?php echo csrf_field(); ?>
    <?php if(isset($attendance)): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">


                <?php echo csrf_field(); ?>
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    <h5>Thông tin chấm công <span class="text-danger">*</span></h5>
                                </a>
                            </li>
                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-save"></i> <?php echo app('translator')->get('Save'); ?>
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="d-flex-wap">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Mã nhân viên'); ?><small class="text-red">*</small></label>
                                            <input type="text" class="form-control" name="employee_id"
                                                value="<?php echo e(old('employee_id', $attendance->employee_id ?? '')); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Giờ vào'); ?></label>
                                            <input type="text" class="form-control" name="check_in"
                                                value="<?php echo e(old('check_in', $attendance->check_in ?? '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Giờ ra'); ?></label>
                                            <input type="text" class="form-control" name="check_out"
                                                value="<?php echo e(old('check_out', $attendance->check_out ?? '')); ?>">
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Ngày công chuẩn'); ?></label>
                                            <input type="number" class="form-control" name="standard_working_days"
                                                value="<?php echo e(old('standard_working_days', $attendance->standard_working_days ?? '')); ?>">
                                        </div>
                                    </div>

                                    

                                    

                                </div>
                            </div> <!-- tab-pane -->
                        </div> <!-- tab-content -->
                    </div>
                </div>
                <div class="box-footer">
                    <a href="<?php echo e(route(Request::segment(2) . '.index')); ?>">
                        <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</form>
<?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/V_attendance/form.blade.php ENDPATH**/ ?>