@extends('berrier::themes.default.layouts.app')

@section('css')
@stop

@section('content')
<div class="container">
    <div class="section-content">
        <div class="row ">
            <h1 class="text-center title-1">{{ $page->title }}</h1>
            <hr class="center-block small text-hr">
            <div class="col-xs-12">
                <div class="text-content has-lead-para text-left">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
@stop
