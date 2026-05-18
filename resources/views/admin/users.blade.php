@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Users', 'title' => 'Users'])

@php $accounts = collect($accounts ?? []); $tenants = collect($tenants ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'User accounts', 'title' => 'Create and edit tenant login accounts', 'text' => 'Passwords should be stored as hashes in production.'])
    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
      @component('partials.panel', ['title' => 'Add account'])
        <form method="POST" action="{{ url('/admin/users') }}" class="grid gap-4">
          @csrf
          <select name="tenant_id" class="rounded-2xl border border-stone-200 px-4 py-3"><option value="">Select tenant</option>@foreach ($tenants as $tenant)<option value="{{ data_get($tenant, 'id') }}">{{ data_get($tenant, 'name') }}</option>@endforeach</select>
          <input name="username" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Username">
          <input name="password" type="password" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Password">
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Create account</button>
        </form>
      @endcomponent
      @component('partials.panel', ['title' => 'Accounts'])
        <div class="grid gap-3">
          @forelse ($accounts as $account)
            @php $tenant = $tenants->firstWhere('id', data_get($account, 'tenant_id')); @endphp
            <div class="rounded-3xl border border-stone-200 bg-white/75 p-4"><p class="font-semibold">{{ data_get($account, 'username') }}</p><p class="text-sm text-stone-500">{{ data_get($account, 'role') }} {{ $tenant ? '- ' . data_get($tenant, 'name') : '' }}</p><p class="text-sm text-stone-500">Password: ******</p></div>
          @empty
            <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No accounts yet.</div>
          @endforelse
        </div>
      @endcomponent
    </div>
  </section>
@endsection