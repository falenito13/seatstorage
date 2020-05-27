@extends('admin::admin')

@section('styles')
<style>
  .nav-tabs > li {
    margin-bottom: -1px;
  }
  .nav-tabs > li > a {
    margin-left: 0px;
  }

</style>
@endsection('style')

@section('body')

{{ Breadcrumbs::render('admin.translation.index', $currentFile) }}

<div style="margin-bottom: 20px;">
  @include('admin::admin.buttons.link-button', ['href' => route( $baseLangName . '.create'), 'title' => __('Add translation'), 'class' => 'info'])
</div>

<ul class="nav nav-tabs">
  @foreach($langFiles as $langFile)
  <li class="{{ $langFile['original_name'] == $currentFile ? 'active' : '' }}"><a href="{{ $langFile['url'] }}">{{ $langFile['name'] }}</a></li>
  @endforeach
</ul>

@include('admin::admin.components.success')

<div class="block">

  <div class="row style-alt">

    <div class="col-sm-6 col-lg-12">

      <div class="table-responsive">
        <table class="table table-vcenter table-striped">
          <thead>
            <tr>
              <th>File</th>
              <th style="width: 200px;">Key</th>
              <th>en</th>
              <th>ka</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($fileArrays['en'] as $key => $fileArray)
            <tr id="{{ $key }}">
              <td>{{ $currentFile }}</td>
              <td style="width: 200px;">{{ $key }}</td>
              <td>
                <input type="text" class="form-control value-{{$key}}-en" value="{{ $fileArray }}">
              </td>
              <td>
                <input type="text"  class="form-control value-{{$key}}-ka" value="{{ array_key_exists($key, $fileArrays['ka']) ? $fileArrays['ka'][$key] : '' }}">
              </td>
              <td class="text-center">
                <div class="btn-group btn-group-xs">
                  <button data-update-route="{{ route('admin.translation.update') }}" data-key="{{ $key }}" data-file="{{ $currentFile }}" data-toggle="tooltip" title="" class="btn btn-success update-lang" data-original-title="save"><i class="gi gi gi-ok_2"></i></button>
                  <button data-update-route="{{ route('admin.translation.delete') }}" data-key="{{ $key }}" data-file="{{ $currentFile }}" data-toggle="tooltip" title="" class="btn btn-danger delete-lang" data-original-title="delate"><i class="fa fa-trash"></i></button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>

    </div>

  </div>

</div>

@endsection

@section('footer_script')

<script>
$('.update-lang').on('click', function (e){

  let updateRoute = $(this).data('update-route');
  let key = $(this).data('key');
  let file = $(this).data('file');

  let valueka = $(`.value-${key}-ka`).val();
  let valueen = $(`.value-${key}-en`).val();

  $.post(updateRoute, {
    _token: document.head.querySelector('meta[name="csrf-token"]').content,
    key: key,
    file: file,
    values: {
      ka: valueka,
      en: valueen
    }
  }).done(function (response) {
    alert('success');
  })

})

$('.delete-lang').on('click', function (e){

  let deleteRoute = $(this).data('update-route');
  let key = $(this).data('key');
  let file = $(this).data('file');

  $.post(deleteRoute, {
    _token: document.head.querySelector('meta[name="csrf-token"]').content,
    key: key,
    file: file
  }).done(function (response) {
    $(`#${key}`).remove();
    alert('success');
  })

})

</script>

@endsection
