<?php

namespace App\Filament\Resources\IncomePayments;

use App\Filament\Resources\IncomePayments\Pages\CreateIncomePayment;
use App\Filament\Resources\IncomePayments\Pages\EditIncomePayment;
use App\Filament\Resources\IncomePayments\Pages\ListIncomePayments;
use App\Filament\Resources\IncomePayments\Pages\ViewIncomePayment;
use App\Filament\Resources\IncomePayments\Schemas\IncomePaymentForm;
use App\Filament\Resources\IncomePayments\Schemas\IncomePaymentInfolist;
use App\Filament\Resources\IncomePayments\Tables\IncomePaymentsTable;
use App\Models\IncomePayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IncomePaymentResource extends Resource
{
    protected static ?string $model = IncomePayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Recebimentos';

    protected static ?string $modelLabel = 'Recebimento';

    protected static ?string $pluralModelLabel = 'Checklist de Recebimentos';

    public static function getNavigationBadge(): ?string
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $unreceivedCount = IncomePayment::query()
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('received', false)
            ->count();

        return $unreceivedCount > 0 ? (string) $unreceivedCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return IncomePaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IncomePaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IncomePaymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomePayments::route('/'),
            'create' => CreateIncomePayment::route('/create'),
            'view' => ViewIncomePayment::route('/{record}'),
            'edit' => EditIncomePayment::route('/{record}/edit'),
        ];
    }
}
