<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RelatedEntity extends Model
{
    public function reference()
    {
        return $this->morphTo();
    }
}
