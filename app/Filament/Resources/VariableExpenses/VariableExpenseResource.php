<?php

namespace App\Filament\Resources\VariableExpenses;

use App\Filament\Resources\VariableExpenses\Pages\CreateVariableExpense;
use App\Filament\Resources\VariableExpenses\Pages\EditVariableExpense;
use App\Filament\Resources\VariableExpenses\Pages\ListVariableExpenses;
use App\Filament\Resources\VariableExpenses\Pages\ViewVariableExpense;
use App\Filament\Resources\VariableExpenses\Schemas\VariableExpenseForm;
use App\Filament\Resources\VariableExpenses\Schemas\VariableExpenseInfolist;
use App\Filament\Resources\VariableExpenses\Tables\VariableExpensesTable;
use App\Models\VariableExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VariableExpenseResource extends Resource
{
    protected static ?string $model = VariableExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Despesas Variáveis';

    protected static ?string $modelLabel = 'Despesa Variável';

    protected static ?string $pluralModelLabel = 'Despesas Variáveis';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return VariableExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VariableExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VariableExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVariableExpenses::route('/'),
            'create' => CreateVariableExpense::route('/create'),
            'view' => ViewVariableExpense::route('/{record}'),
            'edit' => EditVariableExpense::route('/{record}/edit'),
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
