<?php

namespace App\Http\Controllers;
use App\Traits\apiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use apiResponse, AuthorizesRequests;
}
