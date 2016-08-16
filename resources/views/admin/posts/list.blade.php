@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/bootgrid/jquery.bootgrid.min.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Posts
            <small>manage blog posts</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of posts</h3>
                        <div class="box-tools">
                            <a href="{{url('admin/posts/create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Create new</a>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="grid-data">
                                <thead>
                                    <tr>
                                        <th data-column-id="id" data-identifier="true">#</th>
                                        <th data-column-id="title" data-converter="string">Title</th>
                                        <th data-column-id="categories" data-converter="string">Categories</th>
                                        <th data-column-id="is_active" data-formatter="is_active">Visible?</th>
                                        <th data-column-id="actions" data-formatter="actions" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop


@section('js')
<script src="{{asset('admin_assets/plugins/bootgrid/jquery.bootgrid.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/bootgrid/jquery.bootgrid.fa.min.js')}}"></script>

<script>
    var grid_url = '/admin/posts';
    var grid_view_front = true;
    var grid_view_front_url = '{{ config('app.url') . '/' . config('app.locale') . '/p' }}';
</script>

<script src="{{asset('admin_assets/plugins/bootgrid/laravel-bootgrid.js')}}"></script>
@stop