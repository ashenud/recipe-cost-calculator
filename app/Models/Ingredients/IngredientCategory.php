<?php

namespace App\Models\Ingredients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class IngredientCategory extends Model
{
    use HasFactory, SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $primaryKey = 'in_cat_id';

    protected $table = 'ingredient_categories';

    protected $fillable = [
        'in_cat_name',
        'in_cat_code',
        'in_cat_short_name'
    ];

    public function has_ingredients() {
        return $this->hasMany(Ingredient::class,'in_cat_id');
    }
}
