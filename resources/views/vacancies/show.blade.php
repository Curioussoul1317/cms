 
@extends('layouts.app')

@section('title', 'Vacancies')


@section('content')
 
<style>
    body {
        background-color: #f5f5f5;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .vacancies-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .vacancies-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        gap: 30px;
    }

    .vacancies-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .search-box {
        position: relative;
        flex: 0 0 350px;
    }

    .search-input {
        width: 100%;
        padding: 12px 45px 12px 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #00d9b4;
        box-shadow: 0 0 0 3px rgba(0, 217, 180, 0.1);
    }

    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 1.1rem;
    }

    .vacancies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }

    .vacancy-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s;
        position: relative;
    }

    .vacancy-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .vacancy-status {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .vacancy-status.expired {
        background: #fed7d7;
        color: #c53030;
    }

    .vacancy-status.active {
        background: #c6f6d5;
        color: #22543d;
    }

    .vacancy-posted {
        font-size: 0.8rem;
        color: #a0aec0;
        margin-bottom: 12px;
    }

    .vacancy-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 16px;
        padding-right: 80px;
    }

    .vacancy-view-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #00d9b4;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        margin-bottom: 16px;
    }

    .vacancy-view-btn:hover {
        background: #00c4a0;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .vacancy-details {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .vacancy-detail-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.88rem;
        color: #718096;
    }

    .vacancy-detail-item i {
        color: #a0aec0;
        font-size: 0.95rem;
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

    @media (max-width: 768px) {
        .vacancies-header {
            flex-direction: column;
            align-items: stretch;
        }

        .vacancies-header h1 {
            font-size: 1.8rem;
        }

        .search-box {
            flex: 1;
        }

        .vacancies-grid {
            grid-template-columns: 1fr;
        }
    }
</style> 

<div class="vacancies-container">
    <div class="vacancies-header">
        <h1>Vacancies</h1>
        <div class="search-box">
            <form action="{{ route('vacancies.show') }}" method="GET">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Search for a job or a location"
                       value="{{ $search }}">
                <i class="bi bi-search search-icon"></i>
            </form>
        </div>
    </div>

    <div class="vacancies-grid">
        @forelse($vacancies as $vacancy)
            <div class="vacancy-card">
                <span class="vacancy-status {{ $vacancy->is_expired ? 'expired' : 'active' }}">
                    {{ $vacancy->is_expired ? 'Expired' : 'Active' }}
                </span>
                
                <div class="vacancy-posted">
                    Posted {{ $vacancy->posted_time_ago }}
                </div>
                
                <h3 class="vacancy-title">{{ $vacancy->title }}</h3>
                
                @if($vacancy->url)
                    <a href="{{ $vacancy->url }}" class="vacancy-view-btn" target="_blank">
                        View
                    </a>
                @endif
                
                <div class="vacancy-details">
                    <div class="vacancy-detail-item">
                        <i class="bi bi-cash"></i>
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