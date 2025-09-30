<!DOCTYPE html>
<html lang="bn" data-lang="bn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tro ESports</title>

    <!-- SEO Meta -->
    <meta name="description" content="Tro ESports - Competitive gaming, tournaments, and esports community. Join us for the best BR and Class Squad matches.">
    <meta name="keywords" content="Tro ESports, esports, gaming, tournaments, BR Match, Class Squad, competitive gaming, Bangladesh esports">
    <meta name="author" content="Tro ESports">
    <link rel="canonical" href="https://troesports.zobayerdev.top" />
    <meta http-equiv="Content-Language" content="en">
    <meta name="revisit-after" content="7 days">
    <meta name="theme-color" content="#0b0f1a" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Tro ESports" />
    <meta property="og:description" content="Join Tro ESports for exciting esports tournaments and competitive gaming." />
    <meta property="og:image" content="https://troesports.zobayerdev.top/TroSports.jpg" />
    <meta property="og:url" content="https://troesports.zobayerdev.top" />
    <meta property="og:type" content="website" />

    <!-- Twitter Meta -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Tro ESports" />
    <meta name="twitter:description" content="Tro ESports - The hub for esports tournaments and competitive gamers." />
    <meta name="twitter:image" content="https://troesports.zobayerdev.top/TroSports.jpg" />

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <!-- Google Fonts: Hind Siliguri for Bangla, Poppins for English -->
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg-dark:#0b0f1a;
            --accent:#ff2d2d; /* primary red */
            --accent-soft:#ff2d2d22;
            --card:#12182a;
            --gradient: radial-gradient(1200px 600px at 10% -10%, #ff2d2d55, transparent 60%),
            radial-gradient(900px 500px at 110% 10%, #00d4ff33, transparent 60%),
            linear-gradient(160deg, #0b0f1a 0%, #0a0e20 50%, #0c1024 100%);
            --font-sans:'Hind Siliguri', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        html { scroll-behavior: smooth; }
        body { background: var(--gradient); color:#ffffff; font-family: var(--font-sans); }
        body.en { font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

        .navbar{ backdrop-filter: blur(8px); background: #0b0f1acc; }
        .nav-link{ color:#ffffff !important; opacity:.95; }
        .nav-link:hover, .nav-link.active{ color:#fff !important; }

        /* Subtle streaks */
        .bg-streaks{ position:absolute; inset:0; overflow:hidden; mask-image: linear-gradient(#000, #0000 85%); pointer-events:none; }
        .bg-streaks span{ position:absolute; width:2px; height:120px; background: linear-gradient(180deg, #ffffff00, #ffffff66, #ffffff00); animation: fall 9s linear infinite; opacity:.6; }
        @keyframes fall { from { transform: translateY(-150%); } to { transform: translateY(120%);} }
        .bg-streaks span:nth-child(1){ left:8%; animation-delay:0s; }
        .bg-streaks span:nth-child(2){ left:28%; animation-delay:1.8s; }
        .bg-streaks span:nth-child(3){ left:48%; animation-delay:3.5s; }
        .bg-streaks span:nth-child(4){ left:68%; animation-delay:2.2s; }
        .bg-streaks span:nth-child(5){ left:88%; animation-delay:4.1s; }

        .hero{ position:relative; padding-top:8rem; padding-bottom:7rem; background-size:cover; background-position:center; }
        .hero .badge-pill{ background: var(--accent-soft); color:#fff; border:1px solid #ff2d2d55; }
        .hero h1{ font-weight:800; letter-spacing:.3px; }
        .hero-sub{ color:#ffffff; opacity:.9; }
        .btn-pill{ border-radius: 999px; padding:.8rem 1.3rem; }
        .btn-accent{ background: var(--accent); color:#fff; border:none; }
        .btn-accent:hover{ filter: brightness(1.05); }
        .btn-ghost{ background: transparent; color:#fff; border:1px solid #ffffff33; }

        section{ padding: 5rem 0; position:relative; }
        .section-title{ font-weight:700; margin-bottom:1rem; }
        .section-lead{ color:#ffffff; opacity:.9; max-width: 720px; }

        .glass-card{ background: #ffffff08; border:1px solid #ffffff12; border-radius: 18px; backdrop-filter: blur(6px); color:#fff; }
        .card-dark{ background: var(--card); border:1px solid #20263a; color:#fff; }

        footer{ background:#0a0e18; border-top:1px solid #1a2033; }
        .link-muted { color:#eaefff; opacity:.8; }
        .link-muted:hover{ color:#fff; opacity:1; }

        .divider{ height:1px; background:#ffffff2a; margin:2rem 0; }

        .fab-settings{ position:fixed; right:16px; bottom:16px; z-index:1030; }

        /* Match list styling */
        .mode-chip{ cursor:pointer; }
        .list-hover .list-group-item{ background:#12182a; color:#fff; border-color:#1d2540; }
        .list-hover .list-group-item:hover{ background:#17213a; }
        .list-hover .active{ background: var(--accent); border-color: var(--accent); }
    </style>
</head>

<body class="bn">
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top border-bottom border-secondary-subtle">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#home">
            <img src="{{ asset('favicon-32x32.png') }}" alt="Tro ESports Logo" width="28" height="28" class="me-2">
            <span data-i18n="brand">Tro ESports</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home" data-i18n="nav.home">হোম</a></li>
                <li class="nav-item"><a class="nav-link" href="#about" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
                <li class="nav-item"><a class="nav-link" href="#matches" data-i18n="nav.matches">ম্যাচ সমূহ</a></li>
                <li class="nav-item"><a class="nav-link" href="#download" data-i18n="nav.download">ডাউনলোড করুন</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact" data-i18n="nav.contact">যোগাযোগ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}" data-i18n="nav.login">লগইন</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<header id="home" class="hero position-relative overflow-hidden">
    <div class="bg-streaks">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill badge-pill px-3 py-2 mb-3"><small data-i18n="badge">Tro ESports রিওয়ার্ডস</small></span>
                <h1 class="display-5" data-i18n="hero.title">আপনি কি একজন Tro ESports প্লেয়ার?</h1>
                <p class="hero-sub fs-5" data-i18n="hero.sub">গেম খেলে আপনি জিতলে নিতে পারবেন প্রতিদিন ১০০০-২০০০ টাকা পর্যন্ত রিওয়ার্ড। আজই শুরু করুন!</p>
                <div class="d-flex flex-wrap gap-3 pt-2">
                    <a href="#video" class="btn btn-ghost btn-pill" data-i18n="hero.watch"><i class="bi bi-play-circle me-2"></i>ভিডিও দেখুন</a>
                    <a href="#download" class="btn btn-accent btn-pill" data-i18n="hero.download"><i class="bi bi-download me-2"></i>অ্যাপটি ডাউনলোড করুন</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="glass-card p-4 p-lg-5 text-center">
                    <div class="display-6 mb-2">🎮</div>
                    <h5 class="mb-2" data-i18n="hero.card.title">দ্রুত সাইন-আপ</h5>
                    <p class="mb-3" data-i18n="hero.card.text">২ মিনিটে অ্যাকাউন্ট তৈরি করুন, ম্যাচে যোগ দিন এবং পুরস্কার জিতুন।</p>
                    <a href="#download" class="btn btn-accent w-100 btn-pill" data-i18n="hero.card.cta">এখনই শুরু করুন</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ABOUT -->
<section id="about">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <img class="img-fluid rounded-4 border border-1 border-secondary-subtle" alt="About" src="{{asset('TroSports.jpg')}}"/>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title" data-i18n="about.title">আমাদের সম্পর্কে</h2>
                <p class="section-lead" data-i18n="about.lead">আমরা বাংলাদেশে কমিউনিটি-ড্রিভেন ই-স্পোর্টস টুর্নামেন্ট আয়োজন করি যেখানে প্রতিদিনের ম্যাচ থেকে উইকেন্ড চ্যাম্পিয়নশিপ পর্যন্ত সবই রয়েছে। নিরাপদ পেমেন্ট ও ২৪/৭ সাপোর্ট আমাদের বৈশিষ্ট্য।</p>
                <div class="row g-3 pt-2">
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">🏆</div><div class="fw-semibold" data-i18n="about.i1">ডেইলি উইনস</div></div></div>
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">💳</div><div class="fw-semibold" data-i18n="about.i2">ইনস্ট্যান্ট পেআউটস</div></div></div>
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">🛡️</div><div class="fw-semibold" data-i18n="about.i3">ফেয়ার প্লে</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MATCHES -->
<section id="matches">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title" data-i18n="matches.title">Match</h2>
            <p class="section-lead mx-auto" data-i18n="matches.lead">যে মোডে খেলবেন সেটিতে ক্লিক করুন—নিচে ম্যাচ লিস্ট ও সময় দেখাবে। যে কোনো ম্যাচে ক্লিক করলে বিস্তারিত আসবে।</p>
        </div>

        <!-- Mode chips -->
        <div id="modesGrid" class="row g-3 mb-4">
            <!-- injected by JS -->
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i><span id="listTitle">Match List</span></h5>
                        <span class="badge bg-danger-subtle text-white" id="activeModeLabel">BR Match</span>
                    </div>
                    <div class="list-hover">
                        <ul class="list-group list-group-flush" id="matchList">
                            <!-- list populated via JS -->
                        </ul>
                    </div>
                    <div class="small text-white-50 mt-2" id="emptyNotice" style="display:none;">এই মোডে এখনো কোনো ম্যাচ নেই।</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-3 h-100">
                    <h5 class="mb-2"><i class="bi bi-info-circle me-2"></i>Details</h5>
                    <div id="matchDetails" class="small text-white-50">একটি ম্যাচ সিলেক্ট করুন।</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DOWNLOAD -->
<section id="download">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h2 class="section-title" data-i18n="download.title">Download</h2>
                <p class="section-lead" data-i18n="download.lead">Android ও iOS-এ অ্যাপ ডাউনলোড করে ম্যাচ ব্রাউজ, রেজিস্টার ও রিওয়ার্ড ট্র্যাক করুন।</p>
                <div class="d-flex flex-wrap gap-3 pt-2">
                    <a class="btn btn-accent btn-pill" href="#"><i class="bi bi-android2 me-2"></i><span data-i18n="download.android">অ্যান্ড্রয়েড অ্যাপ</span></a>
                    <a class="btn btn-ghost btn-pill" href="#"><i class="bi bi-apple me-2"></i><span data-i18n="download.ios">iOS অ্যাপ</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-4 p-lg-5">
                    <h5 class="mb-2" data-i18n="download.why">কেন অ্যাপ?</h5>
                    <ul class="mb-0">
                        <li class="mb-2" data-i18n="download.li1">রিয়েল-টাইম নোটিফিকেশন</li>
                        <li class="mb-2" data-i18n="download.li2">সিকিউর ইন-অ্যাপ পেমেন্ট</li>
                        <li data-i18n="download.li3">ওয়ান-ট্যাপ রেজিস্ট্রেশন</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <h2 class="section-title" data-i18n="contact.title">Contact Us</h2>
                <p class="section-lead" data-i18n="contact.lead">যেকোনো তথ্য বা পার্টনারশিপের জন্য আমাদেরকে লিখুন।</p>
                <div class="glass-card p-4">
                    <form onsubmit="event.preventDefault(); this.reset(); alert(activeLang==='bn' ? 'ধন্যবাদ! শীঘ্রই যোগাযোগ করবো।' : 'Thanks! We\'ll reach out soon.');">
                        <div class="mb-3">
                            <label class="form-label" data-i18n="contact.name">আপনার নাম</label>
                            <input type="text" class="form-control bg-transparent text-white border-light" placeholder="e.g. Alex Ahmed" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-i18n="contact.email">ইমেইল</label>
                            <input type="email" class="form-control bg-transparent text-white border-light" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" data-i18n="contact.message">মেসেজ</label>
                            <textarea class="form-control bg-transparent text-white border-light" rows="4" placeholder="Tell us how we can help" required></textarea>
                        </div>
                        <button class="btn btn-accent btn-pill" type="submit"><i class="bi bi-send me-2"></i><span data-i18n="contact.send">বার্তা পাঠান</span></button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card h-100 p-4">
                    <h5 class="mb-3" data-i18n="contact.reach">Reach us</h5>
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i>support@troesports.example</p>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>Dhaka, Bangladesh</p>
                    <div class="divider"></div>
                    <h6 class="mb-2" data-i18n="contact.follow">Follow</h6>
                    <div class="d-flex gap-3">
                        <a class="link-muted" href="#"><i class="bi bi-discord fs-4"></i></a>
                        <a class="link-muted" href="#"><i class="bi bi-facebook fs-4"></i></a>
                        <a class="link-muted" href="#"><i class="bi bi-twitter-x fs-4"></i></a>
                        <a class="link-muted" href="#"><i class="bi bi-youtube fs-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-4 mt-4">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="small">© <span id="y"></span> <span data-i18n="brand">Tro ESports</span>.
            <span data-i18n="footer.rights">সর্বস্বত্ব সংরক্ষিত।</span>
        </div>
        <div class="d-flex gap-3">
            <a class="link-muted small"
               href="privacy.html"
               target="_blank"
               rel="noopener noreferrer"
               data-i18n="footer.privacy">প্রাইভেসি পলিসি</a>
            <a class="link-muted small"
               href="terms.html"
               target="_blank"
               rel="noopener noreferrer"
               data-i18n="footer.terms">টার্মস ও কন্ডিশনস</a>
        </div>
    </div>
</footer>

<!-- Floating Settings Button -->
<button class="btn btn-accent rounded-circle fab-settings" data-bs-toggle="offcanvas" data-bs-target="#settings" aria-label="Customize site"><i class="bi bi-gear fs-5"></i></button>

<!-- Settings Offcanvas -->
<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="settings" aria-labelledby="settingsLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="settingsLabel">Customize</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="mb-3">
            <label class="form-label">Primary Color</label>
            <input type="color" class="form-control form-control-color" id="primaryColor" value="#ff2d2d" />
        </div>
        <div class="mb-3">
            <label class="form-label">Font</label>
            <select id="fontSelect" class="form-select">
                <option value="bn">Hind Siliguri (Bangla)</option>
                <option value="en">Poppins (English UI)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Hero Background Image URL</label>
            <input id="bgInput" type="url" class="form-control" placeholder="https://.../image.jpg" />
            <div class="form-text">Leave blank to keep default gradient.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Language</label>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-light" id="langBn">বাংলা</button>
                <button type="button" class="btn btn-outline-light" id="langEn">English</button>
            </div>
        </div>
        <button class="btn btn-accent w-100" id="applyBtn"><i class="bi bi-check2-circle me-2"></i>Apply</button>
    </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" data-i18n="footer.privacy">প্রাইভেসি পলিসি</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body small">
                <span data-i18n="policy.text">এটি ডেমো প্রাইভেসি পলিসি। আপনার প্রকৃত নীতিমালা এখানে যুক্ত করুন।</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light btn-pill" data-bs-dismiss="modal" data-i18n="common.close">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" data-i18n="footer.terms">টার্মস ও কন্ডিশনস</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body small">
                <span data-i18n="terms.text">এগুলি ডেমো শর্তাবলী। খেলাসহ অংশগ্রহণ ও পেআউটের নিয়ম এখানে সংযোজন করুন।</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light btn-pill" data-bs-dismiss="modal" data-i18n="common.close">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- ========= SERVER → JS: Inject modes & matches from DB (no room_details) ========= --}}
@php
    use Carbon\Carbon;

    // Use the exact strings from your <select> as the mode keys
    $modeMeta = [
        'BR Match'   => ['labelBn' => 'BR Match',   'labelEn' => 'BR Match',   'icon' => 'controller'],
        'Class Squad'=> ['labelBn' => 'Class Squad','labelEn' => 'Class Squad','icon' => 'people'],
    ];

    // Group by the exact category values; never include room_details
    $grouped = $matches->groupBy('category')->map(function($items) {
        return $items->map(function($m) {
            $dt = Carbon::parse("{$m->match_date} {$m->match_time}", 'Asia/Dhaka');

            // Try nice BN; fallback if intl not available
            try { $timeBn = $dt->locale('bn')->isoFormat('LL, h:mm A'); }
            catch (\Throwable $e) { $timeBn = $dt->format('d-m-Y, h:i A'); }

            $timeEn = $dt->locale('en')->translatedFormat('M d, Y g:i A');

            return [
                'id'     => (string)$m->id,
                'title'  => $m->match_name,
                'timeBn' => $timeBn,
                'timeEn' => $timeEn,
                'map'    => $m->map_type,
                'type'   => $m->match_type,
                'slots'  => "0/{$m->player_limit}",   // replace 0 with joined count if you have it
                'entry'  => '৳'.(int)$m->entry_fee,
                'prize'  => '৳'.(int)$m->grand_prize,
            ];
        })->values();
    });

    // Build modes array for JS (keys are the same display strings)
    $modesForJs = collect($modeMeta)->map(function($v, $k){
        return array_merge(['key' => $k], $v);
    })->values();
@endphp
<script>
    const modes = {!! $modesForJs->toJson(JSON_UNESCAPED_UNICODE) !!};
    const matchesByMode = {!! $grouped->toJson(JSON_UNESCAPED_UNICODE) !!};
</script>

<script>
    // From server (DB)
    const modes = {!! $modesForJs->toJson(JSON_UNESCAPED_UNICODE) !!};
    const matchesByMode = {!! $grouped->toJson(JSON_UNESCAPED_UNICODE) !!};
</script>

<!-- App JS: uses the injected "modes" and "matchesByMode" -->
<script>
    // Year
    document.getElementById('y').textContent = new Date().getFullYear();

    // Active link on scroll
    const sections = ['home','about','matches','download','contact'];
    const links = sections.map(id => [id, document.querySelector(`.nav-link[href="#${id}"]`)]);
    const opts = {root:null, rootMargin:'-50% 0px -50% 0px', threshold:0};
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(e.isIntersecting){
                links.forEach(([id, el]) => el.classList.toggle('active', `#${id}` === `#${e.target.id}`));
            }
        });
    }, opts);
    sections.forEach(id => io.observe(document.getElementById(id)));

    // i18n packs
    const i18n = {
        bn: {
            brand:'Tro ESports',
            'nav.home':'হোম','nav.about':'আমাদের সম্পর্কে','nav.matches':'ম্যাচ সমূহ','nav.download':'ডাউনলোড করুন','nav.contact':'যোগাযোগ','nav.login':'লগইন',
            badge:'Tro ESports রিওয়ার্ডস',
            'hero.title':'আপনি কি একজন Tro ESports প্লেয়ার?','hero.sub':'গেম খেলে আপনি জিতলে নিতে পারবেন প্রতিদিন ১০০০-২০০০ টাকা পর্যন্ত রিওয়ার্ড। আজই শুরু করুন!',
            'hero.watch':'ভিডিও দেখুন','hero.download':'অ্যাপটি ডাউনলোড করুন','hero.card.title':'দ্রুত সাইন-আপ','hero.card.text':'২ মিনিটে অ্যাকাউন্ট তৈরি করুন, ম্যাচে যোগ দিন এবং পুরস্কার জিতুন।','hero.card.cta':'এখনই শুরু করুন',
            'about.title':'আমাদের সম্পর্কে','about.lead':'আমরা বাংলাদেশে কমিউনিটি-ড্রিভেন ই-স্পোর্টস টুর্নামেন্ট আয়োজন করি যেখানে প্রতিদিনের ম্যাচ থেকে উইকেন্ড চ্যাম্পিয়নশিপ পর্যন্ত সবই রয়েছে। নিরাপদ পেমেন্ট ও ২৪/৭ সাপোর্ট আমাদের বৈশিষ্ট্য।','about.i1':'ডেইলি উইনস','about.i2':'ইনস্ট্যান্ট পেআউটস','about.i3':'ফেয়ার প্লে',
            'matches.title':'Match','matches.lead':'যে মোডে খেলবেন সেটিতে ক্লিক করুন—নিচে ম্যাচ লিস্ট ও সময় দেখাবে। যে কোনো ম্যাচে ক্লিক করলে বিস্তারিত আসবে।',
            'download.title':'Download','download.lead':'Android ও iOS-এ অ্যাপ ডাউনলোড করে ম্যাচ ব্রাউজ, রেজিস্টার ও রিওয়ার্ড ট্র্যাক করুন।','download.android':'অ্যান্ড্রয়েড অ্যাপ','download.ios':'iOS অ্যাপ','download.why':'কেন অ্যাপ?','download.li1':'রিয়েল-টাইম নোটিফিকেশন','download.li2':'সিকিউর ইন-অ্যাপ পেমেন্ট','download.li3':'ওয়ান-ট্যাপ রেজিস্ট্রেশন',
            'contact.title':'Contact Us','contact.lead':'যেকোনো তথ্য বা পার্টনারশিপের জন্য আমাদেরকে লিখুন।','contact.name':'আপনার নাম','contact.email':'ইমেইল','contact.message':'মেসেজ','contact.send':'বার্তা পাঠান','contact.reach':'Reach us','contact.follow':'Follow',
            'footer.rights':'সর্বস্বত্ব সংরক্ষিত।','footer.privacy':'প্রাইভেসি পলিসি','footer.terms':'টার্মস ও কন্ডিশনস',
            'policy.text':'এটি ডেমো প্রাইভেসি পলিসি। আপনার প্রকৃত নীতিমালা এখানে যুক্ত করুন।',
            'terms.text':'এগুলি ডেমো শর্তাবলী। খেলাসহ অংশগ্রহণ ও পেআউটের নিয়ম এখানে সংযোজন করুন।',
            'common.close':'বন্ধ করুন'
        },
        en: {
            brand:'Tro ESports',
            'nav.home':'Home','nav.about':'About Us','nav.matches':'Match','nav.contact':'Contact Us','nav.login':'Login','nav.download':'Download',
            badge:'Tro ESports Rewards',
            'hero.title':'Are you a Tro ESports player?','hero.sub':'Win rewards worth ৳1000-2000 daily by playing matches. Get started today!',
            'hero.watch':'Watch Video','hero.download':'Download the App','hero.card.title':'Quick Sign-Up','hero.card.text':'Create your account in 2 minutes, join matches and win rewards.','hero.card.cta':'Start Now',
            'about.title':'About Us','about.lead':'We host community-driven esports tournaments in Bangladesh — from daily matches to weekend championships — with secure payments and 24/7 support.','about.i1':'Daily Wins','about.i2':'Instant Payouts','about.i3':'Fair Play',
            'matches.title':'Match','matches.lead':'Click a mode to view the list with times below. Click a match to see details.',
            'download.title':'Download','download.lead':'Get our official Android & iOS apps to browse matches, register, and track rewards.','download.android':'Get it on Android','download.ios':'Download on iOS','download.why':'Why the app?','download.li1':'Real-time notifications','download.li2':'Secure in-app payments','download.li3':'One-tap registration',
            'contact.title':'Contact Us','contact.lead':'For questions or partnerships, write to us.','contact.name':'Your Name','contact.email':'Email','contact.message':'Message','contact.send':'Send Message','contact.reach':'Reach us','contact.follow':'Follow',
            'footer.rights':'All rights reserved.','footer.privacy':'Privacy Policy','footer.terms':'Terms & Conditions',
            'policy.text':'This is a sample privacy policy. Replace with your actual policy describing how you collect and use data.',
            'terms.text':'These are placeholder terms and conditions. Replace with rules governing matches, eligibility, and payouts.',
            'common.close':'Close'
        }
    };

    let activeLang = 'bn';
    function applyLang(lang){
        activeLang = lang;
        document.documentElement.lang = lang === 'bn' ? 'bn' : 'en';
        document.body.classList.toggle('en', lang==='en');
        document.body.classList.toggle('bn', lang==='bn');
        document.querySelectorAll('[data-i18n]').forEach(node=>{
            const key = node.getAttribute('data-i18n');
            if(i18n[lang] && i18n[lang][key]) node.textContent = i18n[lang][key];
        });
        renderModes();
        renderMatchList(activeModeKey);
    }

    // App State + Renderers ----------------------------------
    let activeModeKey = 'BR Match';

    function renderModes(){
        const grid = document.getElementById('modesGrid');
        const t = activeLang==='bn' ? 'labelBn' : 'labelEn';

        grid.innerHTML = modes.map(m=>`
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card card-dark text-center p-3 mode-chip ${activeModeKey===m.key?'border border-danger':''}" data-key="${m.key}">
            <div class="fs-3 mb-1"><i class="bi bi-${m.icon}"></i></div>
            <div class="fw-semibold">${m[t]}</div>
          </div>
        </div>`).join('');

        grid.querySelectorAll('.mode-chip').forEach(el=>{
            el.onclick = ()=>{
                activeModeKey = el.getAttribute('data-key');
                renderModes();
                renderMatchList(activeModeKey);
                document.getElementById('matchDetails').innerHTML = '<span class="text-white-50">একটি ম্যাচ সিলেক্ট করুন।</span>';
                const tKey = activeLang==='bn' ? 'labelBn' : 'labelEn';
                const found = modes.find(x=>x.key===activeModeKey);
                document.getElementById('activeModeLabel').textContent = found ? found[tKey] : '';
            }
        });
    }

    function renderMatchList(modeKey){
        const list = document.getElementById('matchList');
        const emptyNotice = document.getElementById('emptyNotice');
        const tTime = activeLang==='bn' ? 'timeBn' : 'timeEn';
        const data = matchesByMode[modeKey] || [];

        if (!data.length) {
            list.innerHTML = '';
            emptyNotice.style.display = 'block';
            document.getElementById('matchDetails').innerHTML = '<span class="text-white-50">এই মোডে এখনো কোনো ম্যাচ নেই।</span>';
            return;
        }

        emptyNotice.style.display = 'none';
        list.innerHTML = data.map((m)=>`
        <li class="list-group-item d-flex align-items-center justify-content-between" data-id="${m.id}">
          <div class="me-2">
            <div class="fw-semibold">${m.title}</div>
            <div class="small text-white-50"><i class="bi bi-clock me-1"></i>${m[tTime]}</div>
          </div>
          <button class="btn btn-outline-light btn-sm" aria-label="View details"><i class="bi bi-chevron-right"></i></button>
        </li>`).join('');

        list.querySelectorAll('.list-group-item').forEach((li)=>{
            li.onclick = ()=>{
                const id = li.getAttribute('data-id');
                const m = (matchesByMode[modeKey]||[]).find(x=>x.id===id);
                if(m) renderMatchDetails(m);
                list.querySelectorAll('.list-group-item').forEach(x=>x.classList.remove('active'));
                li.classList.add('active');
            };
        });
    }

    function renderMatchDetails(m){
        const details = document.getElementById('matchDetails');
        details.innerHTML = `
        <div class="card card-dark">
          <div class="card-body">
            <h6 class="card-title mb-2">${m.title}</h6>
            <div class="row g-2 small">
              <div class="col-6"><span class="text-white-50">Time:</span> ${activeLang==='bn'?m.timeBn:m.timeEn}</div>
              <div class="col-6"><span class="text-white-50">Type:</span> ${m.type}</div>
              <div class="col-6"><span class="text-white-50">Map:</span> ${m.map}</div>
              <div class="col-6"><span class="text-white-50">Slots:</span> ${m.slots}</div>
              <div class="col-6"><span class="text-white-50">Entry:</span> ${m.entry}</div>
              <div class="col-6"><span class="text-white-50">Prize:</span> ${m.prize}</div>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="#contact" class="btn btn-accent btn-pill"><i class="bi bi-rocket-takeoff me-2"></i>Join</a>
              <button class="btn btn-ghost btn-pill" onclick="navigator.clipboard.writeText('${m.title} — ${m.type}');"><i class="bi bi-share me-2"></i>Share</button>
            </div>
          </div>
        </div>`;
    }

    // Settings controls
    const primaryEl = document.getElementById('primaryColor');
    const fontSel = document.getElementById('fontSelect');
    const bgInput = document.getElementById('bgInput');
    document.getElementById('langBn').onclick = ()=>applyLang('bn');
    document.getElementById('langEn').onclick = ()=>applyLang('en');
    document.getElementById('applyBtn').onclick = ()=>{
        if(primaryEl.value){
            document.documentElement.style.setProperty('--accent', primaryEl.value);
            document.documentElement.style.setProperty('--accent-soft', primaryEl.value + '22');
        }
        document.body.classList.toggle('en', fontSel.value==='en');
        document.body.classList.toggle('bn', fontSel.value==='bn');
        const hero = document.getElementById('home');
        const url = bgInput.value.trim();
        hero.style.backgroundImage = url ? `url('${url}')` : '';
    };

    // Init
    applyLang('bn');
    renderModes();
    renderMatchList(activeModeKey);
</script>
</body>
</html>
