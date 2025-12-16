@extends('layouts.public')
@section('title', 'Corporate Profile')
@section('content')
<main class="page-wrapper">
    <div class="page-body">
        <div style="padding: 0px;">

            <style>
                /* ========================================
                   BASE RESET
                   ======================================== */
                *, *::before, *::after {
                    box-sizing: border-box;
                }

                html, body {
                    overflow-x: hidden;
                    width: 100%;
                }

                :root {
                    --primary-teal: #00D4C8;
                    --primary-teal-dark: #00B8AD;
                    --accent-gradient: linear-gradient(135deg, #1dc8e1 0%, #1fe9ba 100%);
                    --text-dark: #1a1a1a;
                    --text-gray: #555;
                    --bg-gray: #f5f5f5;
                    --bg-white: #ffffff;
                }

                /* ========================================
                   SECTION - FULL WIDTH
                   ======================================== */
                .cp-section {
                    width: 100%;
                    padding: 60px 0;
                }

                .cp-section--gray {
                    background-color: var(--bg-gray);
                }

                .cp-section--white {
                    background-color: var(--bg-white);
                }

                /* ========================================
                   CONTAINER - CENTERED
                   ======================================== */
                .cp-container {
                    width: 100%;
                    max-width: 1000px;
                    margin: 0 auto;
                    padding: 0 20px;
                }

                /* ========================================
                   DESCRIPTION SECTION
                   ======================================== */
                .cp-description {
                    font-size: 1rem;
                    color: var(--text-gray);
                    line-height: 1.8;
                    text-align: center;
                }

                /* ========================================
                   SECTION TITLE
                   ======================================== */
                .cp-section-title {
                    font-size: 1.75rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    text-align: center;
                    margin-bottom: 40px;
                }

                /* ========================================
                   VISION / MISSION BLOCK
                   ======================================== */
                .vm-block {
                    display: flex;
                    align-items: center;
                    gap: 40px;
                    margin-bottom: 50px;
                }

                .vm-block:last-child {
                    margin-bottom: 0;
                }

                .vm-icon-box {
                    width: 180px;
                    height: 180px;
                    background: var(--accent-gradient);
                    border-radius: 16px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                }

                .vm-icon-box img {
                    width: 90px;
                    height: 90px;
                    object-fit: contain;
                    filter: brightness(0) invert(1);
                }

                .vm-content {
                    flex: 1;
                }

                .vm-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 15px;
                }

                .vm-text {
                    font-size: 0.95rem;
                    color: var(--text-gray);
                    line-height: 1.7;
                    margin: 0;
                }

                /* ========================================
                   OBJECTIVES
                   ======================================== */
                .obj-wrapper {
                    display: flex;
                    align-items: flex-start;
                    gap: 40px;
                }

                .obj-cards {
                    flex: 1;
                }

                .obj-card {
                    background: var(--bg-white);
                    padding: 20px 25px;
                    margin-bottom: 15px;
                    border-left: 4px solid var(--text-dark);
                    border-radius: 0;
                }

                .obj-card:last-child {
                    margin-bottom: 0;
                }

                .obj-card-title {
                    font-size: 1rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 8px;
                }

                .obj-card-desc {
                    font-size: 0.9rem;
                    color: var(--text-gray);
                    line-height: 1.6;
                    margin: 0;
                }

                .obj-image {
                    width: 280px;
                    flex-shrink: 0;
                }

                .obj-image img {
                    width: 100%;
                    height: auto;
                }

                /* ========================================
                   STRATEGIES / VALUES / PRINCIPLES
                   ======================================== */
                .list-block {
                    display: flex;
                    align-items: flex-start;
                    gap: 40px;
                }

                .list-icon-box {
                    width: 140px;
                    height: 140px;
                    background: var(--accent-gradient);
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                }

                .list-icon-box img {
                    width: 70px;
                    height: 70px;
                    object-fit: contain;
                    filter: brightness(0) invert(1);
                }

                .list-content {
                    flex: 1;
                }

                .list-title {
                    font-size: 1.4rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 20px;
                }

                .cp-list {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .cp-list li {
                    padding: 10px 0 10px 35px;
                    position: relative;
                    font-size: 0.95rem;
                    color: var(--text-gray);
                    line-height: 1.6;
                }

                .cp-list li::before {
                    content: "\f00c";
                    font-family: "Font Awesome 6 Free";
                    font-weight: 900;
                    position: absolute;
                    left: 0;
                    top: 10px;
                    width: 22px;
                    height: 22px;
                    background: var(--primary-teal);
                    color: #fff;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 10px;
                }

                .cp-numbered-list {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                    counter-reset: num;
                }

                .cp-numbered-list li {
                    padding: 10px 0 10px 38px;
                    position: relative;
                    font-size: 0.95rem;
                    color: var(--text-gray);
                    line-height: 1.6;
                    counter-increment: num;
                }

                .cp-numbered-list li::before {
                    content: counter(num);
                    position: absolute;
                    left: 0;
                    top: 10px;
                    width: 24px;
                    height: 24px;
                    background: var(--primary-teal);
                    color: #fff;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 12px;
                    font-weight: 700;
                }

                .list-side-image {
                    width: 180px;
                    flex-shrink: 0;
                }

                .list-side-image img {
                    width: 100%;
                    height: auto;
                }

                /* ========================================
                   BOARD OF DIRECTORS
                   ======================================== */
                .bod-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 40px;
                }

                .bod-card {
                    text-align: center;
                }

                .bod-img-wrap {
                    position: relative;
                    width: 160px;
                    height: 160px;
                    margin: 0 auto 20px;
                    cursor: pointer;
                }

                .bod-img {
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    object-fit: cover;
                    filter: grayscale(100%);
                    transition: all 0.3s ease;
                }

                .bod-img-wrap:hover .bod-img {
                    filter: grayscale(0%);
                    opacity: 0;
                }

                .bod-placeholder {
                    width: 100%;
                    height: 100%;
                    border-radius: 50%;
                    background: #ccc;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .bod-placeholder i {
                    font-size: 3rem;
                    color: #999;
                }

                .bod-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(145deg, #00bcd4, #009688);
                    border-radius: 12px;
                    padding: 15px;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                    overflow: hidden;
                }

                .bod-img-wrap:hover .bod-overlay {
                    opacity: 1;
                    visibility: visible;
                }

                .bod-overlay-text {
                    color: #fff;
                    font-size: 0.65rem;
                    line-height: 1.45;
                    text-align: left;
                    height: 100%;
                    overflow-y: auto;
                    margin: 0;
                }

                .bod-name {
                    font-size: 1rem;
                    font-weight: 600;
                    color: var(--text-dark);
                    margin-bottom: 5px;
                }

                .bod-position {
                    font-size: 0.85rem;
                    color: var(--primary-teal);
                    margin: 0;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                /* ========================================
                   TIMELINE
                   ======================================== */
                .tl-header {
                    text-align: center;
                    margin-bottom: 40px;
                }

                .tl-header h2 {
                    font-size: 1.75rem;
                    font-weight: 700;
                    color: var(--text-dark);
                    margin-bottom: 8px;
                }

                .tl-header p {
                    color: #888;
                    font-size: 0.9rem;
                    margin: 0;
                }

                .year-block {
                    text-align: center;
                    margin-bottom: 10px;
                }

                .year-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    color: #00bcd4;
                    cursor: pointer;
                    display: inline-block;
                    transition: transform 0.3s;
                }

                .year-title:hover {
                    transform: scale(1.05);
                }

                .year-content {
                    display: none;
                    padding: 30px 0;
                    position: relative;
                }

                .year-content.active {
                    display: block;
                }

                .year-content::before {
                    content: '';
                    position: absolute;
                    left: 50%;
                    transform: translateX(-50%);
                    top: 0;
                    bottom: 0;
                    width: 3px;
                    background: #c4e538;
                }

                .tl-item {
                    display: flex;
                    margin-bottom: 50px;
                    position: relative;
                }

                .tl-item:last-child {
                    margin-bottom: 0;
                }

                .tl-item::before {
                    content: '';
                    position: absolute;
                    left: 50%;
                    transform: translateX(-50%);
                    top: 15px;
                    width: 14px;
                    height: 14px;
                    background: #c4e538;
                    border-radius: 50%;
                    z-index: 2;
                }

                .tl-left, .tl-right {
                    width: 50%;
                    padding: 0 40px;
                }

                .tl-left {
                    text-align: right;
                }

                .tl-desc {
                    font-size: 0.95rem;
                    font-weight: 600;
                    color: #333;
                    line-height: 1.6;
                    margin-bottom: 8px;
                }

                .tl-date {
                    font-size: 0.8rem;
                    color: #999;
                }

                .tl-img {
                    width: 220px;
                    height: 140px;
                    object-fit: cover;
                    border-radius: 8px;
                    border: 4px solid #fff;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                }

                /* ========================================
                   PARTNERS
                   ======================================== */
                .partners-grid {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 30px;
                }

                .partner-item img {
                    max-width: 100px;
                    max-height: 50px;
                    object-fit: contain;
                }

                /* ========================================
                   RESPONSIVE - TABLET
                   ======================================== */
                @media (max-width: 991px) {
                    .cp-section {
                        padding: 50px 0;
                    }

                    .vm-block {
                        gap: 30px;
                    }

                    .vm-icon-box {
                        width: 140px;
                        height: 140px;
                    }

                    .vm-icon-box img {
                        width: 70px;
                        height: 70px;
                    }

                    .obj-wrapper {
                        flex-direction: column;
                    }

                    .obj-image {
                        width: 100%;
                        max-width: 250px;
                        margin: 30px auto 0;
                    }

                    .list-block {
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                    }

                    .list-icon-box {
                        width: 120px;
                        height: 120px;
                    }

                    .list-icon-box img {
                        width: 60px;
                        height: 60px;
                    }

                    .list-content {
                        width: 100%;
                    }

                    .cp-list li,
                    .cp-numbered-list li {
                        text-align: left;
                    }

                    .list-side-image {
                        width: 100%;
                        max-width: 150px;
                        margin-top: 25px;
                    }

                    .bod-grid {
                        grid-template-columns: repeat(3, 1fr);
                        gap: 30px;
                    }

                    .bod-img-wrap {
                        width: 140px;
                        height: 140px;
                    }

                    /* Timeline tablet */
                    .year-content::before {
                        left: 20px;
                        transform: none;
                    }

                    .tl-item {
                        flex-direction: column;
                    }

                    .tl-item::before {
                        left: 20px;
                        transform: none;
                        top: 5px;
                        width: 12px;
                        height: 12px;
                    }

                    .tl-left, .tl-right {
                        width: 100%;
                        padding: 0 0 0 50px;
                        text-align: left;
                    }

                    .tl-right {
                        margin-top: 15px;
                    }

                    .tl-img {
                        width: 100%;
                        max-width: 280px;
                        height: auto;
                    }
                }

                /* ========================================
                   RESPONSIVE - MOBILE
                   ======================================== */
                @media (max-width: 767px) {
                    .cp-section {
                        padding: 40px 0;
                    }

                    .cp-container {
                        padding: 0 15px;
                    }

                    .cp-description {
                        font-size: 0.9rem;
                        line-height: 1.7;
                    }

                    .cp-section-title {
                        font-size: 1.4rem;
                        margin-bottom: 30px;
                    }

                    /* HIDE ICON BOXES ON MOBILE */
                    .vm-icon-box,
                    .list-icon-box {
                        display: none;
                    }

                    .vm-block {
                        flex-direction: column;
                        text-align: center;
                        gap: 0;
                        margin-bottom: 40px;
                    }

                    .vm-title {
                        font-size: 1.3rem;
                        margin-bottom: 12px;
                    }

                    .vm-text {
                        font-size: 0.9rem;
                    }

                    .obj-card {
                        padding: 18px 20px;
                    }

                    .obj-card-title {
                        font-size: 0.95rem;
                    }

                    .obj-image {
                        display: none;
                    }

                    .list-block {
                        text-align: left;
                    }

                    .list-title {
                        font-size: 1.2rem;
                        text-align: center;
                        margin-bottom: 15px;
                    }

                    .cp-list li,
                    .cp-numbered-list li {
                        font-size: 0.9rem;
                        padding-left: 32px;
                    }

                    .list-side-image {
                        display: none;
                    }

                    /* BOD - FULL WIDTH SINGLE COLUMN */
                    .bod-grid {
                        grid-template-columns: 1fr;
                        gap: 20px;
                        max-width: 350px;
                        margin: 0 auto;
                    }

                    .bod-card {
                        text-align: center;
                    }

                    .bod-img-wrap {
                        width: 200px;
                        height: 200px;
                        margin-bottom: 15px;
                    }

                    .bod-overlay {
                        display: none;
                    }

                    .bod-name {
                        font-size: 1.1rem;
                    }

                    .bod-position {
                        font-size: 0.8rem;
                    }

                    /* Timeline mobile */
                    .tl-header h2 {
                        font-size: 1.4rem;
                    }

                    .year-title {
                        font-size: 1.3rem;
                    }

                    .year-content::before {
                        left: 12px;
                        width: 2px;
                    }

                    .tl-item::before {
                        left: 12px;
                        width: 10px;
                        height: 10px;
                    }

                    .tl-left, .tl-right {
                        padding-left: 35px;
                    }

                    .tl-desc {
                        font-size: 0.85rem;
                    }

                    .tl-img {
                        max-width: 160px;
                        height: 100px;
                    }

                    .partner-item img {
                        max-width: 70px;
                        max-height: 35px;
                    }
                }

                /* ========================================
                   RESPONSIVE - SMALL MOBILE
                   ======================================== */
                @media (max-width: 480px) {
                    .cp-section {
                        padding: 30px 0;
                    }

                    .cp-container {
                        padding: 0 12px;
                    }

                    .cp-section-title {
                        font-size: 1.25rem;
                    }

                    .vm-title {
                        font-size: 1.2rem;
                    }

                    .bod-img-wrap {
                        width: 180px;
                        height: 180px;
                    }

                    .tl-img {
                        max-width: 130px;
                        height: 80px;
                    }

                    .year-title {
                        font-size: 1.15rem;
                    }

                    .partner-item img {
                        max-width: 55px;
                        max-height: 28px;
                    }
                }
            </style>

            <!-- DESCRIPTION -->
            @if($corprofile->description)
            <section class="cp-section cp-section--gray">
                <div class="cp-container">
                    <p class="cp-description">{{ $corprofile->description }}</p>
                </div>
            </section>
            @endif

            <!-- VISION & MISSION -->
            <section id="our-company" class="cp-section cp-section--white">
                <div class="cp-container">

                    @if($corprofile->vision_text || $corprofile->vision_image)
                    <div class="vm-block">
                        @if($corprofile->vision_image)
                        <div class="vm-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->vision_image) }}" alt="Vision">
                        </div>
                        @endif
                        <div class="vm-content">
                            <h3 class="vm-title">Vision</h3>
                            <p class="vm-text">{{ $corprofile->vision_text }}</p>
                        </div>
                    </div>
                    @endif

                    @if($corprofile->mission_text || $corprofile->mission_image)
                    <div class="vm-block">
                        @if($corprofile->mission_image)
                        <div class="vm-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->mission_image) }}" alt="Mission">
                        </div>
                        @endif
                        <div class="vm-content">
                            <h3 class="vm-title">Mission</h3>
                            <p class="vm-text">{{ $corprofile->mission_text }}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </section>

            <!-- OBJECTIVES -->
            @if($corprofile->objectives->count() > 0)
            <section class="cp-section cp-section--gray">
                <div class="cp-container">
                    <h2 class="cp-section-title">Objectives</h2>

                    <div class="obj-wrapper">
                        <div class="obj-cards">
                            @foreach($corprofile->objectives as $objective)
                            <div class="obj-card">
                                <h4 class="obj-card-title">{{ $objective->title }}:</h4>
                                <p class="obj-card-desc">{{ $objective->description }}</p>
                            </div>
                            @endforeach
                        </div>
                        @if($corprofile->objectives_image)
                        <div class="obj-image">
                            <img src="{{ asset('storage/' . $corprofile->objectives_image) }}" alt="Objectives">
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            <!-- STRATEGIES -->
            @if($corprofile->strategies->count() > 0)
            <section class="cp-section cp-section--white">
                <div class="cp-container">
                    <div class="list-block">
                        @if($corprofile->strategies_image)
                        <div class="list-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->strategies_image) }}" alt="Strategies">
                        </div>
                        @endif
                        <div class="list-content">
                            <h3 class="list-title">Strategies</h3>
                            <ul class="cp-list">
                                @foreach($corprofile->strategies as $strategy)
                                <li>{{ $strategy->text }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!-- VALUES -->
            @if($corprofile->values->count() > 0)
            <section class="cp-section cp-section--gray">
                <div class="cp-container">
                    <div class="list-block">
                        <div class="list-content">
                            <h3 class="list-title">Values</h3>
                            <ul class="cp-list">
                                @foreach($corprofile->values as $value)
                                <li>{{ $value->text }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if($corprofile->values_image)
                        <div class="list-side-image">
                            <img src="{{ asset('storage/' . $corprofile->values_image) }}" alt="Values">
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            <!-- GUIDING PRINCIPLES -->
            @if($corprofile->principles->count() > 0)
            <section class="cp-section cp-section--white">
                <div class="cp-container">
                    <div class="list-block">
                        @if($corprofile->principles_image)
                        <div class="list-icon-box">
                            <img src="{{ asset('storage/' . $corprofile->principles_image) }}" alt="Principles">
                        </div>
                        @endif
                        <div class="list-content">
                            <h3 class="list-title">Guiding Principles</h3>
                            <ol class="cp-numbered-list">
                                @foreach($corprofile->principles as $principle)
                                <li>{{ $principle->text }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            @endif

            <!-- BOARD OF DIRECTORS -->
            <section id="board-of-directors" class="cp-section cp-section--white">
                <div class="cp-container">
                    <h2 class="cp-section-title">Board of Directors</h2>

                    @if($directors->count() > 0)
                    <div class="bod-grid">
                        @foreach($directors as $director)
                        <div class="bod-card">
                            <div class="bod-img-wrap">
                                @if($director->image)
                                <img src="{{ asset('storage/' . $director->image) }}" alt="{{ $director->name }}" class="bod-img">
                                @else
                                <div class="bod-placeholder">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                @endif

                                @if($director->description)
                                <div class="bod-overlay">
                                    <p class="bod-overlay-text">{{ $director->description }}</p>
                                </div>
                                @endif
                            </div>
                            <h3 class="bod-name">{{ $director->name }}</h3>
                            <p class="bod-position">{{ $director->title }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p style="text-align: center; color: #888;">No board members found</p>
                    @endif
                </div>
            </section>

            <!-- TIMELINE -->
            <section id="timeline" class="cp-section cp-section--gray">
                <div class="cp-container">
                    <div class="tl-header">
                        <h2>Our Timeline</h2>
                        <p>Click on a year to expand</p>
                    </div>

                    @foreach($groupedByYear as $year => $items)
                    <div class="year-block">
                        <h3 class="year-title" data-year="{{ $year }}">{{ $year }}</h3>

                        <div class="year-content {{ $loop->first ? 'active' : '' }}" id="year-{{ $year }}">
                            @foreach($items as $item)
                            <div class="tl-item">
                                @if($loop->odd)
                                <div class="tl-left">
                                    <p class="tl-desc">{{ $item->description }}</p>
                                    <span class="tl-date"><i class="fa-regular fa-calendar me-1"></i>{{ $item->date->format('jS F Y') }}</span>
                                </div>
                                <div class="tl-right">
                                    @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="Timeline" class="tl-img">
                                    @endif
                                </div>
                                @else
                                <div class="tl-left">
                                    @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="Timeline" class="tl-img" style="float: right;">
                                    @endif
                                </div>
                                <div class="tl-right">
                                    <p class="tl-desc">{{ $item->description }}</p>
                                    <span class="tl-date"><i class="fa-regular fa-calendar me-1"></i>{{ $item->date->format('jS F Y') }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- PARTNERS -->
            <section id="our-partners" class="cp-section cp-section--white">
                <div class="cp-container">
                    <h2 class="cp-section-title">Our Partners</h2>

                    <div class="partners-grid">
                        @foreach($partners as $partner)
                        <div class="partner-item">
                            <img src="{{ $partner->image_url }}" alt="{{ $partner->name }}" title="{{ $partner->name }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearTitles = document.querySelectorAll('.year-title');

                yearTitles.forEach(function(title) {
                    title.addEventListener('click', function() {
                        const year = this.getAttribute('data-year');
                        const content = document.getElementById('year-' + year);

                        // Close all
                        document.querySelectorAll('.year-content').forEach(function(c) {
                            c.classList.remove('active');
                        });

                        // Open clicked
                        if (content) {
                            content.classList.add('active');
                        }
                    });
                });

                // Hash scroll
                if (window.location.hash) {
                    const el = document.querySelector(window.location.hash);
                    if (el) {
                        setTimeout(function() {
                            el.scrollIntoView({ behavior: 'smooth' });
                        }, 100);
                    }
                }
            });
            </script>

        </div>
    </div>
</main>
@endsection