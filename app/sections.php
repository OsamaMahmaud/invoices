<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $table='sections';
    protected $fillable=['section_name','description','Created_by','created_at','updated_at'];
    protected $hidden=['created_at','updated_at'];

    /**
     * Get all of the comments for the sections
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\products', 'section_id');
    }
}
