<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Cache;
use Exception;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function index(){
        try {
            $admin = Cache::remember('admin', 60*60*24, function(){
                return AdminModel::getAdmin();
            });
            $response = array(
                'success' => true,
                'message' => 'Successfuly get data admin',
                'data' => $admin->isEmpty() ? null : $admin
            );
            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, these error in internal server',
                'data' => null,
                'error' => $error->getMessage()
            );
            return response()->json($response, 500);
        }
    }

    public function show(int $admin_id){
        try {
            $cacheKey = 'admin_'.$admin_id;
            $admin = Cache::remember($cacheKey, 60*60*24, function() use($admin_id){
                return AdminModel::getAdminById($admin_id);
            });

            if(!$admin){
                $response = array(
                    'success' => false,
                    'message' => 'Data Admin not found',
                    'data' => null
                );

                return response()->json($response, 404);
            }

            $response = array(
                'success' => true,
                'message' => 'Successfuly get data admin',
                'data' => $admin->isEmpty() ? null : $admin
            );
            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, these error in internal server',
                'data' => null,
                'error' => $error->getMessage()
            );
            return response()->json($response, 500);
        }

    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'admin_username' => 'required|string|max:50',
                'admin_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:50',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/'
                ]
            ]);
            if ($validator->fails()) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create data admin, data not completed, please check your data',
                    'data' => null,
                    'error' => $validator->errors()
                );
                return response()->json($response, 400);
            }

            $admin = AdminModel::createAdmin($validator->validate());
            Cache::put('admin', AdminModel::getAdmin(), 60 * 5);

            $response = array(
                'success' => true,
                'message' => 'Successfuly create data admin',
                'data' => $admin
            );
            return response()->json($response, 201);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, these error in internal server',
                'data' => null,
                'error' => $error->getMessage()
            );
            return response()->json($response, 500);
        }
    }

    public function update(Request $request, int $admin_id){
        try {
            $validator = Validator::make($request->all(), [
                'admin_username' => 'required|string|max:50',
                'admin_password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:50',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/'
                ]
            ]);
            if ($validator->fails()) {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to create data admin, data not completed, please check your data',
                    'data' => null,
                    'error' => $validator->errors()
                );
                return response()->json($response, 400);
            }

            $admin = AdminModel::updateAdmin($validator->validate(), $admin_id);
            Cache::put('admin', AdminModel::getAdmin(), 60 * 5);

            $response = array(
                'success' => true,
                'message' => 'Successfuly update data admin',
                'data' => $admin
            );
            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, these error in internal server',
                'data' => null,
                'error' => $error->getMessage()
            );
            return response()->json($response, 500);
        }
    }

    public function destroy(int $admin_id){
        try {
            $admin = AdminModel::deleteAdmin($admin_id);
            Cache::put('admin', AdminModel::getAdmin(), 60 * 5);

            $response = array(
                'success' => true,
                'message' => 'Successfuly delete data admin',
                'data' => $admin
            );

            return response()->json($response, 200);
        } catch (Exception $error) {
            $response = array(
                'success' => false,
                'message' => 'Sorry, these error in internal server',
                'data' => null,
                'error' => $error->getMessage()
            );
            return response()->json($response, 500);
        }
    }
}
