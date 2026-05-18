@php
  $property = $property ?? [
    'name' => "Madaje's Boarding House",
    'address' => '95WX+QQP Hinunangan, Southern Leyte. Nearby Address: San Pedro Street, Hinunangan, Southern Leyte',
    'map_url' => 'https://www.google.com/maps?q=10.3969560,125.1994614&z=18&output=embed',
    'manager' => 'Mariel Daje',
    'phone' => '0918 234 8899',
    'notes' => '',
  ];
@endphp
@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Profile', 'title' => 'Profile', 'property' => $property])

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Boarding house profile', 'title' => 'Configure property details', 'text' => 'These details appear on login, tenant pages, and print reports.'])
    @component('partials.panel', ['title' => 'Property information'])
      <form method="POST" action="{{ url('/admin/profile') }}" class="grid gap-4 md:grid-cols-2">
        @csrf @method('PUT')
        <input name="name" value="{{ $property['name'] }}" class="rounded-2xl border border-stone-200 px-4 py-3">
        <input name="manager" value="{{ $property['manager'] }}" class="rounded-2xl border border-stone-200 px-4 py-3">
        <input name="phone" value="{{ $property['phone'] }}" class="rounded-2xl border border-stone-200 px-4 py-3">
        <input name="address" value="{{ $property['address'] }}" class="rounded-2xl border border-stone-200 px-4 py-3">
        <input name="map_url" value="{{ $property['map_url'] }}" class="md:col-span-2 rounded-2xl border border-stone-200 px-4 py-3">
        <textarea name="notes" class="md:col-span-2 min-h-28 rounded-2xl border border-stone-200 px-4 py-3">{{ $property['notes'] }}</textarea>
        <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Save profile</button>
      </form>
      <iframe title="Map" src="{{ $property['map_url'] }}" class="mt-5 h-72 w-full rounded-3xl border border-stone-200"></iframe>
    @endcomponent
  </section>
@endsection