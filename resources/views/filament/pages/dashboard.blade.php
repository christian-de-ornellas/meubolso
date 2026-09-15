<x-filament-panels::page x-data="{ activeTab: $wire.entangle('activeTab') }">
    <x-glass-tab-nav>
        <x-glass-tab
            alpine-active="activeTab === 'receitas'"
            @click="activeTab = 'receitas'"
            color="rgb(34, 197, 94)"
        >
            Receitas
        </x-glass-tab>

        <x-glass-tab
            alpine-active="activeTab === 'despesas'"
            @click="activeTab = 'despesas'"
            color="rgb(239, 68, 68)"
        >
            Despesas
        </x-glass-tab>

        <x-glass-tab
            alpine-active="activeTab === 'comparativo'"
            @click="activeTab = 'comparativo'"
            color="rgb(245, 158, 11)"
        >
            Comparativo
        </x-glass-tab>

        <x-glass-tab
            alpine-active="activeTab === 'projecao'"
            @click="activeTab = 'projecao'"
            color="rgb(139, 92, 246)"
        >
            Projeção
        </x-glass-tab>
    </x-glass-tab-nav>

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
