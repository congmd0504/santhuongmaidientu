 <div class="breadcrumbs clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <ol class="breadcrumb mb-0" style="font-size: 12px;">
                        <li class="breadcrumb-item">
                            <a href="{{ makeLink("home") }}" >Trang chủ</a>
                        </li>
                        @foreach ($breadcrumbs as $item)
                        @if ($loop->last)
                        <li class="breadcrumb-item active "><a href="{{ makeLink($type,$item['id']??'',$item['slug']??'') }}">{{ $item['name'] }}</a></li>
                        @else
                        <li class="breadcrumb-item"><a href="{{ makeLink($type,$item['id']??'',$item['slug'])??'' }}">{{ $item['name'] }}</a></li>
                        @endif

                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
