<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Links</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="/survey"><i class='fa fa-question'></i> <span>The Survey</span></a></li>
            <li><a href="/about"><i class='fa fa-link'></i> <span>About the Co-op</span></a></li>
            <li><a href="http://newsletter.firstworldrural.ca"><i class='fa fa-newspaper-o'></i> <span>Newsletter</span></a></li>
            <li><a href="https://forum.firstworldrural.ca"><i class='fa fa-comments-o'></i> <span>Forum</span></a></li>
            <li><a href="/all"><i class='fa fa-users'></i> <span>All Survey Responses</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-cloud'></i>
                    <span>By ISP</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach($isps as $an_isp)
                        <li><a href="{{url("/byIsp/".$an_isp)}}">{{$an_isp}}</a></li>
                    @endforeach
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
