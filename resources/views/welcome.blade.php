<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Hub | Work Order System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />

    <!-- Custom Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-900: #0f172a;
            --primary-800: #1e293b;
            --accent-700: #2563eb;
            --accent-800: #1d4ed8;
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
        }

        /* Prevent scrolling completely */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--neutral-50) 0%, #ffffff 100%);
            height: 100vh;
            overflow: hidden; /* This makes it non-scrollable */
            width: 100%;
        }

        .font-display { font-family: 'Space Grotesk', sans-serif; }

        .hero-gradient {
            background: linear-gradient(135deg, var(--neutral-50) 0%, #ffffff 50%, var(--neutral-100) 100%);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary-900) 0%, var(--accent-700) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Card Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* Custom Button Style */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-700) 0%, var(--accent-800) 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        /* Animations */
        .floating-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }

        .nav-blur {
            backdrop-filter: blur(10px);
            background: rgba(248, 250, 252, 0.85);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased">

    <!-- NAVIGATION -->
    <nav class="fixed w-full z-50 top-0 start-0 border-b border-white/20 nav-blur">
        <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto px-6 py-4">

            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 group rtl:space-x-reverse">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="font-display font-bold text-2xl text-gray-900 tracking-tight">Request Hub</span>
            </a>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-3 md:space-x-4">
                <a href="login" class="px-3 py-2 text-gray-700 font-medium hover:text-gray-900 transition-colors text-sm md:text-base">
                    Sign In
                </a>
                <a href="register" class="btn-primary px-5 py-2.5 text-white font-medium rounded-xl shadow-lg flex items-center text-sm md:text-base">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (Full Height) -->
    <section class="hero-gradient h-screen w-full flex items-center relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 w-full pt-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- TEXT CONTENT -->
                <div class="space-y-8">
                    <div class="space-y-6 fade-in">
                        <h1 class="font-display font-bold text-5xl lg:text-6xl leading-tight text-gradient">
                            Centralized Support for Every Department
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed max-w-lg">
                            We didn't just build a request system; we built a bridge between employees and service providers. Whether it's an urgent IT fix or routine maintenance.
                        </p>
                    </div>

                    <!-- CTA BUTTONS -->
                    <div class="flex flex-col sm:flex-row gap-4 fade-in stagger-1">
                        <a href="login" class="btn-primary px-8 py-4 text-white font-semibold rounded-xl inline-flex items-center justify-center shadow-lg shadow-blue-500/30">
                            Get Started Now
                            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- MINI FEATURES -->
                    <div class="grid grid-cols-2 gap-6 pt-8 fade-in stagger-2">
                        <div class="feature-card p-6 rounded-2xl shadow-sm">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Priority Tracking</h3>
                            <p class="text-sm text-gray-600">Identify high-priority requests.</p>
                        </div>

                        <div class="feature-card p-6 rounded-2xl shadow-sm">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7H4l5-5v5zm6 10V7a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h10a1 1 0 001-1z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Smart Alerts</h3>
                            <p class="text-sm text-gray-600">Automated notifications.</p>
                        </div>
                    </div>
                </div>

                <!-- HERO IMAGES -->
                <div class="relative fade-in stagger-3 hidden lg:block">
                    <div class="grid grid-cols-2 gap-6 floating-animation">
                        <div class="space-y-6">
                            <div class="card-hover rounded-3xl overflow-hidden shadow-2xl">
                                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=600"
                                     alt="Office"
                                     class="w-full h-64 object-cover">
                            </div>
                            <div class="card-hover rounded-3xl overflow-hidden shadow-2xl">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=600"
                                     alt="Meeting"
                                     class="w-full h-48 object-cover">
                            </div>
                        </div>

                        <div class="space-y-6 mt-8">
                            <div class="card-hover rounded-3xl overflow-hidden shadow-2xl">
                                <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&q=80&w=600"
                                     alt="Support"
                                     class="w-full h-48 object-cover">
                            </div>
                            <div class="card-hover rounded-3xl overflow-hidden shadow-2xl">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=600"
                                     alt="Office"
                                     class="w-full h-64 object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Floating Stats Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-2xl floating-animation" style="animation-delay: -3s;">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">99.9%</div>
                            <div class="text-sm text-gray-600">Uptime</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- Animation Script -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>
</body>
</html>
