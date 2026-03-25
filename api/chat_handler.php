<?php
include("../includes/db.php");
session_start();

$user_id = $_SESSION['user_id'];
$message = $_POST['message'];

/* GET USER API KEY */
$api_key = "YOUR_API_KEY";

$prompt = "You are an AI career mentor.
Help students learn skills, guide roadmap, suggest projects.
Answer clearly and shortly.

Student question: $message";

$data = [
    "model" => "llama-3.1-8b-instant",
    "messages" => [
        ["role" => "user", "content" => $prompt]
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
curl_close($ch);

$result = json_decode($response, true);

$reply = $result['choices'][0]['message']['content'] ?? "AI error";

/* SAVE CHAT */
$message = mysqli_real_escape_string($conn, $message);
$reply = mysqli_real_escape_string($conn, $reply);

$stmt = $conn->prepare("INSERT INTO chat_messages (user_id,message,response) VALUES (?,?,?)");
$stmt->bind_param("iss", $user_id, $message, $reply);
$stmt->execute();

echo $reply;
