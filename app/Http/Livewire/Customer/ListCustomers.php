<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class ListCustomers extends Component
{
    use WithPagination;
    public bool $showFilters = false;
    public int $perPage = 20;
    public bool $selectPage = false;
    public bool $selectAll = false;
    public $selected = [];
    public array $filters = [
        'search' => '',
    ];

    public function updatedFilters($field)
    {
        $this->resetPage();
    }

    public function updatedSelectPage($value)
    {
        $this->selected = $value
            ? $this->customers->pluck('id')->map(fn ($id) => (string) $id)
            : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo (clone $this->customersQuery)
                ->unless($this->selectAll, fn ($query) => $query->whereKey($this->selected))
                ->toCsv();
        }, 'customers.csv');
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getCustomersQueryProperty()
    {
        return Customer::query()
            ->when($this->filters['search'], fn ($query, $search) => $query->search(['name'], $search));
    }

    public function getCustomersProperty()
    {
        return $this->customersQuery->paginate($this->perPage);
    }

    public function render()
    {
        if ($this->selectAll) {
            $this->selected = $this->customers->pluck('id')->map(fn ($id) => (string) $id);
        }
        return view('livewire.customer.list-customers',  [
            'customers' => $this->customers
        ]);
    }
}
