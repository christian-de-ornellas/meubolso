<?php

namespace App\Filament\Resources\AccountTransfers;

use App\Filament\Resources\AccountTransfers\Pages\CreateAccountTransfer;
use App\Filament\Resources\AccountTransfers\Pages\EditAccountTransfer;
use App\Filament\Resources\AccountTransfers\Pages\ListAccountTransfers;
use App\Filament\Resources\AccountTransfers\Pages\ViewAccountTransfer;
use App\Filament\Resources\AccountTransfers\Schemas\AccountTransferForm;
use App\Filament\Resources\AccountTransfers\Schemas\AccountTransferInfolist;
use App\Filament\Resources\AccountTransfers\Tables\AccountTransfersTable;
use App\Models\AccountTransfer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AccountTransferResource extends Resource
{
    protected static ?string $model = AccountTransfer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $navigationLabel = 'Transferências';

    protected static ?string $modelLabel = 'Transferência';

    protected static ?string $pluralModelLabel = 'Transferências';

    protected static string|UnitEnum|null $navigationGroup = 'Contas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return AccountTransferForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AccountTransferInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccountTransfersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccountTransfers::route('/'),
            'create' => CreateAccountTransfer::route('/create'),
            'view' => ViewAccountTransfer::route('/{record}'),
            'edit' => EditAccountTransfer::route('/{record}/edit'),
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
