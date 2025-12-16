 
@extends('layouts.app')

@section('title', 'Our Partners')
 
@section('content')
<style>
    body {
        background-color: #ffffff;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .ourpartners-section {
        padding: 80px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .ourpartners-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .ourpartners-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0;
        letter-spacing: 0.3px;
    }

    .partners-grid {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 50px;
        row-gap: 40px;
    }

    .partner-item {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .partner-item:hover {
        transform: scale(1.05);
    }

    .partner-logo {
        max-width: 140px;
        max-height: 80px;
        width: auto;
        height: auto;
        object-fit: contain;
        filter: grayscale(0%);
        transition: filter 0.3s ease;
    }

    .partner-item:hover .partner-logo {
        filter: grayscale(0%) brightness(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .partners-grid {
            gap: 30px;
            row-gap: 30px;
        }

        .partner-logo {
            max-width: 100px;
            max-height: 60px;
        }

        .ourpartners-header h1 {
            font-size: 1.6rem;
        }

        .ourpartners-section {
            padding: 50px 15px;
        }
    }

    @media (max-width: 480px) {
        .partners-grid {
            gap: 25px;
            row-gap: 25px;
        }

        .partner-logo {
            max-width: 80px;
            max-height: 50px;
        }
    }
</style> 

<section class="ourpartners-section">
    <div class="ourpartners-header">
        <h1>Our Partners</h1>
    </div>

    <div class="partners-grid">
        @foreach($partners as $partner)
            <div class="partner-item">
                <img src="{{ $partner->image_url }}" 
                     alt="{{ $partner->name }}" 
                     class="partner-logo"
                     title="{{ $partner->name }}">
            </div>
        @endforeach
    </div>
</section>
@endsection