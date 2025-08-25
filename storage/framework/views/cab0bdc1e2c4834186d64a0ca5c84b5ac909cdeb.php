<form action="<?php echo e(isset($payroll) ? route('payroll.update', $payroll->id) : route('payroll.store')); ?>"
    method="POST" id="form-create">

    <?php echo csrf_field(); ?>
    <?php if(isset($payroll)): ?>
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
                                    <h5>Thông tin bảng lương <span class="text-danger">*</span></h5>
                                </a>
                            </li>
                            <button type="submit" class="btn btn-info btn-sm pull-right">
                                <i class="fa fa-save"></i> <?php echo app('translator')->get(isset($payroll) ? 'Cập nhật' : 'Lưu'); ?>
                            </button>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Mã nhân viên'); ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="employee_id"
                                                value="<?php echo e(old('employee_id', $payroll->employee_id ?? '')); ?>"
                                                placeholder="<?php echo app('translator')->get('Nhập mã nhân viên'); ?>" required>
                                            <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Tháng'); ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="month"
                                                value="<?php echo e(old('month', $payroll->month ?? '')); ?>"
                                                placeholder="<?php echo app('translator')->get('YYYY-MM-DD'); ?>" pattern="\d{4}-\d{2}-\d{2}" required>
                                            <?php $__errorArgs = ['month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Hỗ trợ xăng xe, điện thoại, vé xe'); ?></label>
                                            <input type="number" step="0.01" class="form-control" name="travel_phone_ticket"
                                                value="<?php echo e(old('travel_phone_ticket', $payroll->travel_phone_ticket ?? '')); ?>"
                                                placeholder="<?php echo app('translator')->get('Nhập hỗ trợ xăng xe, điện thoại, vé xe'); ?>">
                                            <?php $__errorArgs = ['travel_phone_ticket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Hỗ trợ cơm thứ 7'); ?></label>
                                            <input type="number" step="0.01" class="form-control" name="saturday_meal_support"
                                                value="<?php echo e(old('saturday_meal_support', $payroll->saturday_meal_support ?? '')); ?>"
                                                placeholder="<?php echo app('translator')->get('Nhập hỗ trợ cơm thứ 7'); ?>">
                                            <?php $__errorArgs = ['saturday_meal_support'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                </div> <!-- row -->
                            </div> <!-- tab-pane -->
                        </div> <!-- tab-content -->
                    </div> <!-- nav-tabs-custom -->

                    <div class="box-footer">
                        <a href="<?php echo e(route('payroll.index')); ?>">
                            <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                        </a>
                    </div>
                </div> <!-- box-body -->
            </div> <!-- box -->
        </div> <!-- col-lg-12 -->
    </div> <!-- row -->
</form>
<?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/payroll/form.blade.php ENDPATH**/ ?>