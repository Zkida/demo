<?php

namespace App\Filament\Resources\ApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\Applications\PaymentPlan;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentPlan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('plan_type')
                    ->options([
                        'full' => 'Full payment',
                        'monthly' => 'Monthly payment',
                        'quarterly' => 'Quarterly payment',
                        'biannual' => 'Biannual payment',
                        'annual' => 'Annual payment',
                    ])
                    ->required()
                    ->label('Payment plan type')
                    ->columnSpan('full'),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpan('full'),
                Forms\Components\Section::make('Add Payments')
                    ->schema([
                        Forms\Components\Repeater::make('payments')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('provider')
                                    ->options([
                                        'stripe' => 'Stripe',
                                        'paypal' => 'Paypal',
                                        'square' => 'Square',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->numeric()
                                    ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                    ->required()
                                    ->label('Payment amount'),
                                Forms\Components\DatePicker::make('paid_at')
                                    ->required(),
                                Forms\Components\Textarea::make('notes')
                                    ->maxLength(65535)
                                    ->columnSpan('full'),
                            ])
							->columns(3),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Payment Plans')
            ->columns([
                Tables\Columns\TextColumn::make('plan_type')
                    ->sortable()
                    ->searchable()
					->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('payments_count')->counts('payments')
                    ->sortable()
                    ->label('Number of payments'),
				Tables\Columns\TextColumn::make('notes')
					->words(10),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
}
