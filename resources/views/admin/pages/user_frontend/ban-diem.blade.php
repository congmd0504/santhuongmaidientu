@extends('admin.layouts.main')
@section('title', "Bắn điểm thành viên")
@section('css')
    <link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #000 !important;
        }

        .select2-container .select2-selection--single {
            height: auto;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        @include('admin.partials.content-header', ['name' => "Amin User", "key" => "Bắn điểm thành viên"])
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
                        <form action="{{route('admin.user_frontend.banDiemPost')}}" method="POST"
                            enctype="multipart/form-data" onsubmit="submitPay(this)">
                            @csrf
                            @csrf
                            <div class="row">
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
                                <div class="col-md-6">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Bắn điểm cho thành viên</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="form-group">
                                                <label for="">Số điểm</label>
                                                <input type="text" class="form-control jsFormatNumber" name="pay"
                                                    placeholder="" oninput="format_curency(this);" type="text"
                                                    onchange="format_curency(this);">
                                                {{-- <input type="hidden" class="form-control" min="1" step="1"
                                                    id="pay_hidden" value="{{ old('pay') }}" name="pay"
                                                    placeholder="Nhập số tiền nạp"> --}}
                                                @error('pay')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chọn loại bắn</label>
                                                <select name="type" class="form-control" id="">
                                                    <option value="xu">Bắn KTG</option>
                                                    <option value="diem">Bắn VNĐ</option>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label d-block">Hình thức bắn điểm <span
                                                        class="text-danger">*</span></label>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type_shoot"
                                                        id="shoot_user" value="user" checked>
                                                    <label class="form-check-label" for="shoot_user">
                                                        Bắn cho thành viên
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="type_shoot"
                                                        id="shoot_rank" value="rank">
                                                    <label class="form-check-label" for="shoot_rank">
                                                        Bắn theo hạng thành viên
                                                    </label>
                                                </div>
                                            </div>

                                            {{-- Chọn thành viên --}}
                                            <div class="form-group box-user">
                                                <label>Chọn thành viên (nếu không chọn mặc định bắn cho tất cả)</label>
                                                <select name="user_id" class="form-control select-2-init">
                                                    <option value="">Chọn thành viên</option>
                                                    @foreach ($data as $item)
                                                        <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->username }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Chọn hạng thành viên --}}
                                            <div class="form-group box-rank d-none">
                                                <label>Chọn hạng thành viên</label> <br>
                                                <select name="rank_id" class="form-control select-2-init" style="width: 100%">
                                                     @foreach (config("point.level") as $key => $itemLevel) <option
                                                        value="{{ $key }}" @if(old('level') == $key){{'selected'}} @endif>
                                                        {{ $itemLevel }}</option>
                                                    @endforeach
                                                </select>
                                                @error('rank_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
@endsection
@section('js')
    <script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        $(function () {
            $(".select-2-init").select2({
                placeholder: "----Tất cả----",
                allowClear: true
            })
        })
    </script>
    <script>

        $(document).ready(function () {
            $('#pay').number(true, 0, '.', ',');
            let pay_show = $('#pay').val();
            let pay_hide = $('#pay_hidden').val(pay_show);

        });
        $('#pay').on('change', function () {
            let pay_show = $('#pay').val();
            let pay_hide = $('#pay_hidden').val(pay_show);
        });
        $(document).on('change', 'input[name="type_shoot"]', function () {
            let type = $(this).val();

            if (type === 'user') {
                $('.box-user').removeClass('d-none');
                $('.box-rank').addClass('d-none');
            } else {
                $('.box-user').addClass('d-none');
                $('.box-rank').removeClass('d-none');
            }
        });

    </script>
@endsection