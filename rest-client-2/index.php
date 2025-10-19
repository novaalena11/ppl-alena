<?php
// index.php (versi perbaikan - home teks baku, hilangkan logo Home, perbaikan active nav)
// load config.php
include("config/config.php");

// safety: pastikan $sample_articles terdefinisi agar tidak muncul warning
if (!isset($sample_articles) || !is_array($sample_articles)) {
    $sample_articles = [];
}

// NewsAPI (ganti api key jika perlu)
$api_key = "991fc2be472145069e249bfdd5953bc9";
$url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $api_key;

$data = http_request_get($url);
$hasil = json_decode($data, true);

if (is_array($hasil) && isset($hasil['articles']) && is_array($hasil['articles']) && count($hasil['articles'])>0) {
    $articles = $hasil['articles'];
    $used_fallback = false;
} else {
    $articles = $sample_articles;
    $used_fallback = true;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>RestClient - Portal Berita</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    :root{ --brand-pink:#e83e8c; --brand-pink-dark:#c92b6b; }
    body { scroll-behavior: smooth; padding-top:72px; background:#fff; }
    .topbar { background: linear-gradient(90deg, var(--brand-pink), var(--brand-pink-dark)); }
    .navbar .nav-link { color: rgba(255,255,255,0.95) !important; }
    .brand { color:#fff; font-weight:600; }
    /* header hero (Home) */
    .hero {
      background: linear-gradient(90deg, rgba(232,62,140,0.07), rgba(201,43,107,0.03));
      padding: 70px 0;
      margin-bottom: 8px;
    }
    .hero h1 { font-weight:700; color:#222; }
    .hero p { color:#444; font-size:1.05rem; }
    /* news card */
    .news-card { border:1px solid #ececec; border-radius:8px; overflow:hidden; background:#fff; display:flex; flex-direction:column; height:100%; }
    .news-thumb { width:100%; height:180px; object-fit:cover; display:block; background:#f2f2f2; }
    .card-body-compact { padding:14px; display:flex; flex-direction:column; flex:1 1 auto; }
    .news-source { font-size:0.82rem; color:#777; margin-bottom:6px; }
    .news-title { font-size:1rem; font-weight:700; margin:0 0 8px 0; color:#222; line-height:1.2; min-height:2.4em; }
    .news-desc { font-size:0.9rem; color:#555; margin-bottom:10px; flex:1 1 auto; }
    .read-more { font-size:0.95rem; color:var(--brand-pink-dark); text-decoration:none; font-weight:600; }
    .read-more:hover { color:#a71d52; text-decoration:underline; }
    .card-col { padding:12px; }
    .alert-fallback { background:#fff0f6; border-color:#ffc7e3; color:#6f1d45; }
    /* about */
    .about { padding:34px 0; }
    /* active nav highlight */
    .nav-link.active { text-decoration:underline; font-weight:600; }
    @media (max-width:576px){ .news-thumb{height:140px;} }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg topbar">
  <div class="container">
    <a class="navbar-brand brand" href="#home">RestClient</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1)"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-3" id="mainNav">
        <li class="nav-item"><a class="nav-link" href="#home" data-target="home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#news" data-target="news">News</a></li>
        <li class="nav-item"><a class="nav-link" href="#about" data-target="about">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Home / Hero -->
<section id="home" class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <h1>Portal Berita RestClient</h1>
        <p>Menyajikan berita terkini dan terpercaya secara ringkas dan informatif. Klik menu <strong>News</strong> untuk melihat daftar artikel terbaru, lengkap dengan ringkasan dan tautan ke sumber asli.</p>
      </div>
    </div>
  </div>
</section>

<!-- News -->
<section id="news" class="py-3">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 style="margin:0">News</h2>
      <?php if ($used_fallback): ?>
        <div class="badge rounded-pill bg-warning text-dark">Menampilkan contoh berita (fallback)</div>
      <?php endif; ?>
    </div>

    <div class="row">
      <?php foreach ($articles as $idx => $row):
          $imgRaw = $row['urlToImage'] ?? '';
          $img = (preg_match('#^https?://#i', $imgRaw) ? $imgRaw : ( !empty($imgRaw) && file_exists(__DIR__ . '/' . ltrim($imgRaw, '/')) ? $imgRaw : 'https://via.placeholder.com/800x450?text=No+Image' ));
          $author = $row['author'] ?? ($row['source']['name'] ?? 'Sumber');
          $title = $row['title'] ?? '(Judul tidak tersedia)';
          $desc = $row['description'] ?? '';
          $link = $row['url'] ?? '';
          $has_link = preg_match('#^https?://#i', $link);
      ?>
        <div class="col-lg-4 col-md-6 col-sm-12 card-col">
          <article class="news-card shadow-sm">
            <img class="news-thumb" src="<?php echo htmlspecialchars($img); ?>" alt="gambar" onerror="this.onerror=null;this.src='https://via.placeholder.com/800x450?text=No+Image';">
            <div class="card-body-compact">
              <div class="news-source">Oleh <?php echo htmlspecialchars($author); ?></div>
              <h3 class="news-title"><?php echo htmlspecialchars($title); ?></h3>
              <p class="news-desc"><?php echo htmlspecialchars($desc); ?></p>
              <div class="mt-2 text-start">
                <?php if ($has_link): ?>
                  <a class="read-more" href="<?php echo htmlspecialchars($link); ?>" target="_blank" rel="noopener">Selengkapnya..</a>
                <?php else: ?>
                  <a class="read-more" href="javascript:void(0)" onclick="alert('Tidak ada tautan sumber untuk artikel ini (contoh).');">Selengkapnya..</a>
                <?php endif; ?>
              </div>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- About -->
<section id="about" class="about bg-light">
  <div class="container">
    <h2>About</h2>
    <p>Ini adalah demo RestClient yang dibuat untuk tugas/latihan. Aplikasi menunjukkan cara mengambil data dari REST API (NewsAPI) kemudian menampilkannya sebagai daftar berita. Kamu dapat mengganti sumber data dengan API lokal atau database sendiri.</p>
    <p>Fitur yang disertakan:</p>
    <ul>
      <li>Menampilkan daftar berita dalam tata letak grid responsif.</li>
      <li>Penggunaan placeholder gambar bila gambar asli tidak tersedia.</li>
      <li>Fallback data lokal bila API tidak mengembalikan konten.</li>
    </ul>
  </div>
</section>

<!-- footer -->
<footer class="py-4 text-center">
  <div class="container">
    <small>© <?php echo date('Y'); ?> RestClient — Demo</small>
  </div>
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
(function(){
  const navLinks = Array.from(document.querySelectorAll('#mainNav .nav-link'));
  const sectionMap = {};
  let manualClick = false; // tandai kalau user klik manual

  navLinks.forEach(a => {
    const target = a.getAttribute('href');
    if (target && target.startsWith('#')) sectionMap[target.slice(1)] = a;

    a.addEventListener('click', function(){
      manualClick = true; // user klik manual
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      // sembunyikan navbar di mobile
      const bsCollapse = document.getElementById('navMain');
      if (bsCollapse && bsCollapse.classList.contains('show')) {
        new bootstrap.Collapse(bsCollapse).hide();
      }

      // hapus flag manualClick setelah jeda agar observer bisa kembali bekerja
      setTimeout(() => manualClick = false, 1000);
    });
  });

  // build sections map
  const sections = Object.keys(sectionMap).map(id => document.getElementById(id)).filter(Boolean);

  function setActiveById(id) {
    navLinks.forEach(l => {
      const tgt = l.getAttribute('data-target') || (l.getAttribute('href') ? l.getAttribute('href').replace('#','') : '');
      l.classList.toggle('active', tgt === id);
    });
  }

  // Improved IntersectionObserver / scroll fallback:
  if ('IntersectionObserver' in window && sections.length) {
    // thresholds granular for better ratio resolution
    const thresholds = [];
    for (let i=0; i<=100; i++) thresholds.push(i/100);

    const io = new IntersectionObserver((entries) => {
      if (manualClick) return; // hormati klik manual
      // collect intersecting entries
      const visible = entries.filter(e => e.isIntersecting);
      if (visible.length === 0) {
        return;
      }
      // pick the one with largest intersectionRatio
      visible.sort((a,b) => b.intersectionRatio - a.intersectionRatio);
      const top = visible[0];
      if (top && top.target && top.target.id) {
        setActiveById(top.target.id);
      }
    }, { threshold: thresholds, rootMargin: '0px 0px -20% 0px' });

    sections.forEach(s => io.observe(s));
  } else {
    // fallback: choose section whose center is closest to viewport center
    window.addEventListener('scroll', () => {
      if (manualClick) return;
      const viewportCenter = window.scrollY + (window.innerHeight / 2);
      let bestId = null;
      let bestDist = Infinity;
      sections.forEach(sec => {
        const rect = sec.getBoundingClientRect();
        const secTopAbs = window.scrollY + rect.top;
        const secCenter = secTopAbs + (rect.height / 2);
        const dist = Math.abs(secCenter - viewportCenter);
        if (dist < bestDist) {
          bestDist = dist;
          bestId = sec.id;
        }
      });
      if (bestId) setActiveById(bestId);
    }, { passive: true });
  }

})();
</script>
</body>
</html>
