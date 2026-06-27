<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceInternal extends Model
{
    protected $guarded = [];
    protected $fillable = ['title', 'type', 'amount','method', 'transaction_date', 'description', 'attachment', 'created_by'];
    protected $dates = ['transaction_date']; // Pastikan ini untuk mengkonversi ke Carbon
}
