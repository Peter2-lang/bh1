@php
  $adminNav = [
    ['label' => 'Overview', 'href' => '/admin/dashboard'],
    ['label' => 'Tenants', 'href' => '/admin/tenants'],
    ['label' => 'Rooms', 'href' => '/admin/rooms'],
    ['label' => 'Payments', 'href' => '/admin/payments'],
    ['label' => 'Calendar', 'href' => '/admin/calendar'],
    ['label' => 'Reports', 'href' => '/admin/reports'],
    ['label' => 'Users', 'href' => '/admin/users'],
    ['label' => 'Profile', 'href' => '/admin/profile'],
  ];
  $tenantNav = [
    ['label' => 'Dashboard', 'href' => '/tenant/dashboard'],
    ['label' => 'Calendar', 'href' => '/tenant/calendar'],
    ['label' => 'Payment', 'href' => '/tenant/payment'],
    ['label' => 'Reports', 'href' => '/tenant/reports'],
    ['label' => 'Profile', 'href' => '/tenant/profile'],
  ];
  $nav = $role === 'admin' ? $adminNav : $tenantNav;
@endphp
<aside class="sticky top-0 hidden h-screen w-72 shrink-0 border-r border-stone-200/80 bg-white/60 p-5 backdrop-blur-xl lg:block no-print">
  <div class="flex h-full flex-col">
    <div class="rounded-[2rem] bg-stone-950 p-5 text-white shadow-xl shadow-stone-900/10">
      <p class="text-xs uppercase tracking-[0.3em] text-white/50">{{ ucfirst($role) }} Portal</p>
      <h1 class="mt-3 text-2xl font-black leading-none tracking-tight">{{ $property['name'] }}</h1>
      <p class="mt-3 text-sm leading-6 text-white/65">{{ $property['address'] }}</p>
    </div>

    <nav class="mt-6 grid gap-2">
      @foreach ($nav as $item)
        <a href="{{ url($item['href']) }}" class="rounded-2xl px-4 py-3 text-left text-sm font-semibold transition {{ $active === $item['label'] ? 'bg-amber-800 text-white shadow-lg shadow-amber-900/10' : 'text-stone-600 hover:bg-white hover:text-stone-950' }}">
          {{ $item['label'] }}
        </a>
      @endforeach
    </nav>

    <div class="mt-auto rounded-3xl border border-stone-200 bg-white/75 p-4">
      <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Signed in as</p>
      <p class="mt-2 font-semibold text-stone-950">{{ auth()->user()->name ?? auth()->user()->username ?? 'User' }}</p>
      <form method="POST" action="{{ url('/logout') }}">
        @csrf
        <button class="mt-4 w-full rounded-2xl bg-stone-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-800">
          Log out
        </button>
      </form>
    </div>
  </div>
</aside>