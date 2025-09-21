<!DOCTYPE html>
<html lang="bn" data-lang="bn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{config('app.name')}}</title>
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
    </style>
</head>
<body class="bn">
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top border-bottom border-secondary-subtle">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#home"><i class="bi bi-controller me-2"></i><span data-i18n="brand">{{config('app.name')}}</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#home" data-i18n="nav.home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about" data-i18n="nav.about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#matches" data-i18n="nav.matches">Match</a></li>
                <li class="nav-item"><a class="nav-link" href="#download" data-i18n="nav.download">Download</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact" data-i18n="nav.contact">Contact Us</a></li>
                <li class="nav-item"><a
                    href="{{ route('login') }}"
                    class="nav-link"
                >
                    Log in
                </a>
                </li>
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
                <span class="badge rounded-pill badge-pill px-3 py-2 mb-3"><small data-i18n="badge">{{config('app.name')}} রিওয়ার্ডস</small></span>
                <h1 class="display-5" data-i18n="hero.title">আপনি কি একজন {{config('app.name')}} প্লেয়ার?</h1>
                <p class="hero-sub fs-5" data-i18n="hero.sub">গেম খেলে আপনি জিতলে নিতে পারবেন প্রতিদিন ১০০০‑২০০০ টাকা পর্যন্ত রিওয়ার্ড। আজই শুরু করুন!</p>
                <div class="d-flex flex-wrap gap-3 pt-2">
                    <a href="#video" class="btn btn-ghost btn-pill" data-i18n="hero.watch"><i class="bi bi-play-circle me-2"></i>ভিডিও দেখুন</a>
                    <a href="#download" class="btn btn-accent btn-pill" data-i18n="hero.download"><i class="bi bi-download me-2"></i>অ্যাপটি ডাউনলোড করুন</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="glass-card p-4 p-lg-5 text-center">
                    <div class="display-6 mb-2">🎮</div>
                    <h5 class="mb-2" data-i18n="hero.card.title">দ্রুত সাইন‑আপ</h5>
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
                <img class="img-fluid rounded-4 border border-1 border-secondary-subtle" alt="About" src="https://images.unsplash.com/photo-1603484477859-abe6a73f9365?q=80&w=1400&auto=format&fit=crop"/>
            </div>
            <div class="col-lg-6">
                <h2 class="section-title" data-i18n="about.title">আমাদের সম্পর্কে</h2>
                <p class="section-lead" data-i18n="about.lead">আমরা বাংলাদেশে কমিউনিটি‑ড্রিভেন ই‑স্পোর্টস টুর্নামেন্ট আয়োজন করি যেখানে প্রতিদিনের ম্যাচ থেকে উইকেন্ড চ্যাম্পিয়নশিপ পর্যন্ত সবই রয়েছে। নিরাপদ পেমেন্ট ও ২৪/৭ সাপোর্ট আমাদের বৈশিষ্ট্য।</p>
                <div class="row g-3 pt-2">
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">🏆</div><div class="fw-semibold" data-i18n="about.i1">ডেইলি উইনস</div></div></div>
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">💳</div><div class="fw-semibold" data-i18n="about.i2">ইনস্ট্যান্ট পেআউটস</div></div></div>
                    <div class="col-6 col-md-4"><div class="glass-card p-3 h-100 text-center"><div class="fs-3">🛡</div><div class="fw-semibold" data-i18n="about.i3">ফেয়ার প্লে</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MATCHES: simple labels only -->
<section id="matches">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Match</h2>
            <p class="section-lead mx-auto">শুধু মোড অনুযায়ী ব্রাউজ করুন—সময়/তারিখ ছাড়া।</p>
        </div>
        <div id="matchesGrid" class="row g-4"></div>
        <div id="categoryMatches" class="row mt-4"></div>
    </div>
</section>

