<?php

namespace App\Models\Ingredients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class IngredientUnit extends Model
{
    use HasFactory, SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $primaryKey = 'unit_id';

    protected $table = 'ingredient_units';

    protected $fillable = [
        'unit_name'
    ];
}
