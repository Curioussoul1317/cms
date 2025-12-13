@extends('layouts.app')

@section('title', 'Our Timeline')

 
@section('content')
<style>
    body {
        background-color: #e8e8e8;
        font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .ourtimeline-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .ourtimeline-header {
        text-align: center;
        margin-bottom: 80px;
    }

    .ourtimeline-header h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .ourtimeline-header p {
        color: #888;
        font-size: 0.88rem;
        font-weight: 400;
    }

    /* Years list - centered */
    .timeline-years-list {
        text-align: center;
        margin-bottom: 60px;
    }

    .year-title {
        font-size: 2.3rem;
        font-weight: 700;
        color: #00bcd4;
        margin-bottom: 20px;
        cursor: pointer;
        transition: all 0.3s;
        user-select: none;
        display: inline-block;
        width: 100%;
    }

    .year-title:hover {
        color: #0097a7;
        transform: scale(1.05);
    }

    .year-title.active {
        color: #cddc39;
    }

    /* Timeline container */
    .timeline-content-wrapper {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
    }

    /* Center vertical line */
    .timeline-content-wrapper::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 4px;
        background: #cddc39;
    }

    .year-items {
        display: none;
        position: relative;
    }

    .year-items.active {
        display: block;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 120px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 50px;
    }

    /* Timeline center dot */
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 50%;
        margin-top: -10px;
        width: 18px;
        height: 18px;
        background-color: #cddc39;
        border: 5px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 4px #cddc39;
        z-index: 10;
    }

    /* FIRST ITEM (Index 0) - Description LEFT, Image RIGHT */
    .timeline-item:nth-child(1) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(1) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(1) .timeline-image {
        order: 2;
        margin-left: calc(50% + 30px);
    }

    /* SECOND ITEM (Index 1) - Image LEFT, Description RIGHT */
    .timeline-item:nth-child(2) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(2) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
    }

    .timeline-item:nth-child(2) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    /* THIRD ITEM - Same as FIRST */
    .timeline-item:nth-child(3) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(3) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(3) .timeline-image {
        order: 2;
        margin-left: calc(50% + 30px);
    }

    /* FOURTH ITEM - Same as SECOND */
    .timeline-item:nth-child(4) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(4) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
    }

    .timeline-item:nth-child(4) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    /* Continue pattern for more items */
    .timeline-item:nth-child(odd) {
        justify-content: flex-end;
    }

    .timeline-item:nth-child(odd) .timeline-description-wrapper {
        order: 1;
        text-align: right;
        padding-right: 25px;
    }

    .timeline-item:nth-child(odd) .timeline-image {
        order: 2;
        margin-left: calc(50% + 30px);
    }

    .timeline-item:nth-child(even) {
        justify-content: flex-start;
    }

    .timeline-item:nth-child(even) .timeline-image {
        order: 1;
        margin-right: calc(50% + 30px);
    }

    .timeline-item:nth-child(even) .timeline-description-wrapper {
        order: 2;
        text-align: left;
        padding-left: 25px;
    }

    .timeline-description-wrapper {
        flex: 0 0 350px;
        max-width: 350px;
    }

    .timeline-description {
        background: white;
        padding: 24px 26px;
        border-radius: 8px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        font-size: 0.9rem;
        line-height: 1.6;
        color: #2c2c2c;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .timeline-date {
        color: #999;
        font-size: 0.82rem;
        font-weight: 400;
        padding: 0 5px;
    }

    .timeline-image {
        flex: 0 0 350px;
        max-width: 350px;
    }

    .timeline-image img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    /* Dashed connector lines */
    .timeline-connector {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 3px;
        z-index: 5;
        background: repeating-linear-gradient(
            to right,
            #00bcd4 0,
            #00bcd4 10px,
            transparent 10px,
            transparent 18px
        );
    }

    /* Connector for odd items (description on left) */
    .timeline-item:nth-child(odd) .timeline-connector {
        left: calc(50% + 15px);
        width: 70px;
    }

    /* Connector for even items (description on right) */
    .timeline-item:nth-child(even) .timeline-connector {
        right: calc(50% + 15px);
        width: 70px;
    }

    @media (max-width: 992px) {
        .timeline-content-wrapper::before {
            left: 30px;
            transform: none;
        }

        .timeline-item {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding-left: 70px;
            gap: 20px;
        }

        .timeline-item::before {
            left: 30px;
            transform: none;
        }

        .timeline-item:nth-child(odd) .timeline-description-wrapper,
        .timeline-item:nth-child(even) .timeline-description-wrapper {
            order: 1 !important;
            text-align: left !important;
            padding: 0 !important;
            max-width: 100%;
            flex: 1;
        }

        .timeline-item:nth-child(odd) .timeline-image,
        .timeline-item:nth-child(even) .timeline-image {
            order: 2 !important;
            margin: 0 !important;
            max-width: 100%;
            flex: 1;
        }

        .timeline-connector {
            display: none;
        }

        .timeline-years-list .year-title {
            font-size: 2rem;
        }
    }
</style> 

<div class="ourtimeline-container">
    <div class="ourtimeline-header">
        <h1>Our Timeline</h1>
        <p>Click on a year to expand</p>
    </div>

    <!-- Years list centered -->
    <div class="timeline-years-list">
        @foreach($groupedByYear as $year => $items)
            <h2 class="year-title {{ $loop->first ? 'active' : '' }}" data-year="{{ $year }}">
                {{ $year }}
            </h2>
        @endforeach
    </div>

    <!-- Timeline items -->
    <div class="timeline-content-wrapper">
        @foreach($groupedByYear as $year => $items)
            <div class="year-items {{ $loop->first ? 'active' : '' }}" id="year-{{ $year }}">
                @foreach($items as $item)
                    <div class="timeline-item">
                        <div class="timeline-connector"></div>
                        
                        <div class="timeline-description-wrapper">
                            <div class="timeline-description">
                                {{ $item->description }}
                            </div>
                            <div class="timeline-date">
                                {{ $item->date->format('jS F Y') }}
                            </div>
                        </div>

                        @if($item->image)
                            <div class="timeline-image">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Timeline event">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const yearTitles = document.querySelectorAll('.year-title');
        
        yearTitles.forEach(function(yearTitle) {
            yearTitle.addEventListener('click', function() {
                const year = this.getAttribute('data-year');
                
                // Hide all year items
                document.querySelectorAll('.year-items').forEach(function(item) {
                    item.classList.remove('active');
                });
                
                // Remove active class from all year titles
                yearTitles.forEach(function(title) {
                    title.classList.remove('active');
                });
                
                // Show selected year items
                const selectedYear = document.getElementById('year-' + year);
                if (selectedYear) {
                    selectedYear.classList.add('active');
                }
                
                // Add active class to clicked year
                this.classList.add('active');
            });
        });
    });
</script>
@endsection