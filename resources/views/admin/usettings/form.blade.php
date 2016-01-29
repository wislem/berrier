@if($setting)
    {!! BootForm::open()->action('/admin/usettings/' . $setting->id)->put() !!}
    {!! BootForm::bind($setting) !!}
@else
    {!! BootForm::open()->action('/admin/usettings') !!}
@endif
<div class="box-body">
    {!! BootForm::text('Name', 'name') !!}
    {!! BootForm::text('Key', 'key') !!}
    {!! BootForm::checkbox('User editable', 'user_editable') !!}
    {!! BootForm::textarea('Default value', 'default') !!}
</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
