<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\TalentProfile;

class TalentProfileController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $profiles = TalentProfile::query()
                    ->whereNull('deleted_at')
                    ->paginate($perPage);

        return response()->json($profiles);
    }

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
