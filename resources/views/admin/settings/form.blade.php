@if($setting)
{!! BootForm::open()->action('/admin/settings/' . $setting->id)->put() !!}
{!! BootForm::bind($setting) !!}
@else
{!! BootForm::open()->action('/admin/settings') !!}
@endif

<div class="box-body">
    {!! BootForm::text('Name', 'name') !!}
    {!! BootForm::text('Key', 'key') !!}
    {!! BootForm::textarea('Value', 'value') !!}
</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
