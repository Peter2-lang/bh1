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
@extends('layouts.boarding-house', ['role' => 'tenant', 'active' => 'Dashboard', 'title' => 'Tenant Dashboard', 'property' => $property])

@php
  $tenant = $tenant ?? null;
  $room = $room ?? null;
  $availableRooms = collect($availableRooms ?? []);
  $balance = $balance ?? 0;
  $verifiedPaid = $verifiedPaid ?? 0;
  $sharedMonthly = $sharedMonthly ?? data_get($room, 'monthly_rate', 0);
@endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant dashboard', 'title' => 'Welcome, ' . data_get($tenant, 'name', 'Tenant'), 'text' => 'Your due is shared by room. A payment by one roommate updates everyone in the room.'])
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5"><p class="text-sm font-semibold text-stone-500">Current due</p><p class="mt-3 text-3xl font-black">PHP {{ number_format($balance, 2) }}</p></div>
      <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5"><p class="text-sm font-semibold text-stone-500">Shared monthly</p><p class="mt-3 text-3xl font-black">PHP {{ number_format($sharedMonthly, 2) }}</p></div>
      <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5"><p class="text-sm font-semibold text-stone-500">Verified paid</p><p class="mt-3 text-3xl font-black">PHP {{ number_format($verifiedPaid, 2) }}</p></div>
      <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5"><p class="text-sm font-semibold text-stone-500">Available rooms</p><p class="mt-3 text-3xl font-black">{{ $availableRooms->count() }}</p></div>
    </div>
    @component('partials.panel', ['title' => 'Boarding house location'])
      <iframe title="Map" src="{{ $property['map_url'] }}" class="h-72 w-full rounded-3xl border border-stone-200"></iframe>
    @endcomponent
  </section>
@endsection