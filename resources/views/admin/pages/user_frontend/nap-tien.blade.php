@extends('admin.layouts.main')
@section('title',"Sửa thành viên")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
   background-color: #000 !important;
   }
   .select2-container .select2-selection--single{
   height: auto;
   }
</style>
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Amin User","key"=>"Sửa thành viên"])
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
               <form action="{{route('admin.user_frontend.napTienPost',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data"
                onsubmit="submitPay(this)"
                >
                  @csrf
                  @csrf
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card card-outline card-primary">
                              <div class="card-header">
                                 <h3 class="card-title">Nạp tiền cho tài khoản {{ $data->username }}</h3>
                              </div>
                              <div class="card-body table-responsive p-3">
                                  <div class="form-group">
                                      <label for="">Số tiền  ({{ number_format(config("point.pointToMoney")) }}đ đổi được 1 điểm)</label>
                                      <input

                                          class="form-control jsFormatNumber"
                                          min="200000"
                                          step="1"
                                          id=""
                                          value="{{ old('pay') }}"  name="pay"
                                          placeholder="Nhập số tiền nạp"
                                          oninput="format_curency(this);" type="text" onchange="format_curency(this);"
                                      >
                                      @error('pay')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                  </div>

                                  <div class="form-group">
                                       <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content -->
</div>
<script>
    function format_curency(a) {
        let val = a.value.replaceAll('.', '');
        // console.log(a.value);

          a.value = val.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    }
    function submitPay(form) {
        console.log($(form).find('.jsFormatNumber').val());
        $(form).find('.jsFormatNumber').val($(form).find('.jsFormatNumber').val().replaceAll('.', ''));


    }
    </script>
@endsection
@section('js')
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
<script>
   $(function(){
     $(".select-2-init").select2({
       placeholder: "Chọn role",
       allowClear: true
     })
   })
</script>
@endsection
