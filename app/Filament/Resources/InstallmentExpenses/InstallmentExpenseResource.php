<?php

namespace App\Filament\Resources\InstallmentExpenses;

use App\Filament\Resources\InstallmentExpenses\Pages\CreateInstallmentExpense;
use App\Filament\Resources\InstallmentExpenses\Pages\EditInstallmentExpense;
use App\Filament\Resources\InstallmentExpenses\Pages\ListInstallmentExpenses;
use App\Filament\Resources\InstallmentExpenses\Pages\ViewInstallmentExpense;
use App\Filament\Resources\InstallmentExpenses\Schemas\InstallmentExpenseForm;
use App\Filament\Resources\InstallmentExpenses\Schemas\InstallmentExpenseInfolist;
use App\Filament\Resources\InstallmentExpenses\Tables\InstallmentExpensesTable;
use App\Models\InstallmentExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class InstallmentExpenseResource extends Resource
{
    protected static ?string $model = InstallmentExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static ?string $navigationLabel = 'Parcelamentos';

    protected static ?string $modelLabel = 'Parcelamento';

    protected static ?string $pluralModelLabel = 'Parcelamentos';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return InstallmentExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstallmentExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstallmentExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\InstallmentExpenses\RelationManagers\InstallmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstallmentExpenses::route('/'),
            'create' => CreateInstallmentExpense::route('/create'),
            'view' => ViewInstallmentExpense::route('/{record}'),
            'edit' => EditInstallmentExpense::route('/{record}/edit'),
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
