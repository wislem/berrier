@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/redactor/redactor.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit User Setting <small>{{$setting->title}}</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-10 col-md-12">
                <div class="box box-success">
                    @include('berrier::admin.usettings.form', ['setting' => $setting])
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>
@stop