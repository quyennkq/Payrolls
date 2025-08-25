<?php $__env->startSection('title'); ?>
    Bảng lương tháng <?php echo e($month->format('m/Y')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
    <h3>Bảng lương tháng <?php echo e($month->format('m/Y')); ?></h3>

    <?php if($rows->isEmpty()): ?>
        <div class="alert alert-warning">Chưa có dữ liệu lương cho tháng này</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th>Tên NV</th>
                        <th>Lương cơ bản/ngày</th>
                        <th>Tổng thu nhập</th>
                        <th>Thực lĩnh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($row->employee_id); ?></td>
                            <td><?php echo e($row->admin->name ?? ''); ?></td>
                            <td><?php echo e($row->base_salary_by_days); ?></td>
                            <td><?php echo e($row->total_income); ?></td>
                            <td><?php echo e($row->net_income); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/payroll/monthly.blade.php ENDPATH**/ ?>