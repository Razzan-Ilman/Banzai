@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@section('content')
<div class="search-page" style="padding: 4rem 0;">
    <div class="container">
        <!-- Search Form -->
        <div style="max-width: 600px; margin: 0 auto 3rem;">
            <form action="{{ route('search') }}" method="GET">
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari materi, artikel, event..." 
                           style="flex: 1; padding: 1rem 1.5rem; border: 2px solid var(--neutral-200); border-radius: 50px; font-size: 1rem; outline: none;"
                           autofocus>
                    <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 1rem 2rem;">
                        🔍 Cari
                    </button>
                </div>
            </form>
        </div>

        @if($query)
            <h2 style="font-size: 1.25rem; color: var(--ink-900); margin-bottom: 1.5rem;">
                Hasil pencarian untuk "<strong>{{ $query }}</strong>" ({{ $results->count() }} hasil)
            </h2>
        @endif

        @if($results->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($results as $result)
                    <a href="{{ $result['url'] }}" class="card" style="text-decoration: none; transition: transform 0.2s;">
                        <div class="card-body" style="display: flex; gap: 1rem; align-items: start;">
                            <div style="font-size: 2rem;">{{ $result['icon'] }}</div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                    <span style="background: var(--primary-100); color: var(--primary-700); padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem; text-transform: capitalize;">
                                        {{ $result['type'] }}
                                    </span>
                                </div>
                                <h3 style="font-size: 1rem; font-weight: 600; color: var(--ink-900); margin-bottom: 0.25rem;">
                                    {{ $result['title'] }}
                                </h3>
                                @if($result['description'])
                                    <p style="font-size: 0.875rem; color: var(--neutral-600); line-height: 1.5;">
                                        {{ $result['description'] }}
                                    </p>
                                @endif
                            </div>
                            <div style="color: var(--primary-500);">→</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @elseif($query)
            <div style="text-align: center; padding: 4rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
                <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Tidak ditemukan</h3>
                <p style="color: var(--neutral-500);">Tidak ada hasil untuk "{{ $query }}"</p>
            </div>
        @endif
    </div>
</div>

<style>
    .search-page .card:hover {
        transform: translateX(4px);
    }
</style>
@endsection
