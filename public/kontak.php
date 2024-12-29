<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kontak Hogwarts</title>
    <!-- <link rel="stylesheet" href="../styles/kontak.css" /> -->
    <script
      src="https://kit.fontawesome.com/23a7c17145.js"
      crossorigin="anonymous"
    ></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v21.0"></script>
    <link rel="stylesheet" href="../styles/kontak.css">
  </head>
  <body>
    <div id="navbar-container"></div>
    <div class="kontak">
      <h1>Kontak Kami</h1>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8162519149632!2d109.35324907321245!3d-0.058341999941080254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d59eb7759bd55%3A0x19c3e04c2e455bfc!2sUniversitas%20BSI%20Kampus%20Pontianak!5e0!3m2!1sid!2sid!4v1731308446627!5m2!1sid!2sid"
        width="600"
        height="450"
        style="border: 0"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
      <div class="detail-kontak">
        <div class="alamat">
          <i class="fa-solid fa-map"></i>
          <h2>Alamat</h2>
          <p>
            Jl. Abdul Rahman Saleh No.18, Bangka Belitung Laut, Kec. Pontianak
            Tenggara, Kota Pontianak, Kalimantan Barat 78124
          </p>
        </div>
        <div class="notelp">
          <i class="fa-solid fa-address-book"></i>
          <h2>No. Telepon & Email</h2>
          <p>
            <a href="https://wa.me/056158392"
              ><i class="fa-solid fa-phone"></i> 056158392</a
            >
          </p>
          <p>
            <a href="#"
              ><i class="fa-solid fa-envelope"></i> hogwarts@sch.ac.id</a
            >
          </p>
        </div>
        <div class="media-sosial">
          <h2>Media Sosial</h2>
          <p>
            <a href="https://www.facebook.com/hogwarts"
              ><i class="fa-brands fa-facebook"></i> Facebook</a>
          </p>
          <p>
            <a href="https://www.twitter.com/hogwarts"
              ><i class="fa-brands fa-twitter"></i> Twitter</a>
          </p>
          <p>
            <a href="https://www.instagram.com/hogwarts"
              ><i class="fa-brands fa-instagram"></i> Instagram</a>
          </p>
        </div>
        <section id="fb-root"></section>
                <?php
                    $uri = 'http://yourdomain.com' . $_SERVER['REQUEST_URI'];
                ?>
    
                <div class="fb-comments" data-href="<?php echo $uri; ?>" data-width="100%" data-numposts="5"></div>
      </div>
    </div>
<script src="../script/main.js" defer></script>
  </body>
</html>
