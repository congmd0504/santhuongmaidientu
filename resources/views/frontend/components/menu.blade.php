@php
   $i=1;
   if (!isset($limit)) {
     $limit=99;
   }

@endphp


  <ul class="nav-main">
    @foreach ($data as $value)

        <li class="nav-item">
            <a href="{{ $value['slug_full'] }}"><span>{{ $value['name'] }}</span>
                @isset($value['childs'])
                @if (count($value['childs'])>0&&$limit>=$i+1)
                {!!  $icon_d??""  !!}
                @endif
                @endisset
            </a>
            @isset($value['childs'])
                @if (count($value['childs'])>0&&$limit>=$i+1)
                    <ul class="nav-sub">
                        @foreach ($value['childs'] as $childValue)
                            @include('frontend.components.menu-child', ['childs' => $childValue])
                        @endforeach
                    </ul>
                @endif
            @endisset
        </li>
    @endforeach
        {{--<li class="nav-item">
            <a href="/mang-xa-hoi">
                <span>Mạng xã hội</span>
            </a>
        </li>--}}
</ul>





