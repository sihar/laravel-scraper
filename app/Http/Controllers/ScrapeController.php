<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use App\Services\PortfolioScraper;
use App\models\TalentProfile;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Talent Profile API",
 *     version="1.0.0"
 * )
 */
class ScrapeController extends Controller
{
    protected $scraper;

    public function __construct(PortfolioScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    /**
     * @OA\Post(
     *     path="/api/scrape",
     *     summary="Scrape a public URL and store structured data",
     *     tags={"Scraper"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Scrape completed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="job_position", type="string"),
     *                 @OA\Property(property="summary_experience", type="string"),
     *                 @OA\Property(property="clients", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Scraping failed"
     *     )
     * )
     */
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
