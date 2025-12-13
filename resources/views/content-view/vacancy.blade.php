@extends('layouts.public')

@section('title', 'Vacancies')


@section('content')
 
<style>
    body {
        background-color: #f7f7f7;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .vacancies-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 40px;
    }

    .vacancies-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 50px;
        gap: 40px;
    }

    .vacancies-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .search-box {
        position: relative;
        flex: 0 0 400px;
    }

    .search-input {
        width: 100%;
        padding: 14px 20px 14px 50px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        background: white;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #00d9b4;
        box-shadow: 0 0 0 3px rgba(0, 217, 180, 0.1);
    }

    .search-input::placeholder {
        color: #cbd5e0;
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #00d9b4;
        font-size: 1.1rem;
    }

    .vacancies-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .vacancy-card {
        background: white;
        border-radius: 10px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .vacancy-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .vacancy-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .vacancy-status {
        font-size: 0.85rem;
        font-weight: 600;
        padding: 0;
    }

    .vacancy-status.expired {
        color: #e53e3e;
    }

    .vacancy-status.active {
        color: #38a169;
    }

    .vacancy-posted {
        font-size: 0.85rem;
        color: #a0aec0;
    }

    .vacancy-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .vacancy-view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 32px;
        background: #00d9b4;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        margin-bottom: 24px;
        align-self: flex-start;
    }

    .vacancy-view-btn:hover {
        background: #00c4a0;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .vacancy-details {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: auto;
    }

    .vacancy-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #4a5568;
    }

    .vacancy-detail-item i {
        color: #a0aec0;
        font-size: 1rem;
    }

    .no-vacancies {
        text-align: center;
        padding: 80px 20px;
        color: #a0aec0;
    }

    .no-vacancies i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 1200px) {
        .vacancies-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .vacancies-container {
            padding: 40px 20px;
        }

        .vacancies-header {
            flex-direction: column;
            align-items: stretch;
            gap: 20px;
        }

        .vacancies-header h1 {
            font-size: 2rem;
        }

        .search-box {
            flex: 1;
        }

        .vacancies-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .vacancy-details {
            flex-direction: column;
            gap: 12px;
        }
    }
</style> 

<div class="vacancies-container">
    <div class="vacancies-header">
        <h1>Vacancies</h1>
        <div class="search-box">
            <form action="{{ route('corprofile.OpenVacancies') }}" method="GET">
                <i class="bi bi-search search-icon"></i>
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Search for a job or a location"
                       value="{{ $search }}">
            </form>
        </div>
    </div> 

    <div class="vacancies-grid">
        @forelse($vacancies as $vacancy)
            <div class="vacancy-card">
                <div class="vacancy-header">
                    <span class="vacancy-status {{ $vacancy->is_expired ? 'expired' : 'active' }}">
                        {{ $vacancy->is_expired ? 'Expired' : 'Active' }}
                    </span>
                    <div class="vacancy-posted">
                        Posted {{ $vacancy->posted_time_ago }}
                    </div>
                </div>
                
                <h3 class="vacancy-title">{{ $vacancy->title }}</h3>
                
                @if($vacancy->url)
                    <a href="{{ $vacancy->url }}" class="vacancy-view-btn" target="_blank">
                        View
                    </a>
                @endif
                
                <div class="vacancy-details">
                    <div class="vacancy-detail-item">
                        <i class="bi bi-briefcase"></i>
                        <span>{{ $vacancy->salary }}</span>
                    </div>
                    <div class="vacancy-detail-item">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ $vacancy->due_date->format('jS F Y') }}</span>
                    </div>
                    <div class="vacancy-detail-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ $vacancy->location->location_name }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-vacancies" style="grid-column: 1 / -1;">
                <i class="bi bi-briefcase"></i>
                <h3>No vacancies found</h3>
                @if($search)
                    <p>Try adjusting your search terms</p>
                @else
                    <p>No vacancies available at the moment</p>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection