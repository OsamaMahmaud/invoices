<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices_detailes extends Model
{
    //

    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'product',
        'Section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'Payment_Date',
    ];
}
