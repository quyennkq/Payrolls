<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .table>tbody>tr>td {
            vertical-align: middle;
        }
        .table th, .table td {
            padding: 10px;
        }
        .select2.select2-container {
            width: 100% !important;
        }
        .box-body {
            padding: 15px;
        }
        .nav-tabs-custom {
            margin-bottom: 20px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content-header'); ?>
    <section class="content-header">
        <h1>
            <?php echo app('translator')->get($module_name); ?>
            <a class="btn btn-sm btn-warning pull-right" href="<?php echo e(route('extracurricular.create')); ?>">
                <i class="fa fa-plus"></i> <?php echo app('translator')->get('Thêm mới chương trình ngoại khóa'); ?>
            </a>
        </h1>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="loading-notification" class="loading-notification">
        <p><?php echo app('translator')->get('Please wait'); ?>...</p>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="box_alert">
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
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab">
                                        <h5 class="fw-bold">Thông tin chính</h5>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab">
                                        <h5 class="fw-bold">Danh sách học sinh</h5>
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab">
                                        <h5 class="fw-bold">Danh sách giáo viên</h5>
                                    </a>
                                </li>
                                <a class="" href="<?php echo e(route('extracurricular.index')); ?>">
                                    <button type="submit" class="btn btn-info btn-sm pull-right">
                                        <i class="fa fa-save"></i> <?php echo app('translator')->get('Save'); ?>
                                    </button>
                                </a>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 200px"><?php echo app('translator')->get('Tên chương trình'); ?></th>
                                                        <td><?php echo e($rows->name ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Mô tả'); ?></th>
                                                        <td><?php echo e($rows->description ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Ngày bắt đầu'); ?></th>
                                                        <td><?php echo e($rows->first_date ? date('d/m/Y', strtotime($rows->first_date)) : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Ngày kết thúc'); ?></th>
                                                        <td><?php echo e($rows->last_date ? date('d/m/Y', strtotime($rows->last_date)) : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Thời gian bắt đầu'); ?></th>
                                                        <td><?php echo e($rows->start_time ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Thời gian kết thúc'); ?></th>
                                                        <td><?php echo e($rows->end_time ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Địa điểm tổ chức'); ?></th>
                                                        <td><?php echo e($rows->location ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Hình thức tham gia'); ?></th>
                                                        <td><?php echo e($rows->form_participation ? __($rows->form_participation) : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Hình thức tổ chức'); ?></th>
                                                        <td><?php echo e($rows->form_organizational ? __($rows->form_organizational) : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo app('translator')->get('Giá tiền'); ?></th>
                                                        <td><?php echo e(number_format($rows->expense ?? 0, 0, ',', '.')); ?> VNĐ</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box" style="border-top: 3px solid #d2d6de;">
                                                <div class="box-header">
                                                    <h3 class="box-title"><?php echo app('translator')->get('Danh sách học sinh'); ?></h3>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-hover sticky">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo app('translator')->get('Mã Học Viên'); ?></th>
                                                                <th><?php echo app('translator')->get('Họ tên'); ?></th>
                                                                <th><?php echo app('translator')->get('Nickname'); ?></th>
                                                                <th><?php echo app('translator')->get('Ngày vào'); ?></th>
                                                                <th><?php echo app('translator')->get('Ngày ra'); ?></th>
                                                                <th><?php echo app('translator')->get('Trạng thái'); ?></th>
                                                                <th><?php echo app('translator')->get('Loại'); ?></th>
                                                                <th><?php echo app('translator')->get('Action'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="box_student">
                                                               <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="valign-middle">
                                                                    <td><?php echo e($student->student_code); ?></td>
                                                                    <td><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></td>
                                                                    <td><?php echo e($student->sex == 'male' ? 'Nam' : 'Nữ'); ?></td>
                                                                    <td><?php echo e(\Carbon\Carbon::parse($student->birthday)->age); ?></td>
                                                                    <td><?php echo e($student->phone); ?></td>
                                                                    <td><?php echo e($student->email); ?></td>
                                                                    <td><?php echo e($student->status); ?></td>
                                                                    <td>
                                                                        <input type="checkbox" name="is_checked" value="1" <?php echo e(old('is_checked', $student->is_checked ?? false) ? 'checked' : ''); ?>>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title"><?php echo app('translator')->get('Danh sách giáo viên'); ?></h3>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-hover sticky">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th><?php echo app('translator')->get('Giáo viên'); ?></th>
                                                                <th><?php echo app('translator')->get('Ngày bắt đầu'); ?></th>
                                                                <th><?php echo app('translator')->get('Ngày kết thúc'); ?></th>
                                                                <th><?php echo app('translator')->get('GVCN'); ?></th>
                                                                <th><?php echo app('translator')->get('Status'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="box_teacher">
                                                            <?php if(isset($detail->teacher)): ?>
                                                                <?php $__currentLoopData = $detail->teacher; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($item->pivot->status != 'delete'): ?>
                                                                        <tr class="item_teacher" data-id="<?php echo e($item->id); ?>">
                                                                            <td><?php echo e($item->name ?? 'N/A'); ?></td>
                                                                            <td><?php echo e(optional($item->pivot)->start_at ? date('d/m/Y', strtotime($item->pivot->start_at)) : 'N/A'); ?></td>
                                                                            <td><?php echo e(optional($item->pivot)->stop_at ? date('d/m/Y', strtotime($item->pivot->stop_at)) : 'N/A'); ?></td>
                                                                            <td><?php echo e($item->pivot->is_teacher_main == 1 ? __('Yes') : __('No')); ?></td>
                                                                            <td><?php echo e($item->pivot->status ? __($item->pivot->status) : 'N/A'); ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="5" class="text-center"><?php echo app('translator')->get('Không có giáo viên'); ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-success btn-sm" href="<?php echo e(route('extracurricular.index')); ?>">
                                <i class="fa fa-bars"></i> <?php echo app('translator')->get('List'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steamwonder\resources\views/admin/pages/extracurricular/show.blade.php ENDPATH**/ ?>