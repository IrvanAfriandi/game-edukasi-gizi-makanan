@extends("layouts.index")
@section("content")
<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    <div class="header-carousel-item bg-danger">
        <!-- Logo Section -->
        <div class="container mb-4">
            <div class="row justify-content-center align-items-center">
                <div class="col-3 col-md-1 text-center">
                    <div class="neon-effect">
                        <img src="{{ asset('src/img/umc.png') }}" class="img-fluid" alt="Logo 1">
                    </div>
                </div>
                <div class="col-3 col-md-1 text-center">
                    <div class="neon-effect" style="margin-left: -30px">
                        <img src="{{ asset('src/img/lppm.png') }}" class="img-fluid" alt="Logo 2">
                    </div>
                </div>
                <div class="col-3 col-md-1 text-center" style="margin-left: -30px">
                    <div class="neon-effect">
                        <img src="{{ asset('src/img/km.png') }}" class="img-fluid" alt="Logo 3">
                    </div>
                </div>
                <div class="col-3 col-md-1 text-center" style="margin-left: -30px">
                    <div class="neon-effect">
                        <img src="{{ asset('src/img/nine.png') }}" class="img-fluid" alt="Logo 4">
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Logo Section -->

        <div class="carousel-caption">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7 animated fadeInLeft">
                        <div class="text-sm-center text-md-start">
                            <h4 class="text-white text-uppercase fw-bold mb-4">edukasi digital</h4>
                            <h1 class="display-1 text-white mb-4">Membantu Anak SDN Sukarasa</h1>
                            <p class="mb-5 fs-5">Memahami Tentang Gizi dari Makanan Menggunakan Media Website
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5 animated fadeInRight">
                        <div class="carousel-img" style="object-fit: cover;">
                            <img src="{{ asset('src/img/anak.png')}}" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Carousel End -->
<div class="container-fluid blog py-5" style="min-height: 600px; background-image: url('{{ asset('src/img/bgn.png') }}'); background-size: cover; background-position: center;">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                <a href="belajar" style="text-decoration: none; color: inherit;">
                    <div class="blog-item" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <div class="blog-img">
                            <img src="{{ asset('src/img/edukasi_anak.png') }}" class="img-fluid rounded-top w-100" alt="">
                            <div class="blog-categiry py-2 px-4">
                                <span>Edukasi</span>
                            </div>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-comment d-flex justify-content-between mb-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                <a href="game" style="text-decoration: none; color: inherit;">
                    <div class="blog-item" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <div class="blog-img">
                            <img src="{{ asset('src/img/game_anak.png') }}" class="img-fluid rounded-top w-100" alt="">
                            <div class="blog-categiry py-2 px-4">
                                <span>Permainan</span>
                            </div>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-comment d-flex justify-content-between mb-3">
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>  
@endsection
