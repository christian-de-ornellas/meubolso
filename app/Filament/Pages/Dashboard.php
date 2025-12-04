<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BalanceStatsOverview;
use App\Filament\Widgets\BalanceTrendChart;
use App\Filament\Widgets\ExpensesByCategoryChart;
use App\Filament\Widgets\FinancialStatsOverview;
use App\Filament\Widgets\FinancialSummaryTable;
use App\Filament\Widgets\IncomesByCategoryChart;
use App\Filament\Widgets\IncomeStatsOverview;
use App\Filament\Widgets\MonthlyComparisonBarChart;
use App\Filament\Widgets\MonthlyComparisonChart;
use App\Filament\Widgets\MonthlyIncomeComparisonChart;
use App\Filament\Widgets\RecentVariableExpenses;
use App\Filament\Widgets\RecentVariableIncomes;
use App\Filament\Widgets\UpcomingFixedExpenses;
use Filament\Pages\Dashboard as BaseDashboard;
use Livewire\Attributes\Url;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard Financeiro';

    protected string $view = 'filament.pages.dashboard';

    #[Url]
    public string $activeTab = 'receitas';

    protected $listeners = ['activeTabUpdated' => '$refresh'];

    public function updatedActiveTab()
    {
        // Força atualização quando a aba muda
        $this->dispatch('activeTabUpdated');
    }

    public function getColumns(): int | array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return match ($this->activeTab) {
            'receitas' => [
                IncomeStatsOverview::class,
                IncomesByCategoryChart::class,
                MonthlyIncomeComparisonChart::class,
                RecentVariableIncomes::class,
            ],
            'despesas' => [
                FinancialStatsOverview::class,
                ExpensesByCategoryChart::class,
                UpcomingFixedExpenses::class,
                RecentVariableExpenses::class,
                MonthlyComparisonChart::class,
            ],
            'comparativo' => [
                BalanceStatsOverview::class,
                MonthlyComparisonBarChart::class,
                BalanceTrendChart::class,
                FinancialSummaryTable::class,
            ],
            default => [
                IncomeStatsOverview::class,
                IncomesByCategoryChart::class,
                MonthlyIncomeComparisonChart::class,
                RecentVariableIncomes::class,
            ],
        };
    }

    public function getVisibleWidgets(): array
    {
        return $this->getWidgets();
    }
}
