<?php

namespace App\Filament\Agency\Pages;

use App\Models\Agency;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
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

class EditAgencyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Profile';

    protected static UnitEnum|string|null $navigationGroup = 'Account';

    protected static ?string $title = 'Agency profile';

    protected string $view = 'filament.agency.pages.edit-agency-profile';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user?->isAgency() ?? false;
    }

    public function mount(): void
    {
        $agency = $this->getAgency();

        abort_unless($agency, 403);

        $this->form->fill($agency->only([
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
            'facebook',
            'instagram',
            'twitter',
            'linkedin',
            'youtube',
            'working_hours',
            'specialties',
            'years_in_business',
            'business_registration_info',
        ]));
    }

    protected function getAgency(): ?Agency
    {
        return Auth::user()?->agency;
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
                            ->image()
                            ->disk('public')
                            ->directory('agencies/logos'),
                        FileUpload::make('banner')
                            ->image()
                            ->disk('public')
                            ->directory('agencies/banners'),
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
                        TextInput::make('facebook'),
                        TextInput::make('instagram'),
                        TextInput::make('twitter'),
                        TextInput::make('linkedin'),
                        TextInput::make('youtube'),
                    ]),
                Textarea::make('working_hours')
                    ->columnSpanFull(),
                Textarea::make('specialties')
                    ->columnSpanFull(),
                TextInput::make('years_in_business')
                    ->numeric(),
                Textarea::make('business_registration_info')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $agency = $this->getAgency();

        abort_unless($agency, 403);

        $agency->fill($this->form->getState());
        $agency->save();

        Notification::make()
            ->title('Agency profile updated')
            ->success()
            ->send();
    }
}
