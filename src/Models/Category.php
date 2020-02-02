<?php

namespace Lawin\Seat\Esintel\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'lawin_esintel_categories';

    protected $fillable = [
        'category_name',
        'is_active',
    ];



    public static function getCategories() {
        return Category::all();
    }



    public static function getActiveCategories() {
        return Category::where('is_active', 1)->get();
    }
}