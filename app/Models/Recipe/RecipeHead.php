<?php

namespace App\Models\Recipe;

use App\Models\Other\SystemCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class RecipeHead extends Model
{
    use HasFactory, SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $primaryKey = 'recipe_id';

    protected $table = 'recipe_heads';

    protected $fillable = [
        'recipe_name',
        'recipe_date',
        'recipe_code',
        'recipe_currency',
        'recipe_image',
        'recipe_preparation',
        'recipe_cost',
    ];

    public function has_lines() {
        return $this->hasMany(RecipeLine::class,'recipe_id')->withTrashed();
    }

    public function belonged_currency() {
        return $this->belongsTo(SystemCurrency::class,'cur_id','recipe_currency')->withTrashed();
    }

    public static function genCode() {
        $max_count = self::withTrashed()->count();
        if($max_count) {
            $code = 'RECIPE/'.str_pad($max_count+1,4,0,STR_PAD_LEFT);
        } else {
            $code = 'RECIPE/0001';
        }
        return $code;
    }

}
