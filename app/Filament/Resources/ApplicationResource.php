<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Applications\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
						->schema([
							Forms\Components\Select::make('applicant_id')
                            ->relationship('applicant', 'email')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email(),
                                Forms\Components\DatePicker::make('date_of_birth'),
                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\Select::make('country')
                                    ->required()
                                    ->options(self::getCountries())
                                    ->placeholder('Select a country')
                                    ->searchable(),
                                Forms\Components\TextInput::make('ocupation'),
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalWidth('lg');
                            }),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                                'graduated' => 'Graduated',
                            ])
                            ->label('Status')
                            ->required(),
                        Forms\Components\Select::make('program_id')
                            ->relationship('program', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('how_found_us')
                            ->label('How did you find us?'),
                        Forms\Components\Datepicker::make('registrated_at')
                            ->required()
                            ->label('Registration date'),
                        Forms\Components\Datepicker::make('interwieved_at')
                            ->label('Invited to interview date'),
                        Forms\Components\Datepicker::make('accepted_at')
                            ->label('Accepted date'),
                        Forms\Components\Datepicker::make('graduated_at')
                            ->label('Graduated date'),
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535)
                            ->columnSpan('full'),
						])
						->columns(2)
                    ])
					->columnSpan(['lg' => fn (?Application $record) => $record === null ? 3 : 2]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Application $record): ?string => $record->created_at?->diffForHumans()),
                        Forms\Components\Placeholder::make('payments_count')
                            ->label('Total payments')
                            ->content(fn (Application $record): ?string => '$'.number_format($record->totalPayments(), 2)),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Application $record) => $record === null),
            ])
			->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('applicant.first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('applicant.last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('applicant.email')
                    ->label('Email')
					->copyable()
					->copyMessage('Email address copied')
					->copyMessageDuration(1500)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('registrated_at')
                    ->date()
                    ->label('Registration Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'danger' => 'rejected',
                        'warning' => 'pending',
                        'success' => fn ($state) => in_array($state, ['accepted', 'graduated']),
                    ]),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CertificationsRelationManager::class,
            RelationManagers\PaymentPlansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }

    public static function getCountries(): array
    {
        $countries = [
            'Afghanistan' => 'Afghanistan',
            'Albania' => 'Albania',
            'Algeria' => 'Algeria',
            'American Samoa' => 'American Samoa',
            'Andorra' => 'Andorra',
            'Angola' => 'Angola',
            'Anguilla' => 'Anguilla',
            'Antarctica' => 'Antarctica',
            'Antigua and Barbuda' => 'Antigua and Barbuda',
            'Argentina' => 'Argentina',
            'Armenia' => 'Armenia',
            'Aruba' => 'Aruba',
            'Australia' => 'Australia',
            'Austria' => 'Austria',
            'Azerbaijan' => 'Azerbaijan',
            'Bahamas' => 'Bahamas',
            'Bahrain' => 'Bahrain',
            'Bangladesh' => 'Bangladesh',
            'Barbados' => 'Barbados',
            'Belarus' => 'Belarus',
            'Belgium' => 'Belgium',
            'Belize' => 'Belize',
            'Benin' => 'Benin',
            'Bermuda' => 'Bermuda',
            'Bhutan' => 'Bhutan',
            'Bolivia' => 'Bolivia',
            'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
            'Botswana' => 'Botswana',
            'Bouvet Island' => 'Bouvet Island',
            'Brazil' => 'Brazil',
            'British Antarctic Territory' => 'British Antarctic Territory',
            'British Indian Ocean Territory' => 'British Indian Ocean Territory',
            'British Virgin Islands' => 'British Virgin Islands',
            'Brunei' => 'Brunei',
            'Bulgaria' => 'Bulgaria',
            'Burkina Faso' => 'Burkina Faso',
            'Burundi' => 'Burundi',
            'Cambodia' => 'Cambodia',
            'Cameroon' => 'Cameroon',
            'Canada' => 'Canada',
            'Canton and Enderbury Islands' => 'Canton and Enderbury Islands',
            'Cape Verde' => 'Cape Verde',
            'Cayman Islands' => 'Cayman Islands',
            'Central African Republic' => 'Central African Republic',
            'Chad' => 'Chad',
            'Chile' => 'Chile',
            'China' => 'China',
            'Christmas Island' => 'Christmas Island',
            'Cocos [Keeling] Islands' => 'Cocos [Keeling] Islands',
            'Colombia' => 'Colombia',
            'Comoros' => 'Comoros',
            'Congo - Brazzaville' => 'Congo - Brazzaville',
            'Congo - Kinshasa' => 'Congo - Kinshasa',
            'Cook Islands' => 'Cook Islands',
            'Costa Rica' => 'Costa Rica',
            'Croatia' => 'Croatia',
            'Cuba' => 'Cuba',
            'Cyprus' => 'Cyprus',
            'Czech Republic' => 'Czech Republic',
            'Côte d’Ivoire' => 'Côte d’Ivoire',
            'Denmark' => 'Denmark',
            'Djibouti' => 'Djibouti',
            'Dominica' => 'Dominica',
            'Dominican Republic' => 'Dominican Republic',
            'Dronning Maud Land' => 'Dronning Maud Land',
            'East Germany' => 'East Germany',
            'Ecuador' => 'Ecuador',
            'Egypt' => 'Egypt',
            'El Salvador' => 'El Salvador',
            'Equatorial Guinea' => 'Equatorial Guinea',
            'Eritrea' => 'Eritrea',
            'Estonia' => 'Estonia',
            'Ethiopia' => 'Ethiopia',
            'Falkland Islands' => 'Falkland Islands',
            'Faroe Islands' => 'Faroe Islands',
            'Fiji' => 'Fiji',
            'Finland' => 'Finland',
            'France' => 'France',
            'French Guiana' => 'French Guiana',
            'French Polynesia' => 'French Polynesia',
            'French Southern Territories' => 'French Southern Territories',
            'French Southern and Antarctic Territories' => 'French Southern and Antarctic Territories',
            'Gabon' => 'Gabon',
            'Gambia' => 'Gambia',
            'Georgia' => 'Georgia',
            'Germany' => 'Germany',
            'Ghana' => 'Ghana',
            'Gibraltar' => 'Gibraltar',
            'Greece' => 'Greece',
            'Greenland' => 'Greenland',
            'Grenada' => 'Grenada',
            'Guadeloupe' => 'Guadeloupe',
            'Guam' => 'Guam',
            'Guatemala' => 'Guatemala',
            'Guernsey' => 'Guernsey',
            'Guinea' => 'Guinea',
            'Guinea-Bissau' => 'Guinea-Bissau',
            'Guyana' => 'Guyana',
            'Haiti' => 'Haiti',
            'Heard Island and McDonald Islands' => 'Heard Island and McDonald Islands',
            'Honduras' => 'Honduras',
            'Hong Kong SAR China' => 'Hong Kong SAR China',
            'Hungary' => 'Hungary',
            'Iceland' => 'Iceland',
            'India' => 'India',
            'Indonesia' => 'Indonesia',
            'Iran' => 'Iran',
            'Iraq' => 'Iraq',
            'Ireland' => 'Ireland',
            'Isle of Man' => 'Isle of Man',
            'Israel' => 'Israel',
            'Italy' => 'Italy',
            'Jamaica' => 'Jamaica',
            'Japan' => 'Japan',
            'Jersey' => 'Jersey',
            'Johnston Island' => 'Johnston Island',
            'Jordan' => 'Jordan',
            'Kazakhstan' => 'Kazakhstan',
            'Kenya' => 'Kenya',
            'Kiribati' => 'Kiribati',
            'Kuwait' => 'Kuwait',
            'Kyrgyzstan' => 'Kyrgyzstan',
            'Laos' => 'Laos',
            'Latvia' => 'Latvia',
            'Lebanon' => 'Lebanon',
            'Lesotho' => 'Lesotho',
            'Liberia' => 'Liberia',
            'Libya' => 'Libya',
            'Liechtenstein' => 'Liechtenstein',
            'Lithuania' => 'Lithuania',
            'Luxembourg' => 'Luxembourg',
            'Macau SAR China' => 'Macau SAR China',
            'Macedonia' => 'Macedonia',
            'Madagascar' => 'Madagascar',
            'Malawi' => 'Malawi',
            'Malaysia' => 'Malaysia',
            'Maldives' => 'Maldives',
            'Mali' => 'Mali',
            'Malta' => 'Malta',
            'Marshall Islands' => 'Marshall Islands',
            'Martinique' => 'Martinique',
            'Mauritania' => 'Mauritania',
            'Mauritius' => 'Mauritius',
            'Mayotte' => 'Mayotte',
            'Metropolitan France' => 'Metropolitan France',
            'Mexico' => 'Mexico',
            'Micronesia' => 'Micronesia',
            'Midway Islands' => 'Midway Islands',
            'Moldova' => 'Moldova',
            'Monaco' => 'Monaco',
            'Mongolia' => 'Mongolia',
            'Montenegro' => 'Montenegro',
            'Montserrat' => 'Montserrat',
            'Morocco' => 'Morocco',
            'Mozambique' => 'Mozambique',
            'Myanmar [Burma]' => 'Myanmar [Burma]',
            'Namibia' => 'Namibia',
            'Nauru' => 'Nauru',
            'Nepal' => 'Nepal',
            'Netherlands' => 'Netherlands',
            'Netherlands Antilles' => 'Netherlands Antilles',
            'Neutral Zone' => 'Neutral Zone',
            'New Caledonia' => 'New Caledonia',
            'New Zealand' => 'New Zealand',
            'Nicaragua' => 'Nicaragua',
            'Niger' => 'Niger',
            'Nigeria' => 'Nigeria',
            'Niue' => 'Niue',
            'Norfolk Island' => 'Norfolk Island',
            'North Korea' => 'North Korea',
            'North Vietnam' => 'North Vietnam',
            'Northern Mariana Islands' => 'Northern Mariana Islands',
            'Norway' => 'Norway',
            'Oman' => 'Oman',
            'Pacific Islands Trust Territory' => 'Pacific Islands Trust Territory',
            'Pakistan' => 'Pakistan',
            'Palau' => 'Palau',
            'Palestinian Territories' => 'Palestinian Territories',
            'Panama' => 'Panama',
            'Panama Canal Zone' => 'Panama Canal Zone',
            'Papua New Guinea' => 'Papua New Guinea',
            'Paraguay' => 'Paraguay',
            'People\'s Democratic Republic of Yemen' => 'People\'s Democratic Republic of Yemen',
            'Peru' => 'Peru',
            'Philippines' => 'Philippines',
            'Pitcairn Islands' => 'Pitcairn Islands',
            'Poland' => 'Poland',
            'Portugal' => 'Portugal',
            'Puerto Rico' => 'Puerto Rico',
            'Qatar' => 'Qatar',
            'Romania' => 'Romania',
            'Russia' => 'Russia',
            'Rwanda' => 'Rwanda',
            'Réunion' => 'Réunion',
            'Saint Barthélemy' => 'Saint Barthélemy',
            'Saint Helena' => 'Saint Helena',
            'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
            'Saint Lucia' => 'Saint Lucia',
            'Saint Martin' => 'Saint Martin',
            'Saint Pierre and Miquelon' => 'Saint Pierre and Miquelon',
            'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
            'Samoa' => 'Samoa',
            'San Marino' => 'San Marino',
            'Saudi Arabia' => 'Saudi Arabia',
            'Senegal' => 'Senegal',
            'Serbia' => 'Serbia',
            'Serbia and Montenegro' => 'Serbia and Montenegro',
            'Seychelles' => 'Seychelles',
            'Sierra Leone' => 'Sierra Leone',
            'Singapore' => 'Singapore',
            'Slovakia' => 'Slovakia',
            'Slovenia' => 'Slovenia',
            'Solomon Islands' => 'Solomon Islands',
            'Somalia' => 'Somalia',
            'South Africa' => 'South Africa',
            'South Georgia and the South Sandwich Islands' => 'South Georgia and the South Sandwich Islands',
            'South Korea' => 'South Korea',
            'Spain' => 'Spain',
            'Sri Lanka' => 'Sri Lanka',
            'Sudan' => 'Sudan',
            'Suriname' => 'Suriname',
            'Svalbard and Jan Mayen' => 'Svalbard and Jan Mayen',
            'Swaziland' => 'Swaziland',
            'Sweden' => 'Sweden',
            'Switzerland' => 'Switzerland',
            'Syria' => 'Syria',
            'São Tomé and Príncipe' => 'São Tomé and Príncipe',
            'Taiwan' => 'Taiwan',
            'Tajikistan' => 'Tajikistan',
            'Tanzania' => 'Tanzania',
            'Thailand' => 'Thailand',
            'Timor-Leste' => 'Timor-Leste',
            'Togo' => 'Togo',
            'Tokelau' => 'Tokelau',
            'Tonga' => 'Tonga',
            'Trinidad and Tobago' => 'Trinidad and Tobago',
            'Tunisia' => 'Tunisia',
            'Turkey' => 'Turkey',
            'Turkmenistan' => 'Turkmenistan',
            'Turks and Caicos Islands' => 'Turks and Caicos Islands',
            'Tuvalu' => 'Tuvalu',
            'U.S. Minor Outlying Islands' => 'U.S. Minor Outlying Islands',
            'U.S. Miscellaneous Pacific Islands' => 'U.S. Miscellaneous Pacific Islands',
            'U.S. Virgin Islands' => 'U.S. Virgin Islands',
            'Uganda' => 'Uganda',
            'Ukraine' => 'Ukraine',
            'Union of Soviet Socialist Republics' => 'Union of Soviet Socialist Republics',
            'United Arab Emirates' => 'United Arab Emirates',
            'United Kingdom' => 'United Kingdom',
            'United States' => 'United States',
            'Unknown or Invalid Region' => 'Unknown or Invalid Region',
            'Uruguay' => 'Uruguay',
            'Uzbekistan' => 'Uzbekistan',
            'Vanuatu' => 'Vanuatu',
            'Vatican City' => 'Vatican City',
            'Venezuela' => 'Venezuela',
            'Vietnam' => 'Vietnam',
            'Wake Island' => 'Wake Island',
            'Wallis and Futuna' => 'Wallis and Futuna',
            'Western Sahara' => 'Western Sahara',
            'Yemen' => 'Yemen',
            'Zambia' => 'Zambia',
            'Zimbabwe' => 'Zimbabwe',
            'Åland Islands' => 'Åland Islands',
        ];

        return $countries;

    }
}
