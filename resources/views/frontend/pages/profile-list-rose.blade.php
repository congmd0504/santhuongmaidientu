@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('css')
    <style>

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
            <div class="wrap-content-main">
                <div class="row">
                    <div class="col-sm-12">
						<div class="card-header">
							<h3 class="card-title">Danh sách điểm</h3>
						</div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Điểm</th>
                                    <th>Tên / SĐT</th>
                                    <th>Thời gian</th>
                                    <th>Ghi chú</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @isset($data)
                                    @if ($data->count()>0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td> {{ $item->point/getConfigBB() }}</td>
                                                <td>
                                                    @if ($item->userorigin_id)
                                                    {{ $item->userOriginPoint->name }}/
                                                    {{ $item->userOriginPoint->username}}
                                                    @endif
                                                </td>
                                                <td>{{ date_format($item->created_at,'d/m/Y H:i:s') }}</td>
                                                <td>{{ $typePoint[$item->type]['name'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr><td colspan="4" class="text-center p-3">Chưa có điểm</td></tr>
                                    @endif
                                    @endisset

                                </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
