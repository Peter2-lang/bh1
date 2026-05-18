@extends('layouts.boarding-house', ['role' => 'admin', 'active' => 'Payments', 'title' => 'Payments'])

@php $rooms = collect($rooms ?? []); $tenants = collect($tenants ?? []); $payments = collect($payments ?? []); @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Payments', 'title' => 'Add payments and print reports', 'text' => 'Payments are room-connected. One tenant payment covers the room ledger for all tenants in the same room.'])

    @component('partials.panel', ['title' => 'Add payment'])
      <form method="POST" action="{{ url('/admin/payments') }}" class="grid gap-4 lg:grid-cols-[1fr_1fr_1fr_1fr_auto] lg:items-end">
        @csrf
        <label class="text-sm font-semibold text-stone-700">Tenant / room
          <select name="tenant_id" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3">
            @foreach ($tenants as $tenant)
              @php $room = $rooms->firstWhere('id', data_get($tenant, 'room_id')); @endphp
              <option value="{{ data_get($tenant, 'id') }}">{{ data_get($tenant, 'name') }} - {{ data_get($room, 'name', 'No room') }}</option>
            @endforeach
          </select>
        </label>
        <label class="text-sm font-semibold text-stone-700">Amount<input name="amount" type="number" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
        <label class="text-sm font-semibold text-stone-700">Method<select name="method" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"><option>Cash</option><option>GCash</option><option>E-cash</option></select></label>
        <label class="text-sm font-semibold text-stone-700">Date<input name="payment_date" type="date" value="{{ now()->toDateString() }}" readonly class="mt-2 w-full rounded-2xl border border-stone-200 bg-stone-50 px-4 py-3"></label>
        <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Add payment</button>
        <label class="lg:col-span-4 text-sm font-semibold text-stone-700">Reference<input name="reference" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"></label>
        <label class="text-sm font-semibold text-stone-700">Status<select name="status" class="mt-2 w-full rounded-2xl border border-stone-200 px-4 py-3"><option>Verified</option><option>Pending</option></select></label>
      </form>
    @endcomponent

    @component('partials.panel', ['title' => 'Payment ledger'])
      <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead class="text-xs uppercase tracking-[0.22em] text-stone-500"><tr><th class="py-3 pr-4">Tenant</th><th class="py-3 pr-4">Room</th><th class="py-3 pr-4">Date</th><th class="py-3 pr-4">Method</th><th class="py-3 pr-4">Amount</th><th class="py-3 pr-4">Status</th><th class="py-3 pr-4">Action</th></tr></thead>
          <tbody class="divide-y divide-stone-100">
            @forelse ($payments as $payment)
              @php $tenant = $tenants->firstWhere('id', data_get($payment, 'tenant_id')); $room = $rooms->firstWhere('id', data_get($tenant, 'room_id')); @endphp
              <tr>
                <td class="py-4 pr-4 font-semibold">{{ data_get($tenant, 'name', 'Unknown') }}</td>
                <td class="py-4 pr-4">{{ data_get($room, 'name', 'Unassigned') }}</td>
                <td class="py-4 pr-4">{{ data_get($payment, 'payment_date') }}</td>
                <td class="py-4 pr-4">{{ data_get($payment, 'method') }}</td>
                <td class="py-4 pr-4 font-semibold">PHP {{ number_format(data_get($payment, 'amount', 0), 2) }}</td>
                <td class="py-4 pr-4">{{ data_get($payment, 'status') }}</td>
                <td class="py-4 pr-4"><a class="rounded-full border border-stone-200 px-3 py-1.5 text-xs font-semibold" href="{{ url('/admin/payments/' . data_get($payment, 'id') . '/print') }}">Print</a></td>
              </tr>
            @empty
              <tr><td colspan="7" class="py-6 text-center text-stone-500">No payment records yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    @endcomponent
  </section>
@endsection