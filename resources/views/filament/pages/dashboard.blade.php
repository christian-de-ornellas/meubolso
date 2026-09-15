<x-filament-panels::page x-data="{ activeTab: $wire.entangle('activeTab') }">
    <div class="mb-6">
        <div
            style="
                background: var(--glass-bg);
                backdrop-filter: blur(var(--glass-blur));
                -webkit-backdrop-filter: blur(var(--glass-blur));
                border: 1px solid var(--glass-border);
                box-shadow: var(--glass-shadow);
            "
            class="rounded-2xl p-1.5"
        >
            <nav class="flex gap-1">
                {{-- Receitas --}}
                <button
                    type="button"
                    @click="activeTab = 'receitas'"
                    x-on:mouseenter="$el.dataset.hover = 'true'"
                    x-on:mouseleave="$el.dataset.hover = 'false'"
                    :style="activeTab === 'receitas'
                        ? 'background: linear-gradient(135deg, rgb(34, 197, 94), rgb(22, 163, 74)); color: white; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35), inset 0 1px 0 rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.15);'
                        : ($el.dataset.hover === 'true' ? 'background: rgba(34, 197, 94, 0.08);' : '')"
                    class="flex-1 whitespace-nowrap rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-300 ease-out"
                    :class="activeTab !== 'receitas' ? 'text-gray-600 dark:text-gray-400' : ''"
                >
                    Receitas
                </button>

                {{-- Despesas --}}
                <button
                    type="button"
                    @click="activeTab = 'despesas'"
                    x-on:mouseenter="$el.dataset.hover = 'true'"
                    x-on:mouseleave="$el.dataset.hover = 'false'"
                    :style="activeTab === 'despesas'
                        ? 'background: linear-gradient(135deg, rgb(239, 68, 68), rgb(220, 38, 38)); color: white; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.35), inset 0 1px 0 rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.15);'
                        : ($el.dataset.hover === 'true' ? 'background: rgba(239, 68, 68, 0.08);' : '')"
                    class="flex-1 whitespace-nowrap rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-300 ease-out"
                    :class="activeTab !== 'despesas' ? 'text-gray-600 dark:text-gray-400' : ''"
                >
                    Despesas
                </button>

                {{-- Comparativo --}}
                <button
                    type="button"
                    @click="activeTab = 'comparativo'"
                    x-on:mouseenter="$el.dataset.hover = 'true'"
                    x-on:mouseleave="$el.dataset.hover = 'false'"
                    :style="activeTab === 'comparativo'
                        ? 'background: linear-gradient(135deg, rgb(245, 158, 11), rgb(217, 119, 6)); color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35), inset 0 1px 0 rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.15);'
                        : ($el.dataset.hover === 'true' ? 'background: rgba(245, 158, 11, 0.08);' : '')"
                    class="flex-1 whitespace-nowrap rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-300 ease-out"
                    :class="activeTab !== 'comparativo' ? 'text-gray-600 dark:text-gray-400' : ''"
                >
                    Comparativo
                </button>

                {{-- Projeção --}}
                <button
                    type="button"
                    @click="activeTab = 'projecao'"
                    x-on:mouseenter="$el.dataset.hover = 'true'"
                    x-on:mouseleave="$el.dataset.hover = 'false'"
                    :style="activeTab === 'projecao'
                        ? 'background: linear-gradient(135deg, rgb(139, 92, 246), rgb(109, 40, 217)); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.35), inset 0 1px 0 rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.15);'
                        : ($el.dataset.hover === 'true' ? 'background: rgba(139, 92, 246, 0.08);' : '')"
                    class="flex-1 whitespace-nowrap rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-300 ease-out"
                    :class="activeTab !== 'projecao' ? 'text-gray-600 dark:text-gray-400' : ''"
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
