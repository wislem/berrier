@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/redactor/redactor.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Create new Page
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="box box-success">
                    @include('berrier::admin.pages.form', ['page' => $page])
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{asset('admin_assets/plugins/redactor/redactor.min.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/redactor/plugins/table/table.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/redactor/plugins/video/video.js')}}"></script>

    <script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>
@stop