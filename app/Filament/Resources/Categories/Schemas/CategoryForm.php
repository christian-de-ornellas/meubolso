<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Cor')
                    ->default('#3b82f6')
                    ->columnSpan(1),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('icon')
                    ->label('Ícone')
                    ->options([
                        'heroicon-o-home' => '🏠 Casa',
                        'heroicon-o-shopping-cart' => '🛒 Compras',
                        'heroicon-o-truck' => '🚚 Transporte',
                        'heroicon-o-heart' => '❤️ Saúde',
                        'heroicon-o-academic-cap' => '🎓 Educação',
                        'heroicon-o-sparkles' => '✨ Lazer',
                        'heroicon-o-shopping-bag' => '🛍️ Vestuário',
                        'heroicon-o-wifi' => '📡 Serviços',
                        'heroicon-o-banknotes' => '💵 Dinheiro',
                        'heroicon-o-credit-card' => '💳 Cartão',
                        'heroicon-o-calculator' => '🧮 Calculadora',
                        'heroicon-o-chart-bar' => '📊 Gráfico',
                        'heroicon-o-document-text' => '📄 Documento',
                        'heroicon-o-clock' => '🕐 Relógio',
                        'heroicon-o-gift' => '🎁 Presente',
                        'heroicon-o-light-bulb' => '💡 Ideia',
                        'heroicon-o-wrench-screwdriver' => '🔧 Ferramentas',
                        'heroicon-o-phone' => '📱 Telefone',
                        'heroicon-o-computer-desktop' => '💻 Computador',
                        'heroicon-o-ellipsis-horizontal' => '⋯ Outros',
                    ])
                    ->searchable()
                    ->columnSpanFull(),
            ]);
    }
}
