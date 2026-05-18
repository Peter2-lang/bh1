@php
  $property = $property ?? [
    'name' => "Madaje's Boarding House",
    'address' => '95WX+QQP Hinunangan, Southern Leyte. Nearby Address: San Pedro Street, Hinunangan, Southern Leyte',
    'map_url' => 'https://www.google.com/maps?q=10.3969560,125.1994614&z=18&output=embed',
    'manager' => 'Mariel Daje',
    'phone' => '0918 234 8899',
    'notes' => 'Quiet, clean, and close to school routes.',
  ];
  $role = $role ?? null;
  $active = $active ?? '';
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $property['name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      @media print {
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        body { background: #fff !important; }
      }
      .print-only { display: none; }
    </style>
  </head>
  <body class="min-h-screen bg-[#f6f1e9] text-stone-950 antialiased">
    @if ($role)
      <main class="mx-auto flex min-h-screen max-w-[1600px]">
        @include('partials.sidebar', ['role' => $role, 'active' => $active, 'property' => $property])
        <section class="min-w-0 flex-1 p-4 sm:p-6 lg:p-8">
          <div class="mb-5 rounded-[2rem] border border-white/70 bg-white/80 p-4 shadow-sm shadow-stone-900/5 backdrop-blur lg:hidden no-print">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <p class="text-xs uppercase tracking-[0.25em] text-stone-500">{{ ucfirst($role) }} Portal</p>
                <p class="font-black text-stone-950">{{ $property['name'] }}</p>
              </div>
              <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="rounded-full bg-stone-950 px-4 py-2 text-sm font-semibold text-white">Log out</button>
              </form>
            </div>
          </div>
          @yield('content')
        </section>
      </main>
    @else
      @yield('content')
    @endif
  </body>
</html>