@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Reports', 'title' => 'Reports'])

@php $reports = collect($reports ?? []); $tenants = collect($tenants ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant reports', 'title' => 'Monitor concerns and maintenance requests', 'text' => 'Update report status or delete resolved records.'])
    <div class="grid gap-4 lg:grid-cols-2">
      @forelse ($reports as $report)
        @php $tenant = $tenants->firstWhere('id', data_get($report, 'tenant_id')); @endphp
        @component('partials.panel', ['title' => data_get($report, 'title')])
          <p class="text-sm leading-6 text-stone-600">{{ data_get($report, 'details') }}</p>
          <p class="mt-3 text-sm text-stone-500">{{ data_get($report, 'category') }} from {{ data_get($tenant, 'name', 'Unknown tenant') }}</p>
          <form method="POST" action="{{ url('/admin/reports/' . data_get($report, 'id')) }}" class="mt-4 flex flex-wrap gap-2">
            @csrf @method('PUT')
            <select name="status" class="rounded-2xl border border-stone-200 px-4 py-3"><option>Open</option><option>In Progress</option><option>Resolved</option></select>
            <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Update</button>
          </form>
        @endcomponent
      @empty
        <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No reports yet.</div>
      @endforelse
    </div>
  </section>
@endsection