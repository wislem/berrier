@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/codemirror/codemirror.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit Widget <small>{{$widget->title}}</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-10 col-md-12">
                <div class="box box-success">
                    @include('berrier::admin.widgets.form', ['widget' => $widget])
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{asset('admin_assets/plugins/codemirror/codemirror.js')}}"></script>

    <script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>
@stop