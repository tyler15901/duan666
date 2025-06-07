<?php
namespace Libraries;
use GuzzleHttp\Client;

class GeminiClient
{
    protected $apiKey;
    protected $apiUrl;
    protected $client;

    public function __construct()
    {
        $this->apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : 'AIzaSyAgK09XPBS2rkaYCTEz8bCCugjPcIqatMU';
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$this->apiKey}";
        $this->client = new Client();
    }

    public function analyzeCV($text)
    {
        $prompt = <<<PROMPT
Bạn là chuyên gia nhân sự, hãy chấm điểm CV sau trên thang 100, đưa ra nhận xét khách quan, gợi ý vị trí phù hợp và đề xuất cải thiện ngắn gọn nhất. CV:
---
$text
PROMPT;
        $response = $this->client->post($this->apiUrl, [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        ]);
        $result = json_decode($response->getBody(), true);
        $ai_reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        preg_match('/Điểm[\s:]+(\d+)/iu', $ai_reply, $scoreMatch);
        preg_match('/Nhận xét[\s:]+(.+?)(Gợi ý|Vị trí|$)/isu', $ai_reply, $feedbackMatch);
        preg_match('/Gợi ý.*: *(.+?)(Góp ý|Cải thiện|$)/isu', $ai_reply, $positionMatch);
        preg_match('/(Cải thiện|Góp ý)[\s:]+(.+)/isu', $ai_reply, $improveMatch);

        return [
            'score' => $scoreMatch[1] ?? null,
            'ai_feedback' => trim($feedbackMatch[1] ?? $ai_reply),
            'ai_position_suggestion' => trim($positionMatch[1] ?? ''),
            'ai_improvement' => trim($improveMatch[2] ?? '')
        ];
    }

    public function generateCV($input)
    {
        $prompt = "Viết giúp tôi một bản CV mẫu ngắn gọn, phù hợp với thông tin sau:\n$input";
        $response = $this->client->post($this->apiUrl, [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        ]);
        $result = json_decode($response->getBody(), true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    public function suggestCareerPath($major)
    {
        $prompt = "Bạn hãy gợi ý lộ trình phát triển nghề nghiệp tiêu biểu, các kỹ năng cần thiết và các vị trí phù hợp cho ngành: $major";
        $response = $this->client->post($this->apiUrl, [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        ]);
        $result = json_decode($response->getBody(), true);
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }
}
