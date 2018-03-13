<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">

        @if (!empty(session('global_nav')))
            @if(session('global_nav')[0])
                @foreach(session('global_nav')[0] as $k => $v)
                    <dl id="menu-article">
                        <dt><i class="Hui-iconfont">{{ $v->icon }}</i> {{ $v->name }}<i
                                    class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                        </dt>
                        @if(isset(session('global_nav')[$v->id]))

                            <dd>
                                <ul>
                                    @foreach(session('global_nav')[$v->id] as $key => $val)
                                        <li @if( Request::path() == $val->route) id="open" @endif>
                                            <a href="{{ route( $val->route_alias ) }}"
                                               data-title="{{ $val->name }}">{{ $val->name }}</a>
                                        </li>

                                    @endforeach
                                </ul>
                            </dd>

                        @endif
                    </dl>
                @endforeach
            @endif
        @endif

    </div>
</aside>

<script>
    function openAside() {
        $('#open').parent().parent().css('display', 'block');
        $('#open').parent().parent().prev().addClass('selected');
    }

    window.onload = openAside;
</script>
