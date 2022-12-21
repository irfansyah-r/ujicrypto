<?php

namespace App\Http\Livewire;

use App\Models\Indication;
use App\Models\Asset;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class IndicationTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        // $this->showCheckBox();
        $this->persist(['columns', 'filters']);

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\Indication>
    */
    public function datasource(): Builder
    {
        return Indication::query()
            ->join('assets', function($assets){
                $assets->on('indications.asset_id', '=', 'assets.id');
            })
            ->select('indications.*', 'assets.base as base', 'assets.quote as quote');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [
            'asset' => [
                'base',
                'quote',
            ]
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('asset_id', function(Indication $indication){
                return $indication->asset_id;
            })
            ->addColumn('base', function(Indication $indication){
                return $indication->base;
            })
            ->addColumn('quote', function(Indication $indication){
                return $indication->quote;
            })
            ->addColumn('ma_trend')
            ->addColumn('ma_crossover', function(Indication $indication){
                return $indication->ma_crossover ? 'Yes':'No';
            })
            ->addColumn('psar_trend')
            ->addColumn('psar_reversal', function(Indication $indication){
                return $indication->psar_reversal ? 'Yes':'No';
            })
            ->addColumn('stochastic_trend')
            ->addColumn('stochastic_crossover', function(Indication $indication){
                return $indication->stochastic_crossover ? 'Yes':'No';
            })
            ->addColumn('updated_at_formatted', fn (Indication $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
  {
        return [

            Column::make('BASE', 'base')
                ->makeInputMultiSelect(Asset::all(), 'base', 'asset_id')
                ->placeholder('Find Base')
                ->sortable(),

            Column::make('QUOTE', 'quote')
                ->makeInputMultiSelect(Asset::all(), 'quote', 'asset_id')
                ->placeholder('Find Quote')
                ->sortable(),

            Column::make('MA TREND', 'ma_trend')
                ->sortable()
                ->searchable()
                ->makeInputSelect(Indication::trend('ma_trend'), 'ma_trend'),

            Column::make('MA CROSSOVER', 'ma_crossover')
                ->sortable()
                ->searchable(),

            Column::make('PSAR TREND', 'psar_trend')
                ->sortable()
                ->searchable()
                ->makeInputSelect(Indication::trend('psar_trend'), 'psar_trend'),

            Column::make('PSAR REVERSAL', 'psar_reversal')
                ->sortable()
                ->searchable(),

            Column::make('STOCHASTIC TREND', 'stochastic_trend')
                ->sortable()
                ->searchable()
                ->makeInputSelect(Indication::trend('stochastic_trend'), 'stochastic_trend'),

            Column::make('STOCHASTIC CROSSOVER', 'stochastic_crossover')
                ->sortable()
                ->searchable(),

            Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable(),
                // ->makeInputDatePicker(),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Indication Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
       return [

            Button::make('chart', 'Chart')
                ->class('bg-blue-400 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                ->route('indication.chart', ['assetId' => 'asset_id']),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Indication Action Rules.
     *
     * @return array<int, RuleActions>
     */


    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            // Rule::button('edit')
            //     ->when(fn($indication) => $indication->id === 1)
            //     ->hide(),

            // Rule::rows()
            //     ->when(function ($indication) {
            //         return $indication->ma_crossover && $indication->psar_reversal && $indication->stochastic_crossover;
            //     })
            //     ->setAttribute('class', 'bg-green-200'),

            // Rule::rows()
            //     ->when(function ($indication) {
            //         return !$indication->ma_crossover && !$indication->psar_reversal && !$indication->stochastic_crossover;
            //     })
            //     ->setAttribute('class', 'bg-red-200'),
        ];
    }

}
