<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('client'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('avatar'),
                Toggle::make('active')
                    ->required(),
                TextInput::make('google_id'),
                TextInput::make('login_type')
                    ->required()
                    ->default('email'),
            ]);
    }
}
