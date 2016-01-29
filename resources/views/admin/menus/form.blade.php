@if($menu)
    {!! BootForm::open()->action('/admin/menus/' . $menu->id)->put() !!}
    {!! BootForm::bind($menu) !!}
    {!! BootForm::hidden('items')->value($menu->items) !!}
@else
    {!! BootForm::open()->action('/admin/menus') !!}
    {!! BootForm::hidden('items') !!}
@endif
<div class="box box-success">
    <div class="box-body">

        {!! BootForm::text('Name', 'name') !!}
        {!! BootForm::checkbox('Visible', 'is_active')->defaultToChecked() !!}
    </div>

    <div class="box-footer">
        <ul class="list-inline list-unstyled">
            <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
            <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
        </ul>
    </div>

    {!! BootForm::close() !!}
</div>

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Build the menu</h3>
        <div id="nestable-actions" class="box-tools pull-right">
            <a href="javascript:void(0)" class="btn btn-sm btn-default" data-action="collapse">Collapse All</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default" data-action="expand">Expand All</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <h4>Pages</h4>
                <div class="dd" id="available_items">
                    @if(count($pages))
                        <ol class="dd-list">
                            @foreach($pages as $item)
                                <li class="dd-item" data-id="Page:{{$item->id}}">
                                    <div class="dd-handle"><i class="fa fa-file-text-o fa-fw"></i> {{$item->title}}</div>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <div class="dd-empty"></div>
                    @endif
                </div>

                <h4>Categories</h4>
                <div class="dd" id="available_items_2">
                    @if(count($categories))
                        <ol class="dd-list">
                            {!! showNestedCategories($categories) !!}
                        </ol>
                    @else
                        <div class="dd-empty"></div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <h4>Selected items</h4>
                <div class="dd dd-inverse" id="selected_items">
                    @if($menu)
                        {!! showNestableMenu(beautifyMenuitems(json_decode($menu->items))) !!}
                    @else
                        <div class="dd-empty"></div>
                    @endif
                </div>
                <p>&nbsp;</p>

                <h5>Add a custom link to the menu</h5>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="url" name="xternal_link" value="" placeholder="Type a custom url" class="form-control" id="custom_link">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="url" name="external_link_label" value="" placeholder="Label of your link" class="form-control" id="custom_label">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="target" class="form-control" id="custom_target">
                                <option value="_blank">New window</option>
                                <option value="_top">Same window</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button id="add_selected_item" class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>