<?php

namespace App\Models\Recipe;

use App\Models\Ingredients\Ingredient;
use App\Models\Other\SystemUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class RecipeLine extends Model
{
    use HasFactory, SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $primaryKey = 'rl_id';

    protected $table = 'recipe_lines';

    protected $fillable = [
        'recipe_id',
        'line_no',
        'ingredient_id',
        'unit_id',
        'qty',
        'unit_cost',
        'line_cost',
    ];

    public function belonged_recipe() {
        return $this->belongsTo(RecipeHead::class,'recipe_id')->withTrashed();
    }

    public function belonged_ingredient() {
        return $this->belongsTo(Ingredient::class,'in_id','ingredient_id')->withTrashed();
    }

    public function belonged_unit(){
        return $this->belongsTo(SystemUnit::class,'unit_id')->withTrashed();
    }
}
