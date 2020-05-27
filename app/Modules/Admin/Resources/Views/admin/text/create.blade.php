@extends('admin::admin.layouts.default')


@section('body')
{{ Breadcrumbs::render('admin.translation.create', 'archive') }}

@include('admin::admin.components.success')

<div class="row cms-archive">
  <div class="col-md-12">
    <div class="block">
      <form action="{{ route('admin.translation.store') }}" method="post" class="form-horizontal form-bordered">
        @csrf



        <div class="tab-content" style="overflow:visible!important">

          <div class="form-group">
            <div class="col-md-6 @if($errors->has('file')) has-error @endif">
              <label class="col-md-2 control-label" for="example-text-input">@lang('Files')<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select id="example-select2" name="file"  class="select-select2" style="width: 100%;" data-placeholder="Choose file...">
                  <option></option>
                  @foreach($langFiles as $langFile)
                  <option value="{{ $langFile['original_name'] }}" @if( old('file') && old('file') &&  in_array($langFile['original_name'], [old('file')])) selected @endif>{{ $langFile['name'] }}</option>
                  @endforeach
                </select>
                @include('admin::admin.components.field-error', ['field' => 'file'])
              </div>
            </div>

            <div class="col-md-6 @if($errors->has('key')) has-error @endif ">
              <label class="col-md-2 control-label" for="key">@lang('key')<span class="text-danger">*</span></label>
              <div class="col-md-10">
                <input type="text" id="key" name="key" class="form-control">
                @include('admin::admin.components.field-error', ['field' => 'key'])
              </div>
            </div>
          </div>

          <div class="form-group @if($errors->has('ka')) has-error @endif ">
            <div class="col-md-12">
              <label class="col-md-1 control-label" for="ka">@lang('Ka')<span class="text-danger">*</span></label>
              <div class="col-md-11">
                <input type="text" id="ka" name="ka" class="form-control">
                @include('admin::admin.components.field-error', ['field' => 'ka'])
              </div>
            </div>
          </div>


          <div class="form-group @if($errors->has('en')) has-error @endif ">
            <div class="col-md-12">
              <label class="col-md-1 control-label" for="ka">@lang('En')<span class="text-danger">*</span></label>
              <div class="col-md-11">
                <input type="text" id="en" name="en" class="form-control">
                @include('admin::admin.components.field-error', ['field' => 'ka'])
              </div>
            </div>
          </div>
        </div>

        <div class="form-group form-actions">
          <div class="col-md-12">
            @include('admin::admin.buttons.action-button', ['title' => __('Save'), 'class' => 'success'])
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection
