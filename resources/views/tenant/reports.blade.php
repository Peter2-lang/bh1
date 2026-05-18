@extends('layouts.boarding-house', ['role' => 'tenant', 'active' => 'Reports', 'title' => 'Tenant Reports'])

@php $reports = collect($reports ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant reports', 'title' => 'Send a concern or maintenance request', 'text' => 'Your reports are shown in the admin dashboard.'])
    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
      @component('partials.panel', ['title' => 'New report'])
        <form method="POST" action="{{ url('/tenant/reports') }}" class="grid gap-4">
          @csrf
          <select name="category" class="rounded-2xl border border-stone-200 px-4 py-3"><option>Maintenance</option><option>Payment concern</option><option>Room request</option><option>General concern</option></select>
          <input name="title" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Title">
          <textarea name="details" class="min-h-32 rounded-2xl border border-stone-200 px-4 py-3" placeholder="Details"></textarea>
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Send report</button>
        </form>
      @endcomponent
      @component('partials.panel', ['title' => 'My reports'])
        <div class="grid gap-3">
          @forelse ($reports as $report)
            <div class="rounded-3xl border border-stone-200 bg-white/75 p-4"><p class="font-semibold">{{ data_get($report, 'title') }}</p><p class="mt-1 text-sm text-stone-600">{{ data_get($report, 'details') }}</p><p class="mt-2 text-sm text-stone-500">{{ data_get($report, 'status') }}</p></div>
          @empty
            <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No reports yet.</div>
          @endforelse
        </div>
      @endcomponent
    </div>
  </section>
@endsection