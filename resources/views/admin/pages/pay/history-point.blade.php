@extends('admin.layouts.main')
@section('title',"danh sach bắn điểm")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>" Lịch sử bắn điểm","key"=>"Danh sách bắn điểm"])

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

                @if(session("numberUpdate"))
                <div class="alert alert-success">
                   {{session("numberUpdate")}}
                </div>
                @endif

                <div class="card-header">
                    <form action="{{ route('admin.pay.historyPoint') }}" method="GET">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="form-group col-md-3 mb-0">
                                        <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Tên / email admin">
                                        <div id="keyword_feedback" class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                        <select id="order" name="order_with" class="form-control">
                                            <option value="">-- Sắp xếp theo --</option>
                                            <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                            <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                            <option value="typeASC" {{ $order_with=='typeASC'? 'selected':'' }}>Loại điểm Z-A</option>
                                            <option value="typeDESC" {{ $order_with=='typeDESC'? 'selected':'' }}>Loại điểm A-Z</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                        <select id="" name="fill_action" class="form-control">
                                            <option value="">-- Lọc --</option>
                                            <option value="point" {{ $fill_action=='point'? 'selected':'' }}>Điểm </option>
                                            <option value="pointPM" {{ $fill_action=='pointPM'? 'selected':'' }}>Điểm PM</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-1 mb-0">
                                <button type="submit" class="btn btn-success w-100">Search</button>
                            </div>
                            <div class="col-md-1 mb-0">
                                <a  class="btn btn-danger w-100" href="{{ route('admin.pay.historyPoint') }}">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card card-outline card-primary">
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed wrap-pay" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Username</th>
                                        <th>Số điểm bắn</th>
                                        <th>Loại điểm</th>
                                        <th>Admin xử lý</th>
                                        <th>Ngày bắn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    {{-- {{ dd($item) }} --}}
                                    <tr>
                                        <td>{{$loop->index}}</td>
                                        <td>{{$item->user->username}}</td>
                                        <td>{{$item->point}}</td>
                                        {{-- <td class="content-type">{{$typePoint[$item->status]['name']}}</td> --}}
                                        <td class="content-type">{{$typePoint[$item->type]['name']}}</td>
                                        <td>

                                            @if (($item->userorigin_id))
                                            <ul>
                                                <li><strong>Tên </strong>{{ optional($item->admin)->name }}</li>
                                                <li><strong>Email </strong>{{ optional($item->admin)->email }}</li>
                                            </ul>
                                            @endif

                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
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
{{-- <script src="{{asset('')}}"></script> --}}
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>

@endsection
