<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get($module_name); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content-header'); ?>
    <section class="content-header">
        <h1><?php echo app('translator')->get($module_name); ?>
            <a class="btn btn-sm btn-warning pull-right" href="<?php echo e(route(Request::segment(2) . '.create')); ?>"><i
                    class="fa fa-plus"></i> <?php echo app('translator')->get('Thêm mới chấm công'); ?></a>
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
                <form action="<?php echo e(route('attendance.import')); ?>" method="POST" enctype="multipart/form-data"
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
                <?php if(count($rows) == 0): ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo app('translator')->get('not_found'); ?>
                    </div>
                <?php else: ?>
                    <form id="attendance-form" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo app('translator')->get('STT'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Mã nhân viên'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Tên nhân viên'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Thời gian vào'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Thời gian ra'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Số giờ làm việc'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Ngày công chuẩn'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Công thử việc'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Công chính thức'); ?></th>
                                        <th class="text-center"><?php echo app('translator')->get('Thao tác'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td>
                                                <?php echo e($row->employee_id ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->user->first_name ?? ''); ?> <?php echo e($row->user->last_name ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->check_in ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->check_out ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->work_hours ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->standard_working_days ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->probation_days ?? ''); ?>

                                            </td>
                                            <td>
                                                <?php echo e($row->official_days ?? ''); ?>

                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="<?php echo e(route('attendance.show', $row->id)); ?>" data-toggle="tooltip"
                                                    title="<?php echo app('translator')->get('Chi tiết'); ?>" data-original-title="<?php echo app('translator')->get('Chi tiết'); ?>"
                                                    onclick="return openCenteredPopup(this.href)">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                    title="<?php echo app('translator')->get('Update'); ?>" data-original-title="<?php echo app('translator')->get('Update'); ?>"
                                                    href="<?php echo e(route('attendance.edit', $row->id)); ?>">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                <form action="<?php echo e(route('attendance.delete', $row->id)); ?>" method="POST"
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('<?php echo app('translator')->get('Bạn có chắc chắn muốn xóa?'); ?>');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-sm btn-danger" type="submit"
                                                        data-toggle="tooltip" title="<?php echo app('translator')->get('Delete'); ?>"
                                                        data-original-title="<?php echo app('translator')->get('Delete'); ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
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
        var rows = <?php echo json_encode($rows, 15, 512) ?>;
        let videoStream = null;
        let currentFacingMode = "user";
        var areas = <?php echo json_encode($areas ?? [], 15, 512) ?>;
        var classs = <?php echo json_encode($classs ?? [], 15, 512) ?>;

        // Show/Hide loading notification
        function showLoadingNotification() {
            $('#loading-notification').show();
        }

        function hideLoadingNotification() {
            $('#loading-notification').hide();
        }

        // Open centered popup
        function openCenteredPopup(url) {
            const width = 800;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open(url, '_blank', `width=${width},height=${height},top=${top},left=${left}`);
            return false;
        }

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2();

            // Area change handler
            $('.area_id').change(function() {
                var area_id = $(this).val();
                var html = `<option value=""><?php echo app('translator')->get('Please select'); ?></option>`;
                if (area_id) {
                    html += classs
                        .filter(item => item.area_id == area_id)
                        .map(item => `<option value="${item.id}">${item.code} - ${item.name}</option>`)
                        .join('');
                }
                $('.class_id').html(html).trigger('change');
            });

            const video = $('#video')[0];
            const canvas = $('#canvas')[0];
            const noImage = <?php echo json_encode(url('themes/admin/img/no_image.jpg'), 15, 512) ?>;

            // Camera handling
            function checkCameraAvailability() {
                return navigator.mediaDevices.enumerateDevices()
                    .then(devices => {
                        const videoDevices = devices.filter(device => device.kind === 'videoinput');
                        $('#toggle_camera').toggle(videoDevices.length > 1);
                    })
                    .catch(error => {
                        console.error('Camera check error:', error);
                        $('#toggle_camera').hide();
                    });
            }

            function startCamera(facingMode) {
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                }

                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: facingMode
                        }
                    })
                    .then(stream => {
                        videoStream = stream;
                        video.srcObject = stream;
                        currentFacingMode = typeof facingMode === 'object' ? facingMode.exact : facingMode;
                    })
                    .catch(error => {
                        alert('Không thể truy cập camera: ' + error.message);
                    });
            }

            // Radio button handlers
            $(document).on('change', '.checkin', function() {
                var studentId = $(this).data('id');
                $('#capture').attr('data-id', studentId);
                $('#modal_camera').modal('show');
                $('.information_' + studentId).find('.check_disable').prop('disabled', false);

                const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                const facingMode = isMobile ? {
                    exact: "environment"
                } : "user";
                checkCameraAvailability();
                startCamera(facingMode);
            });

            $(document).on('change', '.absent_unexcused, .absent_excused', function() {
                var studentId = $(this).data('id');
                $('.information_' + studentId).find('.check_disable').prop('disabled', true);
                $('.photo_' + studentId).attr('src', noImage);
                $('.img_' + studentId).val('');
            });

            // Toggle camera
            $('#toggle_camera').on('click', function() {
                const newFacingMode = currentFacingMode === "user" ? {
                    exact: "environment"
                } : "user";
                startCamera(newFacingMode);
            });

            // Capture photo
            $('#capture').on('click', function() {
                var studentId = $(this).data('id');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = canvas.toDataURL('image/png', 0.8);
                $('.photo_' + studentId).attr('src', imageData);
                $('.img_' + studentId).val(imageData);
                $('#modal_camera').modal('hide');
            });

            // Modal close handler
            $('#modal_camera').on('hidden.bs.modal', function() {
                if (videoStream) {
                    videoStream.getTracks().forEach(track => track.stop());
                    videoStream = null;
                }
                $('#toggle_camera').hide();
                video.srcObject = null;

                var studentId = $('#capture').attr('data-id');
                if ($('.photo_' + studentId).attr('src') === noImage) {
                    $('#student_' + studentId + '_checkin').prop('checked', false);
                }
            });

            // Save attendance
            $('.btn_attendance').click(function() {
                var studentId = $(this).data('id');
                var classId = $('.class_id').val();
                var trackedAt = $('.tracked_at').val();
                var status = $('input[name="attendance[' + studentId + '][status]"]:checked').val();
                var parentId = $('select[name="attendance[' + studentId + '][checkin_parent_id]"]').val();
                var teacherId = $('select[name="attendance[' + studentId + '][checkin_teacher_id]"]').val();
                var note = $('input[name="attendance[' + studentId + '][json_params][note]"]').val();
                var img = $('input[name="attendance[' + studentId + '][json_params][img]"]').val();

                if (!status) {
                    alert('Vui lòng chọn trạng thái điểm danh');
                    return;
                }
                if (status === 'checkin' && !parentId) {
                    alert('Vui lòng chọn người đưa');
                    return;
                }
                if (status === 'checkin' && !teacherId) {
                    alert('Vui lòng chọn giáo viên đón');
                    return;
                }
                if (status === 'checkin' && !img) {
                    alert('Vui lòng chụp ảnh');
                    return;
                }

                showLoadingNotification();
                $.ajax({
                    url: '<?php echo e(route('attendance.store')); ?>',
                    type: 'POST',
                    data: {
                        student_id: studentId,
                        class_id: classId,
                        tracked_at: trackedAt,
                        status: status,
                        checkin_parent_id: parentId,
                        checkin_teacher_id: teacherId,
                        'json_params[note]': note,
                        'json_params[img]': img,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        hideLoadingNotification();
                        var alertClass = response.data === 'success' ? 'success' : 'warning';
                        var html = `<div class="alert alert-${alertClass} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            ${response.message}
                        </div>`;
                        $('.box_alert').prepend(html);
                        $('html, body').animate({
                            scrollTop: $('.alert').offset().top
                        }, 1000);
                        setTimeout(() => $('.alert').fadeOut(2000), 800);

                        if (response.data === 'success') {
                            location.reload();
                        }
                    },
                    error: function(response) {
                        hideLoadingNotification();
                        alert(response.responseJSON?.message || 'Đã có lỗi xảy ra');
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\steam\steamwonder\resources\views/admin/pages/V_attendance/index.blade.php ENDPATH**/ ?>