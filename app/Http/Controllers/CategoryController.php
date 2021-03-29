<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function index($companyId)
    {
        $company = Company::find($companyId);
        if (!$company) {
            abort(404);
        }

        if (\auth()->user()->can('view', $company)) {
            return view('category.index')->with('company', $company);
        }
        else {
            abort(403);
        }
    }

    /**
     *  * @OA\Post (
     *     path="/company/{companyId}/category",
     *     summary="store company new changelog category",
     *     @OA\Parameter(
     *     name="companyId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="label",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="bg_color",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="text_color",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param CategoryStoreRequest $request
     * @param $companyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request, $companyId): \Illuminate\Http\JsonResponse
    {
        $category = new Category();

        $data = $request->validated();

        $category->label = $data['label'];
        $category->company_id = $companyId;
        $category->bg_color = $data['bg_color'];
        $category->text_color = $data['text_color'];

        if (\auth()->user()->can('store', $category)) {
            $category->save();
            return response()->json(['status' => 'success', 'category' => $category]);
        }
        else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }

    /**
     *  * @OA\Put  (
     *     path="/company/category/{id}",
     *     summary="update company changelog category",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="label",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="bg_color",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     * ),
     *     @OA\Parameter(
     *     name="text_color",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param CategoryStoreRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryStoreRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog category.']);
        }

        $data = $request->validated();

        $category->label = $data['label'];
        $category->bg_color = $data['bg_color'];
        $category->text_color = $data['text_color'];

        if (\auth()->user()->can('update', $category)) {
            $category->save();
            return response()->json(['status' => 'success', 'message' => 'Category has been successfully updated.', 'category' => $category]);
        }
        else {
            return $this->handleUnauthorizedJsonResponse();
        }
    }

    /**
     *  * @OA\Delete  (
     *     path="/company/category/{id}",
     *     summary="delete company changelog category",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="success"
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog category.']);
        }

        if (count($category->changelogs) > 0) {
            return response()->json(['status' => 'error', 'message' => 'There were changelogs linked to this category. Unable to delete.']);
        }

        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Category has been successfully deleted.']);
    }
}
