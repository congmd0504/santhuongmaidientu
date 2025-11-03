@extends('admin.layouts.main')
@section('css')
<link rel="stylesheet" href="{{asset('lib/char\js\Chart.min.css')}}">
<style>

</style>
@endsection
@section('title',"Những con số")
@section('content')
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <h3 class="alert alert-success">Những con số </h3>
                 </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                   <div class="card-header">
                      <h3 class="card-title">Tỷ lệ phần trăm được nhận</h3>
                   </div>
                   <!-- /.card-header -->
                   <div class="card-body table-responsive p-0" style="height: 400px;">
                      <table class="table table-head-fixed">
                         <thead>
                            <tr>

                               <th class="text-nowrap">Lớp</th>
                               <th class="text-nowrap">Tỷ lệ phần trăm</th>
                            </tr>
                         </thead>
                         <tbody>
                             @foreach ($data['rose'] as $rose)
                             <tr>
                                 <td>Lớp {{ $rose['row'] }}</td>
                                 <td>
                                   {{  $rose['percent'] }} %
                                 </td>

                              </tr>
                             @endforeach

                         </tbody>
                      </table>
                   </div>
                   <!-- /.card-body -->
                </div>
             </div>

             <div class="col-md-6">
                <div class="card card-outline card-primary">
                   <div class="card-header">
                      <h3 class="card-title">Những giá trị mặc định</h3>
                   </div>
                   <!-- /.card-header -->
                   <div class="card-body table-responsive p-0" style="height: 400px;">
                      <table class="table table-head-fixed">
                         <thead>
                            <tr>

                               <th class="text-nowrap">Loại</th>
                               <th class="text-nowrap">Giá trị</th>
                            </tr>
                         </thead>
                         <tbody>

                             <tr>
                                 <td>Điểm thưởng PM khi tạo tài khoản </td>
                                 <td>
                                   {{  $data['typePoint']['defaultPoint'] }} Điểm PM
                                 </td>

                              </tr>
                             {{--<tr>
                               <td>BB thưởng tiêu dùng của sơ đồ 7 lớp </td>
                               <td>
                                 {{  $data['typePoint']['pointReward'] }} Điểm
                               </td>
                            </tr>--}}
                             <tr>
                                <td>Số điểm bắn mặc định </td>
                                <td>
                                  {{  $data['transferPointDefault'] }} Điểm
                                </td>
                             </tr>
                             <tr>
                                <td>Tỷ lệ quy đổi BB  </td>
                                <td>
                                1 BB =  {{  number_format(getConfigBB()) }}
                                </td>
                             </tr>
                         </tbody>
                      </table>
                   </div>
                   <!-- /.card-body -->
                </div>
             </div>

          </div>
        </div>
      </div>
</div>

@endsection
@section('js')

@endsection
