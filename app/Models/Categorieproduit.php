<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorieproduit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sscategories()
    {
        return $this->hasMany(Categorieproduit::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categorieproduit::class, 'parent_id');
    }

    public function estFils($parentCategory)
    {
        $parent = $this->parent;

        while ($parent) {
            if ($parent->id == $parentCategory->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}
