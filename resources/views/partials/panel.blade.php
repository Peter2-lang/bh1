<div class="rounded-[2rem] border border-white/70 bg-white/80 p-5 shadow-sm shadow-stone-900/5 backdrop-blur md:p-6">
  @isset($title)
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
      <h3 class="text-xl font-bold tracking-tight text-stone-950">{{ $title }}</h3>
      {{ $action ?? '' }}
    </div>
  @endisset
  {{ $slot }}
</div>