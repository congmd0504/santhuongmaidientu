@extends('admin.layouts.main')
@section('title',"Danh sách đơn hàng")
@section('css')
<style>
ul{
    padding-left: 20px;
}
.info-box .info-box-number {
    display: block;
    margin-top: .25rem;
    color: #f00;
    font-weight: 700;
}
input::placeholder{
    font-size: 12px;
}

</style>
@endsection
@section('content')
   <div class="content-wrapper">
        @include('admin.partials.content-header',['name'=>"Đơn hàng","key"=>"Danh sách đơn hàng"])
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @isset($dataTransactionGroupByStatus)
                        <div class="col-sm-12">
                            <div class="list-count">
                                <div class="row">
                                    @foreach ($dataTransactionGroupByStatus as $item)

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Số giao dịch {{ $item['name'] }} </span>
                                            <span class="info-box-number"><strong>{{ number_format($item['total']??0) }}</strong> / tổng số {{ $totalTransaction }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    @endforeach
									  <div class="col-md-4 col-sm-6 col-12">
                                        <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Doanh số / chi phí  (%) </span>
                                            <span class="info-box-number"><strong>{{ number_format($totalMoney ?? 0) }}</strong> / {{ number_format($totalHoaHong ?? 0) }}({{$phantram}}%)</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                </div>
                            </div>
                    </div>
                    @endisset

                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Danh sách đơn hàng mới</h3>
                              <div class="card-tools w-60">
                                  <form action="{{ route('admin.transaction.index') }}" method="GET">

                                    <div class="row" style="font-size: 13px;">
                                        <div class="col-md-9" >
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-0">
                                                    <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Mã GD/Username/Tên user/Tên admin/Email Admin">
                                                    <div id="keyword_feedback" class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select id="order" name="order_with" class="form-control">
                                                        <option value="">Sắp xếp theo</option>
                                                        <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày đặt hàng tăng dần</option>
                                                        <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày đặt hàng giảm dần</option>
                                                        <option value="statusASC" {{ $order_with=='statusASC'? 'selected':'' }}>Trạng thái 1-n</option>
                                                        <option value="statusDESC" {{ $order_with=='statusDESC'? 'selected':'' }}>Trạng thái n-1</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select id="status" name="status" class="form-control">
                                                        <option value="">Tình trang đơn hàng</option>
                                                        @foreach ($listStatus as $status)
                                                          <option value="{{ $status['status'] }}" {{ $status['status']==$statusCurrent? 'selected':'' }}>Đơn hàng {{ $status['name'] }}</option>
                                                          @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                            <a href="{{ route('admin.transaction.index') }}" class="btn btn-danger">Làm lại</a>
                                        </div>

                                    </div>
                                </form>
                              </div>
                           </div>
                           <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                            <div class="count">
                                Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalTransaction }}
                             </div>
                          </div>
                           <!-- /.card-header -->
                           <div class="card-body table-responsive p-0" style="font-size: 13px;">
                              <table class="table table-head-fixed">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th class="text-nowrap">Thông tin</th>
                                       <th class="text-nowrap">Tổng tiền</th>
                                       <th class="text-nowrap">Tài khoản</th>
                                       <th class="">Admin xử lý</th>
                                       <th class="text-nowrap">Trạng thái</th>
                                       <th>Thời gian</th>
                                       <th>Trang thái</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($data as $transaction)
                                     <tr>
                                         <td>{{ $transaction->id }}</td>
                                         <td>
                                             <ul class="pl-0">
                                                <li>
                                                    <strong>MGD:</strong>  {{ $transaction->code }}
                                                  </li>
                                                 <li>
                                                   <strong>Name:</strong>  {{ $transaction->name }}
                                                 </li>
                                                 <li>
                                                  <strong>Phone:</strong>   {{ $transaction->phone }}
                                                 </li>
                                                 <li>
                                                  <strong>Email:</strong>   {{ $transaction->email }}
                                                 </li>
                                                 <li>
                                                    <strong>Username:</strong>   {{ optional($transaction->user)->username }}
                                                </li>
                                                <li>
                                                    <strong>Điện thoại người nhận:</strong>   {{ $transaction->phone_nguoinhan }}
                                                </li>
                                                <li>
                                                    <strong>Điạ chỉ:</strong>   {{ $transaction->address_detail }}
                                                </li>
                                             </ul>
                                         </td>
                                         <td class="text-nowrap">
                                             {{-- <span class="tag tag-success"></span> --}}
                                             <ul class="pl-0">
                                                <li>
                                                  <strong>Tổng giá trị đơn hàng:</strong>  {{ number_format($transaction->total) }} đ
                                                </li>
                                                <li>
                                                    <strong>Trả bằng Ví KTG:</strong>   {{ number_format($transaction->point)}} KTG
                                                </li>
                                                 <li>
                                                     <strong>Trả bằng Ví VNĐ:</strong>   {{ number_format($transaction->vi_vnd)}} đ
                                                 </li>
                                                 <li>
                                                     <strong>Trả bằng tiền mặt:</strong>   {{ number_format($transaction->money)}} đ
                                                 </li>
                                            </ul>
                                        </td>

                                         <td class="text-nowrap">{{ $transaction->user_id?'Thành viên':'Khách vãng lai' }}</td>
                                         <td>
                                            <ul  class="pl-0">
                                                <li>
                                                    <strong>Tên </strong> {{ optional($transaction->admin)->name }}
                                                </li>
                                                <li>
                                                    <strong>Email</strong>  {{ optional($transaction->admin)->email }}
                                                </li>
                                            </ul>
                                        </td>
										    {{-- <td class="text-nowrap status" data-url="{{ route('admin.transaction.loadNextStepStatus',['id'=>$transaction->id]) }}">
                                            @include('admin.components.status',[
                                                'dataStatus'=>$transaction,
                                                'listStatus'=>$listStatus,
                                            ])
                                         </td> --}}
                                         <td class="text-nowrap">
                                            <a class="{{ $transaction->status == 4  ? "" :  "show-status"}}"
                                              data-url="{{ route('admin.editStatus', ['id' => $transaction->id]) }}"
                                              data-id="{{ $transaction->id }}">
                                              @include('admin.components.status',[
                                              'dataStatus'=>$transaction,
                                              'listStatus'=>$listStatus,
                                              ])
                                            </a>
                                         </td>
                                         <td class="text-nowrap">{{ $transaction->created_at }}</td>
                                         <td>
                                             <a  class="btn btn-sm btn-info" id="btn-load-transaction-detail" data-url="{{route('admin.transaction.detail',['id'=>$transaction->id])}}" ><i class="fas fa-eye"></i></a>
                                             {{-- <a href="" data-url="{{route('admin.transaction.destroy',['id'=>$transaction->id])}}"  class="btn btn-sm btn-info btn-danger lb_delete"><i class="far fa-trash-alt"></i></a> --}}
                                         </td>
                                      </tr>
                                     @endforeach

                                 </tbody>
                              </table>
                           </div>
                           <!-- /.card-body -->
                        </div>
                     </div>
                     <div class="col-md-12">
                        {{$data->appends(request()->input())->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
     <!-- The Modal chi tiết đơn hàng -->
  <div class="modal fade in" id="transactionDetail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Chi tiết đơn hàng</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         <div class="content" id="loadTransactionDetail">

         </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="statusTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Trạng thái đơn hàng</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div id="loadListErrorStatus"></div>
              <div id="loadTransactionStatus">

              </div>
          </div>
      </div>
  </div>
</div>
@endsection
@section('js')
<script>
        // load trang thái thanh toán và tình trạng đơn hàng
        $(document).on("click", ".show-status", function() {
        // get url load ajax
        let myThis = $(this);
        let urlRequest = myThis.data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.html;
                    $('#loadTransactionStatus').html(html);
                    $('#statusTransaction').modal('show');
                }
            }
        });
        });
	   $(document).on('submit', '#formTransactionStatus', function() {
        event.preventDefault();
        let myThis = $(this);
        //  let formData = new FormData(this);
        let formData = new FormData(this);
        //  formData.append('content', $('#content').val());
        let urlRequest = $(this).data("url");
        let id = $(this).find('[name=id]').val();
        let my = $('[data-id=' + id + ']');
        console.log(my);
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.code == 200) {
                    my.html(response.html);
                    alert('Thay đổi trạng thái thành công');
                    $('#statusTransaction').modal('hide');
                } else {
                    alert('Thay đổi trạng thái không thành công');
                }
            }
        });
    });
</script>
@endsection
