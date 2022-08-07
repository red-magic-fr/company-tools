<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DocumentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DocumentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Document::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document');
        CRUD::setEntityNameStrings('document', 'documents');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('label')->type('string');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DocumentRequest::class);

        CRUD::field('type')->type('relationship')->attribute('label');

        CRUD::field('client')->type('relationship')->attribute('label');

        // TODO Default
        CRUD::field('number')->type('number');

        CRUD::field('edition_date')->type('date')->default(date('Y-m-d'));

        // TODO Lines
        $this->crud->addField([   // repeatable
            'name' => 'lines',
            'label' => 'Lines',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'hidden'
                ],
                [
                    'name' => 'label',
                    'type' => 'text',
                    'label' => 'Label',
                    'wrapper' => ['class' => 'form-group col-md-8'],
                ],
                [
                    'name' => 'price',
                    'type' => 'number',
                    'label' => 'Price',
                    'wrapper' => ['class' => 'form-group col-md-4'],
                ]
            ],

            // optional
            'new_item_label' => 'Add Line', // customize the text of the button
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
