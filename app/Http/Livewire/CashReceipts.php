<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\CashReceipt;
use Livewire\Component;

class CashReceipts extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'search' => '',
        'status' => '',
        'customer' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
    ];
    public CashReceipt $editing;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshCashReceipts' => '$refresh'];

    public function rules()
    {
        return [
            'editing.customer_id' => 'required|integer|exists:customers,id',
            'editing.amount' => 'required|numeric',
            'editing.status' => 'required|in:' . collect(CashReceipt::STATUSES)->keys()->implode(','),
            'editing.date_for_editing' => 'required',
            'editing.note' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'editing.customer_id.required' => 'The customer field is required.'
    ];

    public function mount()
    {
        $this->editing = $this->makeBlankCashReceipt();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'cash-receipts.csv');
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted ' . $deleteCount . ' cashReceipts');
    }

    public function makeBlankCashReceipt()
    {
        return CashReceipt::make(['date' => now(), 'status' => 'active', 'customer_id' => ' ']);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = !$this->showFilters;
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankCashReceipt();

        $this->showEditModal = true;
    }

    public function edit(CashReceipt $cashReceipt)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($cashReceipt)) $this->editing = $cashReceipt;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing->user_id = auth()->id();
        $this->editing->save();

        $this->showEditModal = false;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        $query = CashReceipt::query()
            ->with('customer')
            ->when($this->filters['status'], fn($query, $status) => $query->where('status', $status))
            ->when($this->filters['customer'], fn($query, $customer) => $query->where('customer_id', $customer))
            ->when($this->filters['amount-min'], fn($query, $amount) => $query->where('amount', '>=', $amount))
            ->when($this->filters['amount-max'], fn($query, $amount) => $query->where('amount', '<=', $amount))
            ->when($this->filters['date-min'], fn($query, $date) => $query->where('date', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max'], fn($query, $date) => $query->where('date', '<=', Carbon::parse($date)))
            ->when($this->filters['search'], fn($query, $search) => $query->where('amount', 'like', '%' . $search . '%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.cash-receipts', [
            'cashReceipts' => $this->rows,
        ]);
    }
}
