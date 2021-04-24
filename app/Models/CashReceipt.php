<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\{SoftDeletes, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class CashReceipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'user_id', 'amount', 'status', 'date', 'note'];

    protected $dates = ['date'];

    const STATUSES = [
        'active' => 'Active',
        'transferred' => 'Transferred',
        'reversed' => 'Reversed',
    ];

    public function getStatusColorAttribute(): string
    {
        return [
                'active' => 'green',
                'reversed' => 'red',
            ][$this->status] ?? 'cool-gray';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDateForHumansAttribute()
    {
        return $this->date->format('M, d Y');
    }

    public function getDateForEditingAttribute()
    {
        return $this->date->format('m/d/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $this->date = Carbon::parse($value);
    }
}
