<?php
// PHP variables for dynamic content
$page_title = "Size Guide - FormAndFit Design Showcase";
$company_name = "FormAndFit";
$contact_email = "yash.p.patil821509@gmail.com"; 

// Sizing data for the table
$sizes_metric = [
    'S' => ['Chest' => '86-91 cm', 'Waist' => '71-76 cm', 'Inseam' => '78 cm'],
    'M' => ['Chest' => '96-101 cm', 'Waist' => '81-86 cm', 'Inseam' => '79 cm'],
    'L' => ['Chest' => '106-111 cm', 'Waist' => '91-96 cm', 'Inseam' => '80 cm'],
    'XL' => ['Chest' => '116-121 cm', 'Waist' => '101-106 cm', 'Inseam' => '81 cm'],
];

$sizes_imperial = [
    'S' => ['Chest' => '34-36 in', 'Waist' => '28-30 in', 'Inseam' => '31 in'],
    'M' => ['Chest' => '38-40 in', 'Waist' => '32-34 in', 'Inseam' => '31.5 in'],
    'L' => ['Chest' => '42-44 in', 'Waist' => '36-38 in', 'Inseam' => '32 in'],
    'XL' => ['Chest' => '46-48 in', 'Waist' => '40-42 in', 'Inseam' => '32.5 in'],
];
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
        .mobile-menu { transition: all 0.3s ease; }
        .mobile-menu.open { transform: translateX(0); }
        html { scroll-behavior: smooth; }

        /* Custom Responsive Table Styling for Mobile */
        @media screen and (max-width: 640px) {
            .responsive-table th, .responsive-table td {
                display: block;
                width: 100%;
                text-align: left;
                padding: 0.75rem 1rem;
            }
            .responsive-table thead { display: none; } /* Hide header on mobile */
            .responsive-table tr { 
                margin-bottom: 1rem; 
                border: 1px solid #e5e7eb;
                display: block;
                border-radius: 0.5rem;
            }
            /* Add bold label before cell data on mobile */
            .responsive-table td:before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 0.5rem;
                display: inline-block;
                width: 60px; /* Aligns labels */
            }
        }
        /* Toggle Styling */
        .unit-toggle {
            transition: background-color 0.2s;
        }
        .unit-toggle.active {
            background-color: #dc2626; /* red-600 */
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-gray-900"><?php echo $company_name; ?></span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="../index.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Home</a>
                        <a href="contact-us.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Contact Us</a>
                        <a href="faqs.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">FAQ's</a>
                        
                        <a href="size-guide.php" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium">Size Guide</a>
                    </div>
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
                <a href="contact-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contact Us</a>
                <a href="faqs.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">FAQs</a>
                <a href="size-guide.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">Size Guide</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                The FormAndFit Size Guide
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                Find your perfect fit. Precise measurements ensure comfort, performance, and style.
            </p>
        </div>
    </header>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="lg:grid lg:grid-cols-2 lg:gap-12 mb-16">
                
                <div class="mb-10 lg:mb-0">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center">
                        <i data-feather="ruler" class="w-7 h-7 mr-3 text-red-600"></i>
                        Measurement Blueprint
                    </h2>
                    <p class="text-gray-700 mb-6">
                        Use a soft tape measure and stand relaxed. For a precise 'Form and Fit,' measure directly against the body as shown below.
                    </p>
                    
                    <div class="p-6 bg-gray-100 rounded-xl shadow-lg border-4 border-dashed border-red-200">
                        <div class="relative w-full h-auto max-w-lg mx-auto">
                            <img src="../Data/ss.jpg" alt="Visual diagram showing where to measure chest, waist, and inseam." class="w-full h-auto rounded-lg shadow-xl" loading="lazy">
                        </div>
                        <div class="mt-6 text-center text-sm text-gray-600">
                            *Diagram for Chest, Waist, and Inseam measurement points.
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center">
                        <i data-feather="maximize" class="w-7 h-7 mr-3 text-red-600"></i>
                        Standard Sizing Chart
                    </h2>
                    
                    <div class="flex justify-start mb-6 rounded-lg bg-gray-200 p-1 max-w-sm">
                        <button id="toggle-cm" class="unit-toggle px-6 py-2 rounded-md text-sm font-medium active" onclick="showUnit('metric')">CM (Metric)</button>
                        <button id="toggle-in" class="unit-toggle px-6 py-2 rounded-md text-sm font-medium" onclick="showUnit('imperial')">IN (Imperial)</button>
                    </div>

                    <div id="metric-table" class="unit-data">
                        <table class="responsive-table min-w-full divide-y divide-gray-200 shadow-xl rounded-lg overflow-hidden">
                            <thead class="bg-red-600 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Chest</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Waist</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inseam</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($sizes_metric as $size => $measurements): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" data-label="Size:"><?php echo $size; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Chest:"><?php echo $measurements['Chest']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Waist:"><?php echo $measurements['Waist']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Inseam:"><?php echo $measurements['Inseam']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="imperial-table" class="unit-data hidden">
                        <table class="responsive-table min-w-full divide-y divide-gray-200 shadow-xl rounded-lg overflow-hidden">
                            <thead class="bg-gray-700 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Size</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Chest</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Waist</th>
                                    <th scope="col" scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inseam</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($sizes_imperial as $size => $measurements): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" data-label="Size:"><?php echo $size; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Chest:"><?php echo $measurements['Chest']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Waist:"><?php echo $measurements['Waist']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-label="Inseam:"><?php echo $measurements['Inseam']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            </div>
    </section>

    <section class="py-16 bg-red-600">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white">Any Further Queries?</h2>
            <p class="mt-4 text-xl text-red-100">Contact us or check our FAQ's for quick answers.</p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="contact-us.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg">
                    <i data-feather="mail" class="w-5 h-5 mr-2"></i>
                    Contact Our Team
                </a>
                <a href="faqs.php" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-red-700">
                    <i data-feather="help-circle" class="w-5 h-5 mr-2"></i>
                    View FAQs
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. All rights reserved.</p>
    </footer>

    <script>
        // --- Custom JavaScript for Unit Toggle ---
        function showUnit(unit) {
            const metricTable = document.getElementById('metric-table');
            const imperialTable = document.getElementById('imperial-table');
            const toggleCm = document.getElementById('toggle-cm');
            const toggleIn = document.getElementById('toggle-in');

            if (unit === 'metric') {
                metricTable.classList.remove('hidden');
                imperialTable.classList.add('hidden');
                toggleCm.classList.add('active');
                toggleIn.classList.remove('active');
            } else if (unit === 'imperial') {
                metricTable.classList.add('hidden');
                imperialTable.classList.remove('hidden');
                toggleCm.classList.remove('active');
                toggleIn.classList.add('active');
            }
        }

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