<?php

namespace Lawin\Seat\Esintel\Http\Controllers;

use Lawin\Seat\Esintel\Models\Category;
use Lawin\Seat\Esintel\Http\Validation\CategoryCreateRequest;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;



class CategoryController extends Controller {



    public function createCategory(CategoryCreateRequest $request) {
        $new_category = new Category;
        $data = $request->validated();
        $new_category->category_name = $data['category_name'];
        $new_category->is_active = true;
        $new_category->save();
        return redirect()->back()->with('success', 'Created new category ' . $new_category->category_name);
    }



    public function toggleCategory(Request $request) {

        $category = Category::find($request->id);
        $category->is_active = $request->status;
        $category->update();

        return response()->json(['success' => 'Changed category status.']);
    }


    public function index() {
        $categories = Category::getCategories();
        return view('esintel::categories', compact('categories'));
    }
}
