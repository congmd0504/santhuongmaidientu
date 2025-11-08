@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
<style>
    @media (max-width: 768px) {
        .cccd{
            display:flex;
        }
        .img-load{
            max-width: 100px !important;
        }
        .cccd .wrap-load-image:first-child{
            margin-right: 10px ;
        }

    }
    .click-none{
        display: none !important;
    }
    @media (max-width: 550px) {
        .alert{
            font-size:87% !important;
        }
    }
</style>
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">
                <div class="row">


                    @if ($user->active==0)
                    <div class="col-md-12">
                        <div class="alert alert-danger" style=" font-size: 150%;">
                            <strong>warning!</strong> Tài khoản của bạn chưa được kích hoạt <br>
                            <span style="font-size: 14px;">(Các thông số tài khoản sẽ là thông số của tài khoản sau khi được kích hoạt)</span>
                          </div>
                    </div>
                    @elseif($user->active==2)
                    <div class="col-md-12">
                        <div class="alert alert-danger" style=" font-size: 150%;">
                            <strong>warning!</strong> Tài khoản của bạn đã bị khóa <br>
                          </div>
                    </div>
                    @endif
                    @if ($user->status==0)
                    <div class="col-md-12">
                        <div class="alert alert-danger" style=" font-size: 150%;">
                            <strong>!</strong> Bạn hãy điền đầy đủ thông tin tài khoản để KYC tài khoản <br>
                          </div>
                    </div>
                    @elseif($user->status==1)
                    <div class="col-md-12">
                        <div class="alert alert-danger" style=" font-size: 150%;">
                            <strong>!</strong> Tài khoản của bạn đang đợi admin duyệt yêu cầu kyc <br>
                          </div>
                    </div>
                    @elseif($user->status==2)
                    <div class="col-md-12">
                        <div class="alert alert-success" style=" font-size: 150%;">
                            <strong>!</strong> Tài khoản của bạn đã KYC <br>
                          </div>
                    </div>
                    @endif
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
                        <form action="{{route('profile.updateInfo',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Thông tin tài khoản</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3 ">
                                            <div class="row  mb-3">
                                                <div class="col-md-12">
                                                    <p class="text-right mb-1">
                                                        <button class="btn btn-primary click-none click-noidung" type="button" data-toggle="collapse" data-target="#collapseNdtb" aria-expanded="false" aria-controls="collapseNdtb">
                                                            Click để xem nội dung thông báo từ admin
                                                        </button>
                                                      </p>
                                                      <div class="collapse" id="collapseNdtb">
                                                        <div class="card card-body">
                                                            {!! optional($ndtb)->description !!}
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="wrap-load-image mb-3">
                                                        <div class="form-group">
                                                            <label for="">Ảnh đại diện</label>
                                                            <input type="file" class="form-control-file img-load-input border" id="" name="avatar_path">
                                                        </div>
                                                        @error('avatar_path')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                        <img class="img-load border p-1 w-100" src="{{$data->avatar_path?$data->avatar_path:$shareFrontend['userNoImage']}}" alt="{{$data->name}}" style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                                    </div>
                                                    <div class="cccd">
                                                        <div class="wrap-load-image mb-3">
                                                            <div class="form-group">
                                                                <label for="">Ảnh chứng minh thư mặt trên</label>
                                                                @if ($user->status!=2) 
                                                                <input type="file" class="form-control-file img-load-input border" id="" name="cmt_mattren_path">
                                                            @endif 

                                                            </div>
                                                            @error('cmt_mattren_path')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                            <img class="img-load border p-1 w-100" src="{{$data->cmt_mattren_path?$data->cmt_mattren_path:$shareFrontend['userNoImage']}}" alt="{{$data->name}}" style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                                        </div>
                                                        <div class="wrap-load-image mb-3">
                                                            <div class="form-group">
                                                                <label for="">Ảnh chứng minh thư mặt dưới</label>
                                                                @if ($user->status!=2) 
                                                                
                                                                <input type="file" class="form-control-file img-load-input border" id="" name="cmt_matduoi_path">
                                                           @endif 

                                                            </div>
                                                            @error('cmt_matduoi_path')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                            <img class="img-load border p-1 w-100" src="{{$data->cmt_matduoi_path?$data->cmt_matduoi_path:$shareFrontend['userNoImage']}}" alt="{{$data->name}}" style="height: auto;width:auto;max-width:150px;object-fit:cover;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Họ và tên</label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror"  value="{{old('name')?? $data->name }}"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled' }} name="name" placeholder="Họ và tên">
                                                        @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Email liên hệ <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror"  value="{{old('email')?? $data->email }}"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                            name="email" placeholder="Email" required>
                                                        @error('email')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Tài khoản  <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('username') is-invalid @enderror" required
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{old('username')?? $data->username }}" name="username" placeholder="username">
                                                        @error('username')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Số điện thoại mua hàng </label>
                                                        <input type="tel" pattern="[0-9]{9,11}" class="form-control @error('phone') is-invalid @enderror" required
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{ old('phone')?? $data->phone }}" name="phone" placeholder="Số điện thoại">
                                                        @error('phone')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <label for="">Ngày sinh</label>
                                                        <input type="date" class="form-control  @error('date_birth') is-invalid @enderror"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{ old('date_birth')?? $data->date_birth }}" name="date_birth" placeholder="Ngày sinh">
                                                        @error('date_birth')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="">Địa chỉ nhận hàng</label>
                                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{ old('address')?? $data->address }}" name="address" placeholder="Địa chỉ">
                                                        @error('address')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label for="">Hộ khẩu thường trú</label>
                                                        <input type="text" class="form-control  @error('hktt') is-invalid @enderror"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{ old('hktt')?? $data->hktt }}" name="hktt" placeholder="Hộ khẩu thường trú">
                                                        @error('hktt')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="">Chứng minh thư  <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('cmt') is-invalid @enderror" required
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled' }}
                                                        value="{{  old('cmt')?? $data->cmt }}" name="cmt" placeholder="Chứng minh thư">
                                                        @error('cmt')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Mật khẩu  <span style="color: red;">*</span></label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id=""
                                                            value=""  name="password"
                                                            placeholder="Mật khẩu"
                                                        >
                                                        @error('password')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    {{-- {{ old('password') old('password_confirmation') }} --}}
                                                    <div class="form-group">
                                                        <label for="">Nhập lại mật khẩu  <span style="color: red;">*</span></label>
                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            id=""
                                                            value=""  name="password_confirmation"
                                                            placeholder="Nhập lại mật khẩu"
                                                        >
                                                        @error('password_confirmation')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Số tài khoản  <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('stk') is-invalid @enderror" required
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{  old('stk')??  $data->stk }}" name="stk" placeholder="Số tài khoản">
                                                        @error('stk')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Họ tên chủ tài khoản  <span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control @error('ctk') is-invalid @enderror" required
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{  old('ctk')?? $data->ctk }}" name="ctk" placeholder="Chủ tài khoản">
                                                        @error('ctk')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Ngân hàng  <span style="color: red;">*</span></label>
                                                        <select name="bank_id" class="form-control" id=""   {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}} required >
                                                            <option value="0">Chọn ngân hàng</option>
                                                            @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}" {{ (old('bank_id')?? $data->bank_id)==$bank->id ?'selected':''}}>{{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('bank_id')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <label for="">Chi nhánh ngân hàng</label>
                                                        <input type="text" class="form-control @error('bank_branch') is-invalid @enderror"
                                                        {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}
                                                        value="{{old('bank_branch')?? $data->bank_branch }}" name="bank_branch" placeholder="Tên chi nhánh ngân hàng">
                                                        @error('bank_branch')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div> --}}

                                                    <div class="form-group">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" value="1" name="sex" @if((old('sex')?? $data->sex)=="1"||$data->sex==null) {{'checked'}} @endif   {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}>Nam
                                                            </label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" value="0" @if( (old('sex')?? $data->sex)=="0"){{'checked'}} @endif name="sex"   {{ ($data->status == 0 || $data->status == 1)? '':'disabled'}}>Nữ
                                                            </label>
                                                        </div>
                                                        @error('sex')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group form-check">
                                                        <input type="checkbox" class="form-check-input" name="checkrobot" id="" required>
                                                        @if ($data->status == 0)
                                                             <label class="form-check-label" for="" >Xác nhận các thông tin đã chính xác để gửi yêu cầu KYC cho admin xác nhận</label>
                                                        @else
                                                             <label class="form-check-label" for="" >Tôi đồng ý</label>
                                                        @endif

                                                    </div>
                                                    @error('checkrobot')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                                        <button type="reset" class="btn btn-danger">Làm lại</button>
                                                    </div>
                                                </div>
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
<script>

   $(function(){
        // js load image khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayImage(input, '.wrap-load-image', '.img-load');
    });

    function displayImage(input, selectorWrap, selectorImg) {
        let img = input.parents(selectorWrap).find(selectorImg);
        let file = input.prop('files')[0];
        let reader = new FileReader();

        reader.addEventListener("load", function() {
            // convert image file to base64 string
            img.attr('src', reader.result);
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
   });

</script>
@endsection
