<form
    action="<?php echo e(isset($salary_payment) ? route('salary_payment.update', $salary_payment->id) : route('salary_payment.store')); ?>"
    method="POST" id="form-create">

    <?php echo csrf_field(); ?>
    <?php if(isset($salary_payment)): ?>
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
                                    <h5>Thông tin bảng lương <span class="text-danger">*</span></h5>
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
                                                value="<?php echo e(old('employee_id', $salary_payment->employee_id ?? '')); ?>"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Lương cơ bản'); ?></label>
                                            <input type="text" class="form-control" name="base_salary"
                                                value="<?php echo e(old('base_salary', $salary_payment->base_salary ?? '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Lương nặng lực nhân viên có điều kiện'); ?></label>
                                            <input type="text" class="form-control" name="competency_salary"
                                                value="<?php echo e(old('competency_salary', $salary_payment->competency_salary ?? '')); ?>">
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Lương HQCV có điều kiện'); ?></label>
                                            <input type="number" class="form-control" name="performance_salary"
                                                value="<?php echo e(old('performance_salary', $salary_payment->performance_salary ?? '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Lương đóng BHXH'); ?></label>
                                            <input type="number" class="form-control" name="social_insurance_salary"
                                                value="<?php echo e(old('social_insurance_salary', $salary_payment->social_insurance_salary ?? '')); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Thu nhập theo vị trí'); ?></label>
                                            <input type="number" class="form-control" name="position_income"
                                                value="<?php echo e(old('position_income', $salary_payment->position_income ?? '')); ?>">
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
<?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/salary_payments/form.blade.php ENDPATH**/ ?>