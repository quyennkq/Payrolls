```blade
@extends('admin.layouts.app')

@section('title')
  {{ $module_name }}
@endsection
@push('style')
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
@endpush

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ $module_name }}
      <a class="btn btn-success btn-sm pull-right" href="{{ route('extracurricular.index') }}">
        <i class="fa fa-bars"></i> @lang('List')
      </a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
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

    <form role="form" action="{{ route(Request::segment(2) . '.store') }}" method="POST" id="form_product" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@lang('Create form')</h3>
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
                    <i class="fa fa-save"></i> @lang('Save')
                  </button>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="d-flex-wap">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Tên chương trình ngoại khóa')<small class="text-red">*</small></label>
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Mô tả chương trình')</label>
                          <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Ngày bắt đầu')</label>
                          <input type="date" class="form-control" name="first_date" value="{{ old('first_date') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Ngày kết thúc')</label>
                          <input type="date" class="form-control" name="last_date" value="{{ old('last_date') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Thời gian bắt đầu')</label>
                          <input type="time" class="form-control" name="start_time" value="{{ old('start_time') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Thời gian kết thúc')</label>
                          <input type="time" class="form-control" name="end_time" value="{{ old('end_time') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Địa điểm tổ chức')</label>
                          <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Hình thức tham gia')</label>
                          <input type="text" class="form-control" name="form_participation" value="{{ old('form_participation') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Hình thức tổ chức')</label>
                          <input type="text" class="form-control" name="form_organizational" value="{{ old('form_organizational') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Giá tiền')</label>
                          <input type="number" class="form-control" name="expense" value="{{ old('expense') }}">
                        </div>
                      </div>
                    </div>
                  </div> <!-- tab-pane -->
                </div> <!-- tab-content -->
              </div>
            </div>
            <div class="box-footer">
              <a href="{{ route(Request::segment(2) . '.index') }}">
                <button type="button" class="btn btn-sm btn-success">Danh sách</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('script')
  <script>
    function del_day(th) {
      $(th).parents('.parrent_day').remove();
    }

    $('.add_day').click(function() {
      var _html = `<div class="col-md-3 parrent_day">
                     <span onclick="del_day(this)" class="position-absolute del_day">x</span>
                     <div class="form-group">
                       <label>@lang('Date') <small class="text-red">*</small></label>
                       <input type="date" class="form-control" name="date[]" value="{{ date('Y-m-d') }}">
                     </div>
                   </div>`;
      $('.box-day').append(_html);
    });
  </script>
@endsection
