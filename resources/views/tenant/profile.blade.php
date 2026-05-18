@extends('layouts.boarding-house', ['role' => 'tenant', 'active' => 'Profile', 'title' => 'Tenant Profile'])

@php $tenant = $tenant ?? null; $account = $account ?? null; @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Profile configuration', 'title' => 'Update your profile and login', 'text' => 'Keep your contact details updated.'])
    @component('partials.panel', ['title' => 'My profile'])
      <form method="POST" action="{{ url('/tenant/profile') }}" class="grid gap-4 md:grid-cols-2">
        @csrf @method('PUT')
        <input name="name" value="{{ data_get($tenant, 'name') }}" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Full name">
        <input name="email" value="{{ data_get($tenant, 'email') }}" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Email">
        <input name="phone" value="{{ data_get($tenant, 'phone') }}" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Phone">
        <input name="username" value="{{ data_get($account, 'username') }}" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Username">
        <input name="password" type="password" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="New password">
        <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Save profile</button>
      </form>
    @endcomponent
  </section>
@endsection