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
@extends('layouts.boarding-house', ['role' => null, 'title' => 'Login | ' . $property['name'], 'property' => $property])

@section('content')
  <main class="min-h-screen overflow-hidden text-stone-950">
    <div class="relative min-h-screen">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(135deg, rgba(20,16,12,0.66), rgba(20,16,12,0.28)), url('{{ asset('images/madajes-boarding-house-bg.jpg') }}');"></div>
      <div class="relative grid min-h-screen lg:grid-cols-[1.1fr_0.9fr]">
        <section class="flex flex-col justify-between px-6 py-8 sm:px-10 lg:px-16">
          <div class="flex items-center gap-3">
            <div class="grid h-12 w-12 place-items-center rounded-full border border-white/40 bg-white/60 text-sm font-black shadow-sm backdrop-blur">MB</div>
            <p class="text-lg font-semibold text-white drop-shadow-lg">{{ $property['name'] }}</p>
          </div>

          <div class="max-w-4xl py-16 lg:py-0">
            <p class="text-sm font-semibold uppercase tracking-[0.4em] text-amber-100 drop-shadow-lg">Live rental operations</p>
            <h1 class="mt-5 max-w-4xl text-6xl font-black leading-[0.9] tracking-[-0.08em] text-white drop-shadow-2xl sm:text-7xl lg:text-8xl">Madaje's Boarding House</h1>
            <p class="mt-6 max-w-2xl text-lg font-medium leading-8 text-white drop-shadow-lg sm:text-xl">Manage tenants, rooms, due dates, payments, reports, and account access in one Laravel portal.</p>
          </div>

          <div class="flex flex-wrap items-center gap-5 text-sm font-semibold text-white drop-shadow-lg">
            <span>{{ now()->format('M d, Y') }}</span>
            <span class="h-1.5 w-1.5 rounded-full bg-white/70"></span>
            <a href="{{ str_replace('&output=embed', '', $property['map_url']) }}" target="_blank" class="transition hover:text-amber-100">{{ $property['address'] }}</a>
          </div>
        </section>

        <section class="flex items-center justify-center bg-stone-950/25 px-6 py-10 backdrop-blur-sm lg:px-10">
          <form method="POST" action="{{ url('/login') }}" class="w-full max-w-md rounded-[2rem] border border-white bg-white/95 p-6 text-stone-950 shadow-2xl shadow-stone-950/25 backdrop-blur-xl sm:p-8">
            @csrf
            <div class="space-y-2">
              <p class="text-sm font-black uppercase tracking-[0.28em] text-amber-900">Secure login</p>
              <h2 class="text-3xl font-bold tracking-tight text-stone-950">Choose an account</h2>
              <p class="text-sm font-medium leading-6 text-stone-700">Admin accounts open management. Tenant accounts open dues, payments, reports, and profile settings.</p>
            </div>

            <input id="roleInput" type="hidden" name="role" value="admin">
            <div class="mt-6 grid grid-cols-2 gap-2 rounded-full bg-stone-100 p-1">
              <button type="button" data-role="admin" class="role-button rounded-full bg-stone-950 px-4 py-2 text-sm font-semibold text-white">Admin</button>
              <button type="button" data-role="tenant" class="role-button rounded-full px-4 py-2 text-sm font-semibold text-stone-600">Tenant</button>
            </div>

            <label class="mt-6 block text-sm font-bold text-stone-900">Username
              <input name="username" class="mt-2 w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-stone-950 outline-none transition focus:border-amber-700 focus:ring-4 focus:ring-amber-700/10" placeholder="Enter username">
            </label>

            <label class="mt-4 block text-sm font-bold text-stone-900">Password
              <input name="password" type="password" class="mt-2 w-full rounded-2xl border border-stone-200 bg-white px-4 py-3 text-stone-950 outline-none transition focus:border-amber-700 focus:ring-4 focus:ring-amber-700/10" placeholder="Enter password">
            </label>

            <button class="mt-6 w-full rounded-2xl bg-stone-950 px-5 py-3.5 font-semibold text-white transition hover:-translate-y-0.5 hover:bg-amber-800">Open dashboard</button>

            <div class="mt-5 overflow-hidden rounded-3xl border border-stone-200 bg-white">
              <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                <div>
                  <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-700">Location</p>
                  <p class="mt-1 text-sm font-semibold text-stone-950">{{ $property['address'] }}</p>
                </div>
                <a href="{{ str_replace('&output=embed', '', $property['map_url']) }}" target="_blank" class="rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700">Open Map</a>
              </div>
              <iframe title="Madaje's Boarding House map" src="{{ $property['map_url'] }}" class="h-44 w-full border-t border-stone-200" loading="lazy"></iframe>
            </div>
          </form>
        </section>
      </div>
    </div>
  </main>

  <script>
    document.querySelectorAll('.role-button').forEach((button) => {
      button.addEventListener('click', () => {
        document.getElementById('roleInput').value = button.dataset.role;
        document.querySelectorAll('.role-button').forEach((item) => item.className = 'role-button rounded-full px-4 py-2 text-sm font-semibold text-stone-600');
        button.className = 'role-button rounded-full bg-stone-950 px-4 py-2 text-sm font-semibold text-white';
      });
    });
  </script>
@endsection