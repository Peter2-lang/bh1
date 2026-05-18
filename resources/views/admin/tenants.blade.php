@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Tenants', 'title' => 'Tenants'])

@php $rooms = collect($rooms ?? []); $tenants = collect($tenants ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant management', 'title' => 'Register tenants and transfer rooms', 'text' => 'Assign tenants to rooms and compute shared monthly payment by room occupancy.'])
    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
      @component('partials.panel', ['title' => 'Register tenant'])
        <form method="POST" action="{{ url('/admin/tenants') }}" class="grid gap-4">
          @csrf
          <input name="name" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Full name">
          <input name="email" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Email">
          <input name="phone" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Phone">
          <input name="start_date" type="date" class="rounded-2xl border border-stone-200 px-4 py-3">
          <select name="room_id" class="rounded-2xl border border-stone-200 px-4 py-3">
            @foreach ($rooms as $room)<option value="{{ data_get($room, 'id') }}">{{ data_get($room, 'name') }} No. {{ data_get($room, 'room_number') }}</option>@endforeach
          </select>
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Register tenant</button>
        </form>
      @endcomponent
      @component('partials.panel', ['title' => 'Tenant list'])
        <div class="overflow-x-auto">
          <table class="min-w-full text-left text-sm"><thead class="text-xs uppercase tracking-[0.22em] text-stone-500"><tr><th class="py-3 pr-4">Tenant</th><th class="py-3 pr-4">Room</th><th class="py-3 pr-4">Action</th></tr></thead><tbody class="divide-y divide-stone-100">
            @forelse ($tenants as $tenant)
              @php $room = $rooms->firstWhere('id', data_get($tenant, 'room_id')); @endphp
              <tr><td class="py-4 pr-4 font-semibold">{{ data_get($tenant, 'name') }}</td><td class="py-4 pr-4">{{ data_get($room, 'name', 'Unassigned') }}</td><td class="py-4 pr-4"><form method="POST" action="{{ url('/admin/tenants/' . data_get($tenant, 'id')) }}">@csrf @method('DELETE')<button class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700">Delete</button></form></td></tr>
            @empty
              <tr><td colspan="3" class="py-6 text-center text-stone-500">No tenant records yet.</td></tr>
            @endforelse
          </tbody></table>
        </div>
      @endcomponent
    </div>
  </section>
@endsection