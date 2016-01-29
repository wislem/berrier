@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/bootstrap-editable/css/bootstrap-editable.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/jqtree/jqtree.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Categories
            <small>manage classified categories</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if($errors->has('general'))
                <div class="alert alert-danger">
                    {{ $errors->first('general') }}
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
            </div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of Categories</h3>
                        <div class="box-tools">
                            <div class="loading"></div>
                            <a href="#" class="btn btn-sm btn-success createCategory"><i class="fa fa-plus"></i> Create new</a>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="alert alert-warning">BIG FAT WARNING: Do not, I repeat, DO NOT delete the Root category</div>
                        <div id="categories-tree"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop


@section('js')
<script src="{{asset('admin_assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/jqtree/tree.jquery.js')}}"></script>
<script>
    var data = {!! $categories !!};
    var serverUrl = "/admin/categories";
</script>
<script src="{{asset('admin_assets/dist/js/pages/categories.js')}}"></script>
@stop