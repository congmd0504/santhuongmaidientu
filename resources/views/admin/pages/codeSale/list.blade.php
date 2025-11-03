@extends('admin.layouts.main')
@section('title',"Danh sánh mã giảm giá")
@section('css')
@endsection

@section('content')
<div class="content-wrapper lb_template_list_slider">

    @include('admin.partials.content-header',['name'=>"Slider","key"=>"Danh sách mã giảm giá"])

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session("alert"))
                    <div class="alert alert-success">
                        {{session("alert")}}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                @endif
                <a href="{{route('admin.codeSale.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                 <div class="card card-outline card-primary">
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Code</th>
                                    <th>Giá trị</th>
                                    <th>Số lần được sử dụng</th>
                                    <th class="white-space-nowrap">Trạng thái sử dụng</th>
                                    {{-- <th>slug</th> --}}
                                     <th class="white-space-nowrap">Ngày có hiệu lực</th>
                                     <th class="white-space-nowrap">Ngày hết hiệu lực</th>

                                     <th class="white-space-nowrap">Mã của sản phẩm</th>

                                     <th class="white-space-nowrap">Admin tạo</th>
                                    {{-- <th style="width:150px;">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $item)
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    {{-- <td>{{$item->id}}</td> --}}
                                    <td>{{$item->code}}</td>
                                    <td>{{number_format($item->money)}}</td>
                                    <td>{{number_format($item->count_sale)}}</td>
                                    <td >
                                        ({{number_format($item->count_use)}} lần)
                                        @if ($item->active)
                                         Chưa sử dụng
                                         @else
                                         Đã sử dụng
                                        @endif

                                    </td>
                                    <td >{{$item->date_start}}</td>
                                    <td >{{$item->date_end}}</td>

                                    <td >
                                        @if ($item->product_id)
                                         {{optional($item->product)->name}}
                                         @else
                                         Tất cả sản phẩm
                                        @endif

                                    </td>

                                    <td >{{optional($item->admin)->name}}</td>

                                    {{-- <td>

                                        <a data-url="{{route('admin.codeSale.destroy',['id'=>$item->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->links()}}
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
@endsection
