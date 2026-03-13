<?php
// PHP variables for dynamic content
$page_title = "About Us - FormAndFit Design Showcase"; // Updated for design focus
$company_name = "FormAndFit";
$founding_year = "2025"; // UPDATED founding year
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }

        /* Custom styles to maintain design consistency */
        .dropdown:hover .dropdown-menu { display: block; }
        .mobile-menu { transition: all 0.3s ease; }
        .mobile-menu.open { transform: translateX(0); }
        html { scroll-behavior: smooth; }
        
        /* Custom styles for the values section to add subtle lift/shadow */
        .value-card { transition: all 0.3s; }
        .value-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.1), 0 4px 6px -2px rgba(239, 68, 68, 0.05); }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-gray-900">FormAndFit</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="../index.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Home</a>
                        <a href="about-us.php" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium">About Us</a>
                        <a href="our-story.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Our Story</a>
                        <a href="sustainability.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Sustainability</a>
                        <a href="careers.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Careers</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-64 bg-white shadow-lg transform translate-x-full hidden">
            <div class="flex justify-end p-4">
                <button id="close-menu" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="../index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
                <a href="about-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">About Us</a>
                <a href="our-story.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Our Story</a>
                <a href="sustainability.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Sustainability</a>
                <a href="careers.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Careers</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                Our Showcase: "Form Meets Digital Fitness.""
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                This is the "design blueprint" for a modern athletic wear brand, demonstrating a cohesive user experience and visual strategy.
            </p>
        </div>
    </header>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div class="lg:order-2">
                    <img class="w-full h-auto rounded-lg shadow-xl" src="../Data/ege.png" alt="A conceptual image demonstrating brand consistency and visual identity.">
                </div>
                <div class="mt-10 lg:mt-0 lg:order-1">
                    <blockquote class="text-2xl font-semibold text-gray-900 border-l-4 border-red-500 pl-4">
                        "We believe that true design strength is found where aesthetics and functionality intersect."
                    </blockquote>
                    <p class="mt-6 text-lg text-gray-500">
                        Since our conceptual founding in "<?php echo $founding_year; ?>"", the "<?php echo $company_name; ?>"" brand has been dedicated to demonstrating high-impact web design. This site serves as a digital portfolio, showcasing our ability to create seamless, mobile-responsive, and visually consistent user interfaces that drive engagement and conversion.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        This design is driven by a single goal: to demonstrate powerful brand identity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Our Design Principles</h2>
            <p class="mt-4 text-xl text-gray-500">What guides every pixel and interaction on this site.</p>
            
            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                
                <div class="p-6 bg-white rounded-lg shadow-md value-card">
                    <i data-feather="zap" class="w-10 h-10 text-red-500 mx-auto"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Performance</h3>
                    <p class="mt-2 text-gray-500">Fast load times, responsive layouts, and efficient code that maximizes user experience across all devices.</p>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md value-card">
                    <i data-feather="code" class="w-10 h-10 text-red-500 mx-auto"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Consistency</h3>
                    <p class="mt-2 text-gray-500">Maintaining a single color palette, font system, and component design throughout the entire site.</p>
                </div>
                
                <div class="p-6 bg-white rounded-lg shadow-md value-card">
                    <i data-feather="user-check" class="w-10 h-10 text-red-500 mx-auto"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">Redirection</h3>
                    <p class="mt-2 text-gray-500">Clear, intentional calls-to-action guiding users efficiently to the next intended page/section.</p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 bg-red-600">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white">Explore the Blueprint.</h2>
            <p class="mt-4 text-xl text-red-100">See the full range of our design capabilities and documentation.</p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="our-story.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg">
                    View Our Story Design
                </a>
                <a href="sustainability.php" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-red-700">
                    See Sustainability Concept
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?> Design Showcase. All rights reserved.</p>
    </footer>

    <script>
        // Mobile menu toggle
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

        // Feather icons
        feather.replace();
    </script>
</body>
</html>