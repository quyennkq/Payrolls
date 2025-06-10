


<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo app('translator')->get($module_name); ?>
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
        <form role="form" action="<?php echo e(route(Request::segment(2) . '.store')); ?>" method="POST">
            <input type="hidden" name="member_id" value="<?php echo e($member->id ?? ''); ?>">
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo app('translator')->get('Update form'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php echo csrf_field(); ?>
                        <div class="box-body">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">
                                            <h5>Thông tin chính <span class="text-danger">*</span></h5>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="d-flex-wap">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Username'); ?> <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="username"
                                                        placeholder="<?php echo app('translator')->get('Username'); ?>"
                                                        value="<?php echo e(old('username') ?? ($member->phone ?? '')); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Password'); ?> <small class="text-red">*</small></label>
                                                    <input type="password" class="form-control" required name="password"
                                                        placeholder="<?php echo app('translator')->get('Password must be at least 8 characters'); ?>" value="<?php echo e(old('password')); ?>"
                                                        autocomplete="new-password">
                                                </div>
                                            </div>
                                            <hr class="col-md-12">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('First Name'); ?> <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="first_name"
                                                        placeholder="<?php echo app('translator')->get('First Name'); ?>"
                                                        value="<?php echo e(old('first_name') ?? ($member->first_name ?? '')); ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Last Name'); ?> <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="last_name"
                                                        placeholder="<?php echo app('translator')->get('Last Name'); ?>"
                                                        value="<?php echo e(old('last_name') ?? ($member->last_name ?? '')); ?>"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Email'); ?></label>
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="<?php echo app('translator')->get('Email'); ?>"
                                                        value="<?php echo e(old('email') ?? ($member->email ?? '')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Phone'); ?><small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="phone" required
                                                        placeholder="<?php echo app('translator')->get('Phone'); ?>"
                                                        value="<?php echo e(old('phone') ?? ($member->phone ?? '')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Address'); ?></label>
                                                    <input type="text" class="form-control" name="address"
                                                        placeholder="<?php echo app('translator')->get('Address'); ?>"
                                                        value="<?php echo e(old('address') ?? ($member->address ?? '')); ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.tab-content -->
                        </div><!-- nav-tabs-custom -->

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo app('translator')->get('Status'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="status" class=" form-control select2">
                                    <?php $__currentLoopData = App\Consts::USER_STATUS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"
                                            <?php echo e(old('status') && old('status') == $val ? 'selected' : ''); ?>>
                                            <?php echo app('translator')->get($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo app('translator')->get('Image'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group box_img_right">
                                <div id="image-holder">
                                    <img src="<?php echo e(url('themes/admin/img/no_image.jpg')); ?>">
                                </div>
                                <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-trash"></i></span>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <a data-input="image" data-preview="image-holder" class="btn btn-primary lfm"
                                            data-type="cms-image">
                                            <i class="fa fa-picture-o"></i> <?php echo app('translator')->get('choose'); ?>
                                        </a>
                                    </span>
                                    <input id="image" class="form-control inp_hidden" type="hidden" name="avatar"
                                        placeholder="<?php echo app('translator')->get('Image source'); ?>" value="<?php echo e(old('avatar') ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo app('translator')->get('Publish'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="btn-set">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> <?php echo app('translator')->get('Save'); ?>
                                </button>
                                &nbsp;&nbsp;
                                <a class="btn btn-success " href="<?php echo e(route(Request::segment(2) . '.index')); ?>">
                                    <i class="fa fa-bars"></i> <?php echo app('translator')->get('List'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\steamwonders\resources\views/admin/pages/users/create.blade.php ENDPATH**/ ?>