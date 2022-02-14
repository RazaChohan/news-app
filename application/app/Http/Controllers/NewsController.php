<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Exception;

class NewsController extends Controller
{
    const TITLE_VALIDATION = 'required|string|max:100';
    const CONTENT_VALIDATION = 'required|string|max:255';

    public function __construct(private News $news) {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = [];
        $responseCode = ResponseAlias::HTTP_OK;
        try {
            $response = $this->news->with('user')->get();
        } catch(Exception $exception) {
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            parent::log($exception, self::class);
        }

        return response()->json($response, $responseCode);
    }

    /**
     * @param News $news
     *
     * @return JsonResponse
     */
    public function show(News $news): JsonResponse
    {
        return response()->json($news, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => self::TITLE_VALIDATION,
            'content' => self::CONTENT_VALIDATION,
        ]);

        $response = [];
        $responseCode = ResponseAlias::HTTP_CREATED;
        try {
            $this->news->fill($request->all());
            $this->news->user()->associate($request->user());
            $response = $this->news->save();
            if (empty($response)) {
                $responseCode = ResponseAlias::HTTP_BAD_REQUEST;
            } else {
                $response = $this->news;
            }
        } catch(Exception $exception) {
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            parent::log($exception, self::class);
        }

        return response()->json($response, $responseCode);
    }

    /**
     * @param Request $request
     * @param News $news
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, News $news): JsonResponse
    {
        $this->validate($request, [
            'title' => self::TITLE_VALIDATION,
            'content' => self::CONTENT_VALIDATION,
        ]);

        $responseCode = ResponseAlias::HTTP_OK;
        try {
            $news->update($request->all());
            $news->user()->associate($request->user());
            $news->save();
        } catch(Exception $exception) {
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            parent::log($exception, self::class);
        }

        return response()->json(null, $responseCode);
    }

    /**
     * @param News $news
     *
     * @return JsonResponse
     */
    public function delete(News $news): JsonResponse
    {
        $responseCode = ResponseAlias::HTTP_NO_CONTENT;
        try {
            $news->delete();
        } catch(Exception $exception) {
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            parent::log($exception, self::class);
        }

        return response()->json(null, $responseCode);
    }
}
