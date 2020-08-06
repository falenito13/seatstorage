@extends('admin::layouts.admin')

@section('main')
    <div id="page-content">
    @include('admin::includes.header-section', ['name'   => $data['trans_text']['edit'] ])
        <div class="row">
            <div class="col-xs-12">
                <authority-type-save-component
                    :editor_config="{{ json_encode($data['editor_config']) }}"
                    :id="{{ $data['id'] }}"
                    :get-save-data-route="'{{ $data['routes']['create_form_data'] }}'">
                </authority-type-save-component>
            </div>
        </div>
    </div>
@endsection

