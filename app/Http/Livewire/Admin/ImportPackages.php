<?php

namespace App\Http\Livewire\Admin;

use App\Csv;
use App\Models\Package;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportPackages extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $columns;

    public $fieldColumnMap = [
        'business_id' => '',
        'location_id' => '',
        'tracking_id' => '',
        'delivery_address' => '',
        'delivery_contact' => '',
        'delivery_note' => '',
        'collected_on' => '',
        'deliver_by' => '',
        'status' => '',
        'delivered_on' => '',
        'out_for_delivery_on' => '',
        'reached_location_on' => '',
    ];

    protected $rules = [
        'fieldColumnMap.tracking_id' => 'required',
        'fieldColumnMap.location_id' => 'required',
        'fieldColumnMap.business_id' => 'required',
        'fieldColumnMap.delivery_address' => 'required',
        'fieldColumnMap.collected_on' => 'required',
        'fieldColumnMap.deliver_by' => 'required',
    ];

    protected $customAttributes = [
        'fieldColumnMap.tracking_id' => 'tracking_id',
        'fieldColumnMap.location_id' => 'location_id',
        'fieldColumnMap.business_id' => 'business_id',
        'fieldColumnMap.delivery_address' => 'delivery_address',
        'fieldColumnMap.collected_on' => 'collected_on',
        'fieldColumnMap.deliver_by' => 'deliver_by',
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

        try {
            Csv::from($this->upload)
                ->eachRow(function ($row) use (&$importCount) {
                    Package::create(
                        $this->extractFieldsFromRow($row)
                    );

                    $importCount++;
                });

            $this->emit('refreshPackages');

            $this->notify('Imported '.$importCount.' packages!');
        } catch(\Exception $error) {
            dd($error);
        }
    }

    public function extractFieldsFromRow($row)
    {
        $attributes = collect($this->fieldColumnMap)
            ->filter()
            ->mapWithKeys(function($heading, $field) use ($row) {
                return [$field => $row[$heading]];
            })
            ->toArray();

        return $attributes + ['status' => 'processing','delivered_on' => null,'out_for_delivery_on' => null,'reached_location_on' => null];
    }

    public function guessWhichColumnsMapToWhichFields()
    {
        $guesses = [
            'tracking_id' => ['tracking_id','tracking','id','key'],
            'location_id' => ['location_id','location'],
            'business_id' => ['business_id','business'],
            'delivery_contact' => ['delivery_contact','phone','contact','mobile'],
            'delivery_address' => ['delivery_address','address','street'],
            'delivery_note' => ['delivery_note', 'note', 'notes'],
            'status' => ['status','state'],
            'collected_on' => ['collected_on','collected'],
            'deliver_by' => ['deliver_by','deliver_date'],
            'delivered_on' => ['delivered_on','delivered_date','delivered'],
            'out_for_delivery_on' => ['out_for_delivery_on','dispatched_on','out_on','out_for_delivery'],
            'reached_location_on' => ['reached_location_on','reached_on','reached'],
        ];
        foreach ($this->columns as $column) {
            $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

            if($match) $this->fieldColumnMap[$match] = $column;
        }
    }
}
