<?php

namespace App\Filament\Resources\FixedIncomes;

use App\Filament\Resources\FixedIncomes\Pages\CreateFixedIncome;
use App\Filament\Resources\FixedIncomes\Pages\EditFixedIncome;
use App\Filament\Resources\FixedIncomes\Pages\ListFixedIncomes;
use App\Filament\Resources\FixedIncomes\Pages\ViewFixedIncome;
use App\Filament\Resources\FixedIncomes\Schemas\FixedIncomeForm;
use App\Filament\Resources\FixedIncomes\Schemas\FixedIncomeInfolist;
use App\Filament\Resources\FixedIncomes\Tables\FixedIncomesTable;
use App\Models\FixedIncome;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FixedIncomeResource extends Resource
{
    protected static ?string $model = FixedIncome::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $navigationLabel = 'Receitas Fixas';

    protected static ?string $modelLabel = 'Receita Fixa';

    protected static ?string $pluralModelLabel = 'Receitas Fixas';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return FixedIncomeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FixedIncomeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FixedIncomesTable::configure($table);
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
            'index' => ListFixedIncomes::route('/'),
            'create' => CreateFixedIncome::route('/create'),
            'view' => ViewFixedIncome::route('/{record}'),
            'edit' => EditFixedIncome::route('/{record}/edit'),
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
