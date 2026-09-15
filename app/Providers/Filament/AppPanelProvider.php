<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AccountBalancesOverview;
use App\Filament\Widgets\BalanceStatsOverview;
use App\Filament\Widgets\BalanceTrendChart;
use App\Filament\Widgets\BudgetProgressWidget;
use App\Filament\Widgets\CashFlowProjectionChart;
use App\Filament\Widgets\CreditCardUsageOverview;
use App\Filament\Widgets\ExpensesByCategoryChart;
use App\Filament\Widgets\FinancialGoalsProgressWidget;
use App\Filament\Widgets\FinancialStatsOverview;
use App\Filament\Widgets\FinancialSummaryTable;
use App\Filament\Widgets\IncomesByCategoryChart;
use App\Filament\Widgets\IncomeStatsOverview;
use App\Filament\Widgets\MonthlyComparisonBarChart;
use App\Filament\Widgets\MonthlyComparisonChart;
use App\Filament\Widgets\MonthlyIncomeComparisonChart;
use App\Filament\Widgets\RecentVariableExpenses;
use App\Filament\Widgets\RecentVariableIncomes;
use App\Filament\Widgets\SubscriptionsCostOverview;
use App\Filament\Widgets\UpcomingFixedExpenses;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login()
            ->registration()
            ->brandName('MeuBolso')
            ->darkMode()
            ->font('Instrument Sans')
            ->favicon(asset('favicon.svg'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                NavigationGroup::make('Receitas'),
                NavigationGroup::make('Despesas'),
                NavigationGroup::make('Contas'),
                NavigationGroup::make('Planejamento'),
                NavigationGroup::make('Configuração'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->databaseNotifications()
            ->widgets([
                // Tab Receitas
                IncomeStatsOverview::class,
                IncomesByCategoryChart::class,
                MonthlyIncomeComparisonChart::class,
                RecentVariableIncomes::class,

                // Tab Despesas
                FinancialStatsOverview::class,
                ExpensesByCategoryChart::class,
                UpcomingFixedExpenses::class,
                RecentVariableExpenses::class,
                MonthlyComparisonChart::class,
                BudgetProgressWidget::class,

                // Tab Comparativo
                BalanceStatsOverview::class,
                MonthlyComparisonBarChart::class,
                BalanceTrendChart::class,
                FinancialSummaryTable::class,
                FinancialGoalsProgressWidget::class,

                // Tab Projeção
                CashFlowProjectionChart::class,
                AccountBalancesOverview::class,
                CreditCardUsageOverview::class,
                SubscriptionsCostOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Tutorial')
                    ->icon('heroicon-o-academic-cap')
                    ->url('/app/tutorial'),
            ]);
    }
}
