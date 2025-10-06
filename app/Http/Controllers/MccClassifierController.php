<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MccClassifierController extends Controller
{
    public function show(): View
    {
        return view('classifier.form');
    }

    public function classify(Request $request): View
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:500'],
            'top_k' => ['nullable', 'integer', 'min:1', 'max:10'],
            'top_goods' => ['nullable', 'integer', 'min:0', 'max:20'],
        ]);

        $topK = (int)($validated['top_k'] ?? 3);
        $topGoods = (int)($validated['top_goods'] ?? 5);

        $result = $this->performClassification(
            $validated['text'],
            $topK,
            $topGoods
        );

        return view('classifier.form', [
            'inputText' => $validated['text'],
            'topK' => $topK,
            'topGoods' => $topGoods,
            'predictions' => $result['predictions'],
            'serviceMessage' => $result['serviceMessage'],
            'serviceError' => $result['serviceError'],
        ]);
    }

    public function classifyAsync(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:500'],
            'top_k' => ['nullable', 'integer', 'min:1', 'max:10'],
            'top_goods' => ['nullable', 'integer', 'min:0', 'max:20'],
        ]);

        $topK = (int)($validated['top_k'] ?? 3);
        $topGoods = (int)($validated['top_goods'] ?? 5);

        $result = $this->performClassification(
            $validated['text'],
            $topK,
            $topGoods
        );

        $status = $result['serviceError'] ? 502 : 200;

        return response()->json([
            'text' => $validated['text'],
            'predictions' => $result['predictions'],
            'message' => $result['serviceMessage'],
            'service_error' => $result['serviceError'],
            'top_k' => $topK,
            'top_goods' => $topGoods,
        ], $status);
    }

    private function performClassification(string $text, int $topK, int $topGoods): array
    {
        $baseUrl = rtrim(config('services.mcc.base_url'), '/');

        $predictions = [];
        $serviceMessage = null;
        $serviceError = false;

        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->post($baseUrl . '/predict', [
                    'text' => $text,
                    'top_k' => $topK,
                    'top_goods' => $topGoods,
                ]);

            if ($response->successful()) {
                $payload = $response->json();
                if (is_array($payload)) {
                    if (array_key_exists('predictions', $payload)) {
                        $predictions = $payload['predictions'] ?? [];
                        $serviceMessage = $payload['message'] ?? null;
                    } else {
                        $predictions = $payload;
                    }
                } else {
                    $serviceError = true;
                    $serviceMessage = 'Classifier returned an unexpected response.';
                }
            } else {
                $serviceError = true;
                $serviceMessage = 'Classifier service responded with an error.';
            }
        } catch (\Throwable $exception) {
            $serviceError = true;
            $serviceMessage = 'Classifier service is unavailable.';
        }

        return [
            'predictions' => $predictions,
            'serviceMessage' => $serviceMessage,
            'serviceError' => $serviceError,
        ];
    }
}
