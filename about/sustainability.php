<?php
// PHP variables for dynamic content
$page_title = "Sustainability Design - FormAndFit Showcase"; 
$company_name = "FormAndFit";
$founding_year = "2025"; 
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?php echo $page_title; ?></title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Mobile menu animation */
        .mobile-menu {
            transition: transform 0.3s ease;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        /* Red theme lift hover effect */
        .impact-card, .value-card {
            transition: all 0.3s ease;
        }
        .impact-card:hover, .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.1),
                        0 4px 6px -2px rgba(239, 68, 68, 0.05);
        }
        /* Consistent section card animation */
        .team-card {
            transition: transform 0.3s ease, border 0.3s ease;
            border-bottom: 4px solid transparent;
        }
        .team-card:hover {
            transform: translateY(-3px);
            border-bottom-color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50" role="navigation" aria-label="Primary Navigation">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-6">
                    <a href="../index.php" class="text-xl font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500" aria-label="<?php echo $company_name; ?> Home">
                        <?php echo $company_name; ?>
                    </a>
                    <div class="hidden sm:flex sm:space-x-8">
                        <a href="../index.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Home</a>
                        <a href="about-us.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">About Us</a>
                        <a href="our-story.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Our Story</a>
                        <a href="sustainability.php" class="text-gray-900 px-1 pt-1 border-b-2 border-red-500 text-sm font-medium" aria-current="page">Sustainability</a>
                        <a href="careers.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Careers</a>
                    </div>
                </div>
                <div class="flex items-center sm:hidden">
                    <button id="mobile-menu-button" aria-label="Open mobile menu" aria-expanded="false" aria-controls="mobile-menu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-64 bg-white shadow-lg transform translate-x-full hidden" aria-hidden="true" role="menu" aria-label="Mobile menu">
            <div class="flex justify-end p-4">
                <button id="close-menu" aria-label="Close mobile menu" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="../index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Home</a>
                <a href="about-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">About Us</a>
                <a href="our-story.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Our Story</a>
                <a href="sustainability.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50" aria-current="page" role="menuitem">Sustainability</a>
                <a href="careers.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Careers</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <p class="text-base text-red-400 font-semibold tracking-wide uppercase">Ethical Digital Design</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                The Blueprint for Sustainable Digital Presence.
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                Our commitment extends beyond physical goods; it’s about crafting a <strong>lean, efficient, and accessible digital experience</strong> that minimizes energy consumption.
            </p>
        </div>
    </header>

    <!-- Main -->
    <main>
        <section class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:order-2">
                        <img class="w-full h-auto rounded-lg shadow-xl" src="../Data/sjs.png" alt="Minimalist user interface design showcasing efficiency." loading="lazy" />
                    </div>
                    <div class="mt-10 lg:mt-0 lg:order-1">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Efficiency as a Core Design Metric</h2>
                        <p class="text-lg text-gray-500">
                            Digital products consume energy through data transfer and device processing. Our design philosophy combats this with a **minimalist UI/UX** that lowers the data required to render pages.
                        </p>
                        <blockquote class="mt-8 text-xl italic text-gray-600 border-l-4 border-red-500 pl-4">
                            "A lighter page load is a greener page load. Performance is part of our environmental ethics."
                        </blockquote>
                        <p class="mt-4 text-lg text-gray-500">
                            By leveraging efficient frameworks like Tailwind CSS and prioritizing vector graphics over heavy images, we achieve high-impact visuals with low digital overhead.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Our Sustainable Design Rules</h2>
                <p class="mt-4 text-xl text-gray-500">Embedding responsibility into every line of code.</p>
                
                <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    
                    <div class="p-6 bg-white rounded-lg shadow-md impact-card text-center">
                        <i data-feather="zap" class="w-10 h-10 text-red-500 mx-auto mb-3"></i>
                        <h3 class="mt-2 text-xl font-semibold text-gray-900">Reduced Data Transfer</h3>
                        <p class="mt-2 text-gray-500 text-sm">
                            Optimizing assets and scripts to minimize load size, lowering the processing energy required on user devices.
                        </p>
                    </div>
                    
                    <div class="p-6 bg-white rounded-lg shadow-md impact-card text-center">
                        <i data-feather="eye" class="w-10 h-10 text-red-500 mx-auto mb-3"></i>
                        <h3 class="mt-2 text-xl font-semibold text-gray-900">Inclusive Accessibility</h3>
                        <p class="mt-2 text-gray-500 text-sm">
                            Adhering to WCAG standards ensures usability for all, reinforcing social sustainability and equitable access.
                        </p>
                    </div>
                    
                    <div class="p-6 bg-white rounded-lg shadow-md impact-card text-center">
                        <i data-feather="refresh-cw" class="w-10 h-10 text-red-500 mx-auto mb-3"></i>
                        <h3 class="mt-2 text-xl font-semibold text-gray-900">Maintainable Codebase</h3>
                        <p class="mt-2 text-gray-500 text-sm">
                            Clean, modular, and documented code ensures future maintainability — minimizing waste in redesign and refactor efforts.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-16 bg-red-600 text-center">
            <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white">See Our Sustainability in Action</h2>
                <p class="mt-4 text-xl text-red-100">
                    This showcase is a blueprint. Explore our partner’s live products that implement these principles in real-world design.
                </p>
                <div class="mt-8 flex justify-center">
                    <a href="https://partner-website.com" target="_blank" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                        Visit Partner Site (External)
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?> Design Showcase. All rights reserved.</p>
    </footer>

    <script>
        // Mobile menu toggle (same behavior as careers.php)
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.remove('hidden');
            setTimeout(() => { menu.classList.add('open'); menu.classList.remove('translate-x-full'); }, 10);
        });
        document.getElementById('close-menu').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.remove('open');
            menu.classList.add('translate-x-full');
            setTimeout(() => { menu.classList.add('hidden'); }, 300);
        });

        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
