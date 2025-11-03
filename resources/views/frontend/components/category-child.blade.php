
<li class="">
    <a href="{{ makeLink($type,$childs->id,$childs->slug) }}"><span>{{ $childs->name }}</span>
        @if ($childs->childs->count())
        <i class="fa fa-angle-right pt_icon_right"></i>
        @endif
    </a>

    @if ($childs->childs->count())
        <ul class="">
            @foreach ($childs->childs as $childValue2)
                @include('frontend.components.category-child', ['childs' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

