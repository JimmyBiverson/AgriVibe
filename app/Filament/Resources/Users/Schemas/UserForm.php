<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('username'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                DateTimePicker::make('email_verified_at'),
                DateTimePicker::make('phone_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('account_type')
                    ->required()
                    ->default('farmer'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                TextInput::make('avatar'),
                TextInput::make('referral_code'),
                TextInput::make('referred_by')
                    ->numeric(),
                Toggle::make('is_verified')
                    ->required(),
                DateTimePicker::make('verified_at'),
                Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                DateTimePicker::make('two_factor_confirmed_at'),
                DateTimePicker::make('last_login_at'),
                TextInput::make('last_login_ip'),
                DateTimePicker::make('onboarding_completed_at'),
                TextInput::make('preferences'),
            ]);
    }
}
