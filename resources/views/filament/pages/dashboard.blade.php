<x-filament-panels::page>
    <x-filament::tabs wire:model.live="activeTab">
        <x-filament::tabs.item value="receitas">
            Receitas
        </x-filament::tabs.item>

        <x-filament::tabs.item value="despesas">
            Despesas
        </x-filament::tabs.item>

        <x-filament::tabs.item value="comparativo">
            Comparativo
        </x-filament::tabs.item>
    </x-filament::tabs>

    @if($activeTab === 'receitas')
        <div wire:key="receitas-widgets">
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
    @elseif($activeTab === 'despesas')
        <div wire:key="despesas-widgets">
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
    @elseif($activeTab === 'comparativo')
        <div wire:key="comparativo-widgets">
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
    @endif
</x-filament-panels::page>
