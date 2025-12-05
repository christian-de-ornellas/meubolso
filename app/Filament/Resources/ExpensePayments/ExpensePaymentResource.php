<?php

namespace App\Filament\Resources\ExpensePayments;

use App\Filament\Resources\ExpensePayments\Pages\CreateExpensePayment;
use App\Filament\Resources\ExpensePayments\Pages\EditExpensePayment;
use App\Filament\Resources\ExpensePayments\Pages\ListExpensePayments;
use App\Filament\Resources\ExpensePayments\Pages\ViewExpensePayment;
use App\Filament\Resources\ExpensePayments\Schemas\ExpensePaymentForm;
use App\Filament\Resources\ExpensePayments\Schemas\ExpensePaymentInfolist;
use App\Filament\Resources\ExpensePayments\Tables\ExpensePaymentsTable;
use App\Models\ExpensePayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ExpensePaymentResource extends Resource
{
    protected static ?string $model = ExpensePayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Checklist Mensal';

    protected static ?string $modelLabel = 'Pagamento';

    protected static ?string $pluralModelLabel = 'Checklist de Pagamentos';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ExpensePaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExpensePaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpensePaymentsTable::configure($table);
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
            'index' => ListExpensePayments::route('/'),
            'create' => CreateExpensePayment::route('/create'),
            'view' => ViewExpensePayment::route('/{record}'),
            'edit' => EditExpensePayment::route('/{record}/edit'),
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
