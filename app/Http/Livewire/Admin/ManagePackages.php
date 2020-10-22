<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Business;
use App\Models\Location;
use App\Models\Package;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManagePackages extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use AuthorizesRequests;

    public $showForm = false;
    public $showStatusForm = false;
    public $showConfirmDelete = false;
    public $showConfirmDeleteSelected = false;
    public $deleteId = null;

    public $business_id;
    public $location_id;
    public $tracking_id;
    public $delivery_address;
    public $delivery_contact;
    public $delivery_note;
    public $collected_on;
    public $deliver_by;
    public $status = 'processing';
    public $delivered_on;
    public $out_for_delivery_on;
    public $reached_location_on;
    public $changeStatus;

    public $editId = null;
    public ?Package $editPackage = null;

    public $filters = [
        'search' => '',
        'status' => null,
        'addedOnMax' => null,
        'addedOnMin' => null,
        'locationId' => null,
    ];

    protected $listeners = ['refreshPackages' => '$refresh'];

    public function rules() { return [
        'business_id' => 'required',
        'location_id' => 'required',
        'tracking_id' => 'required|unique:packages,tracking_id,' . $this->editId,
        'delivery_address' => 'required|max:255',
        'delivery_contact' => 'sometimes|max:15',
        'delivery_note' => 'sometimes|max:125',
        'collected_on' => 'required',
        'deliver_by' => 'required',
        'status' => 'required',
        'delivered_on' => 'sometimes',
        'out_for_delivery_on' => 'sometimes',
        'reached_location_on' => 'sometimes',
    ]; }

    protected $messages = [
        'location_id.required' => 'The location field cannot be empty.',
    ];

    public function mount()
    {
        $this->initialSort();
        $this->package = Package::make();
    }

    protected function initialSort(){ $this->sorts = ['collected_on' => 'desc']; }

