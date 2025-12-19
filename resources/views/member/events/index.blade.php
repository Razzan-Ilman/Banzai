@extends('layouts.member')

@section('title', 'Event & Lomba')

@section('content')
<!-- My Events -->
@if($myEvents->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Event yang Saya Ikuti</h2>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            @foreach($myEvents as $event)
                <div style="padding: 1rem; background: var(--neutral-50); border-radius: 8px; border-left: 4px solid var(--group-primary, #0EA5E9);">
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem;">{{ $event->title }}</h4>
                    <p style="font-size: 0.875rem; color: var(--neutral-600);">{{ $event->date->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Upcoming Events -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Event Mendatang</h2>
    </div>
    <div class="card-body">
        @if($upcomingEvents->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                @foreach($upcomingEvents as $event)
                    <div class="event-card" style="border: 1px solid var(--neutral-200); border-radius: 12px; overflow: hidden; transition: all 0.2s ease;">
                        <!-- Event Image Placeholder -->
                        <div style="height: 150px; background: linear-gradient(135deg, var(--group-primary, #0EA5E9), var(--group-secondary, #0284C7)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            📅
                        </div>
                        
                        <!-- Event Info -->
                        <div style="padding: 1.25rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--ink-900);">
                                {{ $event->title }}
                            </h3>
                            <p style="color: var(--neutral-600); font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                                {{ Str::limit($event->description, 80) }}
                            </p>
                            
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; font-size: 0.8125rem; color: var(--neutral-500);">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $event->date->format('d M Y') }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </div>
                            
                            <a href="{{ route('member.events.show', $event) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $upcomingEvents->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: var(--neutral-500);">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem; opacity: 0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p style="font-size: 1.125rem;">Belum ada event mendatang</p>
            </div>
        @endif
    </div>
</div>

<style>
.event-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transform: translateY(-4px);
}
</style>
@endsection
