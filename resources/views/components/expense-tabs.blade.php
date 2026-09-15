<x-glass-tab-nav>
    <x-glass-tab
        href="{{ route('filament.app.resources.fixed-expenses.index') }}"
        :active="request()->routeIs('filament.app.resources.fixed-expenses.index')"
        color="rgb(239, 68, 68)"
    >
        Despesas Fixas
    </x-glass-tab>
    <x-glass-tab
        href="{{ route('filament.app.resources.variable-expenses.index') }}"
        :active="request()->routeIs('filament.app.resources.variable-expenses.index')"
        color="rgb(245, 158, 11)"
    >
        Despesas Variáveis
    </x-glass-tab>
    <x-glass-tab
        href="{{ route('filament.app.resources.installment-expenses.index') }}"
        :active="request()->routeIs('filament.app.resources.installment-expenses.index')"
        color="rgb(99, 102, 241)"
    >
        Parcelamentos
    </x-glass-tab>
</x-glass-tab-nav>
