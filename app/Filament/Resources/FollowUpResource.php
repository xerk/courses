<?php

namespace App\Filament\Resources;

use App\Models\FollowUp;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\FollowUpResource\Pages;

class FollowUpResource extends Resource
{
    protected static ?string $model = FollowUp::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Follow Up')->schema([
                static::getFollowUpForm(true),
                static::getLeadRelation()
            ])
        ]);
    }

    public static function getLeadRelation()
    {
        return Select::make('lead_id')
            ->rules(['required', 'exists:leads,id'])
            ->relationship('lead', 'name')
            ->searchable()
            ->placeholder('Lead')
            ->columnSpan([
                'default' => 12,
                'md' => 4,
            ]);
    }

    public static function getFollowUpForm($relation = false)
    {

        $schema = [];

        if ($relation) {
            $schema[] = static::getLeadRelation();
        }

        $relation ? $md = 4 : $md = 6;

        $schema = array_merge($schema, [
            TextInput::make('title')
                ->rules(['required', 'max:255', 'string'])
                ->placeholder('Title')
                ->columnSpan([
                    'default' => 12,
                    'md' => $md,
                ]),

            Select::make('follow_up_from')
                ->rules([
                    'nullable',
                    'in:email,call,visit',
                ])
                ->searchable()
                ->options([
                    'email' => 'Email',
                    'call' => 'Call',
                    'visit' => 'By visit',
                ])
                ->placeholder('Follow up from')
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
                    'md' => $md,
                ]),

            DatePicker::make('follow_date')
                ->rules(['required', 'date'])
                ->placeholder('Follow up date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('next_follow_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Next Follow up date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            RichEditor::make('Note')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Note')
                ->columnSpan([
                    'default' => 12,
                ]),
        ]);

        return Grid::make(['default' => 12])->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('Note')->limit(50),
                Tables\Columns\TextColumn::make('lead.name')->limit(50),
                Tables\Columns\TextColumn::make('status')->limit(50),
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
                                fn (
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
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                SelectFilter::make('lead_id')->relationship(
                    'lead',
                    'name'
                )->multiple(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFollowUps::route('/'),
            'create' => Pages\CreateFollowUp::route('/create'),
            'edit' => Pages\EditFollowUp::route('/{record}/edit'),
        ];
    }
}
