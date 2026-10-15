@extends('layouts.index')

@section('content')
<main>
    <section class="container-fluid feature bg-light py-5">
        <div class="container py-5" style="max-width: 1000px;">
            <header class="text-center mx-auto mb-5" style="max-width: 800px;">
                <img src="{{ asset('src/img/'.$material['image']) }}" class="img-fluid mb-4" alt="{{ $material['title'] }}" style="max-height: 190px; object-fit: contain;">
                <h1 class="display-4 mb-3">{{ $material['title'] }}</h1>
                <p class="fs-4">{{ $material['summary'] }}</p>
            </header>

            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <article class="h-100 p-4 bg-white rounded shadow-sm">
                        <h2 class="h3">Apa manfaatnya?</h2>
                        <p class="mb-0">{{ $material['function'] }}</p>
                    </article>
                </div>
                <div class="col-lg-6">
                    <article class="h-100 p-4 bg-white rounded shadow-sm">
                        <h2 class="h3">Ayo coba!</h2>
                        <p class="mb-0">{{ $material['activity'] }}</p>
                    </article>
                </div>
            </div>

            <section aria-labelledby="food-examples-heading">
                <h2 id="food-examples-heading" class="h2 text-center mb-4">Contoh makanan</h2>
                <div class="row g-4">
                    @foreach ($material['foods'] as $food)
                        <div class="col-md-4">
                            <article class="card h-100 shadow-sm">
                                <img src="{{ asset('src/img/'.$food['image']) }}" class="card-img-top p-3" alt="{{ $food['name'] }}" style="height: 180px; object-fit: contain;">
                                <div class="card-body">
                                    <h3 class="h4 card-title">{{ $food['name'] }}</h3>
                                    <p class="card-text">{{ $food['tip'] }}</p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>

            <aside class="alert alert-warning mt-5" role="note">
                Setiap anak bisa memiliki kebutuhan dan alergi yang berbeda. Nikmati makanan yang beragam, dan minta bantuan orang dewasa untuk memilih serta menyiapkan makanan dengan aman.
            </aside>

            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <a class="btn btn-danger rounded-pill py-3 px-5" href="{{ route('belajar') }}">Semua Materi</a>
                <a class="btn btn-outline-danger rounded-pill py-3 px-5" href="{{ route('game') }}">Main Pilih Makanan</a>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('main img').forEach(image => {
        const showImagePlaceholder = () => {
            const placeholder = document.createElement('div');
            placeholder.className = 'd-flex align-items-center justify-content-center text-center p-3 bg-white rounded';
            placeholder.textContent = `Gambar ${image.alt} segera ditambahkan`;
            placeholder.setAttribute('role', 'img');
            placeholder.setAttribute('aria-label', placeholder.textContent);
            placeholder.style.minHeight = '160px';
            image.replaceWith(placeholder);
        };

        image.addEventListener('error', showImagePlaceholder, { once: true });
        if (image.complete && image.naturalWidth === 0) {
            showImagePlaceholder();
        }
    });
</script>
@endpush
