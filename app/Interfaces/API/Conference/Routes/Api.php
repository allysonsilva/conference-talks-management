<?php

namespace App\API\Conference\Routes;

use Illuminate\Routing\Router;
use Support\Http\Routing\RouteFile;
use Illuminate\Support\Facades\Route;
use App\API\Conference\Controllers\OrganizeConferenceTracks;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

class Api extends RouteFile
{
    public function routes(Router $router): void
    {
        // Route::get('/', function () {
        //     return view('conference::welcome');
        // });

        $router->post('conferences/talks', OrganizeConferenceTracks::class)
               ->name('handle.tracks');
    }
}
