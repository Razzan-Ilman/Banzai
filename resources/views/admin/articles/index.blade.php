@extends('layouts.admin')

@section('title', 'Artikel / Blog')

@section('content')
<div class="articles-page">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900);">📝 Artikel / Blog</h2>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">+ Tulis Artikel</a>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #D1FAE5; color: #059669; border-radius: 8px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1rem;">
            <form action="{{ route('admin.articles.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <select name="status" class="form-control" style="width: auto;">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
                <select name="category" class="form-control" style="width: auto;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--neutral-50); border-bottom: 1px solid var(--neutral-200);">
                        <th style="padding: 1rem; text-align: left;">Artikel</th>
                        <th style="padding: 1rem; text-align: left;">Kategori</th>
                        <th style="padding: 1rem; text-align: center;">Status</th>
                        <th style="padding: 1rem; text-align: center;">Views</th>
                        <th style="padding: 1rem; text-align: left;">Tanggal</th>
                        <th style="padding: 1rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr style="border-bottom: 1px solid var(--neutral-100);">
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    @if($article->thumbnail)
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 60px; height: 40px; background: var(--neutral-200); border-radius: 4px;"></div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 500; color: var(--ink-900);">{{ $article->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ $article->author->name ?? 'Unknown' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="background: var(--primary-100); color: var(--primary-700); padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                                    {{ $article->category_label }}
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                @if($article->status === 'published')
                                    <span style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Published</span>
                                @elseif($article->status === 'scheduled')
                                    <span style="background: #FEF3C7; color: #D97706; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Scheduled</span>
                                @else
                                    <span style="background: var(--neutral-100); color: var(--neutral-600); padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">Draft</span>
                                @endif
                            </td>
                            <td style="padding: 1rem; text-align: center; color: var(--neutral-600);">
                                {{ number_format($article->views_count) }}
                            </td>
                            <td style="padding: 1rem; font-size: 0.875rem; color: var(--neutral-600);">
                                {{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm" style="background: var(--neutral-100);">✏️</a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: #FEE2E2; color: #DC2626;">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: var(--neutral-500);">
                                Belum ada artikel
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($articles->hasPages())
        <div style="margin-top: 1.5rem;">{{ $articles->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
