<?php

namespace App\Http\Controllers;

use App\Helper\ImageManagerTrait;
use App\Helper\SendMailTrait;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateInfoUserRequest;
use App\Http\Requests\Auth\UpdatePassword;
use App\Http\Requests\ResetPasswordrequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\PasswordResource;
use App\Services\User\UserService;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use APIResponseTrait, SendMailTrait, ImageManagerTrait;

    public function __construct(
        protected UserService $userService
    ) {
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $param = $request->validated();
            $param['role'] = 2;
            $data = $this->userService->createUser($param);

            return $this->successResponse($data, 'Register successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->userService->login($request->validated());
            if (!$data) {
                return $this->errorResponse(null, 'Not found user', 404);
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }
    public function info(): JsonResponse
    {
        try {
            $data = Auth::user();

            return $this->successResponse($data, 'Login successfully', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 'Somethings went wrong', 500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $param = $request->validated();
            //generate token
            $param['token'] = Str::random(64);
            $this->userService->forgotPasword($param);
            //senemail
            $this->callSendForgotPassword([
                'email' => $param['email'],
                'token' => $param['token'],
            ]);
            return $this->successResponse(null, 'Successful', 200);;
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function checkToken(Request $request): JsonResponse
    {
        try {
            $data = $this->userService->checkToken($request->get('token'));
            if (!$data) {
                return $this->errorResponse(null, 'Not found', 404);
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function resetPassword(ResetPasswordrequest $request): JsonResponse
    {
        try {
            $param = $request->validated();
            $param['token'] = $this->get('token');
            $data = $this->userService->resetPassword($param);
            if (!$data) {
                $this->errorResponse(null, 'Not found', 404);
            }
            return $this->successResponse($param, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getUser(int $id): JsonResponse
    {
        try {
            $data = $this->userService->getUserByid($id);
            if (!$data) {
                return $this->errorResponse(null, 'Not found', 404);
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getUserByRole(int $role): JsonResponse
    {
        try {
            $data = $this->userService->getUserByRole($role);
            if (!$data) {
                return $this->errorResponse(null, 'Not found', 404);
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getAll(): JsonResponse
    {
        try {
            $data = $this->userService->getAll();
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function updateInfoUser(UpdateInfoUserRequest $request): JsonResponse
    {
        try {
            $params = $request->validated();
            if (isset($params['image'])) {
                if (is_file($params['image'])) {
                    $fileData = $this->uploads($params['image']);
                    $params['image'] = $fileData['path'];
                }
                $data = $this->userService->updateInfo($params);
            } else {
                $data = $this->userService->updateInfo($params);
            }
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updatePassword(UpdatePassword $request): JsonResponse
    {
        try {
            $param = $request->validated();
            $user = Auth::user();
            if (!Hash::check($param['password_current'], $user->password)) {
                return $this->errorResponse('data not found', 400);
            }
            $data = $this->userService->updateInfo($param);
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updateRole(UpdateOrderRequest $request, int $id): JsonResponse
    {
        try {
            $user['role'] = $request->validated()['status'];
            $data =  $this->userService->updateRole($id, $user);
            return $this->successResponse($data, 'Successful', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
