<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    function index(){
        $user =  User::all();
        return response()->json($this->successResponse($user, 'users received successfully'),200);
    }

    function store(Request $request) {
        $data = $request->all();

        $rules = [
            'name' => 'required'
        ];

        $validator =  Validator::make($data, $rules);
        
        if($validator->fails()) {
            $error = [
                'status' => false,
                'message' => 'user validation error',
                'data' => $validator->errors()
            ];
            return response()->json($error,404);
        }

        $user = User::create($data);
        
        return response()->json($this->successResponse($user, 'user created successfully'),200);
         
    }

    function show($id){
        $user = User::find($id);

        if(is_null($user)) {
            $error = [
                'status' => false,
                'message' => 'no user found',
            ];
            return response()->json($error,404);
        }

        return response()->json($this->successResponse($user, 'user received successfully'),200);
    }

    function update(Request $request, $id){
        $data = $request->all();

        $rules = [
            'name' => 'required'
        ];

        $validator =  Validator::make($data, $rules);
        
        if($validator->fails()) {
            $error = [
                'status' => false,
                'message' => 'user validation error',
                'data' => $validator->errors()
            ];

            return response()->json($error,404);
        }
        $user = User::find($id);
        
        if(is_null($user)) {
            $error = [
                'status' => false,
                'message' => 'no user found',
            ];
            return response()->json($error,404);
        }

        $user->name = $data['name'];
        $user->save();

        return response()->json($this->successResponse($user, 'user updated successfully'),200);
    }

    function destroy($id) {
        $user = User::find($id);
        if(is_null($user)) {
            $error = [
                'status' => false,
                'message' => 'no user found',
            ];
            return response()->json($error,404);
        }

        $user->delete();

        $response = [
            'status' => true,
            'message' => 'user deleted successfully'
        ];

        return response()->json($response,200);
    }

    public function successResponse($data, $message) {
        return [
                'status' => true,
                'message' => $message,
                'data' => $data->toArray()
            ];
         

    }
}
