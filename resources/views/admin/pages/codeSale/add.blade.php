@extends('admin.layouts.main')
@section('title', 'Thêm mã giảm giá')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header', ['name' => 'Mã giảm giá', 'key' => 'Thêm mã giảm giá'])
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
                        <form action="{{ route('admin.codeSale.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thêm mới mã giảm giá</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Số lượng mã muốn tạo</label>
                                                <input type="number"
                                                    class="form-control  @error('number') is-invalid @enderror" required
                                                    value="{{ old('number') }}" name="number" placeholder="Nhập số lượng" min="1" step="1">
                                                @error('number')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Giá trị tiền giảm(đ)</label>
                                                <input type="number"
                                                    class="form-control  @error('money') is-invalid @enderror" required
                                                    value="{{ old('money') }}" name="money" placeholder="Nhập số tiền" min="1" >
                                                @error('money')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Số lần được sử dụng(>=1)</label>
                                                <input type="number"
                                                    class="form-control  @error('count_sale') is-invalid @enderror" required
                                                    value="{{ old('count_sale') ?? 1 }}" name="count_sale" placeholder="Nhập số lần được sử dụng" min="1" >
                                                @error('count_sale')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Ngày có hiệu lực</label>
                                                <input type="date" class="form-control @error('date_start') is-invalid  @enderror" placeholder="" id="" name="date_start" value="{{ old('date_start')}}">
                                                @error('date_start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Ngày hết hiệu lực</label>
                                                <input type="date" class="form-control @error('date_end') is-invalid  @enderror" placeholder="" id="" name="date_end" value="{{ old('date_end')}}">
                                                @error('date_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chọn sản phẩm (nếu không chọn mã sẽ được áp dụng cho tất cả sản phẩm)</label>
                                                <select name="product_id" class="form-control select-2-init"
                                                    id="">
                                                    <option value="">Chọn sản phẩm</option>
                                                    @foreach ($dataProduct as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('product_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <div class="invalid-feedback  d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
