@extends('admin.layouts.main')
@section('title', 'Danh sach sản phẩm')
@section('css')

@endsection
@section('control')
    <a href="{{ route('admin.product.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
@endsection
@section('content')
    <div class="content-wrapper lb_template_list_product">

        @include('admin.partials.content-header', ['name' => 'Product', 'key' => 'Danh sách sản phẩm'])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="d-flex justify-content-between ">
                            <a href="{{ route('admin.product.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                            {{-- <div class="group-button-right d-flex">
                        <form action="{{route('admin.product.import.excel.database')}}" class="form-inline" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="max-width: 250px">
                                <input type="file" class="form-control-file" name="fileExcel" accept=".xlsx" required>
                              </div>
                            <input type="submit" value="Import Execel" class=" btn btn-info ml-1">
                        </form>
                        <form class="form-inline ml-3" action="{{route('admin.product.export.excel.database')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="submit" value="Export Execel" class=" btn btn-danger">
                        </form>
                    </div> --}}
                        </div>

                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="card-tools w-100 mb-3">
                                    <form action="{{ route('admin.product.index') }}" method="GET">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="form-group col-md-3 mb-0">
                                                        <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                            type="text" class="form-control" placeholder="Mã SP/Tên SP">
                                                        <div id="keyword_feedback" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                        <select id="order" name="order_with" class="form-control">
                                                            <option value="">-- Sắp xếp theo --</option>
                                                            <option value="dateASC"
                                                                {{ $order_with == 'dateASC' ? 'selected' : '' }}>Ngày tạo tăng
                                                                dần</option>
                                                            <option value="dateDESC"
                                                                {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Ngày tạo giảm
                                                                dần</option>
                                                            <option value="viewASC"
                                                                {{ $order_with == 'viewASC' ? 'selected' : '' }}>Lượt xem tăng
                                                                dần</option>
                                                            <option value="viewDESC"
                                                                {{ $order_with == 'viewDESC' ? 'selected' : '' }}>Lượt xem giảm
                                                                dần</option>
                                                            <option value="priceASC"
                                                                {{ $order_with == 'priceASC' ? 'selected' : '' }}>Giá tăng dần
                                                            </option>
                                                            <option value="priceDESC"
                                                                {{ $order_with == 'priceDESC' ? 'selected' : '' }}>Giá giảm dần
                                                            </option>
                                                            <option value="payASC"
                                                                {{ $order_with == 'payASC' ? 'selected' : '' }}>Số lượt mua tăng
                                                                dần</option>
                                                            <option value="payDESC"
                                                                {{ $order_with == 'payDESC' ? 'selected' : '' }}>Số lượt mua
                                                                giảm dần</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                        <select id="" name="fill_action" class="form-control">
                                                            <option value="">-- Lọc --</option>
                                                            <option value="hot"
                                                                {{ $fill_action == 'hot' ? 'selected' : '' }}>Sản phẩm sỉ
                                                            </option>
                                                            <option value="no_hot"
                                                                {{ $fill_action == 'no_hot' ? 'selected' : '' }}>Sản phẩm không
                                                                sỉ</option>
                                                            <option value="active"
                                                                {{ $fill_action == 'active' ? 'selected' : '' }}>Sản phẩm hiển
                                                                thị</option>
                                                            <option value="no_active"
                                                                {{ $fill_action == 'no_active' ? 'selected' : '' }}>Sản phẩm bị
                                                                ẩn</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                        <select id="categoryProduct" name="category" class="form-control">
                                                            <option value="">-- Tất cả danh mục --</option>
                                                            {{-- <option value="-1" {{ $status==0? 'selected':'' }}>Đơn hàng đã hủy</option> --}}
                                                            {!! $option !!}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-0">
                                                <button type="submit" class="btn btn-success w-40">Tìm kiếm</button>
                                                <a class="btn btn-danger w-40"
                                                    href="{{ route('admin.product.index') }}">Làm mới</a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                                <div class="count">
                                    Tổng số bản ghi <strong>{{ $data->count() }}</strong> / {{ $totalProduct }}
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0 lb-list-category">
                                <table class="table table-head-fixed" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã SP</th>
                                            <th>Name</th>
                                            <th>Giá</th>
                                            {{-- <th class="white-space-nowrap">Số lượt xem</th> --}}
                                            <th>Số SP tồn kho</th>
                                            <th class="white-space-nowrap">Số lượt mua</th>
                                            <th class="white-space-nowrap">Avatar</th>
                                            <th class="white-space-nowrap">Active</th>
                                            <th class="white-space-nowrap">SP Khởi Nghiệp</th>
                                            <th class="white-space-nowrap">Thứ tự</th>
                                            <th class="white-space-nowrap">Danh mục</th>
                                            <th class="white-space-nowrap">Admin xử lý</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $productItem)
                                            {{-- {{dd($productItem->category)}} --}}
                                            <tr>
                                                <td>{{ $loop->index }}</td>
                                                <td>{{ $productItem->masp }}</td>
                                                <td>{{ $productItem->name }}</td>

                                                <td class="text-nowrap">
                                                    <strong>{{ number_format($productItem->price) }}</strong></td>
                                                {{-- <td class="text-nowrap">{{$productItem->view}}</td> --}}
                                                <td>{{ $productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total ? $productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total : 0 }}
                                                </td>
                                                <td class="text-nowrap">
                                                    {{-- {{$productItem->pay}} --}}
                                                    {{ $productItem->stores()->whereIn('type', [2, 3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total? $productItem->stores()->whereIn('type', [2, 3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total: 0 }}
                                                </td>
                                                <td><img src="{{ asset($productItem->avatar_path) }}"
                                                        alt="{{ $productItem->name }}" style="width:80px;"></td>
                                                <td class="wrap-load-active"
                                                    data-url="{{ route('admin.product.load.active', ['id' => $productItem->id]) }}">
                                                    @include('admin.components.load-change-active', [
                                                        'data' => $productItem,
                                                        'type' => 'sản phẩm',
                                                    ])
                                                </td>
                                                <td class="wrap-load-khoi-nghiep"
                                                    data-url="{{ route('admin.product.load.khoi-nghiep', ['id' => $productItem->id]) }}">
                                                    @include('admin.components.load-change-khoi-nghiep', [
                                                        'data' => $productItem,
                                                        'type' => 'sản phẩm',
                                                    ])
                                                </td>
                                                <td><input data-url="{{ route('admin.loadOrderVeryModel',['table'=>'products','id'=>$productItem->id]) }}" class="lb-order text-center"  type="number" min="0" value="{{ $productItem->order?$productItem->order:0 }}" style="width:50px" />
                                                <td>{{ optional($productItem->category)->name }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <strong>Tên</strong> {{ optional($productItem->admin)->name }}
                                                            <br>
                                                            <strong>Email</strong>
                                                            {{ optional($productItem->admin)->email }}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.product.edit', ['id' => $productItem->id]) }}"
                                                        class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                    <a data-url="{{ route('admin.product.destroy', ['id' => $productItem->id]) }}"
                                                        class="btn btn-sm btn-danger lb_delete"><i
                                                            class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{ $data->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
