

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
            
        </h1>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="loading-notification" class="loading-notification">
        <p><?php echo app('translator')->get('Please wait'); ?>...</p>
    </div>

    <!-- Main content -->
    <section class="content">
        
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo app('translator')->get('Filter'); ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="<?php echo e(route(Request::segment(2) . '.index')); ?>" id="form_filter" method="GET">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Keyword'); ?> </label>
                                <input type="text" class="form-control" name="keyword" placeholder="<?php echo app('translator')->get('Lọc theo mã học sinh, họ tên hoặc email'); ?>"
                                    value="<?php echo e(isset($params['keyword']) ? $params['keyword'] : ''); ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Area'); ?></label>
                                <select name="area_id" id="area_id" class="form-control select2" style="width: 100%;">
                                    <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                    <?php $__currentLoopData = $area; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>"
                                            <?php echo e(isset($params['area_id']) && $value->id == $params['area_id'] ? 'selected' : ''); ?>>
                                            <?php echo e(__($value->name)); ?>

                                            (Mã: <?php echo e($value->code); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Lớp học '); ?></label>
                                <select name="current_class_id" class="form-control select2" style="width: 100%;">
                                    <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                    <?php $__currentLoopData = $list_class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>"
                                            <?php echo e(isset($params['current_class_id']) && $value->id == $params['current_class_id'] ? 'selected' : ''); ?>>
                                            <?php echo e(__($value->name)); ?>

                                            - <?php echo e(optional($value->area)->name ?? ''); ?>

                                            (Mã: <?php echo e($value->code); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Trạng thái '); ?></label>
                                <select name="status" class="form-control select2" style="width: 100%;">
                                    <option value=""><?php echo app('translator')->get('Please select'); ?></option>
                                    <?php $__currentLoopData = $list_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"
                                            <?php echo e(isset($params['status']) && $key == $params['status'] ? 'selected' : ''); ?>>
                                            <?php echo e(__($value)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Filter'); ?></label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm mr-10"><?php echo app('translator')->get('Submit'); ?></button>
                                    <a class="btn btn-default btn-sm mr-10"
                                        href="<?php echo e(route(Request::segment(2) . '.index')); ?>">
                                        <?php echo app('translator')->get('Reset'); ?>
                                    </a>

                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            

        </div>
        
        <div id="create_crmdata_student" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Import học sinh</h4>
                    </div>
                    <form action="<?php echo e(route('data_student.import')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Chọn tệp'); ?> <a href="<?php echo e(url('themes\admin\img\data_student.xlsx')); ?>"
                                            target="_blank">(<?php echo app('translator')->get('Minh họa file excel'); ?>)</a></label>
                                    <small class="text-red">*</small>
                                    <div style="display: flex" class="d-flex">
                                        <input id="file" class="form-control" type="file" required name="file"
                                            placeholder="<?php echo app('translator')->get('Select File'); ?>" value="">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"
                                                aria-hidden="true"></i> <?php echo app('translator')->get('Import'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo app('translator')->get('List'); ?></h3>
            </div>
            <div class="box-body ">
                <?php if(session('errorMessage')): ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo session('errorMessage'); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('successMessage')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo session('successMessage'); ?>

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
                <?php if(count($rows) == 0): ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo app('translator')->get('not_found'); ?>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width:20px;"><?php echo app('translator')->get('STT'); ?></th>
                                    <th style="width:100px;"><?php echo app('translator')->get('Avatar'); ?></th>
                                    <th style="width:50px;"><?php echo app('translator')->get('Mã HS'); ?></th>
                                    <th><?php echo app('translator')->get('Full name'); ?></th>
                                    <th style="width:60px;"><?php echo app('translator')->get('Nickname'); ?></th>
                                    <th style="width:75px;"><?php echo app('translator')->get('Gender'); ?></th>
                                    <th style="width:75px;"><?php echo app('translator')->get('Area'); ?></th>
                                    <th><?php echo app('translator')->get('Địa chỉ'); ?></th>
                                    <th style="width:85px;"><?php echo app('translator')->get('Trạng thái'); ?></th>
                                    <th style="width:80px;"><?php echo app('translator')->get('Lớp học'); ?></th>
                                    <th style="width:80px;"><?php echo app('translator')->get('Nhập học'); ?></th>
                                    <th><?php echo app('translator')->get('Phụ huynh'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <form action="<?php echo e(route(Request::segment(2) . '.destroy', $row->id)); ?>" method="POST"
                                        onsubmit="return confirm('<?php echo app('translator')->get('confirm_action'); ?>')">
                                        <tr class="valign-middle">
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td>
                                                <?php if(!empty($row->avatar)): ?>
                                                    <a href="<?php echo e(asset($row->avatar)); ?>" target="_blank"
                                                        class="image-popup">
                                                        <img src="<?php echo e(asset($row->avatar)); ?>" alt="Avatar"
                                                            width="100" height="100" style="object-fit: cover;">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($row->student_code); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->first_name ?? ''); ?> <?php echo e($row->last_name ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->nickname ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo app('translator')->get($row->sex); ?>
                                            </td>
                                            <td>
                                                <?php echo e($row->area->name ?? ''); ?>

                                            </td>

                                            <td>
                                                <?php echo e($row->address ?? ''); ?>

                                            </td>

                                            <td>
                                                <?php echo e(__($row->status ?? '')); ?>

                                            <td>
                                                <?php echo e($row->currentClass->name ?? ''); ?>

                                            </td>

                                            <td>
                                                <?php echo e(isset($row->enrolled_at) && $row->enrolled_at != '' ? date('d-m-Y', strtotime($row->enrolled_at)) : ''); ?>

                                            </td>
                                            <td>
                                                <?php if(isset($row->studentParents)): ?>
                                                    <ul>
                                                        <?php $__currentLoopData = $row->studentParents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <?php echo e($entry->relationship->title ?? ''); ?>

                                                                <?php echo e($entry->parent->first_name ?? ''); ?>

                                                                <?php echo e($entry->parent->last_name ?? ''); ?>

                                                                <?php echo e($entry->parent->phone ?? ''); ?>

                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="<?php echo e(route(Request::segment(2) . '.show', $row->id)); ?>"
                                                    data-toggle="tooltip" title="<?php echo app('translator')->get('Chi tiết học sinh'); ?>"
                                                    data-original-title="<?php echo app('translator')->get('Chi tiết học sinh'); ?>"
                                                    onclick="return openCenteredPopup(this.href)">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                    title="<?php echo app('translator')->get('Update'); ?>" data-original-title="<?php echo app('translator')->get('Update'); ?>"
                                                    href="<?php echo e(route(Request::segment(2) . '.edit', $row->id)); ?>">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    data-toggle="tooltip" title="<?php echo app('translator')->get('Delete'); ?>"
                                                    data-original-title="<?php echo app('translator')->get('Delete'); ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
                success: function(response) {
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
                        setTimeout(function() {
                            $('.alert-warning').remove();
                        }, 3000);
                    }
                },
                error: function(response) {
                    // Get errors
                    hide_loading_notification();
                    var errors = response.responseJSON.message;
                    console.log(errors);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\steamwonders\resources\views/admin/pages/students/index.blade.php ENDPATH**/ ?>