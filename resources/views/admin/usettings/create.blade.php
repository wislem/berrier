@extends('berrier::admin.layouts.app')

@section('css')
@stop

@section('content')

    <section class="content-header">
        <h1>
            Create new User Setting
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