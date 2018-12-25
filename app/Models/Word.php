<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    /**
     * 複数代入禁止の属性
     * 
     * @var array
     */
    protected $guarded = ['id'];

}
