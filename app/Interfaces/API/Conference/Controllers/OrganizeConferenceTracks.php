<?php

namespace App\API\Conference\Controllers;

use Illuminate\Http\Request;
use Support\Http\Controller;
use Illuminate\Http\JsonResponse;
use App\API\Conference\Rules\TalkTitleRule;
use App\API\Conference\Services\ConferenceManager;
use App\API\Conference\Transformers\ConferenceResource;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrganizeConferenceTracks extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the incoming request.
     *
     * @SuppressWarnings("StaticAccess")
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'data' => ['required', 'array',],
            // 'data.*' => [new TalkTitleRule],
            'data.*' => ['required', 'string', \Illuminate\Validation\Rule::talks()],
            // 'data.*' => [function ($attribute, $value, $fail) {
            //     if ($value <= 10) {
            //         $fail(':attribute needs +10!');
            //     }
            // }]
        ]);

        $conferenceManager = app(ConferenceManager::class, ['talks' => $validatedData['data']]);

        return (ConferenceResource::collection($conferenceManager->execute()))
                ->response()
                ->setStatusCode(HttpResponse::HTTP_OK);
    }
}
