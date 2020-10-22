<?php

namespace App\Http\Livewire\Website;

use App\Models\Package;
use Livewire\Component;

class TrackPackage extends Component
{
    public $trackingId = null;
    public $searched = false;
    public ?Package $result = null;

    protected $rules = [
      'trackingId' => 'required|min:10',
    ];

    public function updatedTrackingId()
    {
        $this->resetErrorBag('trackingId');
    }

    public function track()
    {
        $this->validate();
        $this->result = Package::whereTrackingId($this->trackingId)->first();
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.website.track-package');
    }
}
