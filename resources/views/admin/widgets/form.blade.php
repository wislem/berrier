{!! BootForm::open(['model' => $widget, 'store' => '\Wislem\Berrier\Http\Controllers\Modules\WidgetController@store', 'update' => '\Wislem\Berrier\Http\Controllers\Modules\WidgetController@update']) !!}
<div class="box-body">

    {!! BootForm::text('title', 'Title', null, ['id' => 'title']) !!}

    {!! BootForm::textarea('content', 'Content', null, ['id' => 'content', 'class' => 'codemirror']) !!}

    {!! BootForm::text('path', 'Path to widget script (blade style)', null, ['id' => 'path', 'placeholder' => 'E.g. widgets.my_widget']) !!}

    {!! BootForm::select('pages[]', 'Appear in Pages', $pages, ($widget) ? $widget->pages()->lists('id')->toArray() : null, ['id' => 'pages[]', 'multiple' => '', 'class' => 'select2']) !!}

    {!! BootForm::select('position', 'Position', ['' => '---'] + config('berrier.theme.widget_positions.logo'), null, ['id' => 'position', 'class' => 'select2']) !!}

    {!! BootForm::text('ordr', 'Order of appearance', null, ['id' => 'ordr']) !!}

    {!! BootForm::checkbox('is_active', 'Visible', '1') !!}

    {!! BootForm::checkbox('is_global', 'Global', '1') !!}

</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', ['class' => 'btn btn-primary']) !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
