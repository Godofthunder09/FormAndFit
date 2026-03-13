<?php
// PHP variables for dynamic content
$page_title = "Terms of Service - FormAndFit";
$company_name = "FormAndFit";
$effective_date = "July 1, 2025"; 
$website_url = "www.formandfit.com"; // Placeholder URL
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
                        <a href="privacy-policy.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Privacy Policy</a>
                        <a href="terms-of-service.php" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium">Terms of Service</a>
                        <a href="cookie-policy.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Cookie Policy</a>
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
                <a href="privacy-policy.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Privacy Policy</a>
                <a href="terms-of-service.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">Terms of Service</a>
                <a href="cookie-policy.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Cookie Policy</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                Terms of Service
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                Effective Date: **<?php echo $effective_date; ?>**
            </p>
        </div>
    </header>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-gray-700">
            <p class="font-semibold text-lg text-gray-900">
                Welcome to <?php echo $company_name; ?>. These Terms of Service ("Terms") govern your use of the website located at <?php echo $website_url; ?>. By accessing or using the site, you agree to be bound by these Terms.
            </p>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">1. Purpose of the Website</h2>
                <p>This website serves as a **design showcase and demonstration platform**. It is intended to display the potential look, feel, and functionality of an e-commerce store. **No actual products are sold, or financial transactions processed directly on this site.** Any links to products will redirect you to external partner websites.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>**No Direct Sales:** We are not responsible for transactions conducted on external sites.</li>
                    <li>**Accuracy of Content:** While we strive for accuracy, the content (including pricing, product descriptions, and availability) is for demonstration purposes only.</li>
                </ul>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">2. Intellectual Property</h2>
                <p>All content on this site, including text, graphics, logos, images, and the design itself, is the property of <?php echo $company_name; ?> or its licensors and is protected by copyright and intellectual property laws.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>You may **view and use the site for personal, non-commercial purposes**.</li>
                    <li>You may **not** reproduce, duplicate, copy, sell, or exploit any portion of the service or content without express written permission.</li>
                </ul>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">3. Links to Other Websites</h2>
                <p>Our Service contains links to third-party websites or services (e.g., product purchase pages) that are not owned or controlled by <?php echo $company_name; ?>.</p>
                <p>We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party websites or services. You acknowledge and agree that we shall not be responsible or liable, directly or indirectly, for any damage or loss caused by or in connection with the use of any such content, goods, or services available on or through any such websites or services.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">4. Limitation of Liability</h2>
                <p>In no event shall <?php echo $company_name; ?>, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Your access to or use of, or inability to access or use, the Service.</li>
                    <li>Any conduct or content of any third party on the Service (especially any external purchase link).</li>
                </ul>
                <p>Since this site is a showcase, your use is at your sole risk and is provided "AS IS" and "AS AVAILABLE."</p>
            </div>
        </div>
    </section>

    <section class="bg-red-600 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Explore Our Full Legal Documentation</h2>
            <p class="text-lg sm:text-xl text-red-100 mb-8">
                Learn more about how we handle your data and the technical tracking of this website.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="privacy-policy.php" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-red-50 transition duration-150 ease-in-out shadow-lg">
                    Review Privacy Policy
                </a>
                <a href="cookie-policy.php" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-red-600 transition duration-150 ease-in-out shadow-lg">
                    View Cookie Policy
                </a>
            </div>
        </div>
    </section>
    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. All rights reserved.</p>
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