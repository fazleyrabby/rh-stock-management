<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message= "✨ Everything is awesome! 🚀")
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }

        /**
     * Success response for paginated data.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendPaginatedResponse($result, $meta, $message = "✨ Everything is awesome! 🚀")
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
            'meta'    => $meta, // Include pagination metadata
        ];

        return response()->json($response, 200);
    }
    
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
