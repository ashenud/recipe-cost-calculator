<?php

namespace App\Models\Recipe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class RecipeCategory extends Model
{
    use HasFactory, SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $primaryKey = 'rc_id';

    protected $table = 'recipe_categories';

    protected $fillable = [
        'rc_name',
    ];
}
