@forelse($places as $place)
<div class="place-card">
    <div class="place-card-header">
        <h3 class="place-name">{{ $place->name }}</h3>
        @php
            $isOpen = $place->isOpenNow();
        @endphp
        <span class="place-status {{ $isOpen ? 'open' : 'closed' }}">
            {{ $isOpen ? 'Open' : 'Closed' }}
        </span>
    </div>
    <div class="place-info">
        @if($place->opening_hours && count($place->opening_hours) > 0)
        <div class="place-info-item">
            <i class="bi bi-clock"></i>
            <div>
                <ul class="opening-hours-list">
                    @foreach($place->opening_hours as $schedule)
                    <li>
                        <span class="hours-days">{{ implode(', ', $schedule['days'] ?? []) }}</span>
                        @if(isset($schedule['closed']) && $schedule['closed'])
                        <span class="hours-time hours-closed">Closed</span>
                        @else
                        <span class="hours-time">{{ $schedule['open'] ?? '' }} - {{ $schedule['close'] ?? '' }}</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if($place->phone_number)
        <div class="place-info-item">
            <i class="bi bi-telephone"></i>
            <a href="tel:{{ $place->phone_number }}">{{ $place->phone_number }}</a>
        </div>
        @endif

        @if($place->email)
        <div class="place-info-item">
            <i class="bi bi-envelope"></i>
            <a href="mailto:{{ $place->email }}">{{ $place->email }}</a>
        </div>
        @endif

        @if($place->address)
        <div class="place-info-item">
            <i class="bi bi-pin-map"></i>
            <span>{{ $place->address }}</span>
        </div>
        @endif
    </div>
</div>
@empty
<div class="empty-state">
    <i class="bi bi-geo"></i>
    <h3>No places found</h3>
    <p>Select a different location or check back later.</p>
</div>
@endforelse