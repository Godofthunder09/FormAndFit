
<?php
// PHP variables for dynamic content
$page_title = "Careers & Collaboration - FormAndFit Showcase"; 
$company_name = "FormAndFit";
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
        /* Custom styles to maintain design consistency */
        .mobile-menu {
            transition: transform 0.3s ease;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        /* Uses red theme lift effect from about-us.php */
        .value-card { 
            transition: all 0.3s; 
        }
        .value-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.1), 
                        0 4px 6px -2px rgba(239, 68, 68, 0.05); 
        }
        
        /* Custom Card for Team/Roles */
        .team-card {
            transition: transform 0.3s ease, border 0.3s ease;
            border-bottom: 4px solid transparent;
        }
        .team-card:hover {
            transform: translateY(-3px);
            border-bottom-color: #ef4444; /* red-500 */
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
                        <a href="our-story.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Our Story</a>
                        <a href="sustainability.php" class="text-gray-500 hover:text-gray-700 px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium focus:outline-none focus:border-red-500">Sustainability</a>
                        <a href="careers.php" class="text-gray-900 px-1 pt-1 border-b-2 border-red-500 text-sm font-medium" aria-current="page">Careers</a>
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
                <a href="../index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Home</a>
                <a href="about-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">About Us</a>
                <a href="our-story.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Our Story</a>
                <a href="sustainability.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50" role="menuitem">Sustainability</a>
                <a href="careers.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50" aria-current="page" role="menuitem">Careers</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <p class="text-base text-red-400 font-semibold tracking-wide uppercase">Join the Blueprint</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                The Architects Behind the Design.
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                This space showcases the conceptual roles and collaborative spirit needed to bring a project like **FormAndFit** to life.
            </p>
        </div>
    </header>

    <main>
        <section class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Conceptual Design Roles</h2>
                    <p class="mt-4 max-w-3xl text-xl text-gray-500 lg:mx-auto">
                        These are the key **skillsets** demonstrated by the team that built this showcase, serving as conceptual job titles for our portfolio.
                    </p>
                </div>
                
                <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    
                    <div class="team-card bg-white p-8 rounded-lg shadow-lg hover:shadow-xl text-center">
                        <i data-feather="target" class="w-10 h-10 text-red-500 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900">Lead UX Architect</h3>
                        <p class="mt-3 text-gray-600 text-sm">
                            Responsible for mapping the entire user journey, accessibility compliance (WCAG), and mobile-first wireframing.
                        </p>
                        <a href="#" class="mt-4 inline-block text-sm font-medium text-red-600 hover:text-red-800">
                            (View Case Study)
                        </a>
                    </div>

                    <div class="team-card bg-white p-8 rounded-lg shadow-lg hover:shadow-xl text-center">
                        <i data-feather="code" class="w-10 h-10 text-red-500 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900">Front-End Developer</h3>
                        <p class="mt-3 text-gray-600 text-sm">
                            Specializing in semantic HTML, performance optimization, and dynamic templating using **PHP** and **Tailwind CSS**.
                        </p>
                        <a href="#" class="mt-4 inline-block text-sm font-medium text-red-600 hover:text-red-800">
                            (View Component Library)
                        </a>
                    </div>

                    <div class="team-card bg-white p-8 rounded-lg shadow-lg hover:shadow-xl text-center">
                        <i data-feather="feather" class="w-10 h-10 text-red-500 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900">Visual Brand Designer</h3>
                        <p class="mt-3 text-gray-600 text-sm">
                            Focuses on the core aesthetic, color palette, typography consistency, and overall visual storytelling of the brand.
                        </p>
                        <a href="#" class="mt-4 inline-block text-sm font-medium text-red-600 hover:text-red-800">
                            (View Mood Board)
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-16 bg-gray-50">
            <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Seeking Collaboration?</h2>
                <p class="mt-4 text-xl text-gray-500">
                    If you are interested in partnering with the **designers and developers** who created this showcase, reach out directly.
                </p>
                <div class="mt-8 flex justify-center">
                    <a href="mailto:design.team@example.com" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                        Contact the Team
                    </a>
                </div>
            </div>
        </section>
    </main>

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