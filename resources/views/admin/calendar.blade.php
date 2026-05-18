@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Calendar', 'title' => 'Calendar'])

@php $scheduleItems = collect($scheduleItems ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Schedule calendar', 'title' => 'Create schedules tenants can see', 'text' => 'Publish rent collection, cleaning, inspections, and announcements.'])
    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
      @component('partials.panel', ['title' => 'Add schedule'])
        <form method="POST" action="{{ url('/admin/calendar') }}" class="grid gap-4">
          @csrf
          <input name="title" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Title">
          <input name="category" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Category">
          <input name="schedule_date" type="date" class="rounded-2xl border border-stone-200 px-4 py-3">
          <input name="schedule_time" type="time" class="rounded-2xl border border-stone-200 px-4 py-3">
          <textarea name="details" class="min-h-28 rounded-2xl border border-stone-200 px-4 py-3" placeholder="Details"></textarea>
          <label class="flex items-center gap-3 text-sm font-semibold"><input type="checkbox" name="visible_to_tenants" checked> Show to tenants</label>
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Add schedule</button>
        </form>
      @endcomponent
      @component('partials.panel', ['title' => 'Schedules'])
        <div class="grid gap-3">
          @forelse ($scheduleItems as $item)
            <div class="rounded-3xl border border-stone-200 bg-white/75 p-4"><p class="font-semibold">{{ data_get($item, 'title') }}</p><p class="text-sm text-stone-500">{{ data_get($item, 'schedule_date') }} at {{ data_get($item, 'schedule_time') }}</p><p class="mt-2 text-sm text-stone-600">{{ data_get($item, 'details') }}</p></div>
          @empty
            <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No schedules yet.</div>
          @endforelse
        </div>
      @endcomponent
    </div>
  </section>
@endsection