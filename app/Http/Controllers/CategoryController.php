<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     *  * @OA\Get(
     *     path="/api/{company}/categories",
     *     summary="list of company categories",
     *     @OA\Parameter(
     *     name="companyId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param $companyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCompanyId($companyId): \Illuminate\Http\JsonResponse
    {
        $company = Company::find($companyId);

        return response()->json($company->categories);
    }

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

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog category.']);
        }

        $category->label = $request->get('label');
        $category->save();

        return response()->json(['status' => 'success', 'message' => 'Category has been successfully updated.', 'category' => $category]);

    }
    public function destroy($id): \Illuminate\Http\JsonResponse
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
