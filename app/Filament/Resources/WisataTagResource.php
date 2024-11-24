<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataTagResource\Pages;
use App\Filament\Resources\WisataTagResource\RelationManagers;
use App\Models\wisata_tag;
use Filament\Forms;
use App\Models\Wisata;
use App\Models\Tag;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WisataTagResource extends Resource
{
    protected static ?string $model = wisata_tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'TAG GROUP';
    protected static ?string $navigationLabel = 'Tag By Wisata';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            //
            Forms\Components\Select::make('wisata_id')
            ->label('Wisata')
            ->options(Wisata::all()->pluck('nama_wisata', 'id'))
            ->searchable()
            ->required(),
            Forms\Components\Select::make('tag_id')
            ->label('Tag')
            ->options(Tag::all()->pluck('nama_tag', 'id'))
            ->searchable()


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('wisata_id')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('wisatas.nama_wisata')
                    ->label('Wisata')
                    ->sortable()
                    ->searchable(),
                    Tables\Columns\TextColumn::make('tag_id')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('tags.nama_tag')
                    ->label('Tag')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListWisataTags::route('/'),
            'create' => Pages\CreateWisataTag::route('/create'),
            'edit' => Pages\EditWisataTag::route('/{record}/edit'),
        ];
    }
}
