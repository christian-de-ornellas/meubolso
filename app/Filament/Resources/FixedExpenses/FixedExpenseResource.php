<?php

namespace App\Filament\Resources\FixedExpenses;

use App\Filament\Resources\FixedExpenses\Pages\CreateFixedExpense;
use App\Filament\Resources\FixedExpenses\Pages\EditFixedExpense;
use App\Filament\Resources\FixedExpenses\Pages\ListFixedExpenses;
use App\Filament\Resources\FixedExpenses\Pages\ViewFixedExpense;
use App\Filament\Resources\FixedExpenses\Schemas\FixedExpenseForm;
use App\Filament\Resources\FixedExpenses\Schemas\FixedExpenseInfolist;
use App\Filament\Resources\FixedExpenses\Tables\FixedExpensesTable;
use App\Models\FixedExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FixedExpenseResource extends Resource
{
    protected static ?string $model = FixedExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $navigationLabel = 'Despesas Fixas';

    protected static ?string $modelLabel = 'Despesa Fixa';

    protected static ?string $pluralModelLabel = 'Despesas Fixas';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FixedExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FixedExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FixedExpensesTable::configure($table);
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
            'index' => ListFixedExpenses::route('/'),
            'create' => CreateFixedExpense::route('/create'),
            'view' => ViewFixedExpense::route('/{record}'),
            'edit' => EditFixedExpense::route('/{record}/edit'),
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
