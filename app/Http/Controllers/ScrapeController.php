<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use App\Services\PortfolioScraper;
use App\models\TalentProfile;

class ScrapeController extends Controller
{
    protected $scraper;

    public function __construct(PortfolioScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function scrape(Request $request)
    {
        $url = $request->post('url');
        if (!$url) {
            return response()->json(['error' => 'Missing URL'], 400);
        }

        try {

            $talentProfile = TalentProfile::where('url', $url)->first();
            if ($talentProfile) {
                return response()->json(['status' => 'error', 'message' => 'Profile already exists!'], 409);

            } else {
                $data = $this->scraper->scrape($url);

                TalentProfile::create([
                    'url' => $url,
                    'username' => Str::slug($data['name'] ?? '', '-'),
                    'name' => $data['name'] ?? '',
                    'job_position' => $data['job_position'] ?? '',
                    'summary_experience' => $data['summary_experience'] ?? '',
                ]);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
