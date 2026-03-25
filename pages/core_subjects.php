<?php
include("../includes/auth.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Core Subjects Notes</title>

    <link rel="stylesheet" href="../assets/css/theme.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
        }

        .container {
            width: 85%;
            margin: auto;
            margin-top: 100px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h2 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            color: #9CA3AF;
        }

        .notes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .note-card {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 25px;
            text-decoration: none;
            color: white;
            border: 1px solid rgba(255, 255, 255, .08);
            transition: .3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .note-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .3);
        }

        .note-top {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .os {
            background: #1E3A8A;
        }

        .dbms {
            background: #6B21A8;
        }

        .cn {
            background: #92400E;
        }

        .ai {
            background: #065F46;
        }

        .cloud {
            background: #7F1D1D;
        }

        .programming {
            background: #134E4A;
        }

        .note-title {
            font-size: 18px;
            font-weight: 600;
        }

        .note-desc {
            margin-top: 15px;
            color: #9CA3AF;
            font-size: 14px;
            line-height: 1.5;
        }

        .note-bottom {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #9CA3AF;
        }

        .explore {
            color: #22C55E;
            font-weight: 500;
        }

        @media (max-width: 1000px) {
            .notes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .notes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include("../includes/navbar.php"); ?>
    <div class="container">
        <div class="header">
            <h2>📚 Core Subjects</h2>
            <p>Select a subject to open PDF notes</p>
        </div>

        <div class="notes-grid">

            <a href="../notes//OS.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box os"><i class="fa-solid fa-desktop"></i></div>
                        <div class="note-title">Operating Systems</div>
                    </div>
                    <div class="note-desc">
                        Learn process management, memory handling, scheduling, and file systems.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/DBMS.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box dbms"><i class="fa-solid fa-database"></i></div>
                        <div class="note-title">Database Management Systems</div>
                    </div>
                    <div class="note-desc">
                        Learn relational databases, normalization, indexing and SQL queries.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/CN.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box cn"><i class="fa-solid fa-globe"></i></div>
                        <div class="note-title">Computer Networks</div>
                    </div>
                    <div class="note-desc">
                        Understand networking layers, protocols, routing and internet fundamentals.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/system design.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box cloud"><i class="fa-solid fa-diagram-project"></i></div>
                        <div class="note-title">System Design</div>
                    </div>
                    <div class="note-desc">
                        Learn scalability, load balancing, microservices, databases and architecture design.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="PDF_LINK_AI" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box ai"><i class="fa-solid fa-brain"></i></div>
                        <div class="note-title">Foundation of AI & ML</div>
                    </div>
                    <div class="note-desc">
                        Basics of AI, machine learning algorithms and model training concepts.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="PDF_LINK_CLOUD" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box cloud"><i class="fa-solid fa-cloud"></i></div>
                        <div class="note-title">Foundation of Cloud Computing</div>
                    </div>
                    <div class="note-desc">
                        Learn cloud models, virtualization and service architectures.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="PDF_LINK_PROGRAMMING" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box programming"><i class="fa-solid fa-code"></i></div>
                        <div class="note-title">Programming Fundamentals</div>
                    </div>
                    <div class="note-desc">
                        Learn core programming concepts, logic building and syntax basics.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/DSA.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box ai"><i class="fa-solid fa-diagram-project"></i></div>
                        <div class="note-title">Data Structures & Algorithms</div>
                    </div>
                    <div class="note-desc">
                        Learn arrays, linked lists, trees, graphs, sorting and problem solving techniques.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/OOPs.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box programming"><i class="fa-solid fa-cubes"></i></div>
                        <div class="note-title">Object Oriented Programming</div>
                    </div>
                    <div class="note-desc">
                        Understand classes, objects, inheritance, polymorphism and encapsulation.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/SQL.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box dbms"><i class="fa-solid fa-table"></i></div>
                        <div class="note-title">SQL</div>
                    </div>
                    <div class="note-desc">
                        Learn queries, joins, indexing, aggregation and database optimization.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/python.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box programming"><i class="fa-brands fa-python"></i></div>
                        <div class="note-title">Python</div>
                    </div>
                    <div class="note-desc">
                        Learn Python basics, data structures, functions, OOP and problem solving.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/C.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box programming"><i class="fa-solid fa-c"></i></div>
                        <div class="note-title">C Programming</div>
                    </div>
                    <div class="note-desc">
                        Learn C fundamentals, pointers, memory management and structured programming.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>

            <a href="../notes/java.pdf" target="_blank" class="note-card">
                <div>
                    <div class="note-top">
                        <div class="icon-box programming"><i class="fa-brands fa-java"></i></div>
                        <div class="note-title">Java</div>
                    </div>
                    <div class="note-desc">
                        Learn Java fundamentals, OOP concepts, collections, multithreading and core APIs.
                    </div>
                </div>
                <div class="note-bottom">
                    <span class="explore">Explore →</span>
                </div>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            gsap.from(".header", {
                y: 50,
                opacity: 0,
                duration: 1,
                ease: "power3.out"
            });
        });
    </script>

    <script src="../assets/js/theme.js"></script>

</body>

</html>