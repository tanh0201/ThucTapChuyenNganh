@extends('admin.layout.base')

@section('title', 'Thông Tin Trang Web - PetSam Admin')

@section('breadcrumb')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light px-4 py-3 rounded-lg">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="fas fa-globe text-primary"></i> Thông Tin Trang Web
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    <i class="fas fa-globe me-2"></i>Thông tin trang web
                </h2>
                <a href="{{ route('admin.site-info.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if($siteInfo)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Tên trang web</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $siteInfo->name }}
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Địa chỉ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $siteInfo->address }}
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Số điện thoại</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <a href="tel:{{ $siteInfo->phone }}" class="text-decoration-none">
                                    {{ $siteInfo->phone }}
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <a href="mailto:{{ $siteInfo->email }}" class="text-decoration-none">
                                    {{ $siteInfo->email }}
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mô tả</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $siteInfo->description ?? 'Chưa cập nhật' }}
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mạng xã hội</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <div class="d-flex gap-2">
                                    @if($siteInfo->facebook_url)
                                        <a href="{{ $siteInfo->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    @endif
                                    @if($siteInfo->twitter_url)
                                        <a href="{{ $siteInfo->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if($siteInfo->instagram_url)
                                        <a href="{{ $siteInfo->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                    @if($siteInfo->youtube_url)
                                        <a href="{{ $siteInfo->youtube_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Chưa có thông tin trang web. <a href="{{ route('admin.site-info.edit') }}">Tạo mới</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
