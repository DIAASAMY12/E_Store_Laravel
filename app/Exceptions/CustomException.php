<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Optionally, you can log the exception here
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function render($request)
    {
        return response()->json(['error' => 'User Is already Deleted'], 500);
    }
}
