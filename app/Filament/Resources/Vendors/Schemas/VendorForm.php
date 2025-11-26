<?php

namespace App\Filament\Resources\Vendors\Schemas;

use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use Closure;
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
use Filament\Schemas\Components\Section;
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
                Section::make('Vendor account')
                    ->schema([
                        Select::make('user_id')
                            ->label('Vendor user')
                            ->relationship('user', 'name', fn ($query) => $query->where('type', 'vendor'))
                            ->searchable()
                            ->preload()
                            ->required(fn () => Auth::user()?->isAdmin())
                            ->visible(fn () => Auth::user()?->isAdmin())
                            ->rule(fn (?Vendor $record) => function (string $attribute, $value, Closure $fail) use ($record): void {
                                if (! $value || ! Auth::user()?->isAdmin()) {
                                    return;
                                }

                                $exists = Vendor::withTrashed()
                                    ->where('user_id', $value)
                                    ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))
                                    ->exists();

                                if ($exists) {
                                    $fail('This vendor user is already linked to another vendor record.');
                                }
                            }),
                        TextInput::make('email')
                            ->label('Vendor email')
                            ->email()
                            ->required(fn () => Auth::user()?->isAgency())
                            ->rule(fn () => function (string $attribute, ?string $value, Closure $fail): void {
                                if (! $value) {
                                    return;
                                }

                                if (! Auth::user()?->isAgency()) {
                                    return;
                                }

                                $existing = User::withTrashed()->where('email', $value)->first();

                                if (! $existing) {
                                    return;
                                }

                                if ($existing->trashed()) {
                                    $fail('This email belongs to an inactive account. Ask an admin to restore or delete it before reusing.');

                                    return;
                                }

                                if (! $existing->isVendor()) {
                                    $fail('This email is already assigned to another account type.');
                                }
                            }),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('vendor_password')
                                    ->label('Account password')
                                    ->placeholder('Set a password for the vendor portal')
                                    ->password()
                                    ->same('vendor_password_confirmation')
                                    ->visible(fn (?Vendor $record) => Auth::user()?->isAgency() && $record === null)
                                    ->required(fn (?Vendor $record) => Auth::user()?->isAgency() && $record === null)
                                    ->dehydrated(fn (?Vendor $record) => $record === null)
                                    ->nullable(),
                                TextInput::make('vendor_password_confirmation')
                                    ->label('Confirm password')
                                    ->password()
                                    ->dehydrated(false)
                                    ->visible(fn (?Vendor $record) => Auth::user()?->isAgency() && $record === null)
                                    ->required(fn (?Vendor $record) => Auth::user()?->isAgency() && $record === null)
                                    ->nullable(),
                            ]),
                    ])
                    ->columns(1),
                Section::make('Vendor details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
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
                                            $slug = $baseSlug.'-'.$suffix;
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
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('vendors/logos'),
                                FileUpload::make('banner')
                                    ->image()
                                    ->disk('public')
                                    ->directory('vendors/banners'),
                            ]),
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
                        Grid::make(3)
                            ->schema([
                                TextInput::make('phone')
                                    ->tel(),
                                TextInput::make('whatsapp'),
                                TextInput::make('price_unit')
                                    ->default('per event')
                                    ->required(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('min_price')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('₹'),
                                TextInput::make('max_price')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('₹'),
                            ]),
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
                        Grid::make(3)
                            ->schema([
                                TextInput::make('avg_rating')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('review_count')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('views_count')
                                    ->numeric()
                                    ->default(0),
                            ]),
                        TextInput::make('subscription_status')
                            ->required()
                            ->default('free'),
                        DateTimePicker::make('subscription_expires_at'),
                    ]),
            ]);
    }
}
