<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class CustomerRegistration extends Component
{
    public bool $show = false;
    public string $name = '';
    public bool $saveNew = false;

    protected $rules = [
        'name' => ['required', 'string', 'max:254', 'unique:customers']
    ];

    public function saveAndNew()
    {
        $this->saveNew = true;
        $this->store();
    }

    public function store()
    {
        $this->validate();

        Customer::create(['name' => $this->name]);

        request()->session()->flash('flash.banner', 'Customer successfully added!');
        request()->session()->flash('flash.bannerStyle', 'success');

        $this->reset('name');

        return redirect()->route('dashboard');
        $this->show = $this->saveNew;
    }

    public function render()
    {
        return view('livewire.customer.customer-registration');
    }
}
