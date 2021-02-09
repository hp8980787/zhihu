<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['user_id','title','body'];
    public function isHidden()
    {
        return $this->is_hidden === 'T';
    }
}
