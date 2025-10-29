@extends('layouts.master')

@section('content')
<style>
.contact-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  min-height: 80vh;
  background: radial-gradient(circle at top, #0d0013, #000);
  border-radius: 12px;
  box-shadow: 0 0 25px rgba(255,0,76,0.2);
  padding: 40px;
}

.contact-container h2 {
  color: #ff004c;
  font-size: 2rem;
  text-shadow: 0 0 15px #ff004c;
  margin-bottom: 30px;
}

form {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 600px;
  gap: 15px;
  background: rgba(255,255,255,0.05);
  padding: 30px;
  border-radius: 10px;
  border: 1px solid rgba(255,0,76,0.3);
  box-shadow: 0 0 20px rgba(255,0,76,0.1);
}

label {
  color: #fff;
  font-weight: bold;
  margin-bottom: 5px;
}

input, textarea {
  background: transparent;
  border: 1px solid rgba(255,0,76,0.4);
  color: #fff;
  padding: 10px 12px;
  border-radius: 6px;
  outline: none;
  font-family: 'Poppins', sans-serif;
  transition: all 0.3s ease;
}

input:focus, textarea:focus {
  box-shadow: 0 0 10px #ff004c;
  border-color: #ff004c;
}

textarea {
  min-height: 120px;
  resize: none;
}

button {
  background: none;
  border: 2px solid #ff004c;
  color: #ff004c;
  padding: 12px 20px;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  text-transform: uppercase;
  transition: all 0.3s ease;
  align-self: flex-end;
  box-shadow: 0 0 10px #ff004c inset;
}

button:hover {
  background: #ff004c;
  color: #000;
  box-shadow: 0 0 25px #ff004c, 0 0 50px #ff004c;
  transform: translateY(-3px);
}

.nav-buttons {
  margin-top: 40px;
  text-align: center;
}
</style>

<div class="contact-container">
  <h2>Hubungi Kami</h2>
  <form>
    <div>
      <label for="name">Nama:</label>
      <input type="text" id="name" placeholder="Masukkan nama Anda">
    </div>

    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" placeholder="Masukkan email Anda">
    </div>

    <div>
      <label for="message">Pesan:</label>
      <textarea id="message" placeholder="Tulis pesan Anda..."></textarea>
    </div>

    <button type="submit">Kirim</button>
  </form>

  <div class="nav-buttons">
    <a href="/" class="btn">Home</a>
    <a href="/destinasi" class="btn">Destinasi</a>
    <a href="/kuliner" class="btn">Kuliner</a>
    <a href="/galeri" class="btn">Galeri</a>
  </div>
</div>
@endsection
