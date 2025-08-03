<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
     public function user(Request $request): JsonResponse
    {
        return response()->json([
            'id' => $request->user()->id,
            'firstname' => $request->user()->firstname,
            'lastname' => $request->user()->lastname,
            'email' => $request->user()->email,
            'rol' => $request->user()->getRoleNames()->first(), 
        ]);
    }
}
