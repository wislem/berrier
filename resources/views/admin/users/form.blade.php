@if($user)
    {!! BootForm::open()->action('/admin/users/' . $user->id)->put() !!}
    {!! BootForm::bind($user) !!}
@else
    {!! BootForm::open()->action('/admin/users') !!}
@endif

<div class="box-body">
    <div class="row">
        <div class="col-xs-12 col-md-7">
            {!! BootForm::text('First name', 'first_name') !!}
            {!! BootForm::text('Last name', 'last_name') !!}
            {!! BootForm::email('Email', 'email') !!}
            {!! BootForm::password('Password', 'password') !!}
            {!! BootForm::password('Confirm password', 'password_confirmation') !!}

            {!! BootForm::select('Gender', 'gender')->options(['0' => '---', '1' => 'Male', '2' => 'Female'])->addClass('select2') !!}
            {!! BootForm::text('Birthday', 'birthday')->addClass('date') !!}
            {!! BootForm::select('Role', 'role')->options(['0' => 'Member', '1' => 'Moderator', '2' => 'Administrator'])->addClass('select2') !!}
            {!! BootForm::select('Status', 'status')->options(['0' => 'Inactive', '1' => 'Active', '2' => 'Banned'])->addClass('select2') !!}
            {!! BootForm::textarea('Reason for ban', 'banned_reason') !!}
            {!! BootForm::text('Last seen IP', 'ip')->attribute('readonly', 'readonly') !!}
            {!! BootForm::text('Last login', 'last_login')->attribute('readonly', 'readonly') !!}
        </div>
        <div class="col-xs-12 col-md-5">
            <h3 class="text-primary">User settings</h3>
            @foreach($settings as $setting)
                {!! BootForm::text($setting->name, 'settings['.$setting->id.']', (!$user) ? $setting->default : $user->settings()->whereUsettingId($setting->id)->first()->value) !!}
            @endforeach
        </div>
    </div>
</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>
{!! BootForm::close() !!}
