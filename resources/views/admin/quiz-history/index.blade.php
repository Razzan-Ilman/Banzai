@extends('layouts.admin')

@section('title', 'Riwayat Quiz')

@section('content')
    {{-- Stats Cards --}}
    <div class="stats-grid" style="margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_quizzes'] }}</div>
            <div class="stat-label">Total Quiz</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #0EA5E9;">{{ $stats['this_month'] }}</div>
            <div class="stat-label">Bulan Ini</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #F59E0B;">{{ $stats['borderline_count'] }}</div>
            <div class="stat-label">Borderline ⚠️</div>
        </div>
        <div class="stat-card">
            <div class="stat-value" style="color: #10B981;">{{ $stats['title_holders'] }}</div>
            <div class="stat-label">Title Holders 🏆</div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Riwayat Quiz Anggota</h2>
    </div>

    {{-- Filters --}}
    <div class="card" style="margin-bottom: 1rem;">
        <div class="card-body" style="padding: 1rem;">
            <form action="{{ route('admin.quiz-history.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: flex-end;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">User</label>
                    <select name="user_id" class="form-select" style="min-width: 200px;">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Kelompok</label>
                    <select name="group_id" class="form-select" style="min-width: 150px;">
                        <option value="">Semua</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Bulan</label>
                    <select name="month" class="form-select" style="min-width: 100px;">
                        <option value="">Semua</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('M', mktime(0,0,0,$m,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Tahun</label>
                    <select name="year" class="form-select" style="min-width: 100px;">
                        <option value="">Semua</option>
                        @for($y = 2024; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-checkbox">
                    <input type="checkbox" name="borderline" value="1" id="borderline" {{ request('borderline') ? 'checked' : '' }}>
                    <label for="borderline" style="font-size: 0.875rem;">Borderline saja</label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.quiz-history.index') }}" class="btn btn-sm" style="background: #E5E5E5;">Reset</a>
            </form>
        </div>
    </div>

    {{-- Results Table --}}
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Kelompok</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Konsistensi</th>
                            <th>Title</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            @php
                                $groupColors = [
                                    'MUSASHI' => '#6366F1',      // Indigo
                                    'AME-NO-UZUME' => '#EC4899', // Pink
                                    'FUJIN' => '#10B981',        // Green
                                    'YAMATO' => '#F59E0B',       // Amber
                                ];
                                $bgColor = $groupColors[$result->group->name] ?? '#6B7280';
                            @endphp
                            <tr style="background: {{ $bgColor }}08;">
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span style="width: 32px; height: 32px; border-radius: 50%; background: {{ $bgColor }}; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600;">
                                            {{ strtoupper(substr($result->user->name, 0, 1)) }}
                                        </span>
                                        <div>
                                            <div style="font-weight: 500;">{{ $result->user->name }}</div>
                                            <div style="font-size: 0.75rem; color: #6B7280;">{{ $result->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: {{ $bgColor }}20; color: {{ $bgColor }}; font-weight: 600;">
                                        {{ $result->group->name }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-weight: 600;">{{ $result->total_score }}</span>
                                    <span style="color: #6B7280;">/40</span>
                                </td>
                                <td>
                                    @if($result->is_borderline)
                                        <span class="badge" style="background: #FEF3C7; color: #92400E;">⚠️ Borderline</span>
                                    @else
                                        <span class="badge" style="background: #D1FAE5; color: #065F46;">✓ Clear</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $progress = $result->consistency['progress'] ?? '0/4';
                                        $eligible = $result->consistency['eligible'] ?? false;
                                    @endphp
                                    @if($eligible)
                                        <span class="badge" style="background: #10B981; color: white;">🟢 {{ $progress }}</span>
                                    @elseif(intval(explode('/', $progress)[0]) >= 2)
                                        <span class="badge" style="background: #FEF3C7; color: #92400E;">🟡 {{ $progress }}</span>
                                    @else
                                        <span class="badge" style="background: #F3F4F6; color: #6B7280;">{{ $progress }}</span>
                                    @endif
                                    
                                    @if($result->streak > 1)
                                        <span style="font-size: 0.7rem; color: #6B7280; margin-left: 0.25rem;">
                                            🔥{{ $result->streak }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($result->user->hasTitle())
                                        <span class="badge" style="background: linear-gradient(135deg, #FCD34D, #F59E0B); color: #78350F;">
                                            🏆 {{ $result->user->title->name_kanji }}
                                        </span>
                                    @else
                                        <span style="color: #9CA3AF;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 0.875rem;">{{ date('M Y', mktime(0,0,0,$result->month,1,$result->year)) }}</div>
                                    <div style="font-size: 0.7rem; color: #6B7280;">{{ $result->created_at->format('d M H:i') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #737373; padding: 2rem;">
                                    Tidak ada data quiz
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin-top: 1rem;">
        {{ $results->appends(request()->query())->links() }}
    </div>

    {{-- Legend --}}
    <div class="card" style="margin-top: 1rem;">
        <div class="card-body" style="padding: 0.75rem 1rem;">
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.75rem; color: #6B7280;">
                <span><strong>Legend:</strong></span>
                <span>🟢 Title Eligible (3/4)</span>
                <span>🟡 Almost (2/4)</span>
                <span>⚠️ Borderline (edge score)</span>
                <span>🔥 Streak</span>
                <span>🏆 Title Holder</span>
            </div>
        </div>
    </div>
@endsection
