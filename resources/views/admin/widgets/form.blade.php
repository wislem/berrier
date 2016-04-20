@if($widget)
    {!! BootForm::open()->action('/admin/widgets/' . $widget->id)->put() !!}
    {!! BootForm::bind($widget) !!}
@else
    {!! BootForm::open()->action('/admin/widgets') !!}
@endif
<div class="box-body">

    {!! BootForm::checkbox('Visible', 'is_active')->defaultToChecked() !!}
    {!! BootForm::checkbox('Global', 'is_global')->defaultToChecked() !!}

    {!! BootForm::text('Title', 'title') !!}
    {!! BootForm::textarea('Content', 'content')->addClass('codemirror') !!}
    {!! BootForm::text('Path to widget script (blade style)', 'path')->placeholder('E.g. widgets.my_widget') !!}
    @if($widget)
        {!! BootForm::select('Appear in Pages', 'pages[]', ['' => '---'] + $pages)->select($widget->pages()->lists('id')->toArray())->addClass('select2') !!}
        {!! BootForm::select('Appear in Categories', 'categories[]', ['' => '---'] + $categories)->select($widget->categories()->lists('id')->toArray())->addClass('select2') !!}
        {!! BootForm::select('Appear in Posts', 'posts[]', ['' => '---'] + $posts)->select($widget->posts()->lists('id')->toArray())->addClass('select2') !!}
    @else
        {!! BootForm::select('Appear in Pages', 'pages[]', ['' => '---'] + $pages)->addClass('select2') !!}
        {!! BootForm::select('Appear in Categories', 'categories[]', ['' => '---'] + $categories)->addClass('select2') !!}
        {!! BootForm::select('Appear in Posts', 'posts[]', ['' => '---'] + $posts)->addClass('select2') !!}
    @endif

    {!! BootForm::select('Position', 'position', ['' => '---'] + config('berrier.theme.widget_positions'))->addClass('select2') !!}
    {!! BootForm::text('Order of appearance', 'ordr') !!}

</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
