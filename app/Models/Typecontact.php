<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typecontact extends Model
{
    use HasFactory;
    protected $guarded =[];
    
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
