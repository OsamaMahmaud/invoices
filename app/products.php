<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //

    protected $table='products';
    protected $fillable=['product_name','description','section_id','created_at','updated_at'];
    protected $hidden=['created_at','updated_at'];



        public function section()
        {
            return $this->belongsTo('App\sections', 'section_id');
        }

}


