<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameInstanceResource\Pages;
use App\Filament\Resources\GameInstanceResource\RelationManagers;
use App\Models\GameInstance;
use App\Models\GameInstanceUrl;
use App\Service\GitService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use GitElephant\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameInstanceResource extends Resource
{
    protected static ?string $model = GameInstance::class;
    protected static ?string $label = 'Spielinstanz';
    protected static ?string $pluralLabel = 'Spielinstanzen';
    protected static ?string $navigationLabel = 'Spielinstanzen';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('instance_urls')->label('URLs')
                    ->relationship('instanceUrls', 'url')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('URL')
                            ->required()
                            ->unique(GameInstanceUrl::class, 'url'),
                    ]),
                Forms\Components\TextInput::make('repository')->label('Repository')
                    ->required()
                    ->default(function(){
                        return \Config::get('git.repository');
                    })
                    ->readOnly()
                    ->maxLength(255)
                    ->live()
                    ->debounce(100),
                Forms\Components\Select::make('branch')->label('Branch')
                    ->options(function(GitService $gitService){
                        return $gitService->getBranches();
                    }),
                Forms\Components\TextInput::make('commit')->label('Commit')
                    ->required()
                    ->default('HEAD')
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\Select::make('deploy_key_id')->label('Deploy Key')
                    ->relationship(name: 'deployKey', titleAttribute: 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instance_urls')
                    ->searchable(),
                Tables\Columns\TextColumn::make('repository')
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deploy_key_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameInstances::route('/'),
            'create' => Pages\CreateGameInstance::route('/create'),
            'edit' => Pages\EditGameInstance::route('/{record}/edit'),
        ];
    }
}
