<?php
class AzureAI {
    public static function describeImage($imageUrl) {
        $url = AZURE_OPENAI_ENDPOINT . "openai/deployments/" . AZURE_OPENAI_MODEL . "/chat/completions?api-version=2024-02-15-preview";

        $headers = [
            "Content-Type: application/json",
            "api-key: " . AZURE_OPENAI_KEY
        ];

        $payload = [
            "messages" => [
                ["role" => "system", "content" => "You help describe hotel rooms for booking listings. Focus on cleanliness, bed type, style, and accessibility."],
                ["role" => "user", "content" => [
                    ["type" => "text", "text" => "Describe this hotel room image in less than 250 characters."],
                    ["type" => "image_url", "image_url" => ["url" => $imageUrl]]
                ]]
            ],
            "max_tokens" => 200,
            "temperature" => 0.7
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? 'No description generated.';
    }
}
