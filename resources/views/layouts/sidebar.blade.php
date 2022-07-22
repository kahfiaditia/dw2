<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>
        <?php
        $users = DB::table('users')
            ->select('akses_menu', 'akses_submenu')
            ->where('id', Auth::user()->id)
            ->get();
        $session_menu = explode(',', $users[0]->akses_menu);
        $session_submenu = explode(',', $users[0]->akses_submenu);
        $akses_menu = DB::table('menu')
            ->select('menu.id', 'menu', 'sub_menu', 'menu.icon as icon_menu', DB::raw('group_concat(submenu.id) as id_submenu'))
            ->Join('submenu', 'submenu.menu_id', 'menu.id')
            ->orderby('menu.order_menu', 'ASC')
            ->groupby('menu.id')
            ->get();
        ?>
        @foreach ($akses_menu as $item)
            @if (in_array($item->id, $session_menu))
                <?php $sub_menu = DB::table('submenu')
                    ->select('*')
                    ->where('menu_id', $item->id)
                    ->where('type_menu', 'view')
                    ->get(); ?>
                @if ($item->sub_menu > 0)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-group"></i>
                            <span>{{ $item->menu }}</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @foreach ($sub_menu as $sub_item)
                                @if (in_array($sub_item->id, $session_submenu))
                                    @if ($sub_item->route_submenu)
                                        <li><a href="{{ route($sub_item->route_submenu) }}"
                                                class="waves-effect">{{ $sub_item->submenu }}</a></li>
                                    @else
                                        <li><a href="#" class="waves-effect">{{ $sub_item->submenu }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    @foreach ($sub_menu as $sub_item)
                        <li>
                            <a href="{{ route($sub_item->route_submenu) }}" class="waves-effect">
                                <i class="{{ $item->icon_menu }}"></i>
                                <span>{{ $item->menu }}</span>
                            </a>
                        </li>
                    @endforeach
                @endif
            @endif
        @endforeach
        @if (Auth::user()->roles == 'Administrator')
            <li>
                <a href="{{ route('setting.index') }}" class="waves-effect">
                    <i class="bx bxl-jsfiddle text-info"></i>
                    <span>Setting Website</span>
                </a>
            </li>
        @endif
    </ul>
</div>
