@extends('layouts.boarding-house', ['role' => 'tenant', 'active' => 'Payment', 'title' => 'Tenant Payment'])

@php $payments = collect($payments ?? []); $sharedMonthly = $sharedMonthly ?? 0; @endphp

@section('content')
  <section class="space-y-6">
    @include('partials.header', ['eyebrow' => 'Tenant payment', 'title' => 'Send cash or GCash payment notice', 'text' => 'One shared monthly room payment covers all tenants assigned to the same room after admin verification.'])
    <div class="grid gap-6 xl:grid-cols-[0.75fr_1.25fr]">
      @component('partials.panel', ['title' => 'Submit payment'])
        <form method="POST" action="{{ url('/tenant/payment') }}" class="grid gap-4">
          @csrf
          <input name="amount" type="number" value="{{ $sharedMonthly }}" class="rounded-2xl border border-stone-200 px-4 py-3">
          <select name="method" class="rounded-2xl border border-stone-200 px-4 py-3"><option>GCash</option><option>Cash</option></select>
          <input name="reference" class="rounded-2xl border border-stone-200 px-4 py-3" placeholder="Reference or note">
          <button class="rounded-2xl bg-stone-950 px-5 py-3 font-semibold text-white">Send payment</button>
        </form>
      @endcomponent
      @component('partials.panel', ['title' => 'Room payment history'])
        <div class="grid gap-3">
          @forelse ($payments as $payment)
            <div class="rounded-3xl border border-stone-200 bg-white/75 p-4"><p class="font-semibold">PHP {{ number_format(data_get($payment, 'amount', 0), 2) }}</p><p class="text-sm text-stone-500">{{ data_get($payment, 'method') }} on {{ data_get($payment, 'payment_date') }}</p><p class="text-sm text-stone-500">{{ data_get($payment, 'status') }}</p></div>
          @empty
            <div class="rounded-3xl border border-dashed border-stone-300 p-6 text-center text-stone-500">No payments yet.</div>
          @endforelse
        </div>
      @endcomponent
    </div>
  </section>
@endsection