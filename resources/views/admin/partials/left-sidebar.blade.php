<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">NAVIGATION</li>
        @foreach($menu_main->roots() as $item)
            <li {!! $item->attributes() !!}>
                @if($item->link)
                <a href="{{ $item->url() }}">
                    {!! $item->title !!}
                </a>
                @else
                    {!! $item->title !!}
                @endif
                @if($item->hasChildren())
                    <ul class="treeview-menu">
                        @foreach($item->children() as $child)
                            <li {!! $child->attributes() !!}><a href="{{ $child->url() }}">{!! $child->title !!}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
            @if($item->divider)
                <li class="header">&nbsp;</li>
            @endif
        @endforeach
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>