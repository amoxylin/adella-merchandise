<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class ProductController extends Controller
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
            $products = DB::table("products")
                ->select(
                    DB::raw("
                        products.id as id, products.name as name, products.stock as stock, products.price as price,
                        products.deleted_at as deleted_at, categories.id as category_id, categories.name as category_name,
                        manufacturers.id as manufacturer_id, manufacturers.name as manufacturer_name
                    ")
                )
                ->where("products.deleted_at", "=", null)
                ->join(
                    "categories",
                    "categories.id",
                    "=",
                    "products.category_id"
                )
                ->join(
                    "manufacturers",
                    "manufacturers.id",
                    "=",
                    "products.manufacturer_id"
                )
                ->get();
        } else {
            $products = DB::table("products")
                ->select(
                    DB::raw("
                        products.id as id, products.name as name, products.stock as stock, products.price as price,
                        products.deleted_at as deleted_at, categories.id as category_id, categories.name as category_name,
                        manufacturers.id as manufacturer_id, manufacturers.name as manufacturer_name
                    ")
                )
                ->where("products.deleted_at", "=", null)
                ->where("products.name", "like", "%$search%")
                ->join(
                    "categories",
                    "categories.id",
                    "=",
                    "products.category_id"
                )
                ->join(
                    "manufacturers",
                    "manufacturers.id",
                    "=",
                    "products.manufacturer_id"
                )
                ->get();
        }
        return Inertia::render("Products/Index", [
            "products" => $products,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedProducts = DB::table("products")
            ->select(
                DB::raw("
                    products.id as id, products.name as name, products.stock as stock, products.price as price,
                    products.deleted_at as deleted_at, categories.id as category_id, categories.name as category_name,
                    manufacturers.id as manufacturer_id, manufacturers.name as manufacturer_name
                ")
            )
            ->where("products.deleted_at", "!=", null)
            ->join("categories", "categories.id", "=", "products.category_id")
            ->join(
                "manufacturers",
                "manufacturers.id",
                "=",
                "products.manufacturer_id"
            )
            ->get();
        return Inertia::render("Products/Trashed", [
            "trashed_products" => $trashedProducts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table("categories")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $manufacturers = DB::table("manufacturers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        return Inertia::render("Products/Create", [
            "categories" => $categories,
            "manufacturers" => $manufacturers,
        ]);
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
                "category" => ["required", "integer", "exists:categories,id"],
                "manufacturer" => [
                    "required",
                    "integer",
                    "exists:manufacturers,id",
                ],
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
                "price" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "category" => "product category",
                "manufacturer" => "product manufacturer",
                "name" => "product name",
                "stock" => "product stock",
                "price" => "product price",
            ]
        );
        DB::table("products")->insert([
            "category_id" => $request->category,
            "manufacturer_id" => $request->manufacturer,
            "name" => $request->name,
            "stock" => $request->stock,
            "price" => $request->price,
        ]);
        return Redirect::route("products.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = DB::table("categories")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $manufacturers = DB::table("manufacturers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $product = DB::table("products")
            ->select(
                DB::raw("
                    products.id as id, products.name as name, products.stock as stock, products.price as price,
                    products.deleted_at as deleted_at, categories.id as category_id, categories.name as category_name,
                    manufacturers.id as manufacturer_id, manufacturers.name as manufacturer_name
                ")
            )
            ->where("products.deleted_at", "=", null)
            ->where("products.id", "=", $id)
            ->join("categories", "categories.id", "=", "products.category_id")
            ->join(
                "manufacturers",
                "manufacturers.id",
                "=",
                "products.manufacturer_id"
            )
            ->get();
        return Inertia::render("Products/Edit", [
            "categories" => $categories,
            "manufacturers" => $manufacturers,
            "product" => $product[0],
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
                "category" => ["required", "integer", "exists:categories,id"],
                "manufacturer" => [
                    "required",
                    "integer",
                    "exists:manufacturers,id",
                ],
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
                "price" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "category" => "product category",
                "manufacturer" => "product manufacturer",
                "name" => "product name",
                "stock" => "product stock",
                "price" => "product price",
            ]
        );
        DB::table("products")
            ->where("id", "=", $id)
            ->update([
                "category_id" => $request->category,
                "manufacturer_id" => $request->manufacturer,
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("products.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("products")
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
        DB::table("products")
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
        DB::table("products")
            ->where("deleted_at", "!=", null)
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
