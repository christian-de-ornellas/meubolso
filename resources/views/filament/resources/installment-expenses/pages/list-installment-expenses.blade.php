<x-filament-panels::page>
    <div class="mb-6">
        <div class="glass-tab-nav w-fit rounded-xl p-1">
            <nav class="flex gap-1">
                <a
                    href="{{ route('filament.app.resources.fixed-expenses.index') }}"
                    style="border-radius: 9999px; padding: 12px 32px;"
                    class="whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5"
                >
                    Despesas Fixas
                </a>
                <a
                    href="{{ route('filament.app.resources.variable-expenses.index') }}"
                    style="border-radius: 9999px; padding: 12px 32px;"
                    class="whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5"
                >
                    Despesas Variáveis
                </a>
                <a
                    href="{{ route('filament.app.resources.installment-expenses.index') }}"
                    style="background-color: rgb(99, 102, 241); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;"
                    class="whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                >
                    Parcelamentos
                </a>
            </nav>
        </div>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
