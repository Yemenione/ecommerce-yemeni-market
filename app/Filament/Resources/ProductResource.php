<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    use \Filament\Resources\Concerns\Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $navigationLabel = null;

    public static function getModelLabel(): string
    {
        return __('Product');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }

    public static function getNavigationLabel(): string
    {
        return __('Products');
    }
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make(__('Product Management'))
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('General Information'))
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->required(),
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('sku')
                                            ->label(__('SKU'))
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\TextInput::make('base_price')
                                            ->label(__('Base Price (€)'))
                                            ->numeric()
                                            ->required()
                                            ->prefix('€'),
                                        Forms\Components\TextInput::make('stock')
                                            ->numeric()
                                            ->required()
                                            ->default(0),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label(__('Active Status'))
                                            ->default(true),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label(__('Featured Product')),
                                        Forms\Components\Toggle::make('is_flash_sale')
                                            ->label(__('On Flash Sale')),
                                        Forms\Components\Select::make('tax_id')
                                            ->label(__('Tax Rate'))
                                            ->relationship('tax', 'name')
                                            ->searchable()
                                            ->preload(),
                                    ])->columns(2),
                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull(),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make(__('Luxury Details'))
                            ->schema([
                                Forms\Components\Section::make(__('Premium Attributes'))
                                    ->description(__('Enter materials and care instructions for the luxury feel.'))
                                    ->schema([
                                        Forms\Components\TextInput::make('material')
                                            ->label(__('Material/Fabric'))
                                            ->placeholder('e.g., Pure Sidr Honey, Yemen Silk'),
                                        Forms\Components\TextInput::make('dimensions')
                                            ->label(__('Dimensions/Weight'))
                                            ->placeholder('e.g., 500g, 10x10x20cm'),
                                        Forms\Components\RichEditor::make('care_instructions')
                                            ->label(__('Care Instructions'))
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make(__('Imagery'))
                            ->schema([
                                Forms\Components\Section::make(__('Product Gallery'))
                                    ->description(__('Split your images for better customer presentation.'))
                                    ->schema([
                                        Forms\Components\FileUpload::make('images')
                                            ->label(__('Main Studio Gallery'))
                                            ->multiple()
                                            ->directory('products/studio')
                                            ->image()
                                            ->reorderable()
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('detail_images')
                                            ->label(__('Detail & Close-up Photos'))
                                            ->multiple()
                                            ->directory('products/details')
                                            ->image()
                                            ->reorderable()
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('lifestyle_images')
                                            ->label(__('Lifestyle & Context Images'))
                                            ->multiple()
                                            ->directory('products/lifestyle')
                                            ->image()
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make(__('Variants'))
                            ->schema([
                                Forms\Components\Repeater::make('variants')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('sku')
                                            ->label(__('Variant SKU'))
                                            ->required(),
                                        Forms\Components\ColorPicker::make('color_code')
                                            ->label(__('Color')),
                                        Forms\Components\TextInput::make('size')
                                            ->label(__('Size/Volume')),
                                        Forms\Components\TextInput::make('weight')
                                            ->label(__('Weight (e.g., 500g, 1kg)')),
                                        Forms\Components\TextInput::make('stock')
                                            ->numeric()
                                            ->default(0)
                                            ->required(),
                                        Forms\Components\TextInput::make('price_modifier')
                                            ->numeric()
                                            ->default(0)
                                            ->prefix('€'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label(__('Thumbnail'))
                    ->circular()
                    ->stacked()
                    ->limit(1),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->money('EUR')
                    ->sortable()
                    ->label(__('Price')),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_flash_sale')
                    ->boolean()
                    ->label(__('Sale')),
                Tables\Columns\IconColumn::make('is_featured')
                                    ->boolean()
                                    ->label(__('Featured')),
                                Tables\Columns\IconColumn::make('is_active')
                                    ->boolean()
                                    ->label(__('Active')),
                            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
