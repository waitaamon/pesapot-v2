<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class CustomerRegistration extends Component
{
    public bool $show = false;
    public string $name = '';

    protected $rules = [
        'name' => ['required', 'string', 'max:255', 'unique:customers']
    ];

    public function store()
    {
        $this->validate();

        Customer::create(['name' => $this->name]);

        session()->flash('flash.banner', 'Customer successfully added!');
        session()->flash('flash.bannerStyle', 'success');

        $this->reset('name');

        $this->show = false;
    }

    public function render()
    {
        return view('livewire.customer.customer-registration');
    }
}