//    protected $queryString = ['sortField', 'sortDirection'];

    public function updatedFilters(){ $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function toggleShowForm()
    {
        $this->useCachedRows();
        $this->reset('business_id', 'location_id', 'tracking_id', 'delivery_address',
            'delivery_contact', 'delivery_note', 'collected_on', 'deliver_by', 'status',
            'delivered_on', 'out_for_delivery_on', 'reached_location_on', 'editId', 'editPackage');
        $this->showForm = !$this->showForm;
    }

    public function editPackage(Package $package)
    {
        $this->useCachedRows();
        $this->editPackage = $package;
        $this->editId = $package->id;
        $this->setPackageFields();
        $this->showForm = true;
    }

    public function toggleShowStatusForm(?Package $package = null, $status = null)
    {
        $this->useCachedRows();
        if($this->showStatusForm === false) {
            $this->changeStatus = $status;
            $this->editPackage = $package;
            $this->editId = $package->id;
            $this->setPackageFields();
        } else {
            $this->reset('delivery_note', 'collected_on', 'delivered_on', 'deliver_by',
                'out_for_delivery_on', 'reached_location_on', 'editId', 'editPackage', 'changeStatus');
        }

        $this->showStatusForm = !$this->showStatusForm;
    }

    public function changeStatus()
    {
        $this->authorize('package', $this->editPackage);
        $this->editPackage->update([
            'status' => $this->changeStatus,
            'collected_on' => $this->collected_on ? Carbon::createFromFormat('d/m/Y', $this->collected_on) : null,
            'deliver_by' => $this->deliver_by ? Carbon::createFromFormat('d/m/Y', $this->deliver_by) : null,
            'reached_location_on' => $this->reached_location_on ? Carbon::createFromFormat('d/m/Y', $this->reached_location_on) : null,
            'out_for_delivery_on' => $this->out_for_delivery_on ? Carbon::createFromFormat('d/m/Y', $this->out_for_delivery_on) : null,
            'delivered_on' => $this->delivered_on ? Carbon::createFromFormat('d/m/Y', $this->delivered_on) : null,
        ]);
        $this->reset();
        $this->initialSort();
        $this->notify('Package status updated successfully');
    }

    public function confirmDelete($package_id)
    {
        $this->useCachedRows();
        $this->showConfirmDelete = true;
        $this->deleteId = $package_id;
    }

    public function delete()
    {
        $this->authorize('package', Package::find($this->deleteId));
        try{
            Package::whereId($this->deleteId)->delete();
            $this->showConfirmDelete = false;
            $this->deleteId = null;
            $this->notify('Package deleted successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function deleteSelected()
    {
        collect($this->selected)->map(fn($packageId) => $this->authorize('package', Package::find($packageId)));

        if(!empty($this->selected)) {
            try{
                $this->selectedRowsQuery->delete();

                $this->showConfirmDeleteSelected = false;
                $this->resetSelected();

                $this->notify('Selected packages deleted successfully');
            } catch (\Exception $error) {
                dd($error);
            }
        }
    }

    public function exportSelected()
    {
        collect($this->selected)->map(fn($packageId) => $this->authorize('package', Package::find($packageId)));

        if(!empty($this->selected)) {
            return response()->streamDownload(function() {
                echo $this->selectedRowsQuery->toCsv();
            }, 'packages-' . now()->format('d-m-Y-His') . '.csv');
        }
    }

    public function save()
    {
        $this->editPackage ? $this->authorize('package', $this->editPackage) : null;
        $data = $this->validate();
        $saveData = $this->convertDateStringToTimestamp($data);

        try {
            $this->editPackage
                ? $this->editPackage->update($saveData)
                : Package::create($saveData);
            $this->reset();
            $this->initialSort();
            $this->notify('Package details saved successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function convertDateStringToTimestamp($data)
    {
        $data['collected_on'] = $data['collected_on'] ? Carbon::createFromFormat('d/m/Y', $data['collected_on']) : null;
        $data['deliver_by'] = $data['deliver_by'] ? Carbon::createFromFormat('d/m/Y', $data['deliver_by']) : null;
        $data['delivered_on'] = $data['delivered_on'] ? Carbon::createFromFormat('d/m/Y', $data['delivered_on']) : null;
        $data['out_for_delivery_on'] = $data['out_for_delivery_on'] ? Carbon::createFromFormat('d/m/Y', $data['out_for_delivery_on']) : null;
        $data['reached_location_on'] = $data['reached_location_on'] ? Carbon::createFromFormat('d/m/Y', $data['reached_location_on']) : null;

        return $data;
    }

    protected function setPackageFields()
    {
        $this->business_id = $this->editPackage->business_id;
        $this->location_id = $this->editPackage->location_id;
        $this->tracking_id = $this->editPackage->tracking_id;
        $this->delivery_address = $this->editPackage->delivery_address;
        $this->delivery_contact = $this->editPackage->delivery_contact;
        $this->delivery_note = $this->editPackage->delivery_note;
        $this->collected_on = Carbon::parse($this->editPackage->collected_on)->format('d/m/Y');
        $this->deliver_by = Carbon::parse($this->editPackage->deliver_by)->format('d/m/Y');
        $this->status = $this->editPackage->status;
        $this->delivered_on = $this->editPackage->delivered_on ? Carbon::parse($this->editPackage->delivered_on)->format('d/m/Y') : null;
        $this->out_for_delivery_on = $this->editPackage->out_for_delivery_on ? Carbon::parse($this->editPackage->out_for_delivery_on)->format('d/m/Y') : null;
        $this->reached_location_on = $this->editPackage->reached_location_on ? Carbon::parse($this->editPackage->reached_location_on)->format('d/m/Y') : null;
    }

    public function getRowsQueryProperty()
    {
        $query = Package::query()
            ->when(!auth()->user()->isSuperadmin, function($query) {
                $query->where('location_id', auth()->user()->location_id)
                    ->orWhereHas('business', function($subQuery) {
                        $subQuery->where('location_id', auth()->user()->location_id);
                    });
            })
            ->when(in_array($this->filters['status'], ['0', '1']), fn($query) => $query->where('status', $this->filters['status']))
            ->when($this->filters['locationId'], fn($query, $location_id) => $query->where('location_id', $location_id))
            ->when($this->filters['addedOnMin'], fn($query, $addedOnMin) => $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $addedOnMin)))
            ->when($this->filters['addedOnMax'], fn($query, $addedOnMax) => $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $addedOnMax)))
            ->when($this->filters['search'], fn($query, $search) => $query->where('tracking_id', 'like', '%'.$search.'%'));
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function() {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.admin.manage-packages', [
            'locations' => Location::all(),
            'businesses' => Business::all(),
            'packages' => $this->rows,
        ]);
    }
}
