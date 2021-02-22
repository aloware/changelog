<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Changelog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $changelog = new Changelog();
        $changelog->title = $request->get('title');
        $changelog->body = $request->get('body');

        $category = Category::find($request->get('category_id'));
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find category.']);
        }
        $changelog->category_id = $category->id;

        $account = Account::find($request->get('account_id'));
        if (!$account) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find account.']);
        }
        $changelog->account_id = $account->id;

        if ($request->has('published_at')) {
            $changelog->published_at = Carbon::parse($request->get('published_at'));
        }

        $changelog->save();

        return response()->json(['changelog' => $changelog]);
    }

    public function update($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $changelog = Changelog::find($id);
        $changelog->title = $request->get('title');
        $changelog->body = $request->get('body');

        $category = Category::find($request->get('category_id'));
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find category.']);
        }

        $changelog->category_id = $category->id;

        if ($request->has('published_at')) {
            $changelog->published_at = $request->has('published_at');
        }

        $changelog->save();

        return response()->json(['changelog' => $changelog]);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $changelog = Changelog::find($id);

        if (!$changelog) {
            return response()->json(['status' => 'error', 'message' => 'Unable to find changelog.']);
        }

        //TODO check for soft deletion
        $changelog->delete();

        return response()->json(['status' => 'success', 'message' => 'Changelog has been successfully deleted.']);
    }
}
