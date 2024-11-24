<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use App\Models\acc_review;
use App\Models\Wisata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Wisata';
    protected static ?string $navigationLabel = 'Review Wisata';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('wisata_id')
            ->label('Nama Wisata')
            ->options(Wisata::all()->pluck('nama_wisata', 'id'))
            ->searchable()
            ->required(),
            Forms\Components\TextInput::make('nama_pengunjung')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('rating')
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\Textarea::make('komentar')
                ->required()
                ->columnSpanFull(),
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
                ->label('Nama Wisata')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_pengunjung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('komentar')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('accReview.status')
                    ->label('Status')
                    ->colors([
                        'success' => true,
                        'warning' => false,
                    ])
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Disetujui' : 'Belum Disetujui';
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
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('acc')
                ->label('Setujui')
                ->action(function (Review $record) {
                    if ($record->accReview) {
                        $record->accReview->update(['status' => true]);
                    } else {
                        $record->accReview()->create(['status' => true]);
                    }
                })
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->hidden(fn (Review $record) => $record->accReview?->status === true),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
