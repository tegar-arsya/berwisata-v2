<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Image;
use App\Models\Wisata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wisata';
    protected static ?string $navigationLabel = 'Gambar Wisata';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wisata_id')
                ->label('Wisata')
                ->options(Wisata::all()->pluck('nama_wisata', 'id'))
                ->searchable()
                ->required(),
                Forms\Components\FileUpload::make('image_path')
                ->image()
                ->disk('public/gambar-wisata')
                ->multiple()
                ->reorderable()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wisata_id')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('wisata.nama_wisata')
                    ->label('Wisata')
                    ->numeric()
                    ->sortable(),
                    ImageColumn::make('image_path')
                    ->label('Foto')
                    ->size(50) // Ukuran preview gambar
                    ->getStateUsing(function ($record) {
                        // Pastikan path lengkap untuk gambar
                        $images = is_array($record->image_path) ? $record->image_path : json_decode($record->image_path, true);
                        return isset($images[0]) ? asset('gambar-wisata/' . $images[0]) : null;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
