@extends('layouts.index')

@section('content')
<main class="container-fluid service py-5" style="min-height: 600px; background-image: url('{{ asset('src/img/bgn1.png') }}'); background-size: cover; background-position: center;">
    <div class="container py-5">
        <header class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h1 class="display-4 mb-4">Yuk Belajar Gizi dari Makanan</h1>
            <p class="fs-5">Kenali manfaat zat gizi dan temukan contoh makanan sehari-hari. Makan beragam membantu tubuh mendapatkan berbagai zat gizi.</p>
        </header>
        <div class="row g-4 justify-content-center">
            @foreach ($materials as $slug => $material)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('edukasi.'.$slug) }}" class="service-item d-block h-100 text-decoration-none">
                        <div class="service-img">
                            <img src="{{ asset('src/img/'.$material['image']) }}" class="img-fluid rounded-top w-100" alt="{{ $material['title'] }}" style="height: 190px; object-fit: contain; background: #fff;">
                        </div>
                        <div class="service-content p-4">
                            <div class="service-content-inner">
                                <h2 class="h4 mb-2">{{ $material['title'] }}</h2>
                                <p class="mb-0">{{ $material['summary'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="col-12 text-center mt-5">
                <a class="btn btn-danger rounded-pill py-3 px-5" href="{{ route('beranda') }}">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</main>
@endsection
