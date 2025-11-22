<?php

namespace App\Filament\Vendor\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;

class EditVendorProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Profile';

    protected static UnitEnum|string|null $navigationGroup = 'Account';

    protected static ?string $title = 'Vendor profile';

    protected string $view = 'filament.vendor.pages.edit-vendor-profile';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::user()?->isVendor() ?? false;
    }

    public function mount(): void
    {
        $vendor = $this->getVendor();

        abort_unless($vendor, 403);

        $this->form->fill($vendor->only([
            'business_name',
            'slug',
            'description',
            'logo',
            'banner',
            'website',
            'address',
            'city',
            'state',
            'postal_code',
            'country',
            'latitude',
            'longitude',
            'phone',
            'email',
            'whatsapp',
            'min_price',
            'max_price',
            'price_unit',
            'price_notes',
            'service_areas',
            'specialties',
            'working_hours',
            'years_in_business',
            'business_registration_info',
            'facebook',
            'instagram',
            'twitter',
            'linkedin',
            'youtube',
        ]));
    }

    protected function getVendor()
    {
        return Auth::user()?->vendor;
    }

    protected function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('business_name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                        TextInput::make('slug')
                            ->readOnly()
                            ->disabled(),
                    ]),
                RichEditor::make('description')
                    ->columnSpanFull(),
                Grid::make(2)
                    ->schema([
                        FileUpload::make('logo')
                            ->image(),
                        FileUpload::make('banner')
                            ->image(),
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
                TextInput::make('country'),
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
                        TextInput::make('email')
                            ->email(),
                        TextInput::make('whatsapp'),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('min_price')
                            ->numeric(),
                        TextInput::make('max_price')
                            ->numeric(),
                    ]),
                TextInput::make('price_unit'),
                Textarea::make('price_notes')
                    ->columnSpanFull(),
                Textarea::make('service_areas')
                    ->columnSpanFull(),
                Textarea::make('specialties')
                    ->columnSpanFull(),
                KeyValue::make('working_hours')
                    ->columnSpanFull()
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->addButtonLabel('Add day')
                    ->reorderable(),
                TextInput::make('years_in_business')
                    ->numeric(),
                Textarea::make('business_registration_info')
                    ->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('facebook'),
                        TextInput::make('instagram'),
                        TextInput::make('twitter'),
                        TextInput::make('linkedin'),
                        TextInput::make('youtube'),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $vendor = $this->getVendor();

        abort_unless($vendor, 403);

        $vendor->fill($this->form->getState());
        $vendor->save();

        Notification::make()
            ->title('Vendor profile updated')
            ->success()
            ->send();
    }
}
