<x-filament-panels::page>
    <div class="mb-6">
        <div class="glass-tab-nav rounded-xl p-1">
            <nav class="flex gap-1">
                <a
                    href="{{ route('filament.app.resources.fixed-incomes.index') }}"
                    style="background-color: rgb(34, 197, 94); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;"
                    class="whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                >
                    Receitas Fixas
                </a>
                <a
                    href="{{ route('filament.app.resources.variable-incomes.index') }}"
                    style="border-radius: 9999px; padding: 12px 32px;"
                    class="whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5"
                >
                    Receitas Variáveis
                </a>
            </nav>
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
