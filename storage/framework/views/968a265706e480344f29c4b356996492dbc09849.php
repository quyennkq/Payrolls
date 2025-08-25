<form
    action="<?php echo e(isset($leave_request) ? route('leave_request.update', $leave_request->id) : route('leave_request.store')); ?>"
    method="POST" id="form-create">

    <?php echo csrf_field(); ?>
    <?php if(isset($leave_request)): ?>
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
                                                        <?php echo e(old('employee_id', $leave_request->employee_id ?? '') == $user->id ? 'selected' : ''); ?>>
                                                        <?php echo e($user->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Ngày bắt đầu'); ?> <small class="text-red">*</small></label>
                                            <input type="date" class="form-control" name="leave_date_start"
                                                value="<?php echo e(old('leave_date_start', $leave_request->leave_date_start ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Ngày kết thúc'); ?> <small class="text-red">*</small></label>
                                            <input type="date" class="form-control" name="leave_date_end"
                                                value="<?php echo e(old('leave_date_end', $leave_request->leave_date_end ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Loại nghỉ'); ?> <small class="text-red">*</small></label>
                                            <select class="form-control" id="leave_type" name="leave_type">
                                                <option value="">-- Chọn kiểu nghỉ --</option>
                                                <option value="paid"
                                                    <?php echo e(old('leave_type', $leave_request->leave_type ?? '') == 'paid' ? 'selected' : ''); ?>>
                                                    Nghỉ phép (có lương)
                                                </option>
                                                <option value="unpaid"
                                                    <?php echo e(old('leave_type', $leave_request->leave_type ?? '') == 'unpaid' ? 'selected' : ''); ?>>
                                                    Nghỉ không phép
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Lý do'); ?></label>
                                            <textarea class="form-control" name="reason" maxlength="100"><?php echo e(old('reason', $leave_request->reason ?? '')); ?></textarea>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Trạng thái'); ?></label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="pending"
                                                    <?php echo e(old('status', $leave_request->status ?? '') == 'pending' ? 'selected' : ''); ?>>
                                                    Chờ duyệt</option>
                                                <option value="approved"
                                                    <?php echo e(old('status', $leave_request->status ?? '') == 'approved' ? 'selected' : ''); ?>>
                                                    Đã duyệt</option>
                                                <option value="rejected"
                                                    <?php echo e(old('status', $leave_request->status ?? '') == 'rejected' ? 'selected' : ''); ?>>
                                                    Từ chối</option>
                                            </select>
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


<?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/leave_request/form.blade.php ENDPATH**/ ?>