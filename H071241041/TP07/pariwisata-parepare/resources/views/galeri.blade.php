{{-- @extends('layouts.master')

@section('content')
<h2>Galeri Cyber Parepare</h2>
<div class="grid">
    <div class="card"><img src="{{ asset('images/tonrangeng.jpg') }}"><div class="card-content"><h3>Taman Tonrangeng</h3><p>Keindahan tepi sungai dengan cahaya malam memukau.</p></div></div>
    <div class="card"><img src="{{ asset('images/pantai-paputo.jpg') }}"><div class="card-content"><h3>Pantai Paputo</h3><p>Debur ombak tenang berpadu dengan lampu-lampu kota.</p></div></div>
    <div class="card"><img src="{{ asset('images/jembatan-cinta.jpg') }}"><div class="card-content"><h3>Jembatan Cinta</h3><p>Simbol cinta bercahaya neon merah di jantung kota.</p></div></div>
    <div class="card"><img src="{{ asset('images/pelabuhan.jpg') }}"><div class="card-content"><h3>Pelabuhan Nusantara</h3><p>Pintu gerbang laut Parepare dalam sinar lampu pelabuhan.</p></div></div>
    <div class="card"><img src="{{ asset('images/monumen-habibie.jpg') }}"><div class="card-content"><h3>Monumen Habibie & Ainun</h3><p>Cinta dan dedikasi yang bersinar abadi.</p></div></div>
    <div class="card"><img src="{{ asset('images/bukit-harapan.jpg') }}"><div class="card-content"><h3>Bukit Harapan</h3><p>Tempat terbaik menikmati bintang di atas kota.</p></div></div>
    <div class="card"><img src="{{ asset('images/pantai-sumpang.jpg') }}"><div class="card-content"><h3>Pantai Sumpang</h3><p>Senja merah muda di ujung pesisir Parepare.</p></div></div>
    <div class="card"><img src="{{ asset('images/masjid-raya.jpg') }}"><div class="card-content"><h3>Masjid Raya</h3><p>Keindahan arsitektur bercahaya lembut di malam hari.</p></div></div>
    <div class="card"><img src="{{ asset('images/pantai-lumpue.jpg') }}"><div class="card-content"><h3>Pantai Lumpue</h3><p>Pantai dengan langit berpendar ungu kemerahan yang magis.</p></div></div>
</div>

<div class="nav-buttons">
    <a href="/" class="btn">Home</a>
    <a href="/destinasi" class="btn">Destinasi</a>
    <a href="/kuliner" class="btn">Kuliner</a>
</div>
@endsection --}}


@extends('layouts.master')

@section('content')
<style>
.page-container {
  background: radial-gradient(circle at top, #0d0013, #000);
  min-height: 100vh;
  padding: 60px 40px;
  text-align: center;
  color: #fff;
  overflow-x: hidden;
}

.page-container h2 {
  color: #ff004c;
  text-shadow: 0 0 15px #ff004c;
  font-size: 2rem;
  margin-bottom: 30px;
}

/* Scroll horizontal */
.gallery-scroll {
  display: flex;
  overflow-x: auto;
  gap: 20px;
  padding: 20px 0;
  scroll-behavior: smooth;
}

.gallery-scroll::-webkit-scrollbar {
  height: 10px;
}

.gallery-scroll::-webkit-scrollbar-thumb {
  background: #ff004c;
  border-radius: 10px;
}

.gallery-card {
  flex: 0 0 250px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,0,76,0.4);
  box-shadow: 0 0 15px rgba(255,0,76,0.1);
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.gallery-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 25px #ff004c;
}

.gallery-card img {
  width: 100%;
  height: 170px;
  object-fit: cover;
}

.gallery-card h3 {
  margin: 15px 0 5px;
  color: #ff004c;
}

.gallery-card p {
  padding: 0 15px 20px;
  color: #ddd;
  font-size: 0.9rem;
  line-height: 1.4;
}

/* Tombol navigasi bawah */
.bottom-nav {
  text-align: center;
  margin-top: 20px;
  padding-bottom: 30px;
}

.bottom-nav .btn {
  display: inline-block;
  margin: 10px 15px;
  padding: 10px 25px;
  border-radius: 8px;
  background: none;
  border: 2px solid #ff004c;
  color: #ff004c;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
  box-shadow: 0 0 12px #ff004c inset;
}

.bottom-nav .btn:hover {
  background: #ff004c;
  color: #000;
  box-shadow: 0 0 20px #ff004c, 0 0 40px #ff004c;
  transform: translateY(-3px);
}
</style>

<div class="page-container">
  <h2>Galeri Parepare</h2>

  <div class="gallery-scroll">
    <div class="gallery-card">
      <img src="{{ asset('images/tonrangeng.jpg') }}" alt="Tonrangeng">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/paputo.jpg') }}" alt="Pantai Paputo">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/hastom.jpg') }}" alt="Jalan Hastom">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/salo-karajae.jpg') }}" alt="Salo Karajae">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/monumen-cinta.jpg') }}" alt="Monumen Cinta">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/masjid-terapung.jpg') }}" alt="Masjid terapung">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/lapangan.jpg') }}" alt="Lapangan">
    </div>

    <div class="gallery-card">
      <img src="{{ asset('images/taman-mattirotasi.jpg') }}" alt="Taman Mattirotasi">
    </div>
  </div>

  <div class="bottom-nav">
    <a href="/" class="btn">Home</a>
    <a href="/destinasi" class="btn">Destinasi</a>
    <a href="/kuliner" class="btn">Kuliner</a>
  </div>
</div>
@endsection
