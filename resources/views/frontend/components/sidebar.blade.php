<div id="side-bar">
    {{--<div class="side-bar">
        @foreach ($categoryProduct as $categoryItem)
        <div class="title-sider-bar">
            {{ $categoryItem->name }}
        </div>
        <div class="list-category">
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs()->get(),
                'type'=>"category_products",
            ])
        </div>
        @endforeach
    </div>--}}

    <div class="side-bar">
        @foreach ($categoryPost as $categoryItem)
        <div class="title-sider-bar">
            {{ $categoryItem->name }}
        </div>
        <div class="list-category">
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs,
                'type'=>"category_posts",
            ])
        </div>
        @endforeach
    </div>
</div>
