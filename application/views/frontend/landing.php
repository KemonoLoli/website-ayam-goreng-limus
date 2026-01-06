<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Warung Ayam Goreng Limus Regency</title>
  <meta name="description" content="Warung Ayam Goreng Limus Regency - Dine-in, Takeaway, Delivery, dan Catering.">
  <meta name="keywords" content="ayam goreng, limus regency, cileungsi, catering, nasi box">

  <!-- Favicons -->
  <link href="<?= base_url('assets/img/favicon.png'); ?>" rel="icon">
  <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/aos/aos.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet">

  <style>
    :root {
      /* Palette Override */
      --nav-color: #FE5D26;
      --nav-hover-color: #F2C078;
      --accent-color: #FE5D26;
      --background-color: #FAEDCA;
      --heading-color: #212529;
      --default-color: #212529;
      /* Force dark default text */
      --contrast-color: #212529;
    }

    body {
      background-color: #fdfdfd;
      color: #212529;
      /* Standard Bootstrap dark gray */
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      color: #000000;
    }

    /* Force high contrast on text elements */
    p,
    li,
    span,
    div {
      color: #212529;
    }

    /* Exception for specific classes that need potential styling, but default to dark if not overridden */
    .text-muted {
      color: #6c757d !important;
      /* Bootstrap standard muted, still readable on white */
    }

    /* Branding Colors */
    .text-primary-custom {
      color: #FE5D26 !important;
    }

    .bg-primary-custom {
      background-color: #FE5D26 !important;
    }

    .btn-book,
    .btn-primary {
      background-color: #FE5D26 !important;
      border-color: #FE5D26 !important;
      color: #fff !important;
    }

    .btn-book:hover,
    .btn-primary:hover {
      background-color: #e04e1d !important;
    }

    .btn-menu,
    .btn-secondary {
      color: #FE5D26 !important;
    }

    /* Section Backgrounds - Ensure text inside stands out */
    .section-bg-cream {
      background-color: #FAEDCA;
    }

    .section-bg-cream p,
    .section-bg-cream li,
    .section-bg-cream h1,
    .section-bg-cream h2,
    .section-bg-cream h3,
    .section-bg-cream h4,
    .section-bg-cream h5,
    .section-bg-cream h6,
    .section-bg-cream div {
      color: #212529 !important;
    }

    .section-bg-softgreen {
      background-color: rgba(193, 219, 179, 0.3);
    }

    .section-bg-softgreen p,
    .section-bg-softgreen div,
    .section-bg-softgreen h4 {
      color: #212529 !important;
    }

    /* Hero Overlay corrections */
    .hero::before {
      background: rgba(0, 0, 0, 0.5);
    }

    .hero h2,
    .hero p,
    .hero .btn-group {
      color: #ffffff !important;
      /* Hero text must be white */
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
    }

    /* Navbar Customization */
    .header {
      --background-color: rgba(255, 255, 255, 0.95);
      /* Light header for better contrast if needed, or keep dark. Let's stick to template default but ensure links are visible */
      --heading-color: #212529;
      --nav-color: #212529;
    }

    /* Footer text override */
    .footer {
      color: #fff !important;
    }

    .footer p,
    .footer li,
    .footer h4,
    .footer a {
      color: #fff !important;
    }

    .footer .text-primary-custom {
      color: #FE5D26 !important;
    }

    .footer .sitename {
      color: #ffffff !important;
    }

    /* Menu item text contrast for dark card backgrounds */
    .menu-item h5 {
      color: #FAEDCA !important;
      /* Cream from palette - high contrast on dark bg */
    }

    .menu-item .text-muted,
    .menu-item p {
      color: #C1DBB3 !important;
      /* Soft green for description text */
    }

    .menu-item .text-primary-custom {
      color: #F2C078 !important;
      /* Soft orange for price */
    }

    /* Header Logo Overlay - Removed to allow natural height */
    /* .header { padding-block: 10px; } */
    /* .header .logo { position: absolute; ... } */

    @media(max-width: 991px) {
      /* .header .logo { position: static; } */
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="<?= site_url() ?>" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="<?= base_url('assets/img/logo-removebg.png') ?>" alt="Warung Limus" class="img-fluid"
          style="max-height: 100px;">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#order">Pemesanan</a></li>
          <li><a href="#catering">Catering</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <?php if ($this->session->userdata('user_id')): ?>
        <a class="btn-getstarted d-none d-sm-block" href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
      <?php else: ?>
        <a class="btn-getstarted d-none d-sm-block" href="<?= site_url('admin/login') ?>">Log In</a>
      <?php endif; ?>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container-fluid hero-container" data-aos="fade-up">
        <div class="row g-0 align-items-center">
          <div class="col-lg-6 content-col">
            <div class="content-wrapper">
              <div class="status-badge">Buka Setiap Hari 10.00 - 22.00</div>
              <h2>Warung Ayam Goreng Limus Regency</h2>
              <p class="mb-4">Dine-in, takeaway, dan delivery dengan ayam goreng penyet khas Limus Regency. Nikmati
                sambal pedas nikmat dan pelayanan ramah.</p>

              <div class="btn-group">
                <a href="#menu" class="btn btn-menu"><i class="bi bi-book"></i> Lihat Menu</a>
                <a href="<?= site_url('order'); ?>" class="btn btn-book"><i class="bi bi-cart-plus"></i> Pesan Tanpa
                  Login</a>
              </div>

              <!-- Methods Icons -->
              <div class="mt-4 d-flex gap-4 text-white">
                <div class="d-flex align-items-center gap-2"><i class="bi bi-shop fs-4"></i> Dine-in</div>
                <div class="d-flex align-items-center gap-2"><i class="bi bi-bag fs-4"></i> Takeaway</div>
                <div class="d-flex align-items-center gap-2"><i class="bi bi-bicycle fs-4"></i> Delivery</div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 swiper-col">
            <div class="swiper hero-swiper init-swiper" data-aos="zoom-out" data-aos-delay="100">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 800,
                  "autoplay": {
                    "delay": 5000
                  },
                  "effect": "fade",
                  "slidesPerView": 1,
                  "navigation": {
                    "nextEl": ".swiper-button-next",
                    "prevEl": ".swiper-button-prev"
                  }
                }
              </script>
              <div class="swiper-wrapper">
                <!-- Placeholder images from template -->
                <div class="swiper-slide">
                  <div class="img-container">
                    <img src="<?= base_url('assets/img/restaurant/misc-square-1.webp'); ?>" alt="Suasana Restoran">
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="img-container">
                    <img src="<?= base_url('assets/img/restaurant/misc-square-2.webp'); ?>" alt="Makanan Lezat">
                  </div>
                </div>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section section-bg-cream">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center gy-4">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="about-content">
              <h3>Cerita Kami</h3>
              <p class="fst-italic text-primary-custom">Berdiri sejak tahun 2020.</p>
              <p>
                Awalnya didirikan sebagai fasilitas makan untuk penyewa kos di sekitar, Warung Ayam Goreng Limus Regency
                kini berkembang melayani pelanggan umum untuk dine-in, takeaway, dan delivery. Kami berkomitmen
                menyajikan hidangan ayam goreng penyet yang nikmat dengan harga terjangkau.
              </p>
              <p>
                Selain melayani pesanan harian, kami juga menyediakan layanan katering untuk acara dan memiliki ruang
                pertemuan (meeting room) yang dilengkapi TV untuk kebutuhan rapat kecil atau acara komunitas Anda.
              </p>

              <div class="mt-4">
                <ul class="list-unstyled">
                  <li><i class="bi bi-check2-circle text-primary-custom"></i> Bahan segar setiap hari</li>
                  <li><i class="bi bi-check2-circle text-primary-custom"></i> Sambal khas buatan sendiri</li>
                  <li><i class="bi bi-check2-circle text-primary-custom"></i> Tempat nyaman & fasilitas lengkap</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="about-image-wrapper">
              <img src="<?= base_url('assets/img/restaurant/showcase-4.webp'); ?>" class="img-fluid main-image shadow"
                alt="Interior Warung">
            </div>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

    <!-- Menu Section (Preview) -->
    <section id="menu" class="menu section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Menu Favorit</h2>
        <p>Pilihan menu terbaik untuk menemani santap Anda hari ini.</p>
      </div>

      <div class="container" data-aos="fade-up">
        <div class="row gy-4">
          <?php if (isset($featured_menu) && !empty($featured_menu)): ?>
            <?php $delay = 100;
            foreach ($featured_menu as $menu): ?>
              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <div class="menu-item d-flex align-items-center gap-4">
                  <?php
                  $img = $menu->gambar && file_exists(FCPATH . 'uploads/menu/' . $menu->gambar)
                    ? base_url('uploads/menu/' . $menu->gambar)
                    : base_url('assets/img/restaurant/main-1.webp');
                  ?>
                  <img src="<?= $img ?>" alt="<?= $menu->nama_menu ?>" class="menu-img img-fluid rounded-3"
                    style="width:120px;height:120px;object-fit:cover;">
                  <div class="menu-content w-100">
                    <div class="d-flex justify-content-between">
                      <h5><?= $menu->nama_menu ?></h5>
                      <span class="fw-bold text-primary-custom">
                        <?php if ($menu->harga_promo && $menu->harga_promo < $menu->harga): ?>
                          <del class="text-muted small">Rp<?= number_format($menu->harga, 0, ',', '.') ?></del>
                          Rp<?= number_format($menu->harga_promo, 0, ',', '.') ?>
                        <?php else: ?>
                          Rp<?= number_format($menu->harga, 0, ',', '.') ?>
                        <?php endif; ?>
                      </span>
                    </div>
                    <p class="fst-italic text-muted"><?= $menu->deskripsi ?: 'Menu favorit kami' ?></p>
                    <?php if ($menu->is_bestseller): ?>
                      <div class="badge rounded-pill bg-warning text-dark">🔥 Best Seller</div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <?php $delay += 100; endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center py-5">
              <p class="text-muted">Menu sedang diperbarui, silakan kunjungi kami langsung.</p>
            </div>
          <?php endif; ?>
        </div>

        <div class="text-center mt-5">
          <a href="<?= site_url('menu'); ?>" class="btn btn-outline-secondary px-4 py-2 rounded-pill">Lihat Menu
            Lengkap</a>
        </div>
      </div>
    </section>

    <!-- Guest Order & Services Section -->
    <section id="order" class="section section-bg-softgreen">
      <div class="container section-title" data-aos="fade-up">
        <h2>Pemesanan Mudah</h2>
        <p>Pesan langsung tanpa perlu repot membuat akun.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 text-center">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 bg-white rounded shadow-sm h-100">
              <div class="display-4 text-primary-custom mb-3"><i class="bi bi-shop"></i></div>
              <h4>Dine-in</h4>
              <p>Datang, duduk, scan QR atau isi nomor meja di website, pesanan akan diantar ke meja Anda.</p>
            </div>
          </div>
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="p-4 bg-white rounded shadow-sm h-100">
              <div class="display-4 text-primary-custom mb-3"><i class="bi bi-bag"></i></div>
              <h4>Takeaway</h4>
              <p>Pesan dari rumah atau kantor, kami siapkan, Anda tinggal ambil di kasir saat sudah siap.</p>
            </div>
          </div>
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="p-4 bg-white rounded shadow-sm h-100">
              <div class="display-4 text-primary-custom mb-3"><i class="bi bi-bicycle"></i></div>
              <h4>Delivery</h4>
              <p>Isi alamat dan nomor WhatsApp, kurir internal kami akan mengantar pesanan hangat ke depan pintu Anda.
              </p>
            </div>
          </div>
        </div>

        <div class="text-center mt-5">
          <a href="<?= site_url('order'); ?>" class="btn btn-book btn-lg px-5">Mulai Pesan Sekarang</a>
        </div>
      </div>
    </section>

    <!-- Order Tracking Section -->
    <section id="track" class="section">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h2>Lacak Pesanan Anda</h2>
            <p>Sudah memesan? Masukkan kode pesanan Anda di bawah ini untuk melihat status terkini (Diproses, Dikirim,
              atau Selesai).</p>

            <form action="<?= site_url('track'); ?>" method="get" class="mt-4">
              <div class="input-group mb-3 justify-content-center">
                <input type="text" name="code" class="form-control form-control-lg"
                  placeholder="Masukkan Kode Pesanan (contoh: LMR-2406...)" style="max-width: 400px;" required>
                <button class="btn btn-primary" type="submit">Lacak</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Catering Section -->
    <section id="catering" class="section section-bg-cream">
      <div class="container section-title" data-aos="fade-up">
        <h2>Catering & Fasilitas</h2>
        <p>Solusi konsumsi untuk acara Anda.</p>
      </div>
      <div class="container" data-aos="fade-up">
        <div class="row align-items-center gy-4">
          <div class="col-lg-6 order-2 order-lg-1">
            <div class="row gy-4">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white p-4 rounded shadow-sm">
                  <i class="bi bi-box2-heart fs-1 text-primary-custom mb-3"></i>
                  <h4>Nasi Box & Catering</h4>
                  <p>Terima pesanan nasi box jumlah besar untuk acara kantor, syukuran, atau Jumat berkah.</p>
                </div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white p-4 rounded shadow-sm">
                  <i class="bi bi-tv fs-1 text-primary-custom mb-3"></i>
                  <h4>Meeting Room</h4>
                  <p>Tersedia ruang pertemuan privat dengan TV, cocok untuk rapat kecil atau nobar.</p>
                </div>
              </div>
            </div>
            <div class="mt-4 text-center text-lg-start">
              <a href="#contact" class="btn btn-outline-secondary">Hubungi Kami untuk Info</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 text-center" data-aos="zoom-in">
            <img src="<?= base_url('assets/img/restaurant/event-1.webp'); ?>" alt="Catering"
              class="img-fluid rounded shadow">
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Lokasi & Kontak</h2>
        <p>Kunjungi kami langsung atau hubungi kami.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0 text-primary-custom"></i>
              <div>
                <h3>Alamat</h3>
                <p>Jl. Blitar No.21 Blok E1, RT.1/RW.6, Limusnunggal, Cileungsi, Bogor 16820</p>
                <a href="https://maps.app.goo.gl/Mh7nEJUxxv7LiU7G7" target="_blank" class="small fw-bold">Lihat di
                  Google Maps &rarr;</a>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-whatsapp flex-shrink-0 text-primary-custom"></i>
              <div>
                <h3>Hubungi Kami</h3>
                <p>Silahkan datang langsung atau pesan online.</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-clock flex-shrink-0 text-primary-custom"></i>
              <div>
                <h3>Jam Operasional</h3>
                <p>Setiap Hari: 10.00 - 22.00 WIB</p>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="map-section w-100 h-100 min-vh-50 rounded overflow-hidden shadow-sm" data-aos="fade-up"
              data-aos-delay="200">
              <!-- Embedded Map linked to the address provided (Approximation centered on region if exact embed not available, but using generic embed for now) -->
              <iframe style="border:0; width: 100%; height: 400px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.2355023608366!2d106.9744516!3d-6.36356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69939118817ecb%3A0xa595998b48b664!2sAyam%20Goreng%20Limus%20Regency%20(Warung%20Limus%20Pojok)!5e0!3m2!1sen!2sid!4v1765646360483!5m2!1sen!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer" style="background-color: #243036; color: #fff;">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="<?= site_url() ?>" class="logo d-flex align-items-center text-white mb-2">
            <span class="sitename">Warung Limus</span>
          </a>
          <p>Warung Ayam Goreng Limus Regency menyajikan ayam penyet lezat dengan harga bersahabat. Melayani dine-in,
            takeaway, dan delivery untuk warga Limus Regency dan sekitarnya.</p>
          <div class="pt-3">
            <p class="mb-1"><strong class="text-primary-custom">Metode Pembayaran:</strong></p>
            <p>Tunai, QRIS, E-Wallet (GoPay, OVO, Dana, ShopeePay)</p>
          </div>
        </div>

        <div class="col-lg-3 col-6 footer-links">
          <h4>Navigasi</h4>
          <ul>
            <li><a href="#hero">Beranda</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#track">Lacak Pesanan</a></li>
            <li><a href="<?= site_url('admin/login') ?>">Login Staff</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-contact text-center text-md-start">
          <h4>Kontak</h4>
          <p>Jl. Blitar No.21 Blok E1</p>
          <p>Limusnunggal, Cileungsi, Bogor 16820</p>
          <p class="mt-4"><strong>Layanan:</strong> Dine-in, Takeaway, Delivery, Catering</p>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4 border-top border-secondary pt-3">
      <p>© <?= date('Y') ?> <strong class="px-1 text-primary-custom">Warung Ayam Goreng Limus Regency</strong></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"
    style="background-color: var(--nav-color);"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/aos/aos.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/isotope-layout/isotope.pkgd.min.js'); ?>"></script>

  <!-- Main JS File -->
  <script src="<?= base_url('assets/js/main.js'); ?>"></script>

</body>

</html>