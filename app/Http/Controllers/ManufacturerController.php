<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class ManufacturerController extends Controller
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
            $manufacturers = DB::table("manufacturers")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("deleted_at", "=", null)
                ->get();
        } else {
            $manufacturers = DB::table("manufacturers")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("deleted_at", "=", null)
                ->where("name", "like", "%$search%")
                ->get();
        }
        return Inertia::render("Manufacturers/Index", [
            "manufacturers" => $manufacturers,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedManufacturers = DB::table("manufacturers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "!=", null)
            ->get();
        return Inertia::render("Manufacturers/Trashed", [
            "trashed_manufacturers" => $trashedManufacturers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Manufacturers/Create");
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
                "name" => "manufacturer name",
            ]
        );
        DB::table("manufacturers")->insert([
            "name" => $request->name,
        ]);
        return Redirect::route("products.manufacturers.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacturer = DB::table("manufacturers")
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("Manufacturers/Edit", [
            "manufacturer" => $manufacturer[0],
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
                "name" => "manufacturer name",
            ]
        );
        DB::table("manufacturers")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("products.manufacturers.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("manufacturers")
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
        DB::table("manufacturers")
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
        DB::table("manufacturers")
            ->where("deleted_at", "!=", null)
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
