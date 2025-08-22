<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Chi tiết bảng lương</h2>
                            <p class="text-muted">Xem thông tin chi tiết về bảng lương nhân viên</p>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body">
                                <h4 class="mb-4 text-primary fw-bold">Thông tin chi tiết</h4>
                                <table class="table table-striped table-bordered align-middle">
                                    <tbody>
                                        <tr>
                                            <th class="w-25">Mã nhân viên</th>
                                            <td><?php echo e($payroll->employee_id ?? 'Không có dữ liệu'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tháng</th>
                                            <td><?php echo e(\Carbon\Carbon::parse($payroll->month)->format('m/Y') ?? 'Không có dữ liệu'); ?></td>
                                        </tr>
                                        <tr class="table-light">
                                            <th>Lương cơ bản theo ngày</th>
                                            <td><strong><?php echo e(number_format($payroll->base_salary_by_days)); ?> đ</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Tổng cộng</th>
                                            <td><?php echo e(number_format($payroll->subtotal_income)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Chi phí trông muộn/sớm/thứ 7</th>
                                            <td><?php echo e(number_format($payroll->late_sat_cost)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Hỗ trợ xăng xe, điện thoại, vé xe</th>
                                            <td><?php echo e(number_format($payroll->travel_phone_ticket)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Phụ cấp kiêm nhiệm</th>
                                            <td><?php echo e(number_format($payroll->multitask_allowance)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Hỗ trợ cơm thứ 7</th>
                                            <td><?php echo e(number_format($payroll->saturday_meal_support)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Kinh doanh</th>
                                            <td><?php echo e(number_format($payroll->business_bonus)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Phụ cấp hỗ trợ bàn giao</th>
                                            <td><?php echo e(number_format($payroll->handover_support)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Truy lĩnh/truy thu</th>
                                            <td><?php echo e(number_format($payroll->adjustment)); ?> đ</td>
                                        </tr>
                                        <tr class="table-info">
                                            <th>Tổng thu nhập</th>
                                            <td><strong><?php echo e(number_format($payroll->total_income)); ?> đ</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Thu nhập không chịu thuế</th>
                                            <td><?php echo e(number_format($payroll->non_taxable_income)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Thu nhập chịu thuế</th>
                                            <td><?php echo e(number_format($payroll->taxable_income)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Giảm trừ gia cảnh</th>
                                            <td><?php echo e(number_format($payroll->personal_deduction)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Thu nhập tính thuế</th>
                                            <td><?php echo e(number_format($payroll->taxable_base)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Trích nộp Quỹ CĐ NLĐ 1%</th>
                                            <td><?php echo e(number_format($payroll->union_fee)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Trích nộp BHXH NLĐ</th>
                                            <td><?php echo e(number_format($payroll->social_insurance)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Trích nộp thuế TNCN</th>
                                            <td><?php echo e(number_format($payroll->income_tax)); ?> đ</td>
                                        </tr>
                                        <tr>
                                            <th>Thu khác</th>
                                            <td><?php echo e(number_format($payroll->other_deductions)); ?> đ</td>
                                        </tr>
                                        <tr class="table-warning">
                                            <th>Tổng khấu trừ</th>
                                            <td><strong><?php echo e(number_format($payroll->total_deductions)); ?> đ</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Tạm ứng</th>
                                            <td><?php echo e(number_format($payroll->advance_payment)); ?> đ</td>
                                        </tr>
                                        <tr class="table-success">
                                            <th>Thực lĩnh</th>
                                            <td><strong><?php echo e(number_format($payroll->net_income)); ?> đ</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="card-footer d-flex justify-content-end">
                                <a href="<?php echo e(route('payroll.index')); ?>" class="btn btn-secondary me-2">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#xoabangluong<?php echo e($payroll->id); ?>">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Xóa -->
                <div class="modal fade" id="xoabangluong<?php echo e($payroll->id); ?>" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Xác nhận xóa bảng lương</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn <strong>xóa bảng lương</strong> này? <br>
                                Hành động này <span class="text-danger fw-bold">không thể hoàn tác</span>.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                                <form action="<?php echo e(route('payroll.delete', $payroll->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/payroll/show.blade.php ENDPATH**/ ?>