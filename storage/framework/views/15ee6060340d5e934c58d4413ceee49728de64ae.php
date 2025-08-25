<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content-header'); ?>
    <section class="content-header">
        <h1><?php echo app('translator')->get($module_name); ?>
            <a class="btn btn-sm btn-warning pull-right" href="<?php echo e(route(Request::segment(2) . '.create')); ?>"><i
                    class="fa fa-plus"></i> <?php echo app('translator')->get('Thêm mới bảng lương'); ?></a>
        </h1>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="content">
        <div id="loading-notification" class="loading-notification" style="display: none;">
            <p><?php echo app('translator')->get('Please wait'); ?>...</p>
        </div>

        
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->get('Filter'); ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="<?php echo e(route(Request::segment(2) . '.index')); ?>" method="GET" id="search-form">
                <div class="box-body">
                    <div class="filter-row">
                        <div class="form-group">
                            <label class="form-label"><?php echo app('translator')->get('Mã nhân viên'); ?></label>
                            <input type="text" class="form-control" name="employee_id" placeholder="<?php echo app('translator')->get('Nhập mã nhân viên'); ?>"
                                value="<?php echo e(isset($params['employee_id']) ? $params['employee_id'] : ''); ?>">
                        </div>

                        
                        <div class="form-group">
                            <label class="form-label"><?php echo app('translator')->get('Chọn tháng'); ?></label>
                            <input type="month" class="form-control" name="month"
                                value="<?php echo e(isset($params['month']) ? $params['month'] : date('Y-m')); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo app('translator')->get('Từ'); ?></label>
                            <input type="date" class="form-control" name="form_date"
                                value="<?php echo e(isset($params['form_date']) ? $params['form_date'] : ''); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo app('translator')->get('Đến'); ?></label>
                            <input type="date" class="form-control" name="to_date"
                                value="<?php echo e(isset($params['to_date']) ? $params['to_date'] : ''); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo app('translator')->get('Thứ tự'); ?></label>
                            <select class="form-control" name="sort">
                                <option value="asc"
                                    <?php echo e(isset($params['sort']) && $params['sort'] == 'asc' ? 'selected' : ''); ?>>
                                    <?php echo app('translator')->get('Tăng dần'); ?></option>
                                <option value="desc"
                                    <?php echo e(isset($params['sort']) && $params['sort'] == 'desc' ? 'selected' : ''); ?>>
                                    <?php echo app('translator')->get('Giảm dần'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary action-btn"><?php echo app('translator')->get('Lọc'); ?></button>
                            <a class="btn btn-default action-btn"
                                href="<?php echo e(route(Request::segment(2) . '.index')); ?>"><?php echo app('translator')->get('Reset'); ?></a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-flex align-items-center gap-2" style="margin: 21px">
                <form action="<?php echo e(route('payroll.import')); ?>" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center gap-2" style="margin-bottom: 21px">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="excel_file" class="form-control form-control-sm" style="height: 38px;"
                        required>
                    <button type="submit" class="btn btn-warning btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-file-excel-o"></i> <?php echo app('translator')->get(' Import'); ?>
                    </button>
                </form>
            </div>
        </div>

        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo app('translator')->get('List'); ?></h3>
            </div>
            <div class="box-body box_alert">
                <?php if(session('errorMessage')): ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo e(session('errorMessage')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('successMessage')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo e(session('successMessage')); ?>

                    </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                


                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo app('translator')->get('STT'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('ID'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Mã nhân viên'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Tên nhân viên'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Tháng'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('lương cơ bản theo ngày'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Tổng thu nhập'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Tổng khấu trừ'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Tạm ứng'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Thực lĩnh'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Thao tác'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td><?php echo e($row->id ?? ''); ?></td>
                                    <td>
                                        <?php echo e($row->employee_id ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->admin->name ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->month ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->base_salary_by_days ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->total_income ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->total_deductions ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->advance_payment ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($row->net_income ?? ''); ?>

                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="<?php echo e(route('payroll.show', $row->id)); ?>"
                                            data-toggle="tooltip" title="<?php echo app('translator')->get('Chi tiết'); ?>"
                                            data-original-title="<?php echo app('translator')->get('Chi tiết'); ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                            title="<?php echo app('translator')->get('Update'); ?>" data-original-title="<?php echo app('translator')->get('Update'); ?>"
                                            href="<?php echo e(route('payroll.edit', $row->id)); ?>">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <form action="<?php echo e(route('payroll.destroy', $row->id)); ?>" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-5">
                        Tìm thấy <?php echo e($rows->total()); ?> kết quả
                    </div>
                    <div class="col-sm-7">
                        <?php echo e($rows->withQueryString()->links('admin.pagination.default')); ?>

                    </div>
                </div>
            </div>
        </div>

        
        
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/payroll/index.blade.php ENDPATH**/ ?>