<x-glass-tab-nav>
    <x-glass-tab
        href="{{ route('filament.app.resources.fixed-incomes.index') }}"
        :active="request()->routeIs('filament.app.resources.fixed-incomes.index')"
        color="rgb(34, 197, 94)"
    >
        Receitas Fixas
    </x-glass-tab>
    <x-glass-tab
        href="{{ route('filament.app.resources.variable-incomes.index') }}"
        :active="request()->routeIs('filament.app.resources.variable-incomes.index')"
        color="rgb(34, 197, 94)"
    >
        Receitas Variáveis
    </x-glass-tab>
</x-glass-tab-nav>
