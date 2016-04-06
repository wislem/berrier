@if($widget)
    {!! BootForm::open()->action('/admin/widgets/' . $widget->id)->put() !!}
    {!! BootForm::bind($widget) !!}
@else
    {!! BootForm::open()->action('/admin/widgets') !!}
@endif
<div class="box-body">

    {!! BootForm::text('title', 'Title') !!}
    {!! BootForm::textarea('content', 'Content')->addClass('codemirror') !!}
    {!! BootForm::text('path', 'Path to widget script (blade style)')->placeholder('E.g. widgets.my_widget') !!}
    @if($widget)
        {!! BootForm::select('pages[]', 'Appear in Pages', ['' => '---'] + $pages)->select($widget->pages()->lists('id')->toArray())->addClass('select2') !!}
    @else
        {!! BootForm::select('pages[]', 'Appear in Pages', ['' => '---'] + $pages)->addClass('select2') !!}
    @endif

    {!! BootForm::select('position', 'Position', ['' => '---'] + config('berrier.theme.widget_positions'))->addClass('select2') !!}
    {!! BootForm::text('ordr', 'Order of appearance') !!}
    {!! BootForm::checkbox('is_active', 'Visible')->defaultToChecked() !!}
    {!! BootForm::checkbox('is_global', 'Global')->defaultToChecked() !!}
</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
