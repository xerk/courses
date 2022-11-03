<?php

namespace App\Filament\Resources;

use App\Models\Lead;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LeadResource\Pages;
use Filament\Resources\{Form, Table, Resource};

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';
    

    public static function form(Form $form): Form
    {
        return $form->schema([
            static::getLeadForm(),
            
            Repeater::make('FollowUps')
                ->relationship('followUps')
                ->schema([
                    FollowUpResource::getFollowUpForm()
                ])->columnSpan('full')
            ]);
    }

    public static function getLeadForm()
    {
        return Section::make('Lead Infomration')->schema([
            Grid::make(['default' => 12])->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('name_ar')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Name Ar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('phone')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Phone')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('category_approved')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Category Approved')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('category_id')
                    ->rules(['required', 'exists:categories,id'])
                    ->relationship('category', 'name')
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('lead_from')
                    ->rules([
                        'nullable',
                        'in:website,calls,whatsapp,by_visit',
                    ])
                    ->searchable()
                    ->options([
                        'website' => 'Website',
                        'calls' => 'Calls',
                        'whatsapp' => 'Whatsapp',
                        'by_visit' => 'By visit',
                    ])
                    ->placeholder('Lead From')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('status')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Status')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('business_landline')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Business Landline')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                RichEditor::make('note')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Note')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('name_ar')->limit(50),
                Tables\Columns\TextColumn::make('email')->limit(50),
                Tables\Columns\TextColumn::make('phone')->limit(50),
                Tables\Columns\TextColumn::make('category_approved')->limit(50),
                Tables\Columns\TextColumn::make('course_type')->enum([
                    'medical' => 'Medical',
                    'technical' => 'Technical',
                ]),
                Tables\Columns\TextColumn::make('category.name')->limit(50),
                Tables\Columns\TextColumn::make('lead_from')->enum([
                    'website' => 'Website',
                    'calls' => 'Calls',
                    'whatsapp' => 'Whatsapp',
                    'by_visit' => 'By visit',
                ]),
                Tables\Columns\TextColumn::make('status')->limit(50),
                Tables\Columns\TextColumn::make('business_landline')->limit(50),
                Tables\Columns\TextColumn::make('note')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                SelectFilter::make('category_id')->relationship(
                    'category',
                    'name'
                )->multiple(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LeadResource\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}