@extends('admin.layouts.main')
@section('title',"Danh sach xuất nhập kho")

@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Kho","key"=>"Danh sách xuất nhập kho"])

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
                <div class="col-md-12">
                    <a href="{{ route('admin.store.create',['type'=>1]) }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>


                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.store.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">

                                            <div class="form-group col-md-6 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Mã SP/Tên SP/Mã GD/Email Admin/ Tên Admin">
                                                <div id="keyword_feedback" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="order" name="order_with" class="form-control">
                                                    <option value="">-- Sắp xếp theo --</option>
                                                    <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                                    <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                                    <option value="typeASC" {{ $order_with=='typeASC'? 'selected':'' }}>Trạng thái A-Z</option>
                                                    <option value="typeDESC" {{ $order_with=='typeDESC'? 'selected':'' }}>Trạng thái Z-A</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="1" {{ $fill_action=='1'? 'selected':'' }}>Nhập kho</option>
                                                    <option value="2" {{ $fill_action=='2'? 'selected':'' }}>Đang chờ xuất kho</option>
                                                    <option value="3" {{ $fill_action=='3'? 'selected':'' }}>Xuất kho</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-0 text-right">
                                        <button type="submit" class="btn btn-success ">Tìm kiếm</button>
                                        <a  class="btn btn-danger " href="{{ route('admin.store.index') }}">Làm mới</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã SP</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Kiểu</th>
                                        <th>Số lượng</th>
                                        <th>Mã giao dịch (nếu có)</th>
                                        <th>Admin xử lý</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $item->product->masp }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $typeStore[$item->type]['name']}}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                @if ($item->transaction_id)
                                                {{ optional($item->transaction)->code}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->admin_id)
                                                <ul>
                                                    <li><strong>Tên </strong> {{optional($item->admin)->name}}</li>
                                                    <li><strong>Email </strong> {{optional($item->admin)->email}}</li>
                                                </ul>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->type==1)
                                                <a href="{{ route('admin.store.edit',['id'=>$item->id]) }}" class="btn btn-sm  btn-success"><i class="fas fa-edit"></i></a>
                                                <a data-url="{{ route('admin.store.destroy',['id'=>$item->id]) }}" class="btn btn-sm  btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
