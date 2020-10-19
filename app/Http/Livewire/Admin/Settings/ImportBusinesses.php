<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Csv;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportBusinesses extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $columns;

    public $fieldColumnMap = [
        'name' => '',
        'phone' => '',
        'location_id' => '',
        'address' => '',
        'status' => '',
        'created_at' => '',
    ];

    protected $rules = [
        'fieldColumnMap.name' => 'required',
        'fieldColumnMap.location_id' => 'required',
    ];

    protected $customAttributes = [
        'fieldColumnMap.title' => 'name',
        'fieldColumnMap.location_id' => 'location_id',
    ];

    public function updatedShowModal($value)
    {
        if(!$value) $this->reset();
    }

    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:txt,csv|max:3072'],
        )->validate();
    }

    public function updatedUpload()
    {
        $this->columns = Csv::from($this->upload)->columns();

        $this->guessWhichColumnsMapToWhichFields();
    }

    public function import()
    {
        $this->validate();

        $importCount = 0;

        Csv::from($this->upload)
            ->eachRow(function ($row) use (&$importCount) {
                Business::create(
                    $this->extractFieldsFromRow($row)
                );

                $importCount++;
            });

        $this->reset();

        $this->emit('refreshBusinesses');

        $this->notify('Imported '.$importCount.' transactions!');
    }

    public function extractFieldsFromRow($row)
    {
        $attributes = collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function($heading, $field) use ($row) {
                return [$field => $row[$heading]];
            })
            ->toArray();

        return $attributes + ['phone' => '', 'address' => '', 'status' => '1', 'created_at' => now()];
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'name' => ['name','title','business'],
            'location_id' => ['location_id','location'],
            'phone' => ['phone','contact','mobile'],
            'address' => ['address'],
            'status' => ['status','state'],
            'created_at' => ['created_at','added_on','added on'],
        ];
        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
