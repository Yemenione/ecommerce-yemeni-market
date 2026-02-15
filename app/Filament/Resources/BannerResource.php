<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    use \Filament\Resources\Concerns\Translatable;

    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('Marketing');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['headline'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label(__('Image'))
                    ->directory('banners')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pre_title')
                    ->label(__('Pre Title (e.g. Exclusive Collection)'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('headline')
                    ->label(__('Headline'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('subheadline')
                    ->label(__('Subheadline'))
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta_text')
                    ->label(__('Button Text'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('cta_url')
                    ->label(__('Button URL'))
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('video_url')
                    ->label(__('Video URL (Optional)'))
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->label(__('Sort Order'))
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('Active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image')),
                Tables\Columns\TextColumn::make('headline')
                    ->label(__('Headline'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label(__('Sort Order'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
