<?php

namespace App\Http\Controllers;

class EducationController extends Controller
{
    public function index()
    {
        return view('edukasi.index', ['materials' => $this->materials()]);
    }

    public function show(string $slug)
    {
        $materials = $this->materials();

        abort_unless(isset($materials[$slug]), 404);

        return view('edukasi.show', ['material' => $materials[$slug]]);
    }

    private function materials(): array
    {
        return [
            'protein' => [
                'title' => 'Protein',
                'image' => 'protein (1).png',
                'summary' => 'Protein membantu tubuh tumbuh, memperbaiki jaringan, dan membentuk bagian penting tubuh.',
                'function' => 'Tubuh menggunakan protein untuk membangun dan memperbaiki otot serta jaringan. Protein juga membantu membentuk enzim dan bagian dari sistem pertahanan tubuh.',
                'foods' => [
                    ['name' => 'Ikan', 'image' => 'ikan.png', 'tip' => 'Pilih ikan yang dimasak matang dan buang durinya.'],
                    ['name' => 'Telur', 'image' => 'telur.png', 'tip' => 'Telur dapat dimakan sebagai lauk saat sarapan atau makan siang.'],
                    ['name' => 'Tempe', 'image' => 'tempe.png', 'tip' => 'Tempe berasal dari kedelai dan cocok dimakan bersama nasi serta sayur.'],
                ],
                'activity' => 'Coba sebutkan satu lauk berprotein yang kamu makan hari ini.',
            ],
            'vitamin_a' => [
                'title' => 'Vitamin A',
                'image' => 'vitamin_a (1).png',
                'summary' => 'Vitamin A mendukung kesehatan mata, kulit, dan pertumbuhan tubuh.',
                'function' => 'Vitamin A membantu mata melihat dengan baik, terutama saat cahaya redup, serta mendukung pertumbuhan dan daya tahan tubuh.',
                'foods' => [
                    ['name' => 'Wortel', 'image' => 'wortel.png', 'tip' => 'Wortel bisa disajikan dalam sup atau ditumis hingga matang.'],
                    ['name' => 'Bayam', 'image' => 'bayam.png', 'tip' => 'Tambahkan bayam ke dalam sayur bening.'],
                    ['name' => 'Labu kuning', 'image' => 'labu.png', 'tip' => 'Labu dapat dimasak menjadi sup atau lauk.'],
                ],
                'activity' => 'Cari sayuran berwarna oranye atau hijau di piringmu.',
            ],
            'vitamin_c' => [
                'title' => 'Vitamin C',
                'image' => 'vitamin_c (1).png',
                'summary' => 'Vitamin C membantu tubuh merawat jaringan dan membantu penyerapan zat besi dari makanan nabati.',
                'function' => 'Vitamin C berperan dalam pembentukan kolagen, membantu penyembuhan luka, dan membantu tubuh menyerap zat besi dari makanan seperti sayuran dan kacang-kacangan.',
                'foods' => [
                    ['name' => 'Jeruk', 'image' => 'jeruk.png', 'tip' => 'Buah utuh memberi serat selain vitamin C.'],
                    ['name' => 'Stroberi', 'image' => 'stroberi.png', 'tip' => 'Cuci buah di bawah air mengalir sebelum dimakan.'],
                    ['name' => 'Pepaya', 'image' => 'pepaya.png', 'tip' => 'Pilih pepaya matang dan sajikan sebagai buah potong.'],
                ],
                'activity' => 'Coba makan buah bersama lauk dan sayur dalam satu waktu makan.',
            ],
            'kalsium' => [
                'title' => 'Kalsium',
                'image' => 'kalsium (1).png',
                'summary' => 'Kalsium membantu membangun dan menjaga tulang serta gigi.',
                'function' => 'Tubuh juga menggunakan kalsium untuk membantu otot bergerak dan saraf mengirim pesan.',
                'foods' => [
                    ['name' => 'Susu', 'image' => 'susu.png', 'tip' => 'Pilih susu yang sesuai untukmu dan nikmati sebagai bagian dari makanan beragam.'],
                    ['name' => 'Keju', 'image' => 'keju.png', 'tip' => 'Keju bisa menjadi pelengkap roti atau makanan.'],
                    ['name' => 'Ikan', 'image' => 'ikan.png', 'tip' => 'Beberapa ikan kecil yang dimakan bersama tulangnya mengandung kalsium.'],
                ],
                'activity' => 'Sebutkan satu makanan yang dapat membantu menjaga tulangmu.',
            ],
            'serat' => [
                'title' => 'Serat',
                'image' => 'serat (1).png',
                'summary' => 'Serat membantu makanan bergerak dengan baik di dalam pencernaan.',
                'function' => 'Serat banyak terdapat pada buah, sayur, kacang-kacangan, dan biji-bijian. Makan beragam sumber serat dan minum air membantu menjaga kebiasaan buang air besar.',
                'foods' => [
                    ['name' => 'Pepaya', 'image' => 'pepaya.png', 'tip' => 'Nikmati sebagai buah utuh, bukan hanya minumannya.'],
                    ['name' => 'Sayuran', 'image' => 'sayur.png', 'tip' => 'Usahakan ada sayuran dengan warna berbeda di piring.'],
                    ['name' => 'Kacang hijau', 'image' => 'kacang_hijau.png', 'tip' => 'Kacang hijau dapat dimasak sampai matang dan empuk.'],
                ],
                'activity' => 'Hitung berapa warna buah dan sayur yang kamu makan hari ini.',
            ],
            'zat_besi' => [
                'title' => 'Zat Besi',
                'image' => 'zat_besi (1).png',
                'summary' => 'Zat besi membantu tubuh membuat sel darah merah yang membawa oksigen.',
                'function' => 'Zat besi dibutuhkan agar oksigen dapat dibawa ke seluruh tubuh. Makanan sumber zat besi dapat berasal dari hewan maupun tumbuhan.',
                'foods' => [
                    ['name' => 'Daging', 'image' => 'daging.png', 'tip' => 'Pastikan daging dimasak hingga matang.'],
                    ['name' => 'Bayam', 'image' => 'bayam.png', 'tip' => 'Bayam dapat menjadi bagian dari menu sayur yang beragam.'],
                    ['name' => 'Jeruk', 'image' => 'jeruk.png', 'tip' => 'Buah sumber vitamin C dapat dimakan bersama makanan nabati sumber zat besi.'],
                ],
                'activity' => 'Pasangkan sayur atau kacang dengan buah sumber vitamin C.',
            ],
            'lemak_sehat' => [
                'title' => 'Lemak Sehat',
                'image' => 'lemak_sehat (1).png',
                'summary' => 'Lemak membantu tubuh mendapatkan energi dan menggunakan beberapa vitamin.',
                'function' => 'Lemak merupakan bagian dari pola makan seimbang. Pilih beragam sumber, seperti ikan, telur, dan kacang-kacangan; batasi makanan yang terlalu sering digoreng.',
                'foods' => [
                    ['name' => 'Ikan', 'image' => 'ikan.png', 'tip' => 'Ikan dapat diolah dengan cara direbus, dikukus, atau dipanggang.'],
                    ['name' => 'Telur', 'image' => 'telur.png', 'tip' => 'Telur juga mengandung protein dan beberapa zat gizi lain.'],
                    ['name' => 'Tempe', 'image' => 'tempe.png', 'tip' => 'Tempe dari kedelai mengandung protein dan dapat menjadi bagian dari menu beragam.'],
                ],
                'activity' => 'Ingat: tubuh memerlukan lemak, tetapi variasi dan porsi yang seimbang juga penting.',
            ],
            'vitamin_d' => [
                'title' => 'Vitamin D',
                'image' => 'vitamin_d (1).png',
                'summary' => 'Vitamin D membantu tubuh menyerap kalsium untuk mendukung tulang.',
                'function' => 'Tubuh dapat membentuk vitamin D saat kulit terkena sinar matahari. Vitamin D juga terdapat pada beberapa makanan. Hindari menatap matahari secara langsung.',
                'foods' => [
                    ['name' => 'Ikan', 'image' => 'ikan.png', 'tip' => 'Beberapa jenis ikan mengandung vitamin D.'],
                    ['name' => 'Telur', 'image' => 'telur.png', 'tip' => 'Telur dapat melengkapi menu beragam.'],
                    ['name' => 'Susu', 'image' => 'susu.png', 'tip' => 'Kandungan vitamin pada susu dapat berbeda; periksa label kemasannya.'],
                ],
                'activity' => 'Ajak orang dewasa memilih waktu bermain di luar yang nyaman dan aman.',
            ],
        ];
    }
}
