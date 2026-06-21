<?php

// ============================================
// BASE CONTROLLER
// ============================================
// Purpose: This is the base controller that all other
// controllers extend from. It provides common functionality
// and utilities for all controllers.
// ============================================

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}