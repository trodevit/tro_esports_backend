@extends('userLayouts.app')

@section('content')
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
                    <p class="hero-sub fs-5" data-i18n="hero.sub">গেম খেলে আপনি জিতলে নিতে পারবেন প্রতিদিন ১০০০-২০০০
                        টাকা পর্যন্ত রিওয়ার্ড। আজই শুরু করুন!</p>
                    <div class="d-flex flex-wrap gap-3 pt-2">
                        <a href="#video" class="btn btn-ghost btn-pill" data-i18n="hero.watch"><i
                                class="bi bi-play-circle me-2"></i>ভিডিও দেখুন</a>
                        <a href="{{route('download-apk')}}" class="btn btn-accent btn-pill" data-i18n="hero.download"><i
                                class="bi bi-download me-2"></i>অ্যাপটি ডাউনলোড করুন</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="glass-card p-4 p-lg-5 text-center">
                        <div class="display-6 mb-2">🎮</div>
                        <h5 class="mb-2" data-i18n="hero.card.title">দ্রুত সাইন-আপ</h5>
                        <p class="mb-3" data-i18n="hero.card.text">২ মিনিটে অ্যাকাউন্ট তৈরি করুন, ম্যাচে যোগ দিন এবং
                            পুরস্কার জিতুন।</p>
                        <a href="{{route('download-apk')}}" class="btn btn-accent w-100 btn-pill"
                           data-i18n="hero.card.cta">এখনই শুরু করুন</a>
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
                    <img class="img-fluid rounded-4 border border-1 border-secondary-subtle" alt="About"
                         src="{{asset('TroSports.jpg')}}"/>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title" data-i18n="about.title">আমাদের সম্পর্কে</h2>
                    <p class="section-lead" data-i18n="about.lead">আমরা বাংলাদেশে কমিউনিটি-ড্রিভেন ই-স্পোর্টস
                        টুর্নামেন্ট আয়োজন করি যেখানে প্রতিদিনের ম্যাচ থেকে উইকেন্ড চ্যাম্পিয়নশিপ পর্যন্ত সবই রয়েছে।
                        নিরাপদ পেমেন্ট ও ২৪/৭ সাপোর্ট আমাদের বৈশিষ্ট্য।</p>
                    <div class="row g-3 pt-2">
                        <div class="col-6 col-md-4">
                            <div class="glass-card p-3 h-100 text-center">
                                <div class="fs-3">🏆</div>
                                <div class="fw-semibold" data-i18n="about.i1">ডেইলি উইনস</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="glass-card p-3 h-100 text-center">
                                <div class="fs-3">💳</div>
                                <div class="fw-semibold" data-i18n="about.i2">ইনস্ট্যান্ট পেআউটস</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="glass-card p-3 h-100 text-center">
                                <div class="fs-3">🛡️</div>
                                <div class="fw-semibold" data-i18n="about.i3">ফেয়ার প্লে</div>
                            </div>
                        </div>
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
                <p class="section-lead mx-auto" data-i18n="matches.lead">যে মোডে খেলবেন সেটিতে ক্লিক করুন—নিচে ম্যাচ
                    লিস্ট ও সময় দেখাবে। যে কোনো ম্যাচে ক্লিক করলে বিস্তারিত আসবে।</p>
            </div>

            <!-- Mode chips -->
            <div id="modesGrid" class="row g-3 mb-4">
                <!-- injected by JS -->
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="glass-card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i><span id="listTitle">Match List</span>
                            </h5>
                            <span class="badge bg-danger-subtle text-white" id="activeModeLabel">BR Match</span>
                        </div>
                        <div class="list-hover">
                            <ul class="list-group list-group-flush" id="matchList">
                                <!-- list populated via JS -->
                            </ul>
                        </div>
                        <div class="small text-white-50 mt-2" id="emptyNotice" style="display:none;">এই মোডে এখনো কোনো
                            ম্যাচ নেই।
                        </div>
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
                    <p class="section-lead" data-i18n="download.lead">Android ও iOS-এ অ্যাপ ডাউনলোড করে ম্যাচ ব্রাউজ,
                        রেজিস্টার ও রিওয়ার্ড ট্র্যাক করুন।</p>
                    <div class="d-flex flex-wrap gap-3 pt-2">
                        <a class="btn btn-accent btn-pill" href="{{route('download-apk')}}"><i
                                class="bi bi-android2 me-2"></i><span
                                data-i18n="download.android">অ্যান্ড্রয়েড অ্যাপ</span></a>
                        <a class="btn btn-ghost btn-pill" href="#"><i class="bi bi-apple me-2"></i><span
                                data-i18n="download.ios">iOS অ্যাপ</span></a>
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
                    <p class="section-lead" data-i18n="contact.lead">যেকোনো তথ্য বা পার্টনারশিপের জন্য আমাদেরকে
                        লিখুন।</p>
                    <div class="glass-card p-4">
                        <form action="{{route('contact')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" data-i18n="contact.name">আপনার নাম</label>
                                <input type="text" class="form-control bg-transparent text-white border-light"
                                       name="name" placeholder="e.g. Alex Ahmed" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" data-i18n="contact.email">ইমেইল</label>
                                <input type="email" class="form-control bg-transparent text-white border-light"
                                       name="email" placeholder="you@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" data-i18n="contact.message">মেসেজ</label>
                                <textarea class="form-control bg-transparent text-white border-light" rows="4"
                                          name="msg" placeholder="Tell us how we can help" required></textarea>
                            </div>
                            <button class="btn btn-accent btn-pill" type="submit"><i class="bi bi-send me-2"></i><span
                                    data-i18n="contact.send">বার্তা পাঠান</span></button>
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

    @php
        use Carbon\Carbon;

        /**
         * Exact mode keys (match your <option value="...">)
         * Keep labels (bn/en) for UI chips and pick an icon name from Bootstrap Icons
         */
        $modeMeta = [
            'br_match'     => ['labelBn' => 'BR Match',      'labelEn' => 'BR Match',      'icon' => 'joystick'],
            'br_servival'  => ['labelBn' => 'BR Survival',   'labelEn' => 'BR Survival',   'icon' => 'heart-pulse'],
            'clash_squad'  => ['labelBn' => 'Clash Squad',   'labelEn' => 'Clash Squad',   'icon' => 'people'],
            'csv2'         => ['labelBn' => 'CS V2',         'labelEn' => 'CS V2',         'icon' => 'grid-3x3-gap'],
            'lone_wolf'    => ['labelBn' => 'Lone Wolf',     'labelEn' => 'Lone Wolf',     'icon' => 'person-walking'],
            'free_match'   => ['labelBn' => 'Free Match',    'labelEn' => 'Free Match',    'icon' => 'ticket'],
        ];

        /**
         * Normalize DB categories (old/new) -> the new slug keys above.
         * Add mappings here if you have more legacy strings in DB.
         */
        $legacyMap = [
            'BR Match'      => 'br_match',
            'BR Servival'   => 'br_servival',   // legacy typo
            'BR Survival'   => 'br_servival',
            'Class Squad'   => 'clash_squad',
            'Clash Squad'   => 'clash_squad',
            'CS V2'         => 'csv2',
            'Lone Wolf'     => 'lone_wolf',
            'Free Match'    => 'free_match',
        ];

        $norm = function ($cat) use ($legacyMap, $modeMeta) {
            // if it's already one of the slug keys:
            if (isset($modeMeta[$cat])) return $cat;
            // map legacy -> slug if known:
            if (isset($legacyMap[$cat])) return $legacyMap[$cat];
            // fallback: default to BR Match bucket
            return 'br_match';
        };

        /**
         * Group matches by normalized category slug.
         * DO NOT include sensitive fields (e.g., room_details).
         */
        $grouped = $matches->groupBy(function ($m) use ($norm) {
            return $norm($m->category);
        })->map(function ($items) {
            return $items->map(function ($m) {
                $dt = Carbon::parse("{$m->match_date} {$m->match_time}", 'Asia/Dhaka');

                try { $timeBn = $dt->locale('bn')->isoFormat('LL, h:mm A'); }
                catch (\Throwable $e) { $timeBn = $dt->format('d-m-Y, h:i A'); }

                $timeEn = $dt->locale('en')->translatedFormat('M d, Y g:i A');

                return [
                    'id'     => (string) $m->id,
                    'title'  => $m->match_name,
                    'timeBn' => $timeBn,
                    'timeEn' => $timeEn,
                    'map'    => $m->map_type,
                    'type'   => $m->match_type,
                    'slots'  => "0/{$m->player_limit}", // replace 0 with joined count if available
                    'entry'  => '৳' . (int) $m->entry_fee,
                    'prize'  => '৳' . (int) $m->grand_prize,
                ];
            })->values();
        });

        /** Build modes array for JS */
        $modesForJs = collect($modeMeta)->map(function ($v, $k) {
            return array_merge(['key' => $k], $v);
        })->values();
    @endphp

    <script>
        const modes = {!! $modesForJs->toJson(JSON_UNESCAPED_UNICODE) !!};
        const matchesByMode = {!! $grouped->toJson(JSON_UNESCAPED_UNICODE) !!};
    </script>

@endsection
