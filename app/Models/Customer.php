<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function getStatusColorAttribute(): string
    {
        return [
                'Active' => 'green',
                'Deactivated' => 'red',
            ][$this->status] ?? 'cool-gray';
    }

    const STATUSES = [
        'active' => 'Active',
        'deactivated' => 'Deactivated',
    ];

    public function getStatusAttribute(): string
    {
        return $this->trashed() ? 'Deactivated' : 'Active';
    }
}
