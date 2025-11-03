@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('css')
    <style>

        .badge-1 {
            background: #dc3545;
        }

        .badge-1 {
            background: #c3e6cb;
        }

        .badge-2 {
            background: #ffc107;
        }

        .badge-3 {
            background: #17a2b8;
        }

        .badge-4 {
            background: #28a745;
        }
        .info-box {
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            border-radius: .25rem;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            width: 100%;
        }
        .info-box .info-box-icon {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 70px;
        }
        .info-box .info-box-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 1.8;
            -ms-flex: 1;
            flex: 1;
            padding: 0 10px;
        }
        .info-box .info-box-text, .info-box .progress-description {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .info-box .info-box-number {
            display: block;
            margin-top: .25rem;
            font-weight: 700;
        }
        .modal-header{
            background-color: #000;
            color: #fff;
        }
        .modal-header .close{
            opacity: 1;
            color: #fff;
        }
        .modal-title{
            margin: 0;

        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}

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


                 <div class="col-sm-12">
                    <div class="wrap-history" style="font-size:13px;">
                        <div class="card-header">
                            <h3 class="card-title">Lịch sử rút điểm</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed">
                               <thead>
                                  <tr>
                                     <th>STT</th>
                                     <th class="text-nowrap">Số điểm </th>
                                     <th>Trạng thái</th>
                                     <th class="text-nowrap">Thời gian</th>
                                  </tr>
                               </thead>
                               <tbody>
                                @if ($data->count()>0)

                                   @foreach ($data as $pay)
                                   <tr>
                                       <td>{{ $loop->index }}</td>
                                       <td>
                                          {{ $pay->point }}
                                       </td>
                                       <td class="text-nowrap">

                                        {{ $typePay[$pay->status]['name'] }}
                                         </td>
                                       <td class="text-nowrap">{{ $pay->created_at }}</td>
                                    </tr>
                                   @endforeach
                                   @endif
                               </tbody>
                            </table>
                         </div>
                       </div>
                 </div>
                 @if ($data->count()>0)
                    <div class="col-md-12">
                        {{$data->links()}}
                    </div>
                 @endif

             </div>
        </div>
    </div>



@endsection
@section('js')

@endsection
