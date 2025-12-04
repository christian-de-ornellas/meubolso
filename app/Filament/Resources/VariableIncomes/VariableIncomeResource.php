<?php

namespace App\Filament\Resources\VariableIncomes;

use App\Filament\Resources\VariableIncomes\Pages\CreateVariableIncome;
use App\Filament\Resources\VariableIncomes\Pages\EditVariableIncome;
use App\Filament\Resources\VariableIncomes\Pages\ListVariableIncomes;
use App\Filament\Resources\VariableIncomes\Pages\ViewVariableIncome;
use App\Filament\Resources\VariableIncomes\Schemas\VariableIncomeForm;
use App\Filament\Resources\VariableIncomes\Schemas\VariableIncomeInfolist;
use App\Filament\Resources\VariableIncomes\Tables\VariableIncomesTable;
use App\Models\VariableIncome;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class VariableIncomeResource extends Resource
{
    protected static ?string $model = VariableIncome::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Receitas Variáveis';

    protected static ?string $modelLabel = 'Receita Variável';

    protected static ?string $pluralModelLabel = 'Receitas Variáveis';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return VariableIncomeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VariableIncomeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VariableIncomesTable::configure($table);
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
            'index' => ListVariableIncomes::route('/'),
            'create' => CreateVariableIncome::route('/create'),
            'view' => ViewVariableIncome::route('/{record}'),
            'edit' => EditVariableIncome::route('/{record}/edit'),
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
