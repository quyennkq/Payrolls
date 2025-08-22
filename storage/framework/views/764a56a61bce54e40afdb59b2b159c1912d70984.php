```blade


<?php $__env->startSection('title'); ?>
  <?php echo e($module_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
  <style>
    .del_day {
      color: red;
      background: #eee;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      text-align: center;
      top: 20px;
      right: 5px;
      cursor: pointer;
    }
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo e($module_name); ?>

      <a class="btn btn-success btn-sm pull-right" href="<?php echo e(route('extracurricular.index')); ?>">
        <i class="fa fa-bars"></i> <?php echo app('translator')->get('List'); ?>
      </a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
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

    <form role="form" action="<?php echo e(route(Request::segment(2) . '.store')); ?>" method="POST" id="form_product" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo app('translator')->get('Create form'); ?></h3>
            </div>
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#tab_1" data-toggle="tab">
                      <h5>Thông tin chương trình <span class="text-danger">*</span></h5>
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
                          <label><?php echo app('translator')->get('Tên chương trình ngoại khóa'); ?><small class="text-red">*</small></label>
                          <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Mô tả chương trình'); ?></label>
                          <input type="text" class="form-control" name="description" value="<?php echo e(old('description')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Ngày bắt đầu'); ?></label>
                          <input type="date" class="form-control" name="first_date" value="<?php echo e(old('first_date')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Ngày kết thúc'); ?></label>
                          <input type="date" class="form-control" name="last_date" value="<?php echo e(old('last_date')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Thời gian bắt đầu'); ?></label>
                          <input type="time" class="form-control" name="start_time" value="<?php echo e(old('start_time')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Thời gian kết thúc'); ?></label>
                          <input type="time" class="form-control" name="end_time" value="<?php echo e(old('end_time')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Địa điểm tổ chức'); ?></label>
                          <input type="text" class="form-control" name="location" value="<?php echo e(old('location')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Hình thức tham gia'); ?></label>
                          <input type="text" class="form-control" name="form_participation" value="<?php echo e(old('form_participation')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Hình thức tổ chức'); ?></label>
                          <input type="text" class="form-control" name="form_organizational" value="<?php echo e(old('form_organizational')); ?>">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo app('translator')->get('Giá tiền'); ?></label>
                          <input type="number" class="form-control" name="expense" value="<?php echo e(old('expense')); ?>">
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
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    function del_day(th) {
      $(th).parents('.parrent_day').remove();
    }

    $('.add_day').click(function() {
      var _html = `<div class="col-md-3 parrent_day">
                     <span onclick="del_day(this)" class="position-absolute del_day">x</span>
                     <div class="form-group">
                       <label><?php echo app('translator')->get('Date'); ?> <small class="text-red">*</small></label>
                       <input type="date" class="form-control" name="date[]" value="<?php echo e(date('Y-m-d')); ?>">
                     </div>
                   </div>`;
      $('.box-day').append(_html);
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steamwonder\resources\views/admin/pages/extracurricular/create.blade.php ENDPATH**/ ?>