<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $category = new Category();
        $category->label = $request->get('label');

        //TODO check on this, might need to add relationship to isolate categories per company and accounts
        //$category->account_id = $request->get('account_id');
        //$category->company_id = $request->get('company_id');

        $category->save();

        return response()->json(['category' => $category]);
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog category.']);
        }

        $category->label = $request->get('label');
        $category->save();

        return response()->json(['status' => 'success', 'message' => 'Category has been successfully updated.', 'category' => $category]);

    }
    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog category.']);
        }

        //TODO check for soft deletion
        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Category has been successfully deleted.']);
    }
}
