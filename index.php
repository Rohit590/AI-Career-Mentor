<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AI Career Platform</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #0B0F19;
            color: #fff;
            overflow-x: hidden;
        }

        /* glowing background */
        body::before {
            content: "";
            position: fixed;
            top: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, .35), transparent);
            filter: blur(120px);
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, .35), transparent);
            filter: blur(120px);
            z-index: -1;
        }

        /* NAV */
        nav {
            position: sticky;
            top: 0;
            z-index: 999;

            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 60px;

            background: rgba(11, 15, 25, 0.65);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        nav h2 {
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        nav a {
            color: #9CA3AF;
            margin-left: 20px;
            text-decoration: none;
            transition: .3s;
        }

        nav a:hover {
            color: white;
        }

        /* HERO */
        .hero {
            min-height: 90vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 70px;
            line-height: 1.1;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero p {
            margin-top: 20px;
            color: #9CA3AF;
            font-size: 18px;
        }

        .hero-buttons {
            margin-top: 30px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            border: none;
            color: white;
            cursor: pointer;
            margin: 5px;
            font-weight: 500;
            transition: .3s;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #3B82F6;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(139, 92, 246, .3);
        }

        /* FEATURES */
        .features {
            padding: 100px 60px;
            text-align: center;
        }

        .features h2 {
            margin-bottom: 40px;
            font-size: 32px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            align-items: stretch;
        }

        .feature-box {
            background: rgba(17, 24, 39, .6);
            padding: 30px;
            border-radius: 18px;
            backdrop-filter: blur(12px);

            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            min-height: 140px;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        .steps {
            padding: 140px 60px;
            text-align: center;
            position: relative;
        }

        .steps h2 {
            font-size: 36px;
            margin-bottom: 60px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .step {
            background: rgba(17, 24, 39, .6);
            backdrop-filter: blur(12px);
            margin: 20px auto;
            padding: 25px 30px;
            border-radius: 16px;
            width: 50%;
            transition: .3s;
            border: 1px solid rgba(255, 255, 255, .05);
        }

        .step:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        /* FOOTER */
        footer {
            margin-top: 80px;
            padding: 60px 20px;
            text-align: center;
            color: #9CA3AF;
            border-top: 1px solid rgba(255, 255, 255, .08);
            background: linear-gradient(to top, rgba(17, 24, 39, .8), transparent);
        }

        /* floating animation */
        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            filter: blur(120px);
            opacity: .3;
            z-index: -1;
        }

        .blob1 {
            top: 20%;
            left: 10%;
        }

        .blob2 {
            bottom: 20%;
            right: 10%;
        }

        #particles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -2;
            top: 0;
            left: 0;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            padding: 30px 0 80px 0;
            text-align: center;
            margin-top: -40px;
        }

        .stat h2 {
            font-size: 40px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .testimonials {
            padding: 140px 60px;
            text-align: center;
        }

        .testimonials h2 {
            font-size: 36px;
            margin-bottom: 60px;
        }

        .testimonial {
            background: rgba(17, 24, 39, .6);
            margin: 25px auto;
            padding: 30px;
            width: 50%;
            border-radius: 18px;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .05);
            transition: .3s;
        }

        .testimonial:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        .testimonial p {
            font-size: 16px;
            color: #D1D5DB;
        }

        .testimonial h4 {
            margin-top: 15px;
            color: #9CA3AF;
        }

        .pricing {
            padding: 140px 60px;
            text-align: center;
        }

        .pricing h2 {
            font-size: 36px;
            margin-bottom: 60px;
        }

        .pricing-grid {
            display: flex;
            justify-content: center;
            gap: 40px;
        }

        .price-card {
            background: rgba(17, 24, 39, .6);
            padding: 40px 30px;
            border-radius: 20px;
            width: 260px;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, .05);
            /* transition: .3s; */
            position: relative;
        }

        .price-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(139, 92, 246, .25);
        }

        .price-card h1 {
            font-size: 42px;
            margin: 15px 0;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero {
            position: relative;
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding-top: 80px;
            padding-bottom: 40px;
        }

        .bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(11, 15, 25, .75);
            z-index: -1;
        }

        .hero-content {
            text-align: center;
        }

        .story {
            background: white;
            padding: 140px 80px;
            position: relative;
        }

        .story::before {
            content: "";
            position: absolute;
            top: -80px;
            left: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(to bottom, transparent, white);
        }

        .story::after {
            content: "";
            position: absolute;
            bottom: -80px;
            left: 0;
            width: 100%;
            height: 80px;
            background: linear-gradient(to top, transparent, white);
        }

        .story-block {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
            margin-bottom: 120px;
        }

        .story-block:nth-child(even) {
            direction: rtl;
        }

        .story-block:nth-child(even) .story-text {
            direction: ltr;
        }

        .story-number {
            font-size: 90px;
            font-weight: 800;
            color: #00000012;
            line-height: 1;
            transition: .3s;
        }

        .story-block:hover .story-number {
            transform: translateX(10px);
            color: #00000020;
        }

        .story-text h3 {
            font-size: 28px;
            margin: 10px 0;
        }

        .story-text p {
            color: #9CA3AF;
            line-height: 1.6;
        }

        .story-img img {
            width: 100%;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .5);
        }

        .story {
            background: white;
            color: #111827;
            position: relative;
            z-index: 1;
        }

        .story-text p {
            color: #4B5563;
        }

        .story-number {
            color: #00000015;
        }

        .story-img img {
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
        }

        .story-img {
            overflow: hidden;
            border-radius: 18px;
        }

        .story-img img {
            width: 100%;
            border-radius: 18px;
            transition: transform .6s ease;
        }

        .story-block:hover .story-img img {
            transform: scale(1.05);
        }

        .story {
            background: white;
            padding: 160px 100px;
        }

        .story-text h3 {
            font-size: 32px;
            font-weight: 600;
            margin: 15px 0;
        }

        .story-text p {
            font-size: 16px;
            line-height: 1.7;
            color: #4B5563;
            max-width: 480px;
        }

        .contact {
            background: #0B0F19;
            padding: 140px 80px;
            text-align: center;
        }

        .contact h2 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #000000;
        }

        .contact-sub {
            color: #9CA3AF;
            margin-bottom: 50px;
            color: #000000;
        }

        .contact-form {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .contact-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contact-right textarea {
            height: 100%;
            min-height: 180px;
        }

        .contact input,
        .contact textarea {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            background: #111827;
            color: white;
        }

        .contact-btn {
            grid-column: span 2;
            padding: 16px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .contact {
            background: url('assets/images/map.png') center/cover no-repeat;
            padding: 140px 80px;

        }
    </style>
</head>

<body>
    <div id="particles"></div>

    <div class="blob blob1"></div>
    <div class="blob blob2"></div>

    <nav>
        <h2>AI Career Mentor</h2>
        <div>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="admin/login.php">Admin</a>
        </div>
    </nav>



    <section class="hero">
        <video autoplay muted loop playsinline class="bg-video">
            <source src="assets/video/graph bg video.mp4">
        </video>
        <div>
            <h1 class="title">Your AI Career Mentor</h1>
            <p class="subtitle">Generate roadmap, track progress and learn with AI</p>

            <div class="hero-buttons">
                <button class="btn" onclick="location.href='register.php'">Get Started</button>
                <button class="btn btn-outline" onclick="location.href='login.php'">Login</button>
            </div>
        </div>


    </section>
    <section class="stats">
        <div class="stat">
            <h2 class="count" data-target="5000">0</h2>
            <p>Students</p>
        </div>

        <div class="stat">
            <h2 class="count" data-target="120">0</h2>
            <p>Career Paths</p>
        </div>

        <div class="stat">
            <h2 class="count" data-target="95">0</h2>
            <p>Success Rate %</p>
        </div>
    </section>

    <section class="features">
        <h2>Powerful Features</h2>

        <div class="feature-grid">

            <div class="feature-box">
                <h3>AI Roadmap Generator</h3>
                <p>Create personalized career roadmap instantly</p>
            </div>

            <div class="feature-box">
                <h3>Project Based Learning</h3>
                <p>Learn by building real world projects</p>
            </div>

            <div class="feature-box">
                <h3>Progress Tracking</h3>
                <p>Track your learning journey visually</p>
            </div>

        </div>
    </section>

    <section class="story">
        <div class="story-block">
            <div class="story-text">
                <div class="story-number">01</div>
                <h3>Generate AI Roadmap</h3>
                <p>Create personalized roadmap based on your career goal.</p>
            </div>

            <div class="story-img">
                <img src="assets/images/ai_roadmap.png">
            </div>
        </div>

        <div class="story-block">
            <div class="story-text">
                <div class="story-number">02</div>
                <h3>Track Progress</h3>
                <p>Complete tasks and track your learning journey.</p>
            </div>

            <div class="story-img">
                <img src="assets/images/progress.png">
            </div>
        </div>

        <div class="story-block">
            <div class="story-text">
                <div class="story-number">03</div>
                <h3>AI Mentor Chat</h3>
                <p>Ask AI for guidance anytime.</p>
            </div>

            <div class="story-img">
                <img src="assets/images/ai_chat.png">
            </div>
        </div>

        <div class="story-block">
            <div class="story-text">
                <div class="story-number">04</div>
                <h3>Core Subjects Notes</h3>
                <p>Access curated learning material.</p>
            </div>

            <div class="story-img">
                <img src="assets/images/notes.png">
            </div>
        </div>

    </section>

    <section class="steps">
        <h2>How It Works</h2>

        <div class="step">Choose your career goal</div>
        <div class="step">Generate AI roadmap</div>
        <div class="step">Complete tasks & earn XP</div>

    </section>

    <section class="pricing">

        <h2>Pricing</h2>

        <div class="pricing-grid">

            <div class="price-card">
                <h3>Free</h3>
                <h1>₹0</h1>
                <p>Basic Roadmaps</p>
                <button onclick="location.href='register.php'" class="btn">Start</button>
            </div>

            <div class="price-card">
                <h3>Pro</h3>
                <h1>₹199</h1>
                <p>AI Mentor + Projects</p>
                <button class="btn">Upgrade</button>
            </div>

        </div>
    </section>

    <section class="testimonials">
        <h2>What Students Say</h2>

        <div class="testimonial">
            <p>"Best AI roadmap platform I used!"</p>
            <h4>- Rohit</h4>
        </div>

        <div class="testimonial">
            <p>"Helped me become frontend developer."</p>
            <h4>- Aman</h4>
        </div>

    </section>

    <?php if (isset($_GET['sent'])) { ?>
        <div style="
            position:fixed;
            top:20px;
            right:20px;
            background:#22c55e;
            color:white;
            padding:12px 20px;
            border-radius:8px;
            z-index:999;
            duration: 0.5s;">
            Message sent successfully ✅
        </div>
    <?php } ?>

    <section class="contact">
        <h2>Contact Us</h2>
        <p class="contact-sub">Fill the details below and our team will reach you</p>

        <form action="contact_submit.php" method="POST" class="contact-form">

            <div class="contact-left">
                <input type="text" name="name" placeholder="Your Name *" required>
                <input type="email" name="email" placeholder="Your Email *" required>
                <input type="text" name="phone" placeholder="Your Phone *" required>
            </div>

            <div class="contact-right">
                <textarea name="message" placeholder="Your Message *" required></textarea>
            </div>

            <button class="contact-btn">SEND MESSAGE</button>

        </form>
    </section>

    <footer>
        © 2026 AI Career Mentor | All Rights Reserved.
    </footer>

    <script>
        const texts = [
            "Generate AI Roadmaps",
            "Track Your Progress",
            "Become Job Ready",
            "Learn With Projects"
        ];

        let i = 0,
            j = 0,
            current = "",
            isDeleting = false;

        function type() {
            const el = document.getElementById("typing");

            current = texts[i];

            if (!isDeleting) {
                el.textContent = current.substring(0, j++);
            } else {
                el.textContent = current.substring(0, j--);
            }

            if (j == current.length) isDeleting = true;
            if (j == 0) {
                isDeleting = false;
                i = (i + 1) % texts.length;
            }

            setTimeout(type, isDeleting ? 50 : 100);
        }

        type();
    </script>

    <script>
        document.querySelectorAll('.count').forEach(counter => {
            const update = () => {
                const target = +counter.getAttribute('data-target');
                const c = +counter.innerText;

                const inc = target / 100;

                if (c < target) {
                    counter.innerText = Math.ceil(c + inc);
                    setTimeout(update, 20);
                } else {
                    counter.innerText = target;
                }
            }
            update();
        });
    </script>

    <script>
        gsap.from("nav", {
            y: -50,
            duration: 1
        })

        gsap.from(".title", {
            y: 50,
            duration: 1
        })
        gsap.from(".subtitle", {
            y: 30,
            delay: .3
        })
        gsap.from(".btn", {
            scale: .8,
            stagger: .2,
            delay: .6
        })

        gsap.from(".feature-box", {
            y: 60,
            stagger: .2,
            duration: 1,
            scrollTrigger: {
                trigger: ".features"
            }
        })

        gsap.from(".step", {
            y: 40,
            stagger: .2,
            scrollTrigger: {
                trigger: ".steps"
            }
        })

        gsap.to(".blob1", {
            x: 100,
            y: 50,
            repeat: -1,
            yoyo: true,
            duration: 8
        })
        gsap.to(".blob2", {
            x: -100,
            y: -50,
            repeat: -1,
            yoyo: true,
            duration: 10
        })

        tsParticles.load("particles", {
            particles: {
                number: {
                    value: 40
                },
                size: {
                    value: 2
                },
                move: {
                    speed: 0.6
                },
                opacity: {
                    value: 0.3
                }
            }
        });

        gsap.registerPlugin(ScrollTrigger);

        gsap.utils.toArray(".story-block").forEach(block => {
            gsap.from(block.querySelector(".story-text"), {
                x: -80,
                opacity: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: block,
                    start: "top 80%"
                }
            })

            gsap.from(block.querySelector(".story-img"), {
                x: 80,
                opacity: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: block,
                    start: "top 80%"
                }
            })
        });

        gsap.utils.toArray(".story-number").forEach((num, i) => {

            let target = (i + 1).toString().padStart(2, '0')

            gsap.fromTo(num, {
                innerText: "00"
            }, {
                innerText: target,
                duration: 1,
                snap: {
                    innerText: 1
                },
                scrollTrigger: {
                    trigger: num,
                    start: "top 80%"
                }
            })

        });

        gsap.utils.toArray(".story-img img").forEach(img => {

            gsap.to(img, {
                y: -60,
                ease: "none",
                scrollTrigger: {
                    trigger: img,
                    scrub: true
                }
            })

        });

        gsap.utils.toArray(".story-block").forEach(block => {

            gsap.from(block, {
                opacity: 0,
                y: 80,
                duration: 1,
                scrollTrigger: {
                    trigger: block,
                    start: "top 85%"
                }
            })

        });
    </script>

    <script>
        gsap.from(".step", {
            y: 60,
            stagger: .2,
            scrollTrigger: {
                trigger: ".steps",
                start: "top 80%"
            }
        })

        gsap.from(".price-card", {
            y: 60,
            stagger: .2,
            scrollTrigger: {
                trigger: ".pricing",
                start: "top 80%"
            }
        })

        gsap.from(".testimonial", {
            y: 60,
            stagger: .2,
            scrollTrigger: {
                trigger: ".testimonials",
                start: "top 80%"
            }
        })
    </script>
</body>

</html>