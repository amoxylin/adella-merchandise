<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    ProductController,
    CategoryController,
    ManufacturerController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ]);
});

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    // Products Endpoint
    Route::group(
        [
            "prefix" => "products",
            "as" => "products.",
        ],
        function () {
            Route::get("/", [ProductController::class, "index"])->name("index");
            Route::get("trashed", [ProductController::class, "trashed"])->name(
                "trashed"
            );
            Route::get("create", [ProductController::class, "create"])->name(
                "create"
            );
            Route::post("store", [ProductController::class, "store"])->name(
                "store"
            );
            Route::get("{id}/edit", [ProductController::class, "edit"])->name(
                "edit"
            );
            Route::put("{id}/update", [
                ProductController::class,
                "update",
            ])->name("update");
            Route::get("{id}/destroy", [
                ProductController::class,
                "destroy",
            ])->name("destroy");
            Route::get("{id}/destroy-permanent", [
                ProductController::class,
                "destroy_permanent",
            ])->name("destroy_permanent");
            Route::get("{id}/restore", [
                ProductController::class,
                "restore",
            ])->name("restore");

            // Product Categories Endpoint
            Route::group(
                [
                    "prefix" => "categories",
                    "as" => "categories.",
                ],
                function () {
                    Route::get("/", [CategoryController::class, "index"])->name(
                        "index"
                    );
                    Route::get("trashed", [
                        CategoryController::class,
                        "trashed",
                    ])->name("trashed");
                    Route::get("create", [
                        CategoryController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        CategoryController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        CategoryController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        CategoryController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        CategoryController::class,
                        "destroy",
                    ])->name("destroy");
                    Route::get("{id}/destroy-permanent", [
                        CategoryController::class,
                        "destroy_permanent",
                    ])->name("destroy_permanent");
                    Route::get("{id}/restore", [
                        CategoryController::class,
                        "restore",
                    ])->name("restore");
                }
            );

            // Product Manufacturers Endpoint
            Route::group(
                [
                    "prefix" => "manufacturers",
                    "as" => "manufacturers.",
                ],
                function () {
                    Route::get("/", [
                        ManufacturerController::class,
                        "index",
                    ])->name("index");
                    Route::get("trashed", [
                        ManufacturerController::class,
                        "trashed",
                    ])->name("trashed");
                    Route::get("create", [
                        ManufacturerController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        ManufacturerController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        ManufacturerController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        ManufacturerController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        ManufacturerController::class,
                        "destroy",
                    ])->name("destroy");
                    Route::get("{id}/destroy-permanent", [
                        ManufacturerController::class,
                        "destroy_permanent",
                    ])->name("destroy_permanent");
                    Route::get("{id}/restore", [
                        ManufacturerController::class,
                        "restore",
                    ])->name("restore");
                }
            );
        }
    );
});
