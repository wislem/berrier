<div class="row">
    <div class="col-md-12">
        {!! BootForm::open()->action('#')->attribute('id', 'modal-form') !!}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs locales" role="tablist">
                    @foreach(config('translatable.locales') as $language)
                        <li><a href="#{{ $language }}" class="toggle_locale">{{ trans('berrier::locales.' . $language) }}</a></li>
                    @endforeach
                </ul>
            </div>
            {!! TranslatableBootForm::text('Slug', 'slug')->addClass('slugit') !!}
            {!! TranslatableBootForm::text('Name', 'name')->addClass('sluggable') !!}
            {!! BootForm::select('Belongs To', 'parent_id')->options(['' => '---'] + $categories)->addClass('select2') !!}
        {!! BootForm::close() !!}
    </div>
</div>

<script src="{{asset('admin_assets/dist/js/pages/form.js')}}"></script>
<script>
    $(function(){
        setTimeout(function(){
            $('.select2').select2();
        }, 200);
    })
</script>
