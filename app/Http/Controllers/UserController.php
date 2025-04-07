<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     title="User Management API",
 *     version="1.0.0",
 *     description="API untuk manajemen data pengguna"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Mendapatkan daftar semua pengguna",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar pengguna berhasil diambil",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function index()
    {
        Log::info('Get all users request');
        $users = User::all();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Membuat pengguna baru",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pengguna berhasil dibuat",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function store(Request $request)
    {
        Log::info('Create user request', $request->all());
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Mendapatkan data pengguna berdasarkan ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengguna",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pengguna berhasil diambil",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengguna tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        Log::info('Get user request', ['id' => $id]);
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Memperbarui data pengguna berdasarkan ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengguna",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pengguna berhasil diperbarui",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengguna tidak ditemukan"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        Log::info('Update user request', ['id' => $id, 'data' => $request->all()]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Menghapus pengguna berdasarkan ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengguna",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pengguna berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengguna tidak ditemukan"
     *     )
     * )
     */
    public function destroy($id)
    {
        Log::info('Delete user request', ['id' => $id]);
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

/**
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="string", format="uuid"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="age", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="age", type="integer")
 * )
 */