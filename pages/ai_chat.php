<?php
include("../includes/auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>AI Mentor</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
        }

        :root {
            --bg-color: #0B0F19;
            --text-color: white;
            --card-bg: rgba(17, 24, 39, .6);
            --input-bg: #1F2937;
        }

        .container {
            width: 65%;
            margin: auto;
            margin-top: 90px;
        }

        .chat-box {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            border-radius: 16px;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
        }

        .message {
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 12px;
            max-width: 75%;
            animation: fade .3s ease;
        }

        .message.user {
            background: linear-gradient(90deg, #3B82F6, #2563EB);
            margin-left: auto;
        }

        .message.ai {
            background: linear-gradient(90deg, #8B5CF6, #7C3AED);
        }

        .input-box {
            display: flex;
            margin-top: 12px;
        }

        input {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: var(--input-bg);
            color: var(--text-color);
        }

        button {
            margin-left: 10px;
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            cursor: pointer;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container">

        <h2>AI Mentor 🤖</h2>

        <div class="chat-box" id="chat">

            <?php
            $query = "SELECT * FROM chat_messages WHERE user_id='$user_id' ORDER BY id ASC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='message user'>{$row['message']}</div>";
                echo "<div class='message ai'>{$row['response']}</div>";
            }
            ?>

        </div>

        <div class="input-box">
            <input type="text" id="msg" placeholder="Ask your career or learning question...">
            <button onclick="sendMessage()">Send</button>
        </div>

    </div>

    <script>
        function sendMessage() {

            let msg = document.getElementById("msg").value;
            if (msg.trim() === "") return;

            let chat = document.getElementById("chat");

            chat.innerHTML += `<div class="message user">${msg}</div>`;
            chat.innerHTML += `<div class="message ai" id="loading">Thinking...</div>`;

            chat.scrollTop = chat.scrollHeight;

            fetch("../api/chat_handler.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "message=" + encodeURIComponent(msg)
                })
                .then(res => res.text())
                .then(data => {

                    document.getElementById("loading").remove();

                    let aiDiv = document.createElement("div");
                    aiDiv.className = "message ai";
                    chat.appendChild(aiDiv);

                    let i = 0;

                    function type() {
                        if (i < data.length) {
                            aiDiv.innerHTML += data.charAt(i);
                            i++;
                            chat.scrollTop = chat.scrollHeight;
                            setTimeout(type, 15);
                        }
                    }

                    type();
                    document.getElementById("msg").value = "";
                });
        }

        document.getElementById("msg").addEventListener("keypress", function(e) {
            if (e.key === "Enter") sendMessage();
        });
    </script>

    <script>
        gsap.from(".container h2", {
            y: 40,
            opacity: 0,
            duration: 1,
            ease: "power3.out"
        });

        gsap.from(".chat-box", {
            y: 50,
            opacity: 0,
            duration: 1,
            delay: 0.2,
            ease: "power3.out"
        });

        gsap.from(".input-box", {
            y: 30,
            opacity: 0,
            duration: 1,
            delay: 0.4,
            ease: "power3.out"
        });

        gsap.from(".message", {
            opacity: 0,
            y: 20,
            duration: 0.5,
            stagger: 0.05,
            delay: 0.6,
            ease: "power2.out"
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            gsap.from(".container h2", {
                y: 40,
                duration: 1
            });

            gsap.from(".chat-box", {
                y: 50,
                duration: 1,
                delay: 0.2
            });

        });
    </script>
    <script src="../assets/js/theme.js"></script>

</body>

</html>