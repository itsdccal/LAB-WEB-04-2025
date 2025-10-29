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
.kuliner-scroll {
  display: flex;
  overflow-x: auto;
  gap: 20px;
  padding: 20px 0;
  scroll-behavior: smooth;
}

.kuliner-scroll::-webkit-scrollbar {
  height: 10px;
}

.kuliner-scroll::-webkit-scrollbar-thumb {
  background: #ff004c;
  border-radius: 10px;
}

.kuliner-card {
  flex: 0 0 250px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,0,76,0.4);
  box-shadow: 0 0 15px rgba(255,0,76,0.1);
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.kuliner-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 25px #ff004c;
}

.kuliner-card img {
  width: 100%;
  height: 170px;
  object-fit: cover;
}

.kuliner-card h3 {
  margin: 15px 0 5px;
  color: #ff004c;
}

.kuliner-card p {
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
  <h2>Kuliner Khas Parepare</h2>

  <div class="kuliner-scroll">
    <div class="kuliner-card">
      <img src="{{ asset('images/mantao.jpg') }}" alt="Roti Mantao">
      <h3>Roti Mantao</h3>
      <p>Roti mantao bisa dinikmati langsung atau digoreng/dikukus lebih dahulu untuk sensasi berbeda.</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/kanse.jpg') }}" alt="Kanse">
      <h3>Kanse</h3>
      <p>Kanse berasal dari kata “kanre santang”, makanan berkuah santan khas Bugis yang gurih dan lezat.</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/rober.jpg') }}" alt="Roti Berre">
      <h3>Roti Berre</h3>
      <p>Roti kenyal dengan rasa manis lembut terbuat dari tepung beras dan kelapa sangrai.</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/apang.jpg') }}" alt="Apang Paranggi">
      <h3>Apang Paranggi</h3>
      <p>Apang paranggi bercita rasa manis gula merah dan aroma khas kelapa parut.</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/baje.jpg') }}" alt="Baje Canggoreng">
      <h3>Baje' Canggoreng</h3>
      <p>Kudapan renyah dari kacang tanah dan gula merah, padat manis menggoda.</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/miayam.jpg') }}" alt="Mie Ayam Mas Kardi">
      <h3>Mie Ayam Mas Kardi 😋</h3>
      <p>Mie ayam terenak di Parepare, ak sangat approve</p>
    </div>

    <div class="kuliner-card">
      <img src="{{ asset('images/toddo.jpg') }}" alt="Toddo-Toddo">
      <h3>Toddo-Toddo</h3>
      <p>Pentol kuah taichan, pedas gurih dan bikin nagih.</p>
    </div>
  </div>

  <div class="bottom-nav">
    <a href="/" class="btn">Home</a>
    <a href="/destinasi" class="btn">Destinasi</a>
    <a href="/galeri" class="btn">Galeri</a>
  </div>
</div>
@endsection
