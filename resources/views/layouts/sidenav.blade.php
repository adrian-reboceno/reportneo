<!-- [ Layout sidenav ] Start -->
<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
        <span class="app-brand-logo demo">
            <img src="{{asset('assets/img/logo.png')}}" alt="Brand Logo" class="img-fluid">
        </span>
        <a href="index.html" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Empire</a>
        <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>
    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1">

        <!-- Dashboards -->
        <li class="sidenav-item active">
            <a href="{{route('dashboard')}}" class="sidenav-link">
                <i class="sidenav-icon feather icon-home"></i>
                <div>Dashboards</div>              
            </a>
        </li>       
        <!-- UI elements -->
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-box"></i>
                <div>Catalogos</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{route('status.index')}}" class="sidenav-link">
                        <div>Status</div>
                    </a>
                </li>                
            </ul>
        </li>     
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-users"></i>
                <div>Manager users</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{route('users.index')}}" class="sidenav-link">
                        <div>Users</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('roles.index')}}" class="sidenav-link">
                        <div>Role</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-layers"></i>
                <div>Cypherlearning</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{route('neotenants.index')}}" class="sidenav-link">
                        <div>Neo Tenant</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('neoapis.index')}}" class="sidenav-link">
                        <div>Neo Api</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('neostatuses.index')}}" class="sidenav-link">
                        <div>Neo Status</div>
                    </a>
                </li>  
                <li class="sidenav-item">
                    <a href="{{route('neoprofiles.index')}}" class="sidenav-link">
                        <div>Neo Profiles</div>
                    </a>
                </li>                               
                <li class="sidenav-item">
                    <a href="{{route('neoorganizations.index')}}" class="sidenav-link">
                        <div>Neo organizations</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-activity "></i>
                <div>Neo Sync</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{route('syncorganizations.create')}}" class="sidenav-link">
                        <div>Organizations</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('syncusers.create')}}" class="sidenav-link">
                        <div>Users</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('syncclasses.create')}}" class="sidenav-link">
                        <div>Class</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('syncclassteachers.create')}}" class="sidenav-link">
                        <div>Teachers Class</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{route('syncclassattendances.create')}}" class="sidenav-link">
                        <div>Attendance sessions class</div>
                    </a>
                </li>
            </ul>
        </li>
        <!--  Icons -->
        {{--  <li class="sidenav-divider mb-1"></li>   feather icon-activity  --}}
        
    </ul>
</div>
<!-- [ Layout sidenav ] End -->