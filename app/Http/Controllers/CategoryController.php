<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        if (empty($search)) {
            $categories = DB::table("categories")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("deleted_at", "=", null)
                ->get();
        } else {
            $categories = DB::table("categories")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("deleted_at", "=", null)
                ->where("name", "like", "%$search%")
                ->get();
        }
        return Inertia::render("Categories/Index", [
            "categories" => $categories,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedCategories = DB::table("categories")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "!=", null)
            ->get();
        return Inertia::render("Categories/Trashed", [
            "trashed_categories" => $trashedCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Categories/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
            ],
            [],
            [
                "name" => "category name",
            ]
        );
        DB::table("categories")->insert([
            "name" => $request->name,
        ]);
        return Redirect::route("products.categories.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = DB::table("categories")
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("Categories/Edit", [
            "category" => $category[0],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
            ],
            [],
            [
                "name" => "category name",
            ]
        );
        DB::table("categories")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("products.categories.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("categories")
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => Carbon::now(),
            ]);
        return back();
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_permanent($id)
    {
        DB::table("categories")
            ->where("id", "=", $id)
            ->delete();
        return back();
    }

    /**
     * Restore the specified trashed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        DB::table("categories")
            ->where("deleted_at", "!=", null)
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
