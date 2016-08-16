@if($page)
    {!! BootForm::open()->action('/admin/pages/' . $page->id)->put() !!}
    {!! BootForm::bind($page) !!}
@else
    {!! BootForm::open()->action('/admin/pages') !!}
@endif

<div class="box-body">
    {!! BootForm::checkbox('Visible', 'is_active')->defaultToChecked() !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs locales" role="tablist">
        @foreach(config('translatable.locales') as $language)
            <li><a href="#{{ $language }}" class="toggle_locale">{{ trans('berrier::locales.' . $language) }}</a></li>
        @endforeach
        </ul>
    </div>

    {!! TranslatableBootForm::text('Slug', 'slug')->addClass('slugit') !!}
    {!! TranslatableBootForm::text('Title', 'title')->addClass('sluggable') !!}
    {!! TranslatableBootForm::textarea('Content', 'content')->addClass('wysiwyg') !!}
    {!! TranslatableBootForm::textarea('Meta description', 'meta_desc') !!}

    {!! BootForm::hidden('folder')->value('editor')->attribute('id', 'uploadFolder') !!}
    {!! BootForm::hidden('_token')->value(csrf_token())->attribute('id', 'token') !!}
</div>

<div class="box-footer">
    <ul class="list-inline list-unstyled">
        <li>{!! BootForm::submit('Save', 'btn-primary') !!}</li>
        <li><a href="{{URL::previous()}}" class="btn btn-default">Cancel</a></li>
    </ul>
</div>

{!! BootForm::close() !!}

