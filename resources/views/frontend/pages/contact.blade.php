@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')

@section('css')
    <style>
        .contact-form .form .call {
            display: none;
        }

        @media(max-width:990px){
            footer {
         display: block !important; 
    }
        }
        @media (max-width:550px) {
            .contact-form .form .call {
                font-size: 14px;
                color: #fff;
                background: #23b814;
                border: none;
                height: 35px;
                width: 150px;
                border-radius: 5px;
                cursor: pointer;
                outline: 0;
                text-transform: uppercase;
                font-weight: 700;
                text-align: center;
                padding: 5px 0;
                display: inline-block;
            }

            .contact-form .form button {
                margin: 0;
            }
        }

        @media (max-width:550px) {
            .contact-form .form .call {
                margin-top: 5px;
            }

            /* .hidden-mobile {
                                            display: none;
                                        } */
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs, $typeBreadcrumb)
                @include('frontend.components.breadcrumbs', [
                    'breadcrumbs' => $breadcrumbs,
                    'type' => $typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main wrap-template-contact template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-form">

                                <div class="form">
                                    <p>Quý khách cần hỗ trợ vui lòng điền đầy đủ thông tin vào các ô dưới đây và gửi cho
                                        chúng tôi hoặc cần xử lý nhanh vui lòng click gọi ngay cho chúng tôi!!!</p>
                                    <form action="{{ route('contact.storeAjax') }}"
                                        data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert"
                                        data-href="#modalAjax" data-content="#content" data-method="POST" method="POST">
                                        <input type="text" name="check_robot" style="display:none" autocomplete="off">

                                        @csrf
                                        <input type="text" placeholder="Họ và tên" required="required" name="name">
                                        <input type="text" placeholder="Email" required="required" name="email">
                                        <input type="text" placeholder="S điện thoại" required="required"
                                            name="phone">
                                        <textarea name="content" placeholder="Thông tin thêm" id="noidung" cols="30" rows="5"></textarea>

                                       <!-- CAPTCHA -->
                                        {{--<label for="captcha">Xác nhận CAPTCHA</label>
                                        <div id="captchaBox" class="mb-2"></div>
                                        <input type="text" id="captchaInput" name="captchaInput" class="form-control" placeholder="Nhập kết quả" required>
                                        --}}
                                        <button class="hvr-float-shadow">Gửi thông tin</button>
                                        @if (isset($footer['hotline']) && $footer['hotline']->count() > 0)
                                            <div class="call">
                                                <a href="tel:{{ optional($footer['hotline'])->value }}"
                                                    class="hvr-float-shadow">Click gọi ngay</a>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 hidden-mobile">
                            <div class="contact-infor">
                                <div class="infor">
                                    @isset($dataAddress)
                                        <div class="address">
                                            <div class="footer-layer">
                                                <div class="title">
                                                    {{ $dataAddress->value }}
                                                </div>
                                                <ul class="pt_list_addres">
                                                    @foreach ($dataAddress->childs as $item)
                                                        <li>{!! $item->slug !!} {{ $item->value }}</li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    @endisset
                                    @isset($map)
                                        <div class="map">
                                            {!! $map->description !!}
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="modalAjax">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết đơn hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content" id="content">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        

        // Xử lý khi form ưc submit
        $(document).on('submit', "[data-ajax='submit']", function (e) {
            e.preventDefault(); // Ngăn form gửi đi ngay

                
                let formValues = $(this).serialize();
                let dataInput = $(this).data();

                $.ajax({
                    type: dataInput.method || "POST",
                    url: dataInput.url,
                    data: formValues,
                    dataType: "json",
                    success: function (response) {
                        if (response.code === 200) {
                            if (dataInput.content) {
                                $(dataInput.content).html(response.html);
                            }
                            if (dataInput.target === "alert") {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message || "Gửi thành công!",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.html || "Đã có lỗi xy ra!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: "Đã có lỗi xảy ra! Vui lòng thử lại.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            
        });
    });
</script>



@endsection
