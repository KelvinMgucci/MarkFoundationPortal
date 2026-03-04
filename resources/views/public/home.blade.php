@extends('layouts.public')
@section('title', 'Mark Foundation — Transforming Lives')

@push('styles')
    <style>
        /* ═══ CAROUSEL ══════════════════════════════════════════════════════════ */
        .carousel {
            position: relative;
            overflow: hidden;
            background: var(--black);
        }

        .carousel__track {
            display: flex;
            transition: transform .8s cubic-bezier(.4, 0, .2, 1);
        }

        .c-slide {
            min-width: 100%;
            position: relative;
            height: 88vh;
            max-height: 680px;
            min-height: 500px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .c-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: brightness(.38);
            transition: transform 10s ease;
        }

        .c-slide.active .c-bg {
            transform: scale(1.06);
        }

        .c-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(13, 17, 9, .82) 0%, rgba(13, 17, 9, .05) 100%);
        }

        .c-inner {
            position: relative;
            z-index: 2;
            max-width: var(--max-w);
            margin: 0 auto;
            padding: 0 2rem;
            width: 100%;
        }

        .c-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--yellow);
            margin-bottom: 1.25rem;
            opacity: 0;
            transform: translateY(16px);
            transition: all .7s .2s;
        }

        .c-slide.active .c-eyebrow {
            opacity: 1;
            transform: translateY(0);
        }

        .c-eyebrow::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--yellow);
            flex-shrink: 0;
        }

        .c-inner h1 {
            font-size: clamp(2.2rem, 5.5vw, 4rem);
            color: #fff;
            line-height: 1.08;
            margin-bottom: 1.25rem;
            max-width: 660px;
            text-shadow: 0 4px 28px rgba(0, 0, 0, .35);
            opacity: 0;
            transform: translateY(20px);
            transition: all .75s .35s;
        }

        .c-slide.active h1 {
            opacity: 1;
            transform: translateY(0);
        }

        .c-inner p {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, .72);
            max-width: 520px;
            margin-bottom: 2rem;
            line-height: 1.8;
            opacity: 0;
            transform: translateY(16px);
            transition: all .7s .5s;
        }

        .c-slide.active p {
            opacity: 1;
            transform: translateY(0);
        }

        .c-actions {
            display: flex;
            gap: .875rem;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(12px);
            transition: all .65s .65s;
        }

        .c-slide.active .c-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .c-dots {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: .5rem;
            z-index: 10;
        }

        .c-dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .3);
            border: none;
            cursor: pointer;
            transition: all .35s;
            padding: 0;
        }

        .c-dot.active {
            background: var(--yellow);
            width: 28px;
        }

        .c-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, .2);
            color: #fff;
            cursor: pointer;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            z-index: 10;
        }

        .c-btn:hover {
            background: var(--green);
            border-color: var(--green);
        }

        .c-btn--prev {
            left: 1.5rem;
        }

        .c-btn--next {
            right: 1.5rem;
        }

        /* ═══ STATS BAR ═════════════════════════════════════════════════════════ */
        .stats-bar { background: var(--green); padding: 1.625rem 0; }
        .stats-bar__inner { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1.25rem; }
        .stat-item { text-align: center; color: #fff; }
        .stat-item__icon { font-size: 1.5rem; margin-bottom: .25rem; }
        .stat-item__num { font-family: var(--font-head); font-size: 2.2rem; font-weight: 700; color: var(--yellow); line-height: 1; }
        .stat-item__lbl { font-size: .77rem; opacity: .82; margin-top: .3rem; }

        /* ═══ ABOUT ══════════════════════════════════════════════════════════════ */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        @media(max-width:820px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }

        .about-visual {
            position: relative;
            height: 420px;
        }

        .about-main-box {
            position: absolute;
            inset: 0 50px 50px 0;
            background: linear-gradient(135deg, var(--green-dk) 0%, var(--green) 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            box-shadow: var(--shadow-lg);
        }

        .about-accent-box {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: var(--yellow);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            box-shadow: 0 8px 32px rgba(245, 197, 24, .35);
        }

        .about-float {
            position: absolute;
            top: 1.5rem;
            left: -1rem;
            background: #fff;
            border-radius: var(--radius-lg);
            padding: .875rem 1.25rem;
            box-shadow: var(--shadow-lg);
            font-size: .8rem;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: .5rem;
            border: 1px solid var(--border);
        }

        @media(max-width:820px) {
            .about-visual {
                height: 300px;
            }

            .about-float {
                display: none;
            }
        }

        .about-text h2 {
            font-size: clamp(1.9rem, 3.5vw, 2.6rem);
            margin-bottom: 1.1rem;
        }

        .about-text p {
            color: var(--ink-3);
            line-height: 1.9;
            margin-bottom: .875rem;
            font-size: .94rem;
        }

        .about-motto {
            font-family: var(--font-head);
            font-style: italic;
            font-size: 1.25rem;
            color: var(--green-dk);
            border-left: 3px solid var(--yellow);
            padding-left: 1rem;
            margin: 1.25rem 0;
            line-height: 1.5;
        }

        .values-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-top: 1.25rem;
        }

        .v-tag {
            font-size: .77rem;
            font-weight: 600;
            padding: .3rem .9rem;
            border-radius: 99px;
            background: var(--green-lt);
            color: var(--green-dk);
            border: 1px solid var(--border-dk);
        }

        /* ── ABOUT ACCORDION ── */
        .about-accordion { margin: 1.25rem 0; display: flex; flex-direction: column; gap: .5rem; }
        .acc-item { border: 1px solid var(--border-dk); border-radius: var(--radius-lg); overflow: hidden; background: var(--white); }
        .acc-btn { width: 100%; display: flex; align-items: center; gap: .75rem; padding: .875rem 1.125rem; background: none; border: none; cursor: pointer; font-family: var(--font-body); font-size: .92rem; font-weight: 600; color: var(--ink); text-align: left; transition: background .2s; }
        .acc-btn:hover { background: var(--green-xlt); }
        .acc-item.open .acc-btn { background: var(--green-lt); color: var(--green-dk); }
        .acc-icon { font-size: 1.1rem; flex-shrink: 0; }
        .acc-arrow { margin-left: auto; flex-shrink: 0; transition: transform .3s; color: var(--green); }
        .acc-item.open .acc-arrow { transform: rotate(180deg); }
        .acc-body { display: none; padding: 0 1.125rem 1rem; font-size: .9rem; color: var(--ink-3); line-height: 1.8; }
        .acc-item.open .acc-body { display: block; }


        .programs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.375rem;
        }

        @media(max-width:960px) {
            .programs-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:560px) {
            .programs-grid {
                grid-template-columns: 1fr;
            }
        }

        .prog-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.875rem;
            position: relative;
            overflow: hidden;
            transition: all .25s;
        }

        .prog-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green), var(--yellow));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s;
        }

        .prog-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .prog-card:hover::after {
            transform: scaleX(1);
        }

        .prog-card__num {
            font-family: var(--font-head);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--green-lt);
            line-height: 1;
            margin-bottom: .5rem;
        }

        .prog-card__icon {
            font-size: 1.875rem;
            margin-bottom: .875rem;
        }

        .prog-card h3 {
            font-size: 1.05rem;
            margin-bottom: .875rem;
            color: var(--ink);
        }

        .prog-card ul {
            font-size: .855rem;
            color: var(--ink-3);
            line-height: 1.85;
            padding-left: 1.125rem;
        }

        .prog-card ul li {
            margin-bottom: .25rem;
        }

        .prog-card--cta {
            background: linear-gradient(140deg, var(--green-dk), var(--green));
            border-color: transparent;
            color: #fff;
        }

        .prog-card--cta h3 {
            color: #fff;
        }

        .prog-card--cta p {
            color: rgba(255, 255, 255, .8);
            font-size: .88rem;
            line-height: 1.75;
        }

        .prog-card--cta .prog-card__icon {
            opacity: .9;
        }

        /* ═══ TEAM ════════════════════════════════════════════════════════════════ */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.375rem;
        }

        @media(max-width:960px) {
            .team-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:560px) {
            .team-grid {
                grid-template-columns: 1fr;
            }
        }

        .team-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all .22s;
        }

        .team-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
        }

        .team-card__top {
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            position: relative;
        }

        .team-card__top--founder {
            background: linear-gradient(135deg, var(--green-dk), var(--green));
        }

        .team-card__top--open {
            background: linear-gradient(135deg, #3b4835, #5a6a52);
        }

        .team-card__body {
            padding: 1.5rem;
        }

        .team-card__role {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: .35rem;
        }

        .team-card h3 {
            font-size: 1.05rem;
            margin-bottom: .6rem;
            color: var(--ink);
        }

        .team-card h3.open {
            color: var(--ink-3);
        }

        .team-card p {
            font-size: .845rem;
            color: var(--ink-3);
            line-height: 1.75;
        }

        .team-card__contact {
            margin-top: 1rem;
            padding-top: .875rem;
            border-top: 1px solid var(--border);
            font-size: .8rem;
            color: var(--ink-3);
            display: flex;
            flex-direction: column;
            gap: .25rem;
        }

        .team-card__contact a {
            color: var(--green);
            text-decoration: none;
        }

        .team-card__contact a:hover {
            text-decoration: underline;
        }

        .team-card--open {
            opacity: .85;
        }

        /* ═══ EVENTS ══════════════════════════════════════════════════════════════ */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.375rem;
        }

        @media(max-width:900px) {
            .events-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:560px) {
            .events-grid {
                grid-template-columns: 1fr;
            }
        }

        .event-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all .22s;
        }

        .event-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--green);
        }

        .event-card__img {
            height: 180px;
            background: linear-gradient(135deg, var(--green-dk), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .event-card__img img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-card__badge {
            position: absolute;
            top: .75rem;
            left: .75rem;
            background: var(--yellow);
            color: var(--black);
            border-radius: var(--radius);
            padding: .25rem .65rem;
            font-size: .73rem;
            font-weight: 700;
            z-index: 1;
        }

        .event-card__body {
            padding: 1.25rem;
        }

        .event-card__body h3 {
            font-size: .98rem;
            font-weight: 600;
            margin-bottom: .4rem;
            line-height: 1.35;
        }

        .event-card__body p {
            font-size: .84rem;
            color: var(--ink-3);
            line-height: 1.65;
        }

        .event-card__meta {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
            margin-top: .625rem;
        }

        /* ═══ GALLERY PREVIEW ════════════════════════════════════════════════════ */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: .875rem;
        }

        @media(max-width:900px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:560px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gthumb {
            aspect-ratio: 1;
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--green-lt);
            position: relative;
            cursor: pointer;
            display: block;
        }

        .gthumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .45s;
        }

        .gthumb:hover img {
            transform: scale(1.1);
        }

        .gthumb__over {
            position: absolute;
            inset: 0;
            background: rgba(13, 17, 9, .4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .3s;
            font-size: 1.5rem;
            color: #fff;
        }

        .gthumb:hover .gthumb__over {
            opacity: 1;
        }

        .gthumb--video {
            background: #111;
        }

        .gthumb--video .play-ic {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            color: rgba(255, 255, 255, .85);
        }

        /* ═══ IMPACT ═════════════════════════════════════════════════════════════ */
        .impact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        @media(max-width:900px) {
            .impact-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .impact-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .impact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green), var(--yellow));
        }

        .impact-card__icon {
            font-size: 2rem;
            margin-bottom: .875rem;
        }

        .impact-card__num {
            font-family: var(--font-head);
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--green);
            line-height: 1;
            margin-bottom: .375rem;
        }

        .impact-card__lbl {
            font-size: .82rem;
            color: var(--ink-3);
            line-height: 1.55;
        }

        /* ═══ TESTIMONIALS ═══════════════════════════════════════════════════════ */
        .testi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media(max-width:640px) {
            .testi-grid {
                grid-template-columns: 1fr;
            }
        }

        .tcard {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem 2rem 1.75rem;
            position: relative;
        }

        .tcard::before {
            content: '\201C';
            font-family: var(--font-head);
            font-size: 6rem;
            color: var(--green-lt);
            position: absolute;
            top: -.25rem;
            left: 1.5rem;
            line-height: 1;
            pointer-events: none;
        }

        .tcard p {
            font-family: var(--font-head);
            font-size: 1.15rem;
            font-style: italic;
            color: var(--ink-2);
            line-height: 1.75;
            margin-bottom: 1.25rem;
            padding-top: 1rem;
            position: relative;
        }

        .tcard__author {
            font-size: .82rem;
            font-weight: 600;
            color: var(--green-dk);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .tcard__author::before {
            content: '—';
        }

        /* ═══ FAQ ═════════════════════════════════════════════════════════════════ */
        .faq-wrap {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            background: var(--white);
            margin-bottom: .75rem;
            overflow: hidden;
        }

        .faq-q {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            font-size: .93rem;
            gap: 1rem;
            color: var(--ink);
        }

        .faq-q:hover {
            background: var(--green-xlt);
        }

        .faq-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
            transition: transform .3s;
            color: var(--green);
            font-weight: 300;
        }

        .faq-item.open .faq-icon {
            transform: rotate(45deg);
        }

        .faq-a {
            display: none;
            padding: 0 1.5rem 1.2rem;
            font-size: .88rem;
            color: var(--ink-3);
            line-height: 1.85;
        }

        .faq-item.open .faq-a {
            display: block;
        }

        /* ═══ PARTNERS ═══════════════════════════════════════════════════════════ */
        .partners-row {
            display: flex;
            gap: .875rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .p-badge {
            padding: .75rem 1.625rem;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            font-size: .84rem;
            font-weight: 600;
            color: var(--ink-2);
            transition: all .2s;
        }

        .p-badge:hover {
            border-color: var(--green);
            color: var(--green);
            background: var(--green-xlt);
        }

        /* ═══ CTA BAND ═══════════════════════════════════════════════════════════ */
        .cta-band {
            background: linear-gradient(135deg, var(--green-dk) 0%, var(--green) 60%, #259450 100%);
            border-radius: var(--radius-xl);
            padding: 4rem 2.5rem;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .cta-band::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(245, 197, 24, .08);
        }

        .cta-band::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(245, 197, 24, .06);
        }

        .cta-band h2 {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            margin-bottom: .875rem;
            position: relative;
            z-index: 1;
        }

        .cta-band p {
            opacity: .8;
            margin-bottom: 2.25rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 1;
            line-height: 1.8;
        }

        .cta-band__btns {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        /* ═══ CAREERS CTA ════════════════════════════════════════════════════════ */
        .careers-cta {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .careers-cta h3 {
            font-size: 1.5rem;
            margin-bottom: .4rem;
        }

        .careers-cta p {
            color: var(--ink-3);
            font-size: .9rem;
            max-width: 480px;
        }
    </style>
@endpush

@section('content')

    {{-- ═══ CAROUSEL ══════════════════════════════════════════════════════════ --}}
    <section class="carousel" aria-label="Hero slideshow">
        <div class="carousel__track" id="cTrack">

            <div class="c-slide active">
                <div class="c-bg" style="background-image:url('{{ asset('images/slide1.jpg') }}')"></div>
                <div class="c-overlay"></div>
                <div class="c-inner">
                    <div class="c-eyebrow">Our Mission</div>
                    <h1>Transforming Lives, One Community at a Time</h1>
                    <p>Empowering vulnerable families, supporting education, and advancing healthcare across Tanzania.</p>
                    <div class="c-actions">
                        <a href="#get-involved" class="btn btn-yellow" style="font-size:.95rem;padding:.85rem 1.875rem;">💛
                            Donate Now</a>
                        <a href="#about" class="btn btn-ghost" style="font-size:.95rem;padding:.85rem 1.875rem;">Learn
                            More</a>
                    </div>
                </div>
            </div>

            <div class="c-slide">
                <div class="c-bg" style="background-image:url('{{ asset('images/slide2.jpg') }}')"></div>
                <div class="c-overlay"></div>
                <div class="c-inner">
                    <div class="c-eyebrow">Education Support</div>
                    <h1>500+ Students Reached Across Manyara Schools</h1>
                    <p>Career guidance, psychosocial support, GBV prevention, life skills education, and counselling —
                        delivered directly in schools.</p>
                    <div class="c-actions">
                        <a href="#programs" class="btn btn-yellow" style="font-size:.95rem;padding:.85rem 1.875rem;">Our
                            Programs</a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-ghost"
                            style="font-size:.95rem;padding:.85rem 1.875rem;">Join Our Team</a>
                    </div>
                </div>
            </div>

            <div class="c-slide">
                <div class="c-bg" style="background-image:url('{{ asset('images/slide4.jpg') }}')"></div>
                <div class="c-overlay"></div>
                <div class="c-inner">
                    <div class="c-eyebrow">Community Impact</div>
                    <h1>150+ Families Supported in Hanang' & Nearby Areas</h1>
                    <p>From food and hygiene kits to health insurance — we're on the ground making a real difference every
                        day.</p>
                    <div class="c-actions">
                        <a href="#impact" class="btn btn-yellow" style="font-size:.95rem;padding:.85rem 1.875rem;">Our
                            Impact</a>
                        <a href="{{ route('events.index') }}" class="btn btn-ghost"
                            style="font-size:.95rem;padding:.85rem 1.875rem;">Upcoming Events</a>
                    </div>
                </div>
            </div>

            <div class="c-slide">
                <div class="c-bg" style="background-image:url('{{ asset('images/slide5.jpg') }}')"></div>
                <div class="c-overlay"></div>
                <div class="c-inner">
                    <div class="c-eyebrow">Volunteer With Us</div>
                    <h1>Join Our Growing Team of Change-Makers</h1>
                    <p>Whether you donate, volunteer, or partner — every act of solidarity helps us reach the next family in
                        need.</p>
                    <div class="c-actions">
                        <a href="#get-involved" class="btn btn-yellow" style="font-size:.95rem;padding:.85rem 1.875rem;">🤝
                            Volunteer</a>
                        <a href="#get-involved" class="btn btn-ghost"
                            style="font-size:.95rem;padding:.85rem 1.875rem;">Partner With Us</a>
                    </div>
                </div>
            </div>

        </div>
        <button class="c-btn c-btn--prev" id="cPrev" aria-label="Previous">&#8592;</button>
        <button class="c-btn c-btn--next" id="cNext" aria-label="Next">&#8594;</button>
        <div class="c-dots" id="cDots"></div>
    </section>

    {{-- ═══ STATS BAR — animated counters from DB ══════════════════════════ --}}
    <div class="stats-bar">
        <div class="wrap stats-bar__inner">
            @forelse($stats as $stat)
            <div class="stat-item">
                <div class="stat-item__icon">{{ $stat->icon }}</div>
                <div class="stat-item__num counter" data-target="{{ $stat->value }}" data-suffix="{{ $stat->suffix }}">0</div>
                <div class="stat-item__lbl">{{ $stat->label }}</div>
            </div>
            @empty
            {{-- fallback hardcoded --}}
            @foreach([['150','Families Supported','🏠'],[' 500','Students Reached','📚'],['50','Health-Insured Families','🏥'],['40','Women Empowered','👩‍👧'],['10','PWDs Supported','♿']] as [$n,$l,$i])
            <div class="stat-item">
                <div class="stat-item__icon">{{ $i }}</div>
                <div class="stat-item__num">{{ $n }}+</div>
                <div class="stat-item__lbl">{{ $l }}</div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>

    {{-- ═══ ABOUT ════════════════════════════════════════════════════════════ --}}
    <section class="sec" id="about">
        <div class="wrap">
            <div class="about-grid">
                <div class="about-visual relative max-w-md mx-auto">
                    <img src="{{ asset('images/family.jpg') }}" alt="Mark Foundation Family Support"
                        class="w-full h-[400px] object-cover rounded-2xl shadow-2xl">
                    <div class="about-accent-box absolute bottom-[-15px] left-[-15px] bg-green-700 text-white p-4 rounded-xl shadow-lg">❤️</div>
                </div>
                <div class="about-text">
                    <div class="eyebrow" style="justify-content:flex-start;">Who We Are</div>
                    <h2>Serving the Most Vulnerable Across Tanzania</h2>
                    <p>Mark Foundation is a registered Tanzanian NGO committed to uplifting vulnerable communities through education, healthcare, and psychosocial support. Since our inception, we have reached marginalized groups such as orphans, widows, people with disabilities, and those affected by disasters.</p>

                    {{-- ── Accordion dropdowns for Mission / Vision / Motto ── --}}
                    <div class="about-accordion">

                        <div class="acc-item open">
                            <button class="acc-btn" onclick="toggleAcc(this)">
                                <span class="acc-icon">🎯</span>
                                <span>Our Mission</span>
                                <svg class="acc-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="acc-body">
                                <p>To empower communities in the fight against poverty, disease, and illiteracy, fostering sustainable social, economic, and cultural development.</p>
                            </div>
                        </div>

                        <div class="acc-item">
                            <button class="acc-btn" onclick="toggleAcc(this)">
                                <span class="acc-icon">🔭</span>
                                <span>Our Vision</span>
                                <svg class="acc-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="acc-body">
                                <p>To be a leading force in enhancing lives and creating lasting impact through humanitarian aid, education, healthcare, and community development initiatives.</p>
                            </div>
                        </div>

                        <div class="acc-item">
                            <button class="acc-btn" onclick="toggleAcc(this)">
                                <span class="acc-icon">💬</span>
                                <span>Our Motto</span>
                                <svg class="acc-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                            <div class="acc-body">
                                <p style="font-family:var(--font-head);font-style:italic;font-size:1.15rem;color:var(--green-dk);">"Hands on progress, shaping every life."</p>
                            </div>
                        </div>

                    </div>

                    <div class="values-wrap">
                        <span class="v-tag">Integrity</span>
                        <span class="v-tag">Inclusiveness</span>
                        <span class="v-tag">Accountability</span>
                        <span class="v-tag">Compassion</span>
                        <span class="v-tag">Innovation</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ PROGRAMS ══════════════════════════════════════════════════════════ --}}
    <section class="sec sec-alt" id="programs">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">What We Do</div>
                <h2>Our Programs</h2>
                <p>Five core pillars guiding all our work in the communities we serve.</p>
            </div>
            <div class="programs-grid">

                <div class="prog-card">
                    <div class="prog-card__num">01</div>
                    <div class="prog-card__icon">🏠</div>
                    <h3>Community Outreach &amp; Basic Needs Support</h3>
                    <ul>
                        <li>Food, hygiene kits &amp; clothing to 150+ vulnerable families in Hanang' and nearby areas</li>
                        <li>Health insurance coverage for 50+ families</li>
                        <li>School uniforms, books &amp; bags for children in need</li>
                    </ul>
                </div>

                <div class="prog-card">
                    <div class="prog-card__num">02</div>
                    <div class="prog-card__icon">📚</div>
                    <h3>Education Support &amp; School Outreach</h3>
                    <ul>
                        <li>Visited 3 schools, reached 500+ students</li>
                        <li>Career guidance &amp; motivation sessions</li>
                        <li>Psychosocial support &amp; mental health awareness</li>
                        <li>Prevention of Gender-Based Violence (PGI)</li>
                        <li>Life skills education &amp; counselling sessions</li>
                    </ul>
                </div>

                <div class="prog-card">
                    <div class="prog-card__num">03</div>
                    <div class="prog-card__icon">🏥</div>
                    <h3>Health &amp; Mental Wellness</h3>
                    <ul>
                        <li>Trained community leaders on Psychological First Aid (PFA)</li>
                        <li>Stress management &amp; post-disaster emotional recovery</li>
                        <li>Referrals to partner clinics for advanced care</li>
                    </ul>
                </div>

                <div class="prog-card">
                    <div class="prog-card__num">04</div>
                    <div class="prog-card__icon">👩‍👧</div>
                    <h3>Women, Youth &amp; Disability Empowerment</h3>
                    <ul>
                        <li>Small economic initiatives for 40+ widows &amp; single mothers</li>
                        <li>Assistive devices &amp; support for 10 people with disabilities</li>
                        <li>Sessions on child rights, self-esteem &amp; anti-discrimination</li>
                    </ul>
                </div>

                <div class="prog-card">
                    <div class="prog-card__num">05</div>
                    <div class="prog-card__icon">🆘</div>
                    <h3>Disaster Response &amp; Relief</h3>
                    <ul>
                        <li>Emergency aid during Hanang' disaster: shelter kits &amp; clothing</li>
                        <li>Trauma support &amp; community healing events</li>
                        <li>Rapid response to disaster-affected families</li>
                    </ul>
                </div>

                <div class="prog-card prog-card--cta">
                    <div class="prog-card__icon">🤝</div>
                    <h3>Partner With Us</h3>
                    <p>We work with schools, hospitals, local government, and NGOs to amplify impact. We welcome corporates,
                        individuals, and organisations who share our values to co-create sustainable change.</p>
                    <a href="#get-involved" class="btn btn-yellow"
                        style="margin-top:1.375rem;font-size:.82rem;padding:.6rem 1.2rem;">Get Involved →</a>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ TEAM — dynamic from DB ══════════════════════════════════════════ --}}
    <section class="sec" id="team">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">The People Behind the Mission</div>
                <h2>Our Team</h2>
                <p>Meet the passionate and dedicated individuals driving the vision of Mark Foundation.</p>
            </div>
            <div class="team-grid">
                @forelse($teamMembers as $member)
                <div class="team-card">
                    <div class="team-card__top team-card__top--founder">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            👤
                        @endif
                    </div>
                    <div class="team-card__body">
                        <p class="team-card__role">{{ $member->role }}</p>
                        <h3>{{ $member->name }}</h3>
                        @if($member->bio)<p>{{ $member->bio }}</p>@endif
                        @if($member->email || $member->phone)
                        <div class="team-card__contact">
                            @if($member->phone)<span>📞 <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a></span>@endif
                            @if($member->email)<span>✉ <a href="mailto:{{ $member->email }}">{{ $member->email }}</a></span>@endif
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div style="grid-column:1/-1;text-align:center;padding:2rem;color:var(--ink-3);">Team members coming soon.</div>
                @endforelse
            </div>
            <div style="text-align:center;margin-top:2.5rem;">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline">View Open Positions →</a>
            </div>
        </div>
    </section>


        {{-- ═══ UPCOMING EVENTS (from DB) ════════════════════════════════════════ --}}
    @if ($upcomingEvents->count() > 0)
        <section class="sec sec-alt" id="events">
            <div class="wrap">
                <div class="sec-hd">
                    <div>
                        <div class="eyebrow">What's On</div>
                        <h2>Upcoming Events</h2>
                        <p>{{ $upcomingEvents->count() }} event{{ $upcomingEvents->count() !== 1 ? 's' : '' }} coming up —
                            all are welcome.</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn btn-outline btn-sm">View All Events →</a>
                </div>
                <div class="events-grid">
                    @foreach ($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="event-card">
                            <div class="event-card__img">
                                @if ($event->cover_image_path)
                                    <img src="{{ Storage::url($event->cover_image_path) }}" alt="{{ $event->title }}">
                                @else
                                    📅
                                @endif
                                <span class="event-card__badge">{{ $event->start_date->format('d M') }}</span>
                            </div>
                            <div class="event-card__body">
                                <h3>{{ $event->title }}</h3>
                                <p>{{ Str::limit($event->description, 90) }}</p>
                                <div class="event-card__meta">
                                    @if ($event->location)
                                        <span class="pill">📍 {{ $event->location }}</span>
                                    @endif
                                    @if ($event->rsvp_link)
                                        <span class="pill" style="background:var(--yellow-lt);color:var(--black);">RSVP
                                            Open</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ GALLERY PREVIEW (from DB) ════════════════════════════════════════ --}}
    @if ($galleryItems->count() > 0)
        <section class="sec{{ $upcomingEvents->count() > 0 ? '' : ' sec-alt' }}" id="gallery-preview">
            <div class="wrap">
                <div class="sec-hd">
                    <div>
                        <div class="eyebrow">Our Work in Pictures</div>
                        <h2>Photos &amp; Videos</h2>
                        <p>Community outreach, school visits, donation days, health support, and training events.</p>
                    </div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-outline btn-sm">Full Gallery →</a>
                </div>
                <div class="gallery-grid">
                    @foreach ($galleryItems as $item)
                        @if ($item->isPhoto() && $item->file_path)
                            <a href="{{ route('gallery.index') }}" class="gthumb">
                                <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->title }}"
                                    loading="lazy">
                                <div class="gthumb__over">🔍</div>
                            </a>
                        @elseif($item->isVideo())
                            <a href="{{ route('gallery.index') }}" class="gthumb gthumb--video">
                                <div class="play-ic">▶</div>
                                <div class="gthumb__over" style="opacity:1;background:rgba(0,0,0,.5);">▶</div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ IMPACT IN NUMBERS ════════════════════════════════════════════════ --}}
    <section class="sec{{ $galleryItems->count() > 0 ? ' sec-alt' : '' }}" id="impact">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">Results That Matter</div>
                <h2>Impact in Numbers</h2>
            </div>
            <div class="impact-grid">
                <div class="impact-card">
                    <div class="impact-card__icon">🏠</div>
                    <div class="impact-card__num">150+</div>
                    <div class="impact-card__lbl">Vulnerable families supported in Hanang' &amp; nearby areas</div>
                </div>
                <div class="impact-card">
                    <div class="impact-card__icon">📚</div>
                    <div class="impact-card__num">500+</div>
                    <div class="impact-card__lbl">Students reached across 3 schools with guidance &amp; support</div>
                </div>
                <div class="impact-card">
                    <div class="impact-card__icon">🏥</div>
                    <div class="impact-card__num">50+</div>
                    <div class="impact-card__lbl">Families covered with health insurance</div>
                </div>
                <div class="impact-card">
                    <div class="impact-card__icon">👩‍👧</div>
                    <div class="impact-card__num">40+</div>
                    <div class="impact-card__lbl">Widows &amp; single mothers empowered with economic initiatives</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TESTIMONIALS — dynamic from DB ════════════════════════════════ --}}
    <section class="sec sec-alt" id="testimonials">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">Voices From the Community</div>
                <h2>Testimonials</h2>
            </div>
            <div class="testi-grid">
                @forelse($testimonials as $t)
                <div class="tcard">
                    <p>"{{ $t->quote }}"</p>
                    <div class="tcard__author">{{ $t->author_name }}@if($t->author_location), {{ $t->author_location }}@endif</div>
                </div>
                @empty
                <div style="grid-column:1/-1;text-align:center;padding:2rem;color:var(--ink-3);">Testimonials coming soon.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ FAQ — dynamic from DB ══════════════════════════════════════════ --}}
    <section class="sec" id="faq">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">Got Questions?</div>
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="faq-wrap">
                @forelse($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-q" onclick="this.parentElement.classList.toggle('open')">
                        <span>{{ $faq->question }}</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-a">{{ $faq->answer }}</div>
                </div>
                @empty
                <p style="text-align:center;color:var(--ink-3);">FAQs coming soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ PARTNERS ══════════════════════════════════════════════════════════ --}}
    <section class="sec sec-alt" id="partners">
        <div class="wrap">
            <div class="sec-title">
                <div class="eyebrow" style="justify-content:center;">Collaboration</div>
                <h2>Partners &amp; Supporters</h2>
                <p>We collaborate with local government, health providers, schools, and NGOs. <a href="#get-involved"
                        style="color:var(--green);font-weight:600;">Contact us to join our efforts.</a></p>
            </div>
            <div class="partners-row">
                <div class="p-badge">
                    <i class="fas fa-landmark"></i>
                    Local Government
                </div>

                <div class="p-badge">
                    <i class="fas fa-hospital"></i>
                    Health Providers
                </div>

                <div class="p-badge">
                    <i class="fas fa-school"></i>
                    Schools & Colleges
                </div>

                <div class="p-badge">
                    <i class="fas fa-handshake"></i>
                    Partner NGOs
                </div>

                <div class="p-badge">
                    <i class="fas fa-plus-circle"></i>
                    Your Organisation
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CAREERS CTA ════════════════════════════════════════════════════════ --}}
    <section class="sec" id="careers">
        <div class="wrap">
            <div class="careers-cta">
                <div>
                    <div class="eyebrow" style="justify-content:flex-start;">Join Our Mission</div>
                    <h3>Careers at Mark Foundation</h3>
                    <p>Join our mission to change lives. We post jobs, internships, and volunteer opportunities. See our
                        current openings and be part of something meaningful.</p>
                </div>
                <a href="{{ route('jobs.index') }}" class="btn btn-green"
                    style="font-size:.95rem;padding:.875rem 2rem;flex-shrink:0;">View Open Positions →</a>
            </div>
        </div>
    </section>

    {{-- ═══ GET INVOLVED / DONATE ════════════════════════════════════════════ --}}
    <section class="sec sec-alt" id="get-involved">
        <div class="wrap">
            <div class="cta-band">
                <h2>Make a Difference Today</h2>
                <p>Your contribution helps us expand our services and reach more people. Join our community of change-makers
                    across Tanzania.</p>
                <div class="cta-band__btns">
                    <a href="mailto:markfoundation87@gmail.com?subject=Donation%20Inquiry" class="btn btn-yellow"
                        style="font-size:1rem;padding:.95rem 2.25rem;">💛 Donate Now</a>
                    <a href="mailto:markfoundation87@gmail.com?subject=Volunteer%20Application" class="btn btn-ghost"
                        style="font-size:1rem;padding:.95rem 2.25rem;">🤝 Volunteer With Us</a>
                    <a href="mailto:markfoundation87@gmail.com?subject=Partnership%20Inquiry" class="btn btn-ghost"
                        style="font-size:1rem;padding:.95rem 2.25rem;">🌍 Partner With Us</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const track = document.getElementById("cTrack");
            const slides = Array.from(track.children);
            const prevBtn = document.getElementById("cPrev");
            const nextBtn = document.getElementById("cNext");
            const dotsNav = document.getElementById("cDots");

            let currentIndex = 0;
            let autoSlide;

            // Create dots dynamically
            slides.forEach((_, index) => {
                const dot = document.createElement("button");
                dot.classList.add("c-dot");
                if (index === 0) dot.classList.add("active");
                dot.addEventListener("click", () => goToSlide(index));
                dotsNav.appendChild(dot);
            });

            const dots = Array.from(dotsNav.children);

            function updateSlides() {
                track.style.transform = `translateX(-${currentIndex * 100}%)`;

                slides.forEach(slide => slide.classList.remove("active"));
                slides[currentIndex].classList.add("active");

                dots.forEach(dot => dot.classList.remove("active"));
                dots[currentIndex].classList.add("active");
            }

            function goToSlide(index) {
                currentIndex = index;
                updateSlides();
                resetAutoSlide();
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % slides.length;
                updateSlides();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateSlides();
            }

            function startAutoSlide() {
                autoSlide = setInterval(nextSlide, 6000); // 6 seconds
            }

            function resetAutoSlide() {
                clearInterval(autoSlide);
                startAutoSlide();
            }

            nextBtn.addEventListener("click", () => {
                nextSlide();
                resetAutoSlide();
            });

            prevBtn.addEventListener("click", () => {
                prevSlide();
                resetAutoSlide();
            });

            // Pause on hover
            track.addEventListener("mouseenter", () => clearInterval(autoSlide));
            track.addEventListener("mouseleave", startAutoSlide);

            updateSlides();
            startAutoSlide();

        });

        (function() {
            const track = document.getElementById('cTrack');
            const dotsEl = document.getElementById('cDots');
            const slides = track.querySelectorAll('.c-slide');
            let cur = 0,
                timer;

            slides.forEach((_, i) => {
                const d = document.createElement('button');
                d.className = 'c-dot' + (i === 0 ? ' active' : '');
                d.setAttribute('aria-label', 'Slide ' + (i + 1));
                d.addEventListener('click', () => go(i));
                dotsEl.appendChild(d);
            });

            function go(n) {
                slides[cur].classList.remove('active');
                dotsEl.children[cur].classList.remove('active');
                cur = (n + slides.length) % slides.length;
                slides[cur].classList.add('active');
                dotsEl.children[cur].classList.add('active');
                track.style.transform = `translateX(-${cur * 100}%)`;
                clearInterval(timer);
                timer = setInterval(() => go(cur + 1), 6000);
            }

            document.getElementById('cPrev').addEventListener('click', () => go(cur - 1));
            document.getElementById('cNext').addEventListener('click', () => go(cur + 1));

            // Touch swipe
            let ts = 0;
            track.addEventListener('touchstart', e => {
                ts = e.touches[0].clientX;
            }, {
                passive: true
            });
            track.addEventListener('touchend', e => {
                const d = e.changedTouches[0].clientX - ts;
                if (Math.abs(d) > 50) go(d < 0 ? cur + 1 : cur - 1);
            });

            timer = setInterval(() => go(cur + 1), 6000);
        })();

        // ── ANIMATED COUNTERS ──────────────────────────────────────────────
        function animateCounter(el) {
            const target = parseInt(el.dataset.target);
            const suffix = el.dataset.suffix || '+';
            const duration = 2000;
            const step = Math.ceil(target / (duration / 16));
            let current = 0;
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = current.toLocaleString() + suffix;
                if (current >= target) clearInterval(timer);
            }, 16);
        }

        // Trigger counters when stats bar scrolls into view
        const counters = document.querySelectorAll('.counter');
        if (counters.length) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            counters.forEach(c => observer.observe(c));
        }

        // ── ACCORDION (about section) ──────────────────────────────────────
        function toggleAcc(btn) {
            const item = btn.closest('.acc-item');
            const isOpen = item.classList.contains('open');
            // Close all
            document.querySelectorAll('.acc-item.open').forEach(i => i.classList.remove('open'));
            // Open clicked (if wasn't open)
            if (!isOpen) item.classList.add('open');
        }
    </script>
@endpush
