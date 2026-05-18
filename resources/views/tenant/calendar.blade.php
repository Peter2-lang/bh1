@extends('layouts.boarding-house', ['role' => 'tenant', 'active' => 'Calendar', 'title' => 'Tenant Calendar'])

@php $scheduleItems = collect($scheduleItems ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant calendar', 'title' => "Schedules from Madaje's Boarding House", 'text' => 'See rent collection, cleaning, and maintenance schedules published by admin.'])
    @component('partials.panel', ['title' => 'Upcoming schedules'])
      <div class="grid gap-3">
        @forelse ($scheduleItems as $item)
          <div class="rounded-3xl border border-stone-200 bg-white/75 p-4"><p class="font-semibold">{{ data_get($item, 'title') }}</p><p class="text-sm text-stone-500">{{ data_get($item, 'schedule_date') }} at {{ data_get($item, 'schedule_time') }}</p><p class="mt-2 text-sm text-stone-600">{{ data_get($item, 'details') }}</p></div>
        @empty
          <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No schedules yet.</div>
        @endforelse
      </div>
    @endcomponent
  </section>
@endsection