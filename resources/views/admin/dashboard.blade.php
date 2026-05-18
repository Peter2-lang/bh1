@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Overview', 'title' => 'Admin Dashboard'])

@php
  $rooms = collect($rooms ?? []);
  $tenants = collect($tenants ?? []);
  $payments = collect($payments ?? []);
  $reports = collect($reports ?? []);
  $verifiedRevenue = $payments->where('status', 'Verified')->sum('amount');
  $pendingRevenue = $payments->where('status', 'Pending')->sum('amount');
  $totalCapacity = $rooms->sum('capacity');
  $openReports = $reports->where('status', '!=', 'Resolved')->count();
@endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', [
      'eyebrow' => 'Admin dashboard',
      'title' => 'Analytics, revenue, tenants, rooms, and reports',
      'text' => 'Use this dashboard as the landing page for your Laravel admin portal.',
    ])

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      @foreach ([
        ['label' => 'Verified revenue', 'value' => 'PHP ' . number_format($verifiedRevenue, 2), 'detail' => 'Confirmed collection'],
        ['label' => 'Pending payments', 'value' => 'PHP ' . number_format($pendingRevenue, 2), 'detail' => 'Awaiting verification'],
        ['label' => 'Tenants', 'value' => $tenants->count(), 'detail' => 'Registered tenant records'],
        ['label' => 'Rooms', 'value' => $rooms->count(), 'detail' => $totalCapacity . ' total capacity'],
      ] as $metric)
        <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5 shadow-sm shadow-stone-900/5">
          <p class="text-sm font-semibold text-stone-500">{{ $metric['label'] }}</p>
          <p class="mt-3 text-3xl font-black tracking-tight text-stone-950">{{ $metric['value'] }}</p>
          <p class="mt-2 text-sm text-stone-500">{{ $metric['detail'] }}</p>
        </div>
      @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_0.8fr]">
      @component('partials.panel', ['title' => 'Room summary'])
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm">
            <thead class="text-xs uppercase tracking-[0.22em] text-stone-500">
              <tr><th class="py-3 pr-4">Room</th><th class="py-3 pr-4">Capacity</th><th class="py-3 pr-4">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
              @forelse ($rooms as $room)
                <tr><td class="py-4 pr-4 font-semibold">{{ data_get($room, 'name') }}</td><td class="py-4 pr-4">{{ data_get($room, 'capacity') }}</td><td class="py-4 pr-4">{{ data_get($room, 'status') }}</td></tr>
              @empty
                <tr><td colspan="3" class="py-6 text-center text-stone-500">No room records yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      @endcomponent

      @component('partials.panel', ['title' => 'Reports'])
        <p class="text-4xl font-black text-stone-950">{{ $openReports }}</p>
        <p class="mt-2 text-sm text-stone-500">Open or in-progress tenant reports.</p>
      @endcomponent
    </div>
  </section>
@endsection