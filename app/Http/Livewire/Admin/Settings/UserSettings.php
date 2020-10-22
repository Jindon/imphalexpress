<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserSettings extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    use AuthorizesRequests;

    public $showForm = false;
    public $name;
    public $phone;
    public $email;
    public $password;
    public $location_id;
    public $status = true;
    public $showConfirmDelete = false;
    public $showConfirmDeleteSelected = false;
    public $deleteId = null;
    public $editId = null;

    public ?User $editUser = null;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public $filters = [
        'search' => null
    ];

    protected $rules = [
        'name' => 'required|max:125',
        'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:6',
        'location_id' => 'required',
        'status' => 'required|in:0,1',
    ];

    protected $messages = [
        'location_id.required' => 'The location field cannot be empty.',
    ];

//    protected $queryString = ['sortField', 'sortDirection'];
    public function mount() { $this->initialSort(); }
    protected function initialSort(){ $this->sorts = ['created_at' => 'desc']; }

    public function toggleShowForm()
    {
        $this->useCachedRows();
        $this->reset('name', 'location_id', 'email', 'phone', 'email', 'status', 'editUser', 'editId');
        $this->showForm = !$this->showForm;
    }

    public function editUser(User $user)
    {
        $this->useCachedRows();
        $this->editUser = $user;
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->location_id = $user->location_id;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->showForm = true;
    }

    public function changeStatus(User $user, $status)
    {
        $this->authorize('settings');
        if($user->status != $status) {
            $user->update(['status' => $status == 1 ? 1 : 0]);
            $this->initialSort();
            $this->notify('Status changed successfully');
        }
    }

    public function confirmDelete($user_id)
    {
        $this->useCachedRows();
        $this->showConfirmDelete = true;
        $this->deleteId = $user_id;
    }

    public function delete()
    {
        $this->authorize('settings');
        try{
            User::whereId($this->deleteId)->delete();
            $this->showConfirmDelete = false;
            $this->deleteId = null;
            $this->initialSort();
            $this->notify('User deleted successfully');
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
                $this->initialSort();
                $this->notify('Selected users deleted successfully');
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
            }, 'users-' . now()->format('d-m-Y-His') . '.csv');
        }
    }

    public function save()
    {
        $this->authorize('settings');
        if($this->editUser) {
            unset($this->rules['password']);
            $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $this->editId;
            if(isset($this->password)) $this->rules['password'] = 'min:6';
        }
        $data = $this->validate();
        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);
        try {
            $this->editUser
                ? $this->editUser->update($data)
                : User::create($data);
            $this->reset();
            $this->initialSort();
            $this->notify('User saved successfully');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function getRowsQueryProperty()
    {
        $query = User::query()
            ->where('id', '!=', auth()->user()->id)
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
        return view('livewire.admin.settings.user', [
            'locations' => Location::all(),
            'users' => $this->rows,
        ])->layout('layouts.settings');
    }
}
