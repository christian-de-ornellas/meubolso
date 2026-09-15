@props([
    'href' => null,
    'active' => false,
    'alpineActive' => null,
    'color' => 'rgb(34, 197, 94)',
])

@php
$activeStyle = "background-color: {$color}; color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;";
$inactiveStyle = "border-radius: 9999px; padding: 12px 32px;";
@endphp

@if($alpineActive)
<button
    type="button"
    :style="{{ $alpineActive }}
        ? '{{ $activeStyle }}'
        : '{{ $inactiveStyle }}'"
    class="inline-flex items-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
    :class="{{ $alpineActive }} ? '' : 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5'"
    {{ $attributes }}
>
    {{ $slot }}
</button>
@else
<a
    href="{{ $href }}"
    style="{{ $active ? $activeStyle : $inactiveStyle }}"
    class="inline-flex items-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out {{ !$active ? 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5' : '' }}"
    {{ $attributes }}
>
    {{ $slot }}
</a>
@endif
