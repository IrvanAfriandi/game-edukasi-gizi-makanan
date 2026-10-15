@extends("layouts.index")
@section("content")
        <div class="container-fluid service py-5" style="min-height: 600px; background-image: url('{{ asset('src/img/bgn1.png') }}'); background-size: cover; background-position: center;">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h1 class="display-4 mb-4">Yuk Belajar Gizi dari Makanan</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="service-item">
                            <a href="protein">
                                <div class="service-img">
                                    <img src="{{ asset('src/img/protein (1).png')}}" class="img-fluid rounded-top w-100" alt="">
                                </div>
                                <div class="service-content p-4">
                                    <div class="service-content-inner">
                                        <a href="protein" class="d-inline-block h4 mb-4">Protein</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="1.0s">
                        <div class="service-item">
                            <a href="vitamin_a">
                                <div class="service-img">
                                    <img src="{{ asset('src/img/vitamin_a (1).png')}}" class="img-fluid rounded-top w-100" alt="">
                                </div>
                                <div class="service-content p-4">
                                    <div class="service-content-inner">
                                        <a href="vitamin_a" class="d-inline-block h4 mb-4">Vitamin A</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="1.2s">
                        <div class="service-item">
                            <a href="vitamin_c">
                                <div class="service-img">
                                    <img src="{{ asset('src/img/vitamin_c (1).png')}}" class="img-fluid rounded-top w-100" alt="">
                                </div>
                                <div class="service-content p-4">
                                    <div class="service-content-inner">
                                        <a href="vitamin_c" class="d-inline-block h4 mb-4">Vitamin C</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <a class="btn btn-danger rounded-pill py-3 px-5" href="beranda">Beranda</a>
                    </div>
                </div>
            </div>
        </div>
@endsection