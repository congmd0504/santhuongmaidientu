
  <ul class="menu-side-bar">
    {{-- <li class="nav_item"><a href="http://demo11.bivaco.net/cham-soc-da"><span>Chăm sóc da</span></a>
        <ul class="menu-side-bar-leve-2">
            <li class="nav_item1">
                <a href="http://demo11.bivaco.net/kem-tri-mun"><span>Kem trị mụn</span></a>
                <ul class="menu-side-bar-leve-3">
                    <li class="nav_item2">
                        <a href="http://demo11.bivaco.net/kem-tri-mun-eucerin"><span>Kem trị mụn Eucerin</span></a>
                    </li>
                </ul>
            </li>

        </ul>
    </li> --}}
    @foreach ($data as $value)
        <li class="nav_item">
            <a href="{{ makeLink($type,$value->id,$value->slug) }}"><span>{{ $value->name }}</span>
                @if ($value->childs->count())
                <i class="fa fa-angle-right pt_icon_right"></i>
                @endif
            </a>

            @if ($value->childs->count())
                <ul class="menu-side-bar-leve-2">
                    @foreach ($value->childs as $childValue)
                        @include('frontend.components.category-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>





