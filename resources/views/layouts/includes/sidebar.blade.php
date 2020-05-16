<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('images/avatar.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->nombreCompleto}}</p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i>
                    {{(isset(Auth::user()->dependencia))?Auth::user()->dependencia:Auth::user()->escuela}}
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Navegacion</li>
            <li class="{{Request::is('home')?'active':''}}">
                <a href="{{url('/home')}}"><i class="fa fa-home"></i> <span>Principal</span></a>
            </li>
            @can('action',App\Activo::class)
                <li class="{{Request::is('activos/*')?'active':''}}">
                    <a href="{{route('listar-activos')}}"><i class="fa fa-tv"></i> <span>Activos</span></a>
                </li>
            @endcan
            @can('action',App\Aula::class)
                <li class="{{Request::is('aulas/*')?'active':''}}">
                    <a href="{{route('listar-aulas')}}"><i class="fa fa-cube"></i> <span>Aulas</span></a>
                </li>
            @endcan
            @can('action',App\Reserva::class)
                <li class="{{Request::is('reservas/*')?'active':''}}">
                    <a href="{{route('listar-reservas')}}"><i class="fa fa-star"></i> <span>Reservas</span></a>
                </li>
            @endcan
            @can('action',App\User::class)
                <li class="{{Request::is('usuarios/*')?'active':''}}">
                    <a href="{{route('listar-usuarios')}}"><i class="fa fa-users"></i> <span>Usuarios</span></a>
                </li>
            @endcan
            {{--<li class="{{Request::is('reportes')?'active':''}}">--}}
            {{--<a href="#"><i class="fa fa-link"></i> <span>Reportes</span></a>--}}
            {{--</li>--}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>