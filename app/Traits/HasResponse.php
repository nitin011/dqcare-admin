<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

trait HasResponse
{
    public function success($data, $statusCode = 200, $status = "success", $message = "Success")
    {
        return response()->json(["status" => $status, 'message' => $message, 'data' => $data], $statusCode);
    }

    public function successMessage($message, $statusCode = 200)
    {
        return response()->json(["status" => "success", 'message' => $message], $statusCode);
    }

    public function error($message, $statusCode = 500)
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }

    public function errorOk($message, $statusCode = 200)
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }

    public function errorMessage($message, $statusCode = 500)
    {
        return response()->json(["status" => "error", 'message' => $message], $statusCode);
    }


    public function redirect($route, $status, $message)
    {
        return redirect($route)->with($status, $message);
    }

    public function redirectSuccess($route, $message = 'Operation was successful!')
    {
        return $this->redirect($route, 'success', $message);
    }

    public function intendedSuccess($route, $message = 'Operation was successful!')
    {
        return redirect()->intended($route)->with('success', $message);
    }

    public function redirectError($route, $message = 'Operation was unsuccessful!')
    {
        return $this->redirect($route, 'error', $message);
    }

    public function intendedError($route, $message = 'Operation was unsuccessful!')
    {
        return redirect()->intended($route)->with('error', $message);
    }



    public function backSuccess($message = 'Operation was successful!')
    {
        return back()->with('success', $message);
    }

    public function backError($message = 'Operation was unsuccessful!')
    {
        return back()->with('error', $message);
    }
}