<!-- DOWNLOAD -->
<section id="download">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h2 class="section-title" data-i18n="download.title">Download</h2>
                <p class="section-lead" data-i18n="download.lead">Android ও iOS‑এ অ্যাপ ডাউনলোড করে ম্যাচ ব্রাউজ, রেজিস্টার ও রিওয়ার্ড ট্র্যাক করুন।</p>
                <div class="d-flex flex-wrap gap-3 pt-2">
                    <a class="btn btn-accent btn-pill" href="#"><i class="bi bi-android2 me-2"></i><span data-i18n="download.android">অ্যান্ড্রয়েড অ্যাপ</span></a>
                    <a class="btn btn-ghost btn-pill" href="#"><i class="bi bi-apple me-2"></i><span data-i18n="download.ios">iOS অ্যাপ</span></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-4 p-lg-5">
                    <h5 class="mb-2" data-i18n="download.why">কেন অ্যাপ?</h5>
                    <ul class="mb-0">
                        <li class="mb-2" data-i18n="download.li1">রিয়েল‑টাইম নোটিফিকেশন</li>
                        <li class="mb-2" data-i18n="download.li2">সিকিউর ইন‑অ্যাপ পেমেন্ট</li>
                        <li data-i18n="download.li3">ওয়ান‑ট্যাপ রেজিস্ট্রেশন</li>
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
                <p class="section-lead" data-i18n="contact.lead">যেকোনো প্রশ্ন বা পার্টনারশিপের জন্য আমাদেরকে লিখুন।</p>
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
        <div class="small">© <span id="y"></span> <span data-i18n="brand">{{config('app.name')}}</span>. <span data-i18n="footer.rights">সর্বস্বত্ব সংরক্ষিত।</span></div>
        <div class="d-flex gap-3">
            <a class="link-muted small" href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" data-i18n="footer.privacy">প্রাইভেসি পলিসি</a>
            <a class="link-muted small" href="#" data-bs-toggle="modal" data-bs-target="#termsModal" data-i18n="footer.terms">টার্মস ও কন্ডিশনস</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Year
    document.getElementById('y').textContent = new Date().getFullYear();

    // Active link on scroll
    const sections = ['home','about','matches','download','contact'];
    const links = sections.map(id => [id, document.querySelector(.nav-link[href="#${id}"])]);
    const opts = {root:null, rootMargin:'-50% 0px -50% 0px', threshold:0};
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if(e.isIntersecting){
                links.forEach(([id, el]) => el.classList.toggle('active', #${id} === #${e.target.id}));
            }
        });
    }, opts);
    sections.forEach(id => io.observe(document.getElementById(id)));

    // i18n packs (keep both for future EN toggle)
    const i18n = {
        bn: {
            brand:'{{config('app.name')}}',
            'nav.home':'Home','nav.about':'About Us','nav.matches':'Match','nav.contact':'Contact Us','nav.download':'Download',
            badge:'{{config('app.name')}} রিওয়ার্ডস',
            'hero.title':'আপনি কি একজন {{config('app.name')}} প্লেয়ার?','hero.sub':'গেম খেলে আপনি জিতলে নিতে পারবেন প্রতিদিন ১০০০‑২০০০ টাকা পর্যন্ত রিওয়ার্ড। আজই শুরু করুন!',
            'hero.watch':'ভিডিও দেখুন','hero.download':'অ্যাপটি ডাউনলোড করুন','hero.card.title':'দ্রুত সাইন‑আপ','hero.card.text':'২ মিনিটে অ্যাকাউন্ট তৈরি করুন, ম্যাচে যোগ দিন এবং পুরস্কার জিতুন।','hero.card.cta':'এখনই শুরু করুন',
            'about.title':'আমাদের সম্পর্কে','about.lead':'আমরা বাংলাদেশে কমিউনিটি‑ড্রিভেন ই‑স্পোর্টস টুর্নামেন্ট আয়োজন করি যেখানে প্রতিদিনের ম্যাচ থেকে উইকেন্ড চ্যাম্পিয়নশিপ পর্যন্ত সবই রয়েছে। নিরাপদ পেমেন্ট ও ২৪/৭ সাপোর্ট আমাদের বৈশিষ্ট্য।','about.i1':'ডেইলি উইনস','about.i2':'ইনস্ট্যান্ট পেআউটস','about.i3':'ফেয়ার প্লে',
            'matches.title':'Match','matches.lead':'শুধু মোড অনুযায়ী ব্রাউজ করুন—সময়/তারিখ ছাড়া।',
            'download.title':'Download','download.lead':'Android ও iOS‑এ অ্যাপ ডাউনলোড করে ম্যাচ ব্রাউজ, রেজিস্টার ও রিওয়ার্ড ট্র্যাক করুন।','download.android':'অ্যান্ড্রয়েড অ্যাপ','download.ios':'iOS অ্যাপ','download.why':'কেন অ্যাপ?','download.li1':'রিয়েল‑টাইম নোটিফিকেশন','download.li2':'সিকিউর ইন‑অ্যাপ পেমেন্ট','download.li3':'ওয়ান‑ট্যাপ রেজিস্ট্রেশন',
            'contact.title':'Contact Us','contact.lead':'যেকোনো প্রশ্ন বা পার্টনারশিপের জন্য আমাদেরকে লিখুন।','contact.name':'আপনার নাম','contact.email':'ইমেইল','contact.message':'মেসেজ','contact.send':'বার্তা পাঠান','contact.reach':'Reach us','contact.follow':'Follow',
            'footer.rights':'সর্বস্বত্ব সংরক্ষিত।','footer.privacy':'প্রাইভেসি পলিসি','footer.terms':'টার্মস ও কন্ডিশনস',
            'policy.text':'এটি ডেমো প্রাইভেসি পলিসি। আপনার প্রকৃত নীতিমালা এখানে যুক্ত করুন।',
            'terms.text':'এগুলি ডেমো শর্তাবলী। খেলাসহ অংশগ্রহণ ও পেআউটের নিয়ম এখানে সংযোজন করুন।',
            'common.close':'বন্ধ করুন'
        },
        en: {
            brand:'{{config('app.name')}}',
            'nav.home':'Home','nav.about':'About Us','nav.matches':'Match','nav.contact':'Contact Us','nav.download':'Download',
            badge:'{{config('app.name')}} Rewards',
            'hero.title':'Are you a {{config('app.name')}} player?','hero.sub':'Win rewards worth ৳1000‑2000 daily by playing matches. Get started today!',
            'hero.watch':'Watch Video','hero.download':'Download the App','hero.card.title':'Quick Sign‑Up','hero.card.text':'Create your account in 2 minutes, join matches and win rewards.','hero.card.cta':'Start Now',
            'about.title':'About Us','about.lead':'We host community‑driven esports tournaments in Bangladesh — from daily matches to weekend championships — with secure payments and 24/7 support.','about.i1':'Daily Wins','about.i2':'Instant Payouts','about.i3':'Fair Play',
            'matches.title':'Match','matches.lead':'Browse by mode only—no dates/times.',
            'download.title':'Download','download.lead':'Get our official Android & iOS apps to browse matches, register, and track rewards.','download.android':'Get it on Android','download.ios':'Download on iOS','download.why':'Why the app?','download.li1':'Real‑time notifications','download.li2':'Secure in‑app payments','download.li3':'One‑tap registration',
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
        renderMatches();
    }

    // Simple match labels only
    const matchLabels = [
        {bn:'BR Match', en:'BR Match'},
        {bn:'Rank Match', en:'Rank Match'},
        {bn:'Clash Squad', en:'Clash Squad'},
        {bn:'Deathmatch', en:'Deathmatch'},
        {bn:'Knockout', en:'Knockout'}
    ];
    function renderMatches() {
        const grid = document.getElementById('matchesGrid');
        const t = activeLang === 'bn' ? 'bn' : 'en';

        grid.innerHTML = matchLabels.map(m => `
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-dark text-center p-4 h-100 category-card" data-key="${m.key}">
                <div class="fw-bold">${m[t]}</div>
            </div>
        </div>
    `).join('');

        // Add click events after rendering
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', () => {
                const category = card.getAttribute('data-key');
                fetchCategoryMatches(category);
            });
        });
    }

    // Fetch matches for the clicked category
    function fetchCategoryMatches(category) {
        fetch(`/matches?category=${category}`)
            .then(res => res.json())
            .then(data => {
                renderCategoryMatches(data);
            })
            .catch(err => console.error('Error fetching matches:', err));
    }

    // Render matches under the labels
    function renderCategoryMatches(matches) {
        const container = document.getElementById('categoryMatches');
        container.innerHTML = matches.map(m => `
        <div class="col-12 col-md-6">
            <div class="card p-3 mb-3">
                <h5>${m.title}</h5>
                <p>${m.description || ''}</p>
            </div>
        </div>
    `).join('');
    }

    document.addEventListener('DOMContentLoaded', renderMatches);

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
        hero.style.backgroundImage = url ? url('${url}') : '';
    };

    // Init
    applyLang('bn');
</script>
</body>
</html>
