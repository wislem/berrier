@extends('berrier::admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/bootgrid/jquery.bootgrid.min.css')}}">
@stop

@section('content')

    <section class="content-header">
        <h1>
            Widgets
            <small>manage app widgets</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List of widgets</h3>
                        <div class="box-tools">
                            <a href="{{url('admin/widgets/create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Create new</a>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="grid-data">
                                <thead>
                                    <tr>
                                        <th data-column-id="id" data-identifier="true">#</th>
                                        <th data-column-id="title" data-converter="string">Title</th>
                                        <th data-column-id="path">Path</th>
                                        <th data-column-id="position">Position</th>
                                        <th data-column-id="is_active" data-formatter="is_active">Active</th>
                                        <th data-column-id="is_global" data-formatter="is_global">Global</th>
                                        <th data-column-id="ordr">Order of appearance</th>
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
    var grid_url = '/admin/widgets';
    var grid_view_front = false;
    var grid_view_front_url = '';
</script>

<script src="{{asset('admin_assets/plugins/bootgrid/laravel-bootgrid.js')}}"></script>
@stop