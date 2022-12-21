<?php

namespace App\Http\Livewire;

use App\Models\Membership;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class MembershipTable extends PowerGridComponent
{
    use ActionButton;
    public string $sortField = 'max_assets';

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Event listeners
    |--------------------------------------------------------------------------
    | Add custom events to AssetesTable
    |
    */

    protected function getListeners(): array
    {
        return array_merge(
                parent::getListeners(), [
                    'bulkDelete',
                    'delete',
                ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Bulk delete button
    |--------------------------------------------------------------------------
    */

    public function bulkDelete(): void
    {
        $this->emit('openModal', 'delete-membership', [
            'membershipIds'           => $this->checkboxValues,
            'confirmationTitle'       => 'Delete membership',
            'confirmationDescription' => 'All User related to this membership will be deleted. Are you sure you want to delete this membership?',
        ]);
    }

    public function delete($membership_id): void
    {
        $this->emit('openModal', 'delete-membership', [
            'membershipIds'           => array($membership_id),
            'confirmationTitle'       => 'Delete membership',
            'confirmationDescription' => 'All Asset User related to this membership will be deleted. Are you sure you want to delete this membership?',
        ]);
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
    * @return Builder<\App\Models\Membership>
    */
    public function datasource(): Builder
    {
        return Membership::query();
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
        return [];
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
            // ->addColumn('id')
            ->addColumn('level')
            ->addColumn('max_assets');
    }

    public function header(): array
    {
        return [
            // Button::add('bulk-delete')
            //     ->caption(__('Bulk delete'))
            //     ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
            //     ->emit('bulkDelete', []),

            Button::add('create_membership')
                ->caption(__('Create New Membership'))
                ->class('cursor-pointer block bg-white-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-600 dark:border-gray-500 dark:bg-gray-500 2xl:dark:placeholder-gray-300 dark:text-gray-200 dark:text-gray-300')
                ->emitTo('memberships', 'create-form', [])

        ];
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
            // Column::make('ID', 'id'),

            Column::make('Level', 'level')
                ->sortable()
                ->searchable(),

            Column::make('Max Assets', 'max_assets')
                ->sortable()
                ->searchable(),

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
     * PowerGrid Membership Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('edit', 'Edit')
                 ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
                 ->emit('edit-form', ['membershipId' => 'id']),

            Button::make('destroy', 'Delete')
                ->target('_self')
                ->class('bg-indigo-500 cursor-pointer text-white px-3 py-0 m-1 rounded text-sm')
                ->emit('delete', ['membership_id' => 'id'])
                // ->route('memberships.destroy', ['membership' => 'id'])
                // ->method('delete')
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
     * PowerGrid Membership Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($membership) => $membership->id === 1)
                ->hide(),
        ];
    }
    */
}
