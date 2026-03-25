<?php

if (isset($_POST['goal'])) {

    $goal = $_POST['goal'];

    $api_key = "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";

    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => [
            [
                "role" => "user",
                "content" => "Suggest 3 next career paths after completing $goal.

Rules:
- Only give career names
- No explanation
- Output in 3 lines
Example:
Full Stack Developer
UI/UX Designer
Software Engineer"
            ]
        ]
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    echo $result['choices'][0]['message']['content'];
}
