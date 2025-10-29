@extends('layouts.master')

@section('content')
<style>
.hero {
  position: relative;
  width: 100%;
  height: 100vh;
  background: url("{{ asset('images/gerbang.jpg') }}") no-repeat center center/cover;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: #fff;
}

.hero::after {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: linear-gradient(180deg, rgba(0,0,0,0.6), rgba(26,0,31,0.8));
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 800px;
  padding: 30px;
}

.hero-content h2 {
  font-size: 3rem;
  color: #ff004c;
  text-shadow: 0 0 20px #ff004c;
  margin-bottom: 20px;
}

.hero-content p {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #f5f5f5;
  margin-bottom: 30px;
}
</style>

<div class="hero">
  <div class="hero-content">
    <h2>Selamat Datang di Kota Parepare</h2>
    <p>
      Kota pelabuhan yang tumbuh di tepi indah Selat Makassar. Sebagai salah satu jalur perdagangan 
      penting di tanah Bugis, Parepare dikenal dengan sebutan “Kota Bandar Madani” yang mencerminkan 
      semangat maju dan budaya yang kuat. Kota ini juga dikenal sebagai “Kota Cinta Habibie Ainun”, 
      tempat lahirnya Presiden ke-3 Republik Indonesia, B.J. Habibie, yang kisah cintanya menjadi 
      inspirasi banyak orang. Dengan luas wilayah sekitar 99,33 km² dan masyarakat yang mayoritas 
      bersuku Bugis, Parepare menghadirkan harmoni antara kemajuan modern dan kearifan lokal yang terus dijaga.
    </p>
    <div>
      <a href="/destinasi" class="btn">Destinasi</a>
      <a href="/kuliner" class="btn">Kuliner</a>
      <a href="/galeri" class="btn">Galeri</a>
    </div>
  </div>
</div>
@endsection
