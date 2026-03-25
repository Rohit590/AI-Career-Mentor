<?php
include("../includes/db.php");

if (isset($_POST['goal'])) {

    $goal = trim($_POST['goal']);

    $api_key = "YOUR_API_KEY";
    error_log("GOAL RECEIVED: " . $goal);
    $prompt = "You are an expert career mentor.

    Create a structured roadmap for becoming a $goal.

    Rules:
    - Give exactly 8 steps
    - Each step must include TYPE and TITLE
    - Types must be ONLY from:
    Learning, Practice, Project, Advanced, Interview
    - Keep each step short (1 line)
    - Do not explain anything
    - Steps must be relevant to the goal
    - Do not use generic steps

    Return ONLY steps in this format:

    1. [Learning] Step title
    2. [Learning] Step title
    3. [Practice] Step title
    4. [Learning] Step title
    5. [Project] Step title
    6. [Advanced] Step title
    7. [Project] Step title
    8. [Interview] Step title";

    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ]
    ];

    $ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }

    curl_close($ch);

    // echo $response;
    // exit;

    $result = json_decode($response, true);

    $text = $result['choices'][0]['message']['content'] ?? "";

    $lines = explode("\n", $text);
    $clean = [];

    foreach ($lines as $line) {
        $line = trim($line);

        // remove numbering like "1. "
        $line = preg_replace('/^\d+\.\s*/', '', $line);

        if (!empty($line)) {
            $clean[] = $line;
        }
    }

    echo implode("\n", $clean);
}
