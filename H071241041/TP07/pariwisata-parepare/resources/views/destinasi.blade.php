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

.dest-scroll {
  display: flex;
  overflow-x: auto;
  gap: 20px;
  padding: 20px 0;
  scroll-behavior: smooth;
}

.dest-scroll::-webkit-scrollbar {
  height: 10px;
}

.dest-scroll::-webkit-scrollbar-thumb {
  background: #ff004c;
  border-radius: 10px;
}

.dest-card {
  flex: 0 0 250px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,0,76,0.4);
  box-shadow: 0 0 15px rgba(255,0,76,0.1);
  border-radius: 10px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.dest-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 25px #ff004c;
}

.dest-card img {
  width: 100%;
  height: 170px;
  object-fit: cover;
}

.dest-card h3 {
  margin: 15px 0 5px;
  color: #ff004c;
}

.dest-card p {
  padding: 0 15px 20px;
  color: #ddd;
  font-size: 0.9rem;
  line-height: 1.4;
}

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
  <h2>Destinasi Wisata Unggulan Parepare</h2>
  <div class="grid">
      <div class="card">
          <img src="{{ asset('images/tonrangeng.jpg') }}" alt="Taman Tonrangeng">
          <div class="card-content">
              <h3>Tonrangeng River Side</h3>
              <p>Spot romantis di tepi Teluk Parepare dengan jembatan cinta berlampu neon.</p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/paputo.jpg') }}" alt="Pantai Paputo">
          <div class="card-content">
              <h3>Pantai Paputo</h3>
              <p>Pantai berpasir putih dan pemandangan laut memukau di bawah langit malam.</p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/cempae.jpg') }}" alt="Anjungan Cempae">
          <div class="card-content">
              <h3>Anjungan Cempae</h3>
              <p>Objek wisata Anjungan Cempae hadir dengan artistik bangunan modern dan kekinian dengan perpaduan berbagai warna yang menambah kemegahannya.</p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/monumen-cinta.jpg') }}" alt="Monumen Habibie Ainun">
          <div class="card-content">
              <h3>Monumen Cinta Habibie Ainun</h3>
              <p>Ikon kota Parepare yang penuh kisah cinta sejati, berkilau di malam hari.</p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/masjid-terapung.jpg') }}" alt="Masjid Terapung">
          <div class="card-content">
              <h3>Masjid Terapung</h3>
              <p>Selain berfungsi sebagai rumah ibadah, masjid tersebut juga menjadi tempat wisata religi yang unik.
                  Masjid ini berlokasi di jalan Mattirotasi, Kecamatan Bacukiki Barat, Parepare.
              </p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/salo-karajae.jpg') }}" alt="Salo Karajae">
          <div class="card-content">
              <h3>Salo Karajae</h3>
              <p>Festival pesisir sungai terbesar di Sulawesi Selatan dengan mengusung dan mengeksplorasi kearifan lokal masyarakat sekitar pesisir sungai karajae</p>
          </div>
      </div>

      <div class="card">
          <img src="{{ asset('images/hastom.jpg') }}" alt="Kawasan Hastom">
          <div class="card-content">
              <h3>Kawasan Hastom</h3>
              <p>Pusat perbelanjaan barang-barang thrift yang terkenal di Parepare. Kawasan Hastom sendiri merupakan kepanjangan dari Jalan Sultan Hasanuddin dan Jalan Baso Daeng Patompo.</p>
          </div>
      </div>
  </div>

  <div class="bottom-nav">
    <a href="/" class="btn">Home</a>
    <a href="/kuliner" class="btn">Kuliner</a>
    <a href="/galeri" class="btn">Galeri</a>
  </div>
</div>
@endsection

