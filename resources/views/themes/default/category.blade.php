@extends('berrier::themes.default.layouts.app')

@section('css')
@stop

@section('content')
<div class="container">
    <div class="row">
    <div class="col-sm-3 page-sidebar">
        <aside>
            <div class="inner-box">
            </div>
        </aside>
    </div>
    <!--/.page-side-bar-->
    <div class="col-sm-9 page-content col-thin-left">
        <div class="category-list">
            <div class="tab-box ">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs add-tabs" id="ajaxTabs" role="tablist">
                    <li class="active"><a href="#allAds" data-url="ajax/1.html" role="tab" data-toggle="tab">All Ads <span class="badge">228,705</span></a></li>
                    <li><a href="#businessAds" data-url="ajax/2.html" role="tab" data-toggle="tab">Business <span class="badge">22,805</span></a></li>
                    <li><a href="#personalAds" data-url="ajax/3.html" role="tab" data-toggle="tab">Personal <span class="badge">18,705</span></a></li>
                </ul>
                <div class="tab-filter">
                    <select class="selectpicker" data-style="btn-select" data-width="auto">
                        <option>Short by</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
            </div>
            <!--/.tab-box-->

            <div class="listing-filter">
                <div class="pull-left col-xs-6">
                    <div class="breadcrumb-list"> <a href="#" class="current"> <span>All ads</span></a> in New York <a href="#selectRegion" id="dropdownMenu1"  data-toggle="modal"> <span class="caret"></span> </a> </div>
                </div>
                <div class="pull-right col-xs-6 text-right listing-view-action"> <span class="list-view active"><i class="  icon-th"></i></span> <span class="compact-view"><i class=" icon-th-list  "></i></span> <span class="grid-view "><i class=" icon-th-large "></i></span> </div>
                <div style="clear:both"></div>
            </div>
            <!--/.listing-filter-->

            <div class="adds-wrapper">
                <div class="tab-content">
                    <div class="tab-pane active" id="allAds">Loading...</div>
                    <div class="tab-pane" id="businessAds"></div>
                    <div class="tab-pane" id="personalAds"></div>
                </div>
            </div>
            <!--/.adds-wrapper-->

            <div class="tab-box  save-search-bar text-center"> <a href=""> <i class=" icon-star-empty"></i> Save Search </a> </div>
        </div>
        <div class="pagination-bar text-center">
            <ul class="pagination">
                <li  class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"> ...</a></li>
                <li><a class="pagination-btn" href="#">Next &raquo;</a></li>
            </ul>
        </div>
        <!--/.pagination-bar -->

        <div class="post-promo text-center">
            <h2> Do you get anything for sell ? </h2>
            <h5>Sell your products online FOR FREE. It's easier than you think !</h5>
            <a href="post-ads.html" class="btn btn-lg btn-border btn-post btn-danger">Post a Free Ad </a></div>
        <!--/.post-promo-->
    </div>
    <!--/.page-content-->
    </div>
</div>
@stop

@section('js')

@stop