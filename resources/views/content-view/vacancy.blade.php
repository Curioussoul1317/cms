@extends('layouts.public')

@section('title', 'Vacancies')

@section('content')
<main class="page-wrapper">
    <div class="page-body">
        <div class="" style="padding: 0px;">

            <style>
                /* Vacancies Page Styles */
                .vacancies-section {
                    padding: 60px 0;
                    background-color: #f8f9fa;
                    min-height: 100vh;
                }

                .vacancies-container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 0 20px;
                }

                /* Header Section */
                .vacancies-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 40px;
                    flex-wrap: wrap;
                    gap: 20px;
                }

                .vacancies-title {
                    font-size: 2rem;
                    font-weight: 700;
                    color: #1a1a1a;
                    margin: 0;
                }

                /* Search Box */
                .vacancies-search {
                    position: relative;
                    width: 100%;
                    max-width: 380px;
                }

                .vacancies-search input {
                    width: 100%;
                    padding: 14px 20px 14px 50px;
                    border: 1px solid #e5e5e5;
                    border-radius: 50px;
                    font-size: 0.95rem;
                    color: #333;
                    background-color: #fff;
                    outline: none;
                    transition: all 0.3s ease;
                }

                .vacancies-search input::placeholder {
                    color: #999;
                }

                .vacancies-search input:focus {
                    border-color: #1CEAB9;
                    box-shadow: 0 0 0 3px rgba(28, 234, 185, 0.1);
                }

                .vacancies-search i {
                    position: absolute;
                    left: 20px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #999;
                    font-size: 1rem;
                }

                /* Cards Grid */
                .vacancies-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 25px;
                }

                /* Vacancy Card */
                .vacancy-card {
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 24px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                    border: 1px solid #f0f0f0;
                    transition: all 0.3s ease;
                    display: flex;
                    flex-direction: column;
                }

                .vacancy-card:hover {
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                    transform: translateY(-2px);
                }

                /* Card Header */
                .vacancy-card-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 12px;
                    flex-wrap: wrap;
                    gap: 8px;
                }

                .vacancy-status {
                    font-size: 0.8rem;
                    font-weight: 500;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                }

                .vacancy-status.expired {
                    color: #FF6B6B;
                }

                .vacancy-status.active {
                    color: #1CEAB9;
                }

                .vacancy-posted {
                    font-size: 0.8rem;
                    color: #999;
                }

                /* Job Title */
                .vacancy-title {
                    font-size: 1.15rem;
                    font-weight: 700;
                    color: #1a1a1a;
                    margin-bottom: 16px;
                    line-height: 1.4;
                }

                /* View Button */
                .vacancy-view-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px 24px;
                    background-color: #1CEAB9;
                    color: #ffffff;
                    font-size: 0.85rem;
                    font-weight: 500;
                    border-radius: 50px;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    border: none;
                    cursor: pointer;
                    margin-bottom: 20px;
                    width: fit-content;
                }

                .vacancy-view-btn:hover {
                    background-color: #17c9a0;
                    color: #ffffff;
                    text-decoration: none;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(28, 234, 185, 0.3);
                }

                /* Card Footer / Meta Info */
                .vacancy-meta {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-top: 16px;
                    border-top: 1px solid #f5f5f5;
                    margin-top: auto;
                    flex-wrap: wrap;
                    gap: 12px;
                }

                .vacancy-meta-item {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    font-size: 0.8rem;
                    color: #666;
                }

                .vacancy-meta-item i {
                    color: #999;
                    font-size: 0.85rem;
                }

                /* Empty State */
                .vacancies-empty {
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 80px 20px;
                    color: #999;
                }

                .vacancies-empty i {
                    font-size: 3rem;
                    margin-bottom: 16px;
                    opacity: 0.5;
                }

                .vacancies-empty p {
                    font-size: 1rem;
                    margin: 0;
                }

                /* No Results State */
                .no-results-message {
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 60px 20px;
                    color: #999;
                    display: none;
                }

                .no-results-message.show {
                    display: block;
                }

                .no-results-message i {
                    font-size: 2.5rem;
                    margin-bottom: 12px;
                    opacity: 0.5;
                }

                /* Loading State */
                .vacancies-loading {
                    grid-column: 1 / -1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 80px 20px;
                }

                .vacancies-spinner {
                    width: 40px;
                    height: 40px;
                    border: 3px solid #e5e5e5;
                    border-top-color: #1CEAB9;
                    border-radius: 50%;
                    animation: spin 0.8s linear infinite;
                }

                @keyframes spin {
                    to { transform: rotate(360deg); }
                }

                /* Pagination */
                .vacancies-pagination {
                    display: flex;
                    justify-content: center;
                    gap: 8px;
                    margin-top: 40px;
                    flex-wrap: wrap;
                }

                .vacancies-pagination a,
                .vacancies-pagination span {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-width: 40px;
                    height: 40px;
                    padding: 0 12px;
                    border-radius: 8px;
                    font-size: 0.9rem;
                    font-weight: 500;
                    text-decoration: none;
                    transition: all 0.3s ease;
                }

                .vacancies-pagination a {
                    background: #fff;
                    color: #666;
                    border: 1px solid #e5e5e5;
                }

                .vacancies-pagination a:hover {
                    border-color: #1CEAB9;
                    color: #1CEAB9;
                }

                .vacancies-pagination span.current {
                    background: #1CEAB9;
                    color: #fff;
                    border: 1px solid #1CEAB9;
                }

                /* Animation */
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(15px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .vacancy-card {
                    animation: fadeInUp 0.4s ease forwards;
                    opacity: 0;
                }

                .vacancy-card:nth-child(1) { animation-delay: 0.05s; }
                .vacancy-card:nth-child(2) { animation-delay: 0.1s; }
                .vacancy-card:nth-child(3) { animation-delay: 0.15s; }
                .vacancy-card:nth-child(4) { animation-delay: 0.2s; }
                .vacancy-card:nth-child(5) { animation-delay: 0.25s; }
                .vacancy-card:nth-child(6) { animation-delay: 0.3s; }
                .vacancy-card:nth-child(7) { animation-delay: 0.35s; }
                .vacancy-card:nth-child(8) { animation-delay: 0.4s; }
                .vacancy-card:nth-child(9) { animation-delay: 0.45s; }

                /* Responsive - Large tablets and small desktops */
                @media (max-width: 1024px) {
                    .vacancies-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }

                    .vacancies-title {
                        font-size: 1.85rem;
                    }
                }

                /* Responsive - Tablets */
                @media (max-width: 768px) {
                    .vacancies-section {
                        padding: 40px 0;
                    }

                    .vacancies-header {
                        flex-direction: column;
                        align-items: stretch;
                        gap: 16px;
                    }

                    .vacancies-search {
                        max-width: 100%;
                    }

                    .vacancies-title {
                        font-size: 1.5rem;
                    }

                    .vacancies-grid {
                        grid-template-columns: 1fr;
                        gap: 16px;
                    }

                    .vacancy-card {
                        padding: 20px;
                    }

                    .vacancy-title {
                        font-size: 1.1rem;
                    }

                    .vacancies-pagination {
                        gap: 6px;
                        margin-top: 30px;
                    }

                    .vacancies-pagination a,
                    .vacancies-pagination span {
                        min-width: 36px;
                        height: 36px;
                        font-size: 0.85rem;
                    }
                }

                /* Responsive - Mobile */
                @media (max-width: 575.98px) {
                    .vacancies-section {
                        padding: 30px 0;
                    }

                    .vacancies-container {
                        padding: 0 15px;
                    }

                    .vacancies-title {
                        font-size: 1.35rem;
                    }

                    .vacancies-search input {
                        padding: 12px 16px 12px 45px;
                        font-size: 0.9rem;
                    }

                    .vacancies-search i {
                        left: 16px;
                    }

                    .vacancy-card {
                        padding: 16px;
                    }

                    .vacancy-card-header {
                        margin-bottom: 10px;
                    }

                    .vacancy-status,
                    .vacancy-posted {
                        font-size: 0.75rem;
                    }

                    .vacancy-title {
                        font-size: 1rem;
                        margin-bottom: 12px;
                    }

                    .vacancy-view-btn {
                        padding: 8px 20px;
                        font-size: 0.8rem;
                        margin-bottom: 16px;
                    }

                    .vacancy-meta {
                        padding-top: 12px;
                        gap: 10px;
                    }

                    .vacancy-meta-item {
                        font-size: 0.75rem;
                        flex: 1 1 calc(50% - 5px);
                    }

                    .vacancy-meta-item:last-child {
                        flex: 1 1 100%;
                    }

                    .vacancy-meta-item i {
                        font-size: 0.8rem;
                    }

                    .vacancies-empty {
                        padding: 60px 15px;
                    }

                    .vacancies-empty i {
                        font-size: 2.5rem;
                    }

                    .vacancies-empty p {
                        font-size: 0.9rem;
                    }
                }

                /* Extra small devices */
                @media (max-width: 375px) {
                    .vacancy-meta-item {
                        flex: 1 1 100%;
                    }
                }
            </style>

            <section class="vacancies-section">
                <div class="vacancies-container">
                    <!-- Header -->
                    <div class="vacancies-header">
                        <h1 class="vacancies-title">Vacancies</h1>

                        <div class="vacancies-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="vacancySearch" placeholder="Search for a job or a location">
                        </div>
                    </div>

                    <!-- Cards Grid -->
                    <div class="vacancies-grid" id="vacanciesGrid">
                        @forelse($vacancies as $vacancy)
                            <div class="vacancy-card" data-title="{{ strtolower($vacancy->title) }}" data-location="{{ strtolower($vacancy->location->location_name ?? ($vacancy->location->name ?? '')) }}">
                                <!-- Card Header -->
                                <div class="vacancy-card-header">
                                    <span class="vacancy-status {{ $vacancy->is_expired ? 'expired' : 'active' }}">
                                        <i class="fa-solid {{ $vacancy->is_expired ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                        {{ $vacancy->is_expired ? 'Expired' : 'Active' }}
                                    </span>
                                    <span class="vacancy-posted">
                                        <i class="fa-regular fa-clock"></i>
                                        Posted {{ $vacancy->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Job Title -->
                                <h3 class="vacancy-title">{{ $vacancy->title }}</h3>

                                <!-- View Button -->
                                <a href=" {{$vacancy->url}}" class="vacancy-view-btn">
                                    <i class="fa-solid fa-eye"></i>
                                    View
                                </a>

                                <!-- Meta Info -->
                                <div class="vacancy-meta">
                                    <div class="vacancy-meta-item">
                                        <i class="fa-solid fa-briefcase"></i>
                                        <span>{{ number_format($vacancy->salary) }}</span>
                                    </div>
                                    <div class="vacancy-meta-item">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $vacancy->deadline ? $vacancy->deadline->format('jS F Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="vacancy-meta-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>{{ $vacancy->location->location_name ?? ($vacancy->location->name ?? 'N/A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="vacancies-empty">
                                <i class="fa-solid fa-briefcase d-block"></i>
                                <p>No vacancies available at the moment</p>
                            </div>
                        @endforelse

                        <!-- No Results Message (for search) -->
                        <div class="no-results-message" id="noResultsMessage">
                            <i class="fa-solid fa-magnifying-glass d-block"></i>
                            <p>No vacancies found matching your search</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($vacancies->hasPages())
                        <div class="vacancies-pagination">
                            {{ $vacancies->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('vacancySearch');
                    const vacancyCards = document.querySelectorAll('.vacancy-card');
                    const noResultsMessage = document.getElementById('noResultsMessage');

                    if (searchInput) {
                        searchInput.addEventListener('input', function() {
                            const searchTerm = this.value.toLowerCase().trim();
                            let visibleCount = 0;

                            vacancyCards.forEach(card => {
                                const title = card.dataset.title || '';
                                const location = card.dataset.location || '';

                                if (title.includes(searchTerm) || location.includes(searchTerm)) {
                                    card.style.display = 'flex';
                                    visibleCount++;
                                } else {
                                    card.style.display = 'none';
                                }
                            });

                            // Show/hide no results message
                            if (noResultsMessage) {
                                if (visibleCount === 0 && searchTerm !== '' && vacancyCards.length > 0) {
                                    noResultsMessage.classList.add('show');
                                } else {
                                    noResultsMessage.classList.remove('show');
                                }
                            }
                        });
                    }
                });
            </script>

        </div>
    </div>
</main>
@endsection