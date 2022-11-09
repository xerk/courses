<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Models\CourseGroup;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\CourseGroupResource\Pages;

class CourseGroupResource extends Resource
{
    protected static ?string $model = CourseGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Main';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    Select::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->options(function () {
                            return User::where('type', 'trainer')->get()->pluck('name', 'id');
                        })
                        ->searchable()
                        ->placeholder('User')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('course_id')
                        ->rules(['required', 'exists:courses,id'])
                        ->relationship('course', 'title')
                        ->searchable()
                        ->placeholder('Course')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('name')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->limit(50),
                Tables\Columns\TextColumn::make('course.title')->limit(50),
                Tables\Columns\TextColumn::make('name')->limit(50),
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

                MultiSelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),

                MultiSelectFilter::make('course_id')->relationship(
                    'course',
                    'title'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CourseGroupResource\RelationManagers\UsersRelationManager::class,
            CourseGroupResource\RelationManagers\AssigmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseGroups::route('/'),
            'create' => Pages\CreateCourseGroup::route('/create'),
            'edit' => Pages\EditCourseGroup::route('/{record}/edit'),
        ];
    }
}
