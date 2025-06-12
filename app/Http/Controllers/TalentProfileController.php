<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\TalentProfile;
use OpenApi\Annotations as OA;

/*
 * @OA\Tag(
 *     name="Talent Profiles",
 *     description="API Endpoints for managing talent profiles"
 * )
 **/
class TalentProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/talent-profiles",
     *     summary="List all talent profiles",
     *     tags={"Talent Profiles"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of profiles")
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $profiles = TalentProfile::query()
                    ->whereNull('deleted_at')
                    ->paginate($perPage);

        return response()->json($profiles);
    }

    /**
     * @OA\Get(
     *     path="/api/talent-profiles/{username}",
     *     summary="Get a talent profile by username",
     *     tags={"Talent Profiles"},
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Profile found"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($username)
    {
        $profile = TalentProfile::where('username', $username)
                    ->whereNull('deleted_at')
                    ->first();

        if (!$profile) {
            return response()->json(['message' => 'Data talent profile not found!'], 404);
        }

        return response()->json($profile);
    }


    /**
     * @OA\Put(
     *     path="/api/talent-profiles/{id}",
     *     summary="Update a talent profile",
     *     tags={"Talent Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "job_position", "username"},
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="job_position", type="string"),
     *             @OA\Property(property="summary_experience", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Profile updated"),
     *     @OA\Response(response=404, description="Profile not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $profile = TalentProfile::find($id);

        if (!$profile || $profile->deleted_at) {
            return response()->json(['message' => 'Data talent profile not found!'], 404);
        }

        $profile->update($request->only([
            'name',
            'job_position',
            'summary_experience',
            'clients',
            'url',
            'username',
        ]));

        return response()->json(['message' => 'Data talent profile updated!', 'data' => $profile]);
    }

    /**
     * @OA\Delete(
     *     path="/api/talent-profiles/{id}",
     *     summary="Delete a profile",
     *     tags={"Talent Profiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Profile deleted"),
     *     @OA\Response(response=404, description="Profile not found")
     * )
     */
    public function destroy($id)
    {
        $profile = TalentProfile::find($id);

        if (!$profile || $profile->deleted_at) {
            return response()->json(['message' => 'Data talent profile not found!'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'Data talent profile deleted!']);
    }
}
