<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Preview-PDF &mdash; Admin UMKM Levelup</title>
  <style>
    *{
        margin: 0;
        padding: 0;
    }
    .logo, .logokeranjang{
        height: 60px;
        margin-top: 50px;
    }
    .logo{
        margin-left: 420px;
    }
    
    .logokeranjang{

    }
    .tebal{
     color: #0c438d;
     text-align: center;
     letter-spacing: 3px;
     font-size: 42px;
     margin-bottom: 5px;
    }
    .garis{
        width: 450px;
        color: #0c438d;
        margin-left: 335px;
        margin-bottom: 10px;
        
    }
    p, h3{
        text-align: center;
        line-height: 40px;
        font-size: 22px;
        font-weight: normal

    }
    p{
        color: rgb(12 67 141);
    }
    h3{
      color: #0c438d;
      font-weight: 800;
    }
    .a{
      margin-bottom: 80px;
    }
    .b{
      font-weight: 900;
      color: #0c438d;
    }
    .garis2{
        width: 200px;
        color: #0c438d;
        margin-left: 460px;
    }
  </style>
</head>
<body style="background-image: url('{{public_path("/img/bg-pdf.png")}}'); height:100vh; background-size:cover;">
  <div class="row">
    <img class="logo" src="{{public_path("/img/logo2.png")}}" alt="">
    <img class="logokeranjang" src="{{public_path("/img/logokeranjang.png")}}" alt="">
  </div>
  <div class="row">
    <h1 class="tebal">SERTIFIKAT</h1>
    <hr class="garis">
    <p>{{$d->id}}/DJAI.4-UMKM/DL.01.{{\Carbon\Carbon::parse($d->created_at)->format('d/m/Y')}}</p>
    <p>diberikan kepada:</p>
    <h1 class="tebal">{{strtoupper($d->name)}}</h1>
    <p>sebagai</p>
    <h1 class="tebal">PESERTA</h1>
    <p>Dalam Program</p>
    <h3>Pendampingan dan Fasilitasi Adopsi Teknologi Digital 4.0 Bagi UMKM <br>
        UMKM LEVEL UP <br>
        TAHUN {{now()->format('Y')}} <br>
        Jakarta, {{\Carbon\Carbon::parse($d->created_at)->format('d F Y')}}
      </h3>
        <p class="a">Direktur Ekonomi Digital</p>
        <hr class="garis2">
        <p class="b">Bonifasiaus Wahyu Pudjianto</p>
  </div>
</body>
</html>
