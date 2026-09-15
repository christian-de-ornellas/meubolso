<x-filament-panels::page x-data="{ activeTab: $wire.entangle('activeTab') }">
    <div class="mb-6">
        <div class="glass-tab-nav rounded-xl p-1">
            <nav class="flex gap-1">
                {{-- Receitas --}}
                <button
                    type="button"
                    @click="activeTab = 'receitas'"
                    :style="activeTab === 'receitas'
                        ? 'background-color: rgb(34, 197, 94); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;'
                        : 'border-radius: 9999px; padding: 12px 32px;'"
                    class="flex-1 text-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                    :class="activeTab !== 'receitas' ? 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5' : ''"
                >
                    Receitas
                </button>

                {{-- Despesas --}}
                <button
                    type="button"
                    @click="activeTab = 'despesas'"
                    :style="activeTab === 'despesas'
                        ? 'background-color: rgb(239, 68, 68); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;'
                        : 'border-radius: 9999px; padding: 12px 32px;'"
                    class="flex-1 text-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                    :class="activeTab !== 'despesas' ? 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5' : ''"
                >
                    Despesas
                </button>

                {{-- Comparativo --}}
                <button
                    type="button"
                    @click="activeTab = 'comparativo'"
                    :style="activeTab === 'comparativo'
                        ? 'background-color: rgb(245, 158, 11); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;'
                        : 'border-radius: 9999px; padding: 12px 32px;'"
                    class="flex-1 text-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                    :class="activeTab !== 'comparativo' ? 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5' : ''"
                >
                    Comparativo
                </button>

                {{-- Projeção --}}
                <button
                    type="button"
                    @click="activeTab = 'projecao'"
                    :style="activeTab === 'projecao'
                        ? 'background-color: rgb(139, 92, 246); color: white; box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.08); border-radius: 9999px; padding: 12px 32px;'
                        : 'border-radius: 9999px; padding: 12px 32px;'"
                    class="flex-1 text-center whitespace-nowrap text-sm font-semibold transition-all duration-200 ease-in-out"
                    :class="activeTab !== 'projecao' ? 'text-gray-600 hover:bg-white/30 dark:text-gray-400 dark:hover:bg-white/5' : ''"
                >
                    Projeção
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
                \App\Filament\Widgets\MonthlyPaymentSummary::class,
                \App\Filament\Widgets\ExpensesByCategoryChart::class,
                \App\Filament\Widgets\UpcomingFixedExpenses::class,
                \App\Filament\Widgets\RecentVariableExpenses::class,
                \App\Filament\Widgets\MonthlyComparisonChart::class,
                \App\Filament\Widgets\BudgetProgressWidget::class,
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
                \App\Filament\Widgets\FinancialGoalsProgressWidget::class,
            ]"
        />
    </div>

    <div x-show="activeTab === 'projecao'" wire:key="projecao-widgets">
        <x-filament-widgets::widgets
            :columns="$this->getColumns()"
            :data="$this->getWidgetData()"
            :widgets="[
                \App\Filament\Widgets\CashFlowProjectionChart::class,
                \App\Filament\Widgets\AccountBalancesOverview::class,
                \App\Filament\Widgets\CreditCardUsageOverview::class,
                \App\Filament\Widgets\SubscriptionsCostOverview::class,
            ]"
        />
    </div>
</x-filament-panels::page>
