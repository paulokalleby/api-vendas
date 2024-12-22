<?php

namespace App\Http\Controllers;

 /**
 * @OA\Server(url="http://localhost"),
 * @OA\Info(title="API Project", version="1.0.0")
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 * )
 */
abstract class Controller
{
    //
}
