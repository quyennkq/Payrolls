@extends('admin.layouts.app')

@section('title')
    @lang($module_name)
@endsection

@push('style')
@endpush

@section('content-header')
    <section class="content-header">
        <h1>@lang($module_name)
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Thêm mới chấm công')</a>
        </h1>
    </section>
@endsection

@section('content')
    <section class="content">
        <div id="loading-notification" class="loading-notification" style="display: none;">
            <p>@lang('Please wait')...</p>
        </div>

        {{-- Search form --}}
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('Filter')</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="{{ route(Request::segment(2) . '.index') }}" method="GET" id="search-form">
                <div class="box-body">
                    <div class="filter-row">
                        <div class="form-group">
                            <label class="form-label">@lang('Mã nhân viên')</label>
                            <input type="text" class="form-control" name="employee_id" placeholder="@lang('Nhập mã nhân viên')"
                                value="{{ isset($params['employee_id']) ? $params['employee_id'] : '' }}">
                        </div>

                        {{-- ✅ Thêm chọn tháng --}}
                        <div class="form-group">
                            <label class="form-label">@lang('Chọn tháng')</label>
                            <input type="month" class="form-control" name="month"
                                value="{{ isset($params['month']) ? $params['month'] : date('Y-m') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Từ')</label>
                            <input type="date" class="form-control" name="form_date"
                                value="{{ isset($params['form_date']) ? $params['form_date'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Đến')</label>
                            <input type="date" class="form-control" name="to_date"
                                value="{{ isset($params['to_date']) ? $params['to_date'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Thứ tự')</label>
                            <select class="form-control" name="sort">
                                <option value="asc"
                                    {{ isset($params['sort']) && $params['sort'] == 'asc' ? 'selected' : '' }}>
                                    @lang('Tăng dần')</option>
                                <option value="desc"
                                    {{ isset($params['sort']) && $params['sort'] == 'desc' ? 'selected' : '' }}>
                                    @lang('Giảm dần')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary action-btn">@lang('Lọc')</button>
                            <a class="btn btn-default action-btn"
                                href="{{ route(Request::segment(2) . '.index') }}">@lang('Reset')</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex align-items-center gap-2" style="margin: 21px">
                <form action="{{ route('attendance.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center gap-2" style="margin-bottom: 21px">
                    @csrf

                    <input type="file" name="excel_file" class="form-control form-control-sm" style="height: 38px;"
                        required>
                    <button type="submit" class="btn btn-warning btn-sm" style="margin-left: 10px;">
                        <i class="fa fa-file-excel-o"></i> @lang(' Import')
                    </button>
                </form>
            </div>
        </div>

        {{-- Attendance Table --}}
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('List')</h3>
            </div>
            <div class="box-body box_alert">
                @if (session('errorMessage'))
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('errorMessage') }}
                    </div>
                @endif
                @if (session('successMessage'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('successMessage') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (count($rows) == 0)
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @lang('not_found')
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('STT')</th>
                                    <th class="text-center">@lang('Mã nhân viên')</th>
                                    <th class="text-center">@lang('Tên nhân viên')</th>
                                    <th class="text-center">@lang('Thời gian vào')</th>
                                    <th class="text-center">@lang('Thời gian ra')</th>
                                    <th class="text-center">@lang('Số giờ làm việc')</th>
                                    <th class="text-center">@lang('Ngày công chuẩn')</th>
                                    <th class="text-center">@lang('Công thử việc')</th>
                                    <th class="text-center">@lang('Công chính thức')</th>
                                    <th class="text-center">@lang('Thao tác')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ $row->employee_id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->admin->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->check_in ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->check_out ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->work_hours ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->standard_working_days ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->probation_days ?? '' }}
                                        </td>
                                        <td>
                                            {{ $row->official_days ?? '' }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ route('attendance.show', $row->id) }}" data-toggle="tooltip"
                                                title="@lang('Chi tiết')" data-original-title="@lang('Chi tiết')"
                                                onclick="return openCenteredPopup(this.href)">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                title="@lang('Update')" data-original-title="@lang('Update')"
                                                href="{{ route('attendance.edit', $row->id) }}">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <form action="{{ route('attendance.delete', $row->id) }}" method="POST"
                                                style="display: inline-block;"
                                                onsubmit="return confirm('@lang('Bạn có chắc chắn muốn xóa?')');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    data-toggle="tooltip" title="@lang('Delete')"
                                                    data-original-title="@lang('Delete')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-5">
                        Tìm thấy {{ $rows->total() }} kết quả
                    </div>
                    <div class="col-sm-7">
                        {{ $rows->withQueryString()->links('admin.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Camera Modal --}}
        {{-- <div class="modal fade" id="modal_camera" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center col-md-12">@lang('Chụp ảnh xác nhận')</h3>
                    </div>
                    <div class="modal-body show_detail_eduction">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <video id="video" autoplay playsinline style="width: 80%"></video>
                                <canvas id="canvas" style="display:none;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="toggle_camera" class="btn btn-primary" style="display: none;">
                            <i class="fa fa-refresh"></i> Đổi Camera
                        </button>
                        <button type="button" id="capture" data-id="" class="btn btn-success">
                            <i class="fa fa-camera"></i> @lang('Chụp ảnh xác nhận')
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-remove"></i> @lang('Close')
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
@endsection

@section('script')
    <script>
        var rows = @json($rows);
        let videoStream = null;
        let currentFacingMode = "user";
        var areas = @json($areas ?? []);
        var classs = @json($classs ?? []);

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
                var html = `<option value="">@lang('Please select')</option>`;
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
            const noImage = @json(url('themes/admin/img/no_image.jpg'));

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
                    url: '{{ route('attendance.store') }}',
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
                        _token: '{{ csrf_token() }}'
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
@endsection
