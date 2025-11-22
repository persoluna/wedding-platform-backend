<?php

namespace App\Filament\Resources\Vendors\Schemas;

use App\Models\Category;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name', fn ($query) => $query->whereHas('roles', fn ($rolesQuery) => $rolesQuery->where('name', 'vendor')))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Category name')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->rows(3),
                                Toggle::make('active')
                                    ->default(true),
                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->default(false),
                            ])
                            ->createOptionModalHeading('Create category')
                            ->createOptionUsing(function (array $data): int {
                                $name = $data['name'];
                                $baseSlug = Str::slug($name);
                                $slug = $baseSlug;
                                $suffix = 2;

                                while (Category::where('slug', $slug)->exists()) {
                                    $slug = $baseSlug . '-' . $suffix;
                                    $suffix++;
                                }

                                $category = Category::create([
                                    'name' => $name,
                                    'slug' => $slug,
                                    'description' => $data['description'] ?? null,
                                    'active' => $data['active'] ?? true,
                                    'is_featured' => $data['is_featured'] ?? false,
                                ]);

                                return $category->getKey();
                            }),
                        TextInput::make('business_name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->readOnly(),
                        Select::make('owning_agency_id')
                            ->relationship('owningAgency', 'business_name')
                            ->searchable()
                            ->preload()
                            ->default(function (): ?int {
                                $user = Auth::user();

                                if (! $user || ! $user->isAgency()) {
                                    return null;
                                }

                                return optional($user->agency)->getKey();
                            })
                            ->disabled(fn () => Auth::user()?->isAgency())
                            ->required(),
                        Hidden::make('created_by_user_id')
                            ->default(fn (): ?int => Auth::id()),
                    ]),
                RichEditor::make('description')
                    ->columnSpanFull(),
                FileUpload::make('logo')
                    ->image(),
                FileUpload::make('banner')
                    ->image(),
                TextInput::make('website')
                    ->url(),
                Textarea::make('address')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('city'),
                        TextInput::make('state'),
                        TextInput::make('postal_code'),
                    ]),
                TextInput::make('country')
                    ->required()
                    ->default('India'),
                Grid::make(2)
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric(),
                        TextInput::make('longitude')
                            ->numeric(),
                    ]),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('whatsapp'),
                Grid::make(2)
                    ->schema([
                        TextInput::make('min_price')
                            ->numeric()
                            ->default(0),
                        TextInput::make('max_price')
                            ->numeric()
                            ->default(0),
                    ]),
                TextInput::make('price_unit')
                    ->default('per event')
                    ->required(),
                Textarea::make('price_notes')
                    ->columnSpanFull(),
                Textarea::make('service_areas')
                    ->columnSpanFull(),
                Textarea::make('specialties')
                    ->columnSpanFull(),
                KeyValue::make('attributes')
                    ->columnSpanFull()
                    ->keyLabel('Attribute')
                    ->valueLabel('Value')
                    ->addButtonLabel('Add attribute')
                    ->nullable(),
                Textarea::make('working_hours')
                    ->columnSpanFull(),
                TextInput::make('years_in_business')
                    ->numeric(),
                Textarea::make('business_registration_info')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        Toggle::make('verified')
                            ->required(),
                        Toggle::make('featured')
                            ->required(),
                        Toggle::make('premium')
                            ->required(),
                    ]),
                TextInput::make('avg_rating')
                    ->numeric()
                    ->default(0),
                TextInput::make('review_count')
                    ->numeric()
                    ->default(0),
                TextInput::make('views_count')
                    ->numeric()
                    ->default(0),
                TextInput::make('subscription_status')
                    ->required()
                    ->default('free'),
                DateTimePicker::make('subscription_expires_at'),
            ]);
    }
}
