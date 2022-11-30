<?php

namespace App\Http\Controllers;

use App\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request, UserRepositoryContract $userRepository)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        if ($userRepository->getFromEmail($input['email']) != null) {
            return $this->sendError('User already exists with this email.', ['email' => $input['email']]);
        }

        $user = $userRepository->create($input);
        $success['token'] =  $user->createToken($user->getName())->plainTextToken;
        $success['name'] =  $user->getName();

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken($user->getName())->plainTextToken;
            $success['name'] =  $user->getName();

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.');
        }
    }
}
