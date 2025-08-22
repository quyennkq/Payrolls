<form
    action="<?php echo e(isset($leave_balance) ? route('leave_balance.update', $leave_balance->id) : route('leave_balance.store')); ?>"
    method="POST" id="form-create">

    <?php echo csrf_field(); ?>
    <?php if(isset($leave_balance)): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

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
                                <i class="fa fa-save"></i> <?php echo app('translator')->get('Save'); ?>
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Tên nhân viên'); ?> <small class="text-red">*</small></label>
                                            <select class="form-control select2" name="employee_id" required>
                                                <option value="">-- Chọn nhân viên --</option>
                                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($user->id); ?>"
                                                        <?php echo e(old('employee_id', $leave_balance->employee_id ?? '') == $user->id ? 'selected' : ''); ?>>
                                                        <?php echo e($user->username); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Năm áp dụng'); ?> <small class="text-red">*</small></label>
                                            <input type="number" class="form-control" name="year"
                                                value="<?php echo e(old('year', $leave_balance->year ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Tháng áp dụng'); ?> <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="month"
                                                value="<?php echo e(old('month', $leave_balance->month ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Tổng số phép được cấp'); ?> <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="total_leave"
                                                value="<?php echo e(old('total_leave', $leave_balance->total_leave ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Số phép đã sử dụng'); ?> <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="used_leave"
                                                value="<?php echo e(old('used_leave', $leave_balance->used_leave ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Số phép còn lại (có thể tự động tính)'); ?> <small class="text-red">*</small></label>
                                             <input type="number" class="form-control" name="remaining_leave"
                                                value="<?php echo e(old('remaining_leave', $leave_balance->remaining_leave ?? '')); ?>"
                                                required>
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
<?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/leave_balance/form.blade.php ENDPATH**/ ?>