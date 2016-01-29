@extends('berrier::admin.layouts.app')

@section('css')

@stop

@section('content')

    <section class="content-header">
        <h1>
            Create new Menu
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                @include('berrier::admin.menus.form', ['menu' => $menu])
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>
    <script src="{{asset('admin_assets/plugins/nestable/jquery.nestable.js')}}"></script>
    <script src="{{asset('admin_assets/dist/js/pages/menus.js')}}"></script>
    <script>
        $(function(){
            CompNestable.init();
        });
    </script>
@stop