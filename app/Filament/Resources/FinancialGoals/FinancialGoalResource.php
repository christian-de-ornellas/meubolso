<?php

namespace App\Filament\Resources\FinancialGoals;

use App\Filament\Resources\FinancialGoals\Pages\CreateFinancialGoal;
use App\Filament\Resources\FinancialGoals\Pages\EditFinancialGoal;
use App\Filament\Resources\FinancialGoals\Pages\ListFinancialGoals;
use App\Filament\Resources\FinancialGoals\Pages\ViewFinancialGoal;
use App\Filament\Resources\FinancialGoals\Schemas\FinancialGoalForm;
use App\Filament\Resources\FinancialGoals\Schemas\FinancialGoalInfolist;
use App\Filament\Resources\FinancialGoals\Tables\FinancialGoalsTable;
use App\Models\FinancialGoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FinancialGoalResource extends Resource
{
    protected static ?string $model = FinancialGoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    protected static ?string $navigationLabel = 'Metas Financeiras';

    protected static ?string $modelLabel = 'Meta Financeira';

    protected static ?string $pluralModelLabel = 'Metas Financeiras';

    protected static string|UnitEnum|null $navigationGroup = 'Planejamento';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FinancialGoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FinancialGoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinancialGoalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinancialGoals::route('/'),
            'create' => CreateFinancialGoal::route('/create'),
            'view' => ViewFinancialGoal::route('/{record}'),
            'edit' => EditFinancialGoal::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
