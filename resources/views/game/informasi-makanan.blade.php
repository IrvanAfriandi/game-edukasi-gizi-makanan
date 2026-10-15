@extends('layouts.index')

@section('content')
<!-- About End -->
<div class="container-fluid faq-section bg-light py-5" style="min-height: 600px; background-image: url('{{ asset('src/img/bgn2.png') }}'); background-size: cover; background-position: center;">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-4 mb-4">Hasil Permainan</h1>
                @if (!is_null($score))
                    <p class="fs-4 mb-1">Skor kamu</p>
                    <p class="text-center fw-bold mb-5" style="color: rgb(0, 140, 0); font-size: clamp(4rem, 15vw, 10rem);">{{ $score }}</p>
                @endif
                @if (count($selectedFoods))
                    <h2 class="h3 mb-4">Makanan yang kamu pilih</h2>
                    <div class="row g-4 justify-content-center mb-5">
                        @foreach ($selectedFoods as $food)
                            <div class="col-6 col-md-3">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset($food['image']) }}" class="card-img-top p-3" alt="{{ $food['name'] }}" style="height: 160px; object-fit: contain;">
                                    <div class="card-body">
                                        <h3 class="h5 card-title">{{ $food['name'] }}</h3>
                                        <p class="card-text">{{ $food['category'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="fs-5 mb-5">Belum ada hasil permainan. Yuk, pilih empat makanan untuk menyusun menu sehat.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
        <a class="btn btn-danger rounded-pill py-3 px-5" href="{{ route('game') }}">Main Lagi</a>
    </div>
</div>
@endsection
