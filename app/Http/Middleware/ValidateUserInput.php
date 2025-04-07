<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ValidateUserInput
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') || $request->isMethod('put')) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email' . ($request->isMethod('put') ? ',' . $request->route('id') : ''),
                'age' => 'required|integer|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::warning('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }
        }

        return $next($request);
    }
}