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
      <a class="btn btn-success btn-sm pull-right" href="{{ route(Request::segment(2) . '.index') }}">
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

    <form role="form" action="{{ route(Request::segment(2) . '.update', ['id' => $health->id ]) }}" method="POST" id="form_product" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">@lang('Update form')</h3>
            </div>
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#tab_1" data-toggle="tab">
                      <h5>Thông tin học sinh <span class="text-danger">*</span></h5>
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
                          <label>@lang('ID')</label>
                          <input type="text" class="form-control" name="student_id" value="{{ old('student_id', $health->student_id ?? '') }}">
                        </div>
                        <div class="form-group">
                          <label>@lang('Chiều cao')</label>
                          <input type="text" class="form-control" name="height" value="{{ old('height', $health->height ?? '') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Cân nặng')</label>
                          <input type="text" class="form-control" name="weight" value="{{ old('weight', $health->weight ?? '') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Nhịp tim')</label>
                          <input type="text" class="form-control" name="health_rate" value="{{ old('health_rate', $health->health_rate ?? '') }}">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>@lang('Huyết áp')</label>
                          <input type="text" class="form-control" name="blood_pressure" value="{{ old('blood_pressure', $health->blood_pressure ?? '') }}">
                        </div>
                      </div>
                      <!-- Container cho chức năng thêm ngày -->
                      <div class="box-day"></div>
                    </div>
                  </div> <!-- tab-pane -->
                </div> <!-- tab-content -->
              </div>
            </div>
            <div class="box-footer">
              <a href="{{ route(Request::segment(2) . '.index') }}">
                <button type="button" class="btn btn-sm btn-success">@lang('Danh sách')</button>
              </a>
              <button type="button" class="btn btn-sm btn-primary add_day">@lang('Thêm ngày')</button>
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
