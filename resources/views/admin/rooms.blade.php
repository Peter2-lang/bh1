@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Rooms', 'title' => 'Rooms'])

@php $rooms = collect($rooms ?? []); $tenants = collect($tenants ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Room inventory', 'title' => 'Add rooms and maintain statuses', 'text' => 'Track room number, capacity, inclusions, and current tenant assignment.'])

    <div class="grid gap-6 xl:grid-cols-[0.75fr_1.25fr]">
      @component('partials.panel', ['title' => 'Add room'])
        <form method="POST" action="{{ url('/admin/rooms') }}" class="grid gap-4">
          @csrf
          <label class="text-sm font-semibold text-stone-700">Room name<input name="name" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
          <label class="text-sm font-semibold text-stone-700">Room number<input name="room_number" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
          <label class="text-sm font-semibold text-stone-700">Type<input name="type" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
          <label class="text-sm font-semibold text-stone-700">Monthly rate<input name="monthly_rate" type="number" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
          <label class="text-sm font-semibold text-stone-700">Capacity<input name="capacity" type="number" min="1" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
          <label class="text-sm font-semibold text-stone-700">Inclusions<textarea name="inclusions" class="mt-2 min-h-24 w-full rounded-2xl border border-stone-200 px-4 py-3"></textarea></label>
          <label class="text-sm font-semibold text-stone-700">Status<select name="status" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"><option>Available</option><option>Occupied</option><option>Maintenance</option></select></label>
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Add room</button>
        </form>
      @endcomponent

      @component('partials.panel', ['title' => 'Rooms'])
        <div class="grid gap-3">
          @forelse ($rooms as $room)
            @php $roomTenants = $tenants->where('room_id', data_get($room, 'id')); @endphp
            <div class="rounded-3xl border border-stone-200 bg-white/75 p-4">
              <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                  <p class="font-semibold text-stone-950">{{ data_get($room, 'name') }} <span class="text-sm text-stone-500">No. {{ data_get($room, 'room_number') }}</span></p>
                  <p class="mt-1 text-sm text-stone-500">{{ data_get($room, 'type') }} room, PHP {{ number_format(data_get($room, 'monthly_rate', 0), 2) }} total monthly</p>
                  <p class="mt-1 text-sm text-stone-500">Capacity: {{ $roomTenants->count() }}/{{ data_get($room, 'capacity') }}</p>
                  <p class="mt-1 text-sm text-stone-500">Inclusions: {{ data_get($room, 'inclusions') }}</p>
                </div>
                <form method="POST" action="{{ url('/admin/rooms/' . data_get($room, 'id')) }}">
                  @csrf @method('DELETE')
                  <button class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700">Delete</button>
                </form>
              </div>
            </div>
          @empty
            <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No rooms yet.</div>
          @endforelse
        </div>
      @endcomponent
    </div>
  </section>
@endsection