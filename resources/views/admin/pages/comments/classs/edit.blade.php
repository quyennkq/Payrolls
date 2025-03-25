@extends('admin.layouts.app')


@section('title')
    @lang($module_name)
@endsection
@php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }
@endphp

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang($module_name)
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a>
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
        <form role="form" action="{{ route(Request::segment(2) . '.update', $detail->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Update form')</h3>
                            @isset($languages)
                                @foreach ($languages as $item)
                                    @if ($item->is_default == 1 && $item->lang_locale != Request::get('lang'))
                                        @if (Request::get('lang') != '')
                                            <a class="text-primary pull-right"
                                                href="{{ route(Request::segment(2) . '.edit', $detail->id) }}"
                                                style="padding-left: 15px">
                                                <i class="fa fa-language"></i> {{ __($item->lang_name) }}
                                            </a>
                                        @endif
                                    @else
                                        @if (Request::get('lang') != $item->lang_locale)
                                            <a class="text-primary pull-right"
                                                href="{{ route(Request::segment(2) . '.edit', $detail->id) }}?lang={{ $item->lang_locale }}"
                                                style="padding-left: 15px">
                                                <i class="fa fa-language"></i> {{ __($item->lang_name) }}
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            @endisset
                            

                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        @if (Request::get('lang') != '' && Request::get('lang') != $languageDefault->lang_locale)
                            <input type="hidden" name="lang" value="{{ Request::get('lang') }}">
                        @endif
                        <div class="box-body">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">
                                            <h5>Thông tin chính <span class="text-danger">*</span></h5>
                                        </a>
                                    </li>
                                    <button type="submit" class="btn btn-info btn-sm pull-right">
                                        <i class="fa fa-save"></i> @lang('Save')
                                    </button>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="d-flex-wap">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Title') <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="@lang('Title')"
                                                        value="{{ old('name') ?? ($detail->json_params->name->$lang ?? $detail->name) }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('Start date') <small class="text-red">*</small></label>
                                                    <input type="datetime-local" class="form-control" name="start_date"
                                                        placeholder="@lang('Start date')" value="{{ old('start_date') ?? $detail->start_date }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('End date') <small class="text-red">*</small></label>
                                                    <input type="datetime-local" class="form-control" name="end_date"
                                                        placeholder="@lang('End date')" value="{{ old('end_date') ?? $detail->end_date }}"
                                                        required>
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
                            <h3 class="box-title">@lang('Publish')</h3>
                        </div>
                        <div class="box-body">
                            <div class="btn-set">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> @lang('Save')
                                </button>
                                &nbsp;&nbsp;
                                <a class="btn btn-success " href="{{ route(Request::segment(2) . '.index') }}">
                                    <i class="fa fa-bars"></i> @lang('List')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Level')</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="level_id" class=" form-control select2">
                                    <option value="">@lang('Level')</option>
                                    @foreach ($levels as $val)
                                        <option value="{{ $val->id }}"
                                            {{ isset($detail->level_id) && $detail->level_id == $val->id ? 'selected' : '' }}>
                                            {{ $val->json_params->name->$lang ?? $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Syllabus')</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="syllabus_id" class=" form-control select2">
                                    <option value="">@lang('Syllabus')</option>
                                    @foreach ($syllabus as $val)
                                        <option value="{{ $val->id }}"
                                            {{ isset($detail->syllabus_id) && $detail->syllabus_id == $val->id ? 'selected' : '' }}>
                                            {{ $val->json_params->name->$lang ?? $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Course')</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="course_id" class=" form-control select2">
                                    <option value="">@lang('Course')</option>
                                    @foreach ($course as $val)
                                        <option value="{{ $val->id }}"
                                            {{ isset($detail->course_id) && $detail->course_id == $val->id ? 'selected' : '' }}>
                                            {{ $val->json_params->name->$lang ?? $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Period')</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="period_id" class=" form-control select2">
                                    <option value="">@lang('Period')</option>
                                    @foreach ($period as $val)
                                        <option value="{{ $val->id }}"
                                            {{ isset($detail->period_id) && $detail->period_id == $val->id ? 'selected' : '' }}>
                                            {{ $val->iorder }} ({{ $val->start_time }} - {{ $val->end_time }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        CKEDITOR.replace('content_vi', ck_options);

        $(document).ready(function() {

            // Fill Available Blocks by template
            $(document).on('click', '.btn_search', function() {
                let keyword = $('#search_title_post').val();
                let taxonomy_id = $('#search_taxonomy_id').val();
                let _targetHTML = $('#post_available');
                _targetHTML.html('');
                let checked_post = [];
                $('input[name="json_params[related_post][]"]:checked').each(function() {
                    checked_post.push($(this).val());
                });

                let url = "{{ route('cms_product.search') }}/";
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        keyword: keyword,
                        taxonomy_id: taxonomy_id,
                        other_list: checked_post,
                        different_id: {{ $detail->id }},
                        is_type: "{{ App\Consts::TAXONOMY['product'] }}"
                    },
                    success: function(response) {
                        if (response.message == 'success') {
                            let list = response.data || null;
                            let _item = '';
                            if (list.length > 0) {
                                list.forEach(item => {
                                    _item += '<tr>';
                                    _item += '<td>' + item.id + '</td>';
                                    _item += '<td>' + item.name + '</td>';
                                    _item += '<td>' + item.is_type + '</td>';
                                    _item += '<td>' + formatDate(item.created_at) +
                                        '</td> ';
                                    _item +=
                                        '<td><input name="json_params[related_post][]" type="checkbox" value="' +
                                        item.id +
                                        '" class="mr-15 related_post_item cursor" autocomplete="off"></td>';
                                    _item += '</tr>';
                                });
                                _targetHTML.html(_item);
                            }
                        } else {
                            _targetHTML.html('<tr><td colspan="5">' + response.message +
                                '</td></tr>');
                        }
                    },
                    error: function(response) {
                        // Get errors
                        let errors = response.responseJSON.message;
                        _targetHTML.html('<tr><td colspan="5">' + errors + '</td></tr>');
                    }
                });
            });

            // Checked and unchecked item event
            $(document).on('click', '.related_post_item', function() {
                let ischecked = $(this).is(':checked');
                let _root = $(this).closest('tr');
                let _targetHTML;

                if (ischecked) {
                    _targetHTML = $("#post_related");
                } else {
                    _targetHTML = $("#post_available");
                }
                _targetHTML.append(_root);
            });

            var no_image_link = '{{ url('themes/admin/img/no_image.jpg') }}';

            $('.add-gallery-image').click(function(event) {
                let keyRandom = new Date().getTime();
                let elementParent = $('.list-gallery-image');
                let elementAppend =
                    '<div class="col-lg-3 col-md-3 col-sm-4 mb-1 gallery-image my-15">';
                elementAppend += '<img width="150px" height="150px" class="img-width"';
                elementAppend += 'src="' + no_image_link + '">';
                elementAppend += '<input type="text" name="json_params[gallery_image][' + keyRandom +
                    ']" class="hidden" id="gallery_image_' + keyRandom +
                    '">';
                elementAppend += '<div class="btn-action">';
                elementAppend +=
                    '<span class="btn btn-sm btn-success btn-upload lfm mr-5" data-input="gallery_image_' +
                    keyRandom +
                    '" data-type="cms-image">';
                elementAppend += '<i class="fa fa-upload"></i>';
                elementAppend += '</span>';
                elementAppend += '<span class="btn btn-sm btn-danger btn-remove">';
                elementAppend += '<i class="fa fa-trash"></i>';
                elementAppend += '</span>';
                elementAppend += '</div>';
                elementParent.append(elementAppend);

                $('.lfm').filemanager('image', {
                    prefix: route_prefix
                });
            });
            // Change image for img tag gallery-image
            $('.list-gallery-image').on('change', 'input', function() {
                let _root = $(this).closest('.gallery-image');
                var img_path = $(this).val();
                _root.find('img').attr('src', img_path);
            });

            // Delete image
            $('.list-gallery-image').on('click', '.btn-remove', function() {
                // if (confirm("@lang('confirm_action')")) {
                let _root = $(this).closest('.gallery-image');
                _root.remove();
                // }
            });

            $('.list-gallery-image').on('mouseover', '.gallery-image', function(e) {
                $(this).find('.btn-action').show();
            });
            $('.list-gallery-image').on('mouseout', '.gallery-image', function(e) {
                $(this).find('.btn-action').hide();
            });

            $('.inp_hidden').on('change', function() {
                $(this).parents('.box_img_right').addClass('active');
            });

            $('.box_img_right').on('click', '.btn-remove', function() {
                let par = $(this).parents('.box_img_right');
                par.removeClass('active');
                par.find('img').attr('src', no_image_link);
                par.find('.input[type=hidden]').val("");
            });

            $('.add_space').on('click', function() {
                var _item =
                    "<input type='text' class='form-control form-group ' name='json_product[space][]' placeholder='Nhập không gian' value=''>";
                $('.defautu_space').append(_item);
            });

            $('.add_convenient').on('click', function() {
                var _item = "";
                _item += "<div class='col-md-3 form-group'>";
                _item +=
                    "<input type='text' class='form-control' name='json_product[convenient][icon][]' placeholder='Icon' value=''>";
                _item += "</div>";
                _item += "<div class='col-md-9 form-group'>";
                _item +=
                    "<input type='text' class='form-control' name='json_product[convenient][name][]' placeholder='Nhập tiện nghi' value=''>";
                _item += "</div>";

                $('.defaunt_convenient').append(_item);
            });
            $('.ck_ty').on('change', function() {
                if ($("#form_product input[name='type']:checked").val() == 2) {
                    $('#type_price').attr("disabled", "true");
                } else {
                    $('#type_price').removeAttr('disabled');

                }
            });
            // Routes get all
            var routes = @json(App\Consts::ROUTE_NAME ?? []);
            $(document).on('change', '#route_name', function() {
                let _value = $(this).val();
                let _targetHTML = $('#template');
                let _list = filterArray(routes, 'name', _value);
                let _optionList = '<option value="">@lang('Please select')</option>';
                if (_list) {
                    _list.forEach(element => {
                        element.template.forEach(item => {
                            _optionList += '<option value="' + item.name + '"> ' + item
                                .title + ' </option>';
                        });
                    });
                    _targetHTML.html(_optionList);
                }
                $(".select2").select2();
            });
        });
    </script>
@endsection
