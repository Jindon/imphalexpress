<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\Business;
use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;

class BusinessSettings extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use AuthorizesRequests;

    public $showForm = false;
    public $name;
    public $phone;
    public $location_id;
    public $status = true;
    public $address = '';
    public $showConfirmDelete = false;
    public $showConfirmDeleteSelected = false;
    public $deleteId = null;

    public ?Business $editBusiness = null;

    public $filters = [
        'search' => '',
        'status' => null,
        'addedOnMax' => null,
        'addedOnMin' => null,
        'locationId' => null,
    ];

    protected $listeners = ['refreshBusinesses' => '$refresh'];

    protected $rules = [
      'name' => 'required|max:125',
      'phone' => 'sometimes|max:15',
      'location_id' => 'required',
      'status' => 'required|in:0,1',
      'address' => 'sometimes|max:250',
    ];

    protected $messages = [
        'location_id.required' => 'The location field cannot be empty.',
    ];

//    protected $queryString = ['sortField', 'sortDirection'];

    public function updatedFilters(){ $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function toggleShowForm()
    {
        $this->useCachedRows();
        $this->showForm = !$this->showForm;
    }

    public function editBusiness(Business $business)
    {
        $this->useCachedRows();
        $this->editBusiness = $business;
        $this->name = $business->name;
        $this->phone = $business->phone;
        $this->location_id = $business->location_id;
        $this->status = $business->status;
        $this->address = $business->address;
        $this->showForm = true;
    }

    public function changeStatus(Business $business, $status)
    {
        $this->authorize('settings');
        if($business->status != $status) {
            $business->update(['status' => $status == 1 ? 1 : 0]);
            $this->notify('Status changed successfully');
        }
    }

    public function confirmDelete($business_id)
    {
        $this->useCachedRows();
        $this->showConfirmDelete = true;
        $this->deleteId = $business_id;
    }

    public function delete()
    {
        $this->authorize('settings');
        try{
            Business::whereId($this->deleteId)->delete();
            $this->showConfirmDelete = false;
            $this->deleteId = null;
            $this->notify('Business deleted successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function deleteSelected()
    {
        $this->authorize('settings');
        if(!empty($this->selected)) {
            try{
                $this->selectedRowsQuery->delete();

                $this->showConfirmDeleteSelected = false;
                $this->selected = [];

                $this->notify('Selected businesses deleted successfully');
            } catch (\Exception $error) {
                dd($error);
            }
        }
    }

    public function exportSelected()
    {
        $this->authorize('settings');
        if(!empty($this->selected)) {
            return response()->streamDownload(function() {
                echo $this->selectedRowsQuery->toCsv();
            }, 'businesses-' . now()->format('d-m-Y-His') . '.csv');
        }
    }

    public function save()
    {
        $this->authorize('settings');
        $data = $this->validate();
        try {
            $this->editBusiness
                ? $this->editBusiness->update($data)
                : Business::create($data);
            $this->reset();
            $this->notify('Business added successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function getRowsQueryProperty()
    {
        $query = Business::query()
            ->when(in_array($this->filters['status'], ['0', '1']), fn($query) => $query->where('status', $this->filters['status']))
            ->when($this->filters['locationId'], fn($query, $location_id) => $query->where('location_id', $location_id))
            ->when($this->filters['addedOnMin'], fn($query, $addedOnMin) => $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $addedOnMin)))
            ->when($this->filters['addedOnMax'], fn($query, $addedOnMax) => $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $addedOnMax)))
            ->when($this->filters['search'], fn($query, $search) => $query->where('name', 'like', '%'.$search.'%'));
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
        return view('livewire.admin.settings.business', [
            'locations' => Location::all(),
            'businesses' => $this->rows,
        ])->layout('layouts.settings');
    }
}
