<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice_attachments extends Model
{
    //
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'file_name',
        'Created_by'


    ];
}
