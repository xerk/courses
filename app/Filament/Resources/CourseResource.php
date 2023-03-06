<?php

namespace App\Filament\Resources;

use App\Models\Course;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\CourseResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    BelongsToSelect::make('category_id')
                        ->rules(['required', 'exists:categories,id'])
                        ->relationship('category', 'name')
                        ->preload()
                        ->searchable()
                        ->placeholder('Category')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('title')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    Select::make('type')
                        ->rules([
                            'nullable',
                            'in:exam,course',
                        ])
                        ->searchable()
                        ->options([
                            'exam' => 'Exam',
                            'course' => 'Course',
                        ])
                        ->placeholder('Select course type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('cost')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Cost')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    SpatieMediaLibraryFileUpload::make('documents')
                        ->multiple()
                        ->enableReordering()
                        ->enableDownload()
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
                Tables\Columns\TextColumn::make('category.name')->limit(50),
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('type')->limit(50),
                Tables\Columns\TextColumn::make('cost')->limit(50),
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

                SelectFilter::make('category_id')->relationship(
                    'category',
                    'name'
                )->multiple(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // CourseResource\RelationManagers\DocumentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
