<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content-header'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo app('translator')->get($module_name); ?>

            <a class="btn btn-sm btn-warning pull-right" href="<?php echo e(route(Request::segment(2) . '.create', ['id' => $student->id])); ?>"><i
                    class="fa fa-plus"></i> <?php echo app('translator')->get('Thêm mới thông tin khám'); ?></a>
        </h1>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Main content -->
    <section class="content">
        
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->get('Filter'); ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="<?php echo e(route(Request::segment(2) . '.index')); ?>" method="GET">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Keyword'); ?> </label>
                                <input type="text" class="form-control" name="keyword"
                                    placeholder="<?php echo e(__('họ tên') . ', ' . __('bệnh lý') . ', ' . __('ghi chú') . '...'); ?>"
                                    value="<?php echo e($params['keyword'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('From date'); ?></label>
                                <input name="created_at_from" id="created_at_from" class="form-control datepicker"
                                    value="<?php echo e($params['created_at_from'] ?? ''); ?>" placeholder="<?php echo app('translator')->get('dd/mm/yyyy'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('To date'); ?></label>
                                <input name="created_at_to" id="created_at_to" class="form-control datepicker"
                                    value="<?php echo e($params['created_at_to'] ?? ''); ?>" placeholder="<?php echo app('translator')->get('dd/mm/yyyy'); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Status'); ?></label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                    <?php $__currentLoopData = App\Consts::CONTACT_STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e(isset($params['status']) && $key == $params['status'] ? 'selected' : ''); ?>>
                                            <?php echo e(__($value)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Filter'); ?></label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm mr-10"><?php echo app('translator')->get('Submit'); ?></button>
                                    <a class="btn btn-default btn-sm" href="<?php echo e(route(Request::segment(2) . '.index')); ?>">
                                        <?php echo app('translator')->get('Reset'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

                <table class="table table-hover table-bordered">
                    <thead>
                                <tr>
                                    <th style="width:20px;"><?php echo app('translator')->get('STT'); ?></th>
                                    <th><?php echo app('translator')->get('Full name'); ?></th>
                                    <th style="width:75px;"><?php echo app('translator')->get('Gender'); ?></th>
                                    <th><?php echo app('translator')->get('Địa chỉ'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Số điện thoại'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Email'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Trạng thái'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Chiều cao'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Cân nặng'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Nhịp tim'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Huyết áp'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $healths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $health): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route(Request::segment(2) . '.destroy', $health->id)); ?>" method="POST"
                                onsubmit="return confirm('<?php echo app('translator')->get('confirm_action'); ?>')">
                                <tr class="valign-middle">
                                    <td>
                                        <?php echo e($health->tb_students->student_code); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->tb_students->first_name); ?> <?php echo e($health->tb_students->last_name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->tb_students->sex == 'male' ? 'Nam' : 'Nữ'); ?>

                                    </td>
                                    <td>
                                        <?php echo e(\Carbon\Carbon::parse($health->tb_students->birthday)->age); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->tb_students->phone); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->tb_students->email); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->tb_students->status); ?>

                                    </td>
                                    <td>
                                        <?php echo e($health->height); ?> cm
                                    </td>
                                    <td>
                                        <?php echo e($health->weight); ?> kg
                                    </td>
                                    <td>
                                        <?php echo e($health->health_rate); ?> / phút
                                    </td>
                                    <td>
                                        <?php echo e($health->blood_pressure); ?>

                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="<?php echo app('translator')->get('Update'); ?>"
                                            data-original-title="<?php echo app('translator')->get('update'); ?>"
                                            href="<?php echo e(route(Request::segment(2) . '.edit', $health->id)); ?>">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip"
                                            title="<?php echo app('translator')->get('Delete'); ?>" data-original-title="<?php echo app('translator')->get('delete'); ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>
                <div class="box-footer">
                    <a href="<?php echo e(route(Request::segment(2) . '.index')); ?>">
                        <button type="button" class="btn btn-sm btn-success">Danh sách</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        function importFile(_form, _url) {
            show_loading_notification();
            var formData = new FormData();
            var file = $('#' + _form)[0].files[0];
            if (file == null) {
                alert('Cần chọn file để Import!');
                return;
            }
            formData.append('file', file);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            $.ajax({
                url: _url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    hide_loading_notification();
                    if (response.data != null) {
                        console.log(response.data);;
                    } else {
                        var _html = `<div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                Bạn không có quyền thao tác chức năng này!
                                                </div>`;
                        $('.table-responsive').prepend(_html);
                        $('html, body').animate({
                            scrollTop: $(".alert-warning").offset().top
                        }, 1000);
                        setTimeout(function () {
                            $('.alert-warning').remove();
                        }, 3000);
                    }
                },
                error: function (response) {
                    // Get errors
                    hide_loading_notification();
                    var errors = response.responseJSON.message;
                    console.log(errors);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steamwonder\resources\views/admin/pages/health/show.blade.php ENDPATH**/ ?>