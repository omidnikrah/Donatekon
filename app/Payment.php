<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['resnumber','cat_id','status','price','name','email','category'];
    public function Category()
    {
        return $this->belongsTo('App\Category');
    }
}
