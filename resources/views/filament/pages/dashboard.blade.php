<x-filament-panels::page x-data="{ activeTab: $wire.entangle('activeTab') }">
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8">
                <button
                    type="button"
                    @click="activeTab = 'receitas'"
                    :class="activeTab === 'receitas'
                        ? 'border-primary-500 text-primary-600 dark:text-primary-400'
                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition"
                >
                    Receitas
                </button>
                <button
                    type="button"
                    @click="activeTab = 'despesas'"
                    :class="activeTab === 'despesas'
                        ? 'border-primary-500 text-primary-600 dark:text-primary-400'
                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition"
                >
                    Despesas
                </button>
                <button
                    type="button"
                    @click="activeTab = 'comparativo'"
                    :class="activeTab === 'comparativo'
                        ? 'border-primary-500 text-primary-600 dark:text-primary-400'
                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition"
                >
                    Comparativo
                </button>
            </nav>
        </div>
    </div>

    <div x-show="activeTab === 'receitas'" wire:key="receitas-widgets">
        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :data="$this->getWidgetData()"
            :widgets="[
                \App\Filament\Widgets\IncomeStatsOverview::class,
                \App\Filament\Widgets\IncomesByCategoryChart::class,
                \App\Filament\Widgets\MonthlyIncomeComparisonChart::class,
                \App\Filament\Widgets\RecentVariableIncomes::class,
            ]"
        />
    </div>

    <div x-show="activeTab === 'despesas'" wire:key="despesas-widgets">
        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :data="$this->getWidgetData()"
            :widgets="[
                \App\Filament\Widgets\FinancialStatsOverview::class,
                \App\Filament\Widgets\ExpensesByCategoryChart::class,
                \App\Filament\Widgets\UpcomingFixedExpenses::class,
                \App\Filament\Widgets\RecentVariableExpenses::class,
                \App\Filament\Widgets\MonthlyComparisonChart::class,
            ]"
        />
    </div>

    <div x-show="activeTab === 'comparativo'" wire:key="comparativo-widgets">
        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :data="$this->getWidgetData()"
            :widgets="[
                \App\Filament\Widgets\BalanceStatsOverview::class,
                \App\Filament\Widgets\MonthlyComparisonBarChart::class,
                \App\Filament\Widgets\BalanceTrendChart::class,
                \App\Filament\Widgets\FinancialSummaryTable::class,
            ]"
        />
    </div>
</x-filament-panels::page>
