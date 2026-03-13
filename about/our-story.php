<?php
// PHP variables for dynamic content
$page_title = "Our Story - FormAndFit Design Showcase"; 
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
        /* Custom styles for consistency and hover effects */
        .mobile-menu {
            transition: transform 0.3s ease;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        /* Timeline styling to make the milestones stand out */
        .timeline {
            border-left: 3px solid #f87171;
        }
        .value-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.1), 
                        0 4px 6px -2px rgba(239, 68, 68, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50">

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
                        <a href="our-story.php" class="text-gray-900 px-1 pt-1 border-b-2 border-red-500 text-sm font-medium" aria-current="page">Our Story</a>
                        <a href="sustainability.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Sustainability</a>
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

        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-64 bg-white shadow-lg transform translate-x-full hidden" aria-hidden="true" role="menu" aria-label="Mobile menu">
            <div class="flex justify-end p-4">
                <button id="close-menu" aria-label="Close mobile menu" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="../index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100" role="menuitem">Home</a>
                <a href="about-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100" role="menuitem">About Us</a>
                <a href="our-story.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100" aria-current="page" role="menuitem">Our Story</a>
                <a href="sustainability.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100" role="menuitem">Sustainability</a>
                <a href="careers.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100" role="menuitem">Careers</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <p class="text-base text-red-400 font-semibold tracking-wide uppercase">Our Journey</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                The Vision That Shapes Every Stitch.
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                From a simple sketch to a global design concept, discover the <strong>heritage and dedication</strong> that defines <?php echo $company_name; ?>.
            </p>
        </div>
    </header>

    <main>
        <section class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-start">
                    <div class="mt-10 lg:mt-0" aria-label="Design collaboration illustration">
                        <img class="w-full h-auto rounded-lg shadow-xl" src="../Data/kj.png" alt="Designers or athletes collaborating to emphasize the brand's story" loading="lazy" />
                    </div>
                    <div class="lg:order-1">
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">The Genesis of Design</h2>
                        <p class="text-lg text-gray-500">
                            In <strong><?php echo $founding_year; ?></strong>, the concept of <?php echo $company_name; ?> was born not from a factory, but from a frustration: why choose between performance and aesthetic? Our founders envisioned an apparel line where the two were inseparable, a vision now reflected in every aspect of this digital showcase.
                        </p>
                        <p class="mt-4 text-lg text-gray-500">
                            This site documents the <strong>architectural thinking</strong> behind a brand that respects both the <strong>athlete’s body</strong> and the <strong>digital canvas</strong>. We detail the processes, the commitment to materials (conceptual here, but critical in real life), and the relentless pursuit of a perfect user journey.
                        </p>
                        <blockquote class="mt-8 text-xl italic text-gray-600 border-l-4 border-red-500 pl-4">
                            "A brand's story is in its details, from the fiber of the fabric to the final pixel on the screen."
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">Our Milestones (The Design Timeline)</h2>
                <div class="timeline space-y-12 pl-6" role="list">
                    <div class="relative" role="listitem">
                        <div class="absolute w-4 h-4 bg-red-500 rounded-full mt-1.5 -left-2 border-2 border-white" aria-hidden="true"></div>
                        <p class="text-sm text-gray-500 uppercase font-semibold">Q1 <?php echo $founding_year; ?></p>
                        <h3 class="text-xl font-semibold text-gray-900 mt-1">Concept Inception &amp; Mood Board</h3>
                        <p class="mt-2 text-gray-600">Initial design direction established. Defined the core aesthetic: functional minimalism meeting bold athleticism. This included selecting the primary color palette and typography.</p>
                    </div>

                    <div class="relative" role="listitem">
                        <div class="absolute w-4 h-4 bg-red-500 rounded-full mt-1.5 -left-2 border-2 border-white" aria-hidden="true"></div>
                        <p class="text-sm text-gray-500 uppercase font-semibold">Q2 <?php echo $founding_year; ?></p>
                        <h3 class="text-xl font-semibold text-gray-900 mt-1">UX/UI Blueprinting</h3>
                        <p class="mt-2 text-gray-600">Wireframes and prototypes created for the entire e-commerce journey, focusing on mobile-first design and accessibility standards. Key site sections defined.</p>
                    </div>

                    <div class="relative" role="listitem">
                        <div class="absolute w-4 h-4 bg-red-500 rounded-full mt-1.5 -left-2 border-2 border-white" aria-hidden="true"></div>
                        <p class="text-sm text-gray-500 uppercase font-semibold">Q3 <?php echo $founding_year; ?></p>
                        <h3 class="text-xl font-semibold text-gray-900 mt-1">Development &amp; Code Freeze</h3>
                        <p class="mt-2 text-gray-600">Transitioned design specs into production-ready HTML, CSS (Tailwind), and PHP templates (like this one). Finalized all component libraries for consistency.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-red-600">
            <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-white">Join Our Design Roster.</h2>
                <p class="mt-4 text-xl text-red-100">Are you ready to build the next chapter of digital excellence?</p>
                <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="careers.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                        Explore Design Careers
                    </a>
                    <a href="sustainability.php" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                        Read About Our Impact
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?> Design Showcase. All rights reserved.</p>
    </footer>

    <script>
        // Mobile menu toggle functionality with ARIA updates
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuButton = document.getElementById('close-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => mobileMenu.classList.add('open'), 10);
            mobileMenu.setAttribute('aria-hidden', 'false');
            mobileMenuButton.setAttribute('aria-expanded', 'true');
        });

        closeMenuButton.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            mobileMenu.setAttribute('aria-hidden', 'true');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            setTimeout(() => mobileMenu.classList.add('hidden'), 300);
        });

        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>
