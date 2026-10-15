@extends("layouts.index")

@section("content")
<div class="container-fluid faq-section bg-light py-5" style="min-height: 600px; background-image: url('{{ asset('src/img/bgn.png') }}'); background-size: cover; background-position: center;">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s" style="position: relative;">
                <img src="{{ asset('src/img/piring.png')}}" class="img-fluid w-100" alt="" style="position: relative; z-index: 1;">
                <div class="food-boxes" style="position: absolute; top: 0; left: 50%; transform: translate(-50%, 0); width: 100%; height: 100%; z-index: 2;">
                    <div class="food-box" id="box1" style="position: absolute; top: 0%; left: 50%; transform: translate(-50%, -50%); width: 100px; height: 100px; background-color: #f5f5f526; border-radius: 0%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                    <div class="food-box" id="box2" style="position: absolute; top: 48%; left: 85%; transform: translate(-50%, -50%); width: 100px; height: 100px; background-color: #f5f5f526; border-radius: 0%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                    <div class="food-box" id="box3" style="position: absolute; top: 95%; left: 50%; transform: translate(-50%, -50%); width: 100px; height: 100px; background-color: #f5f5f526; border-radius: 0%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                    <div class="food-box" id="box4" style="position: absolute; top: 48%; left: 15%; transform: translate(-50%, -50%); width: 100px; height: 100px; background-color: #f5f5f526; border-radius: 0%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                </div>
            </div>  
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-5 text-center">
                        <h1 class="display-4 mb-0">Pilih Makananmu</h1>
                    </div>
                    <div class="accordion d-flex flex-column align-items-center">
                        <div class="menu-buttons d-flex gap-3 mb-4">
                            <button class="menu-btn" onclick="showPopup('Protein')">Protein</button>
                            <button class="menu-btn" onclick="showPopup('Vitamin A')">Vitamin A</button>
                            <button class="menu-btn" onclick="showPopup('Vitamin C')">Vitamin C</button>
                        </div>
                        <div class="action-buttons d-flex gap-3 mt-4">
                            <button id="submitMenu" class="action-btn">Selesai</button>
                            <button id="resetMenu" class="action-btn bg-danger">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
        <a class="btn btn-danger rounded-pill py-3 px-5" href="beranda">Kembali</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const maxSelections = 4;
    const foods = @json($foods);
    const assetBase = @json(asset(''));
    const submitUrl = @json(route('submit.menu'));
    const resultUrl = @json(route('informasi-makanan'));
    let selectedFoods = [];

    function showPopup(category) {
        Swal.fire({
            title: `Pilih Makanan ${category}`,
            html: '<div class="food-options d-flex flex-wrap justify-content-center gap-3"></div>',
            showCloseButton: true,
            showConfirmButton: false,
            focusConfirm: false,
            didOpen: () => {
                const container = Swal.getHtmlContainer().querySelector('.food-options');
                const categoryFoods = foods[category] || [];

                if (categoryFoods.length === 0) {
                    container.textContent = 'Belum ada pilihan makanan untuk kategori ini.';
                    return;
                }

                categoryFoods.forEach(food => {
                    const button = document.createElement('button');
                    const image = document.createElement('img');
                    const name = document.createElement('span');

                    button.type = 'button';
                    button.className = 'btn btn-light d-flex flex-column align-items-center';
                    image.src = `${assetBase}${food.image}`;
                    image.alt = food.name;
                    image.style.maxWidth = '100px';
                    image.style.maxHeight = '100px';
                    name.textContent = food.name;

                    button.append(image, name);
                    button.addEventListener('click', () => selectFood(food.id, food.image));
                    container.append(button);
                });
            }
        });
    }

    function selectFood(foodId, foodImage) {
        if (selectedFoods.length < maxSelections) {
            if (!selectedFoods.some(item => Number(item.id) === Number(foodId))) {
                selectedFoods.push({
                    id: foodId,
                    src: foodImage
                });

                const boxIndex = selectedFoods.length;
                const box = document.getElementById(`box${boxIndex}`);
                box.innerHTML = `
                    <div style="position: relative; width: 100%; height: 100%;">
                        <img src="${assetBase}${foodImage}" alt="Makanan pilihan ${boxIndex}" style="max-width: 100%; max-height: 100%;">
                    </div>
                `;

                Swal.close();
            } else {
                Swal.fire('Makanan ini sudah dipilih!', '', 'warning');
            }
        } else {
            Swal.fire('Anda sudah memilih 4 makanan!', '', 'warning');
        }
    }

    document.getElementById('submitMenu').addEventListener('click', async function() {
        if (selectedFoods.length === maxSelections) {
            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        selectedFoods: selectedFoods.map(food => food.id)
                    })
                });
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Menu belum dapat dihitung.');
                }

                const selectedIds = data.selectedFoods.map(food => food.id);
                const query = new URLSearchParams({
                    score: data.score,
                    selectedFoods: JSON.stringify(selectedIds)
                });
                window.location.href = `${resultUrl}?${query.toString()}`;
            } catch (error) {
                Swal.fire('Terjadi kesalahan', error.message || 'Silakan coba lagi.', 'error');
            }
        } else {
            Swal.fire('Silakan pilih 4 makanan terlebih dahulu!', '', 'warning');
        }
    });

    document.getElementById('resetMenu').addEventListener('click', function() {
        resetMenu();
    });

    function resetMenu() {
        selectedFoods = [];
        for (let i = 1; i <= maxSelections; i++) {
            document.getElementById(`box${i}`).innerHTML = '';
        }

    }
</script>

@endpush
