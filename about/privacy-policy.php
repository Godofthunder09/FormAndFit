<?php
// ---- CONFIGURABLE VARIABLES ----
$page_title    = "Privacy Policy - FormAndFit";
$company_name  = "FormAndFit";
$effective_date = "July 1, 2025";
$contact_email  = "support@formandfit.com";
$website_url    = "www.formandfit.com";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .mobile-menu { transition: transform 0.3s ease; }
        .mobile-menu.open { transform: translateX(0); }
    </style>
</head>
<body class="bg-gray-50">

<!-- NAVIGATION -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-xl font-bold text-gray-900"><?= htmlspecialchars($company_name) ?></span>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="../index.php"        class="nav-link">Home</a>
                    <a href="privacy-policy.php"   class="nav-link-active">Privacy Policy</a>
                    <a href="terms-of-service.php" class="nav-link">Terms of Service</a>
                    <a href="cookie-policy.php"    class="nav-link">Cookie Policy</a>
                </div>
            </div>
            <div class="sm:hidden flex items-center">
                <button id="mobile-menu-button" class="nav-mobile-btn" aria-label="Open menu">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-64 bg-white shadow-lg transform translate-x-full hidden" aria-hidden="true">
        <div class="flex justify-end p-4">
            <button id="close-menu" class="nav-mobile-btn" aria-label="Close menu">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="px-4 pt-2 pb-3 space-y-1">
            <a href="../index.php"        class="nav-link-mobile">Home</a>
            <a href="privacy-policy.php"   class="nav-link-mobile-active">Privacy Policy</a>
            <a href="terms-of-service.php" class="nav-link-mobile">Terms of Service</a>
            <a href="cookie-policy.php"    class="nav-link-mobile">Cookie Policy</a>
        </div>
    </div>
</nav>

<!-- HEADER SECTION -->
<header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">Privacy Policy</h1>
        <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
            Effective Date: <strong><?= htmlspecialchars($effective_date) ?></strong>
        </p>
    </div>
</header>

<!-- MAIN CONTENT -->
<main>
    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-gray-700">

            <p class="font-semibold text-lg text-gray-900">
                This website is a <strong>design showcase</strong>. We do not process direct sales or shipments. This policy outlines how we handle the minimal information collected during your visit.
            </p>

            <!-- 1. INFORMATION WE COLLECT -->
            <section class="space-y-4">
                <h2 class="section-heading">1. Information We Collect</h2>
                <p>We collect only data relevant to the operation and communication of this site:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>Contact Information:</strong> Name and email address, only if voluntarily submitted via a contact form. Used exclusively to respond to your inquiry.</li>
                    <li><strong>Usage Data (Non-Personal):</strong> Anonymous data: IP address, browser type, pages visited—collected for analytics and technical troubleshooting.</li>
                </ul>
            </section>

            <!-- 2. USE OF DATA -->
            <section class="space-y-4">
                <h2 class="section-heading">2. How We Use Your Data</h2>
                <p>Your minimal data is strictly used for:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Direct responses to form inquiries.</li>
                    <li>Website functionality improvement.</li>
                    <li><strong>No data is used for marketing or advertising.</strong></li>
                </ul>
            </section>

            <!-- 3. INTELLECTUAL PROPERTY (IP) -->
            <section class="space-y-4">
                <h2 class="section-heading">3. Design & Intellectual Property (IP)</h2>
                <p>This website's design, layout, content, and code are the <strong>licensed intellectual property</strong> of <?= htmlspecialchars($company_name) ?>.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>No IP Tracking:</strong> Personal data and usage patterns are NOT tracked, monitored, or used to license, sell, or distribute design templates.</li>
                    <li><strong>Design License:</strong> Viewing this site at <?= htmlspecialchars($website_url) ?> grants no license or right to use, copy, reproduce, or distribute design elements beyond viewing purposes.</li>
                </ul>
            </section>

            <!-- 4. DATA SHARING AND REDIRECTION -->
            <section class="space-y-4">
                <h2 class="section-heading">4. Data Sharing & Product Redirection</h2>
                <p><strong>No sale of personal data.</strong> Only anonymous usage data may be shared with analytics providers (e.g., Google Analytics) for traffic analysis.</p>
                <p class="mt-4 font-medium text-gray-900">
                    <strong>Note on Products:</strong> Clicks on product links redirect to external partner sites. Data collected on those sites (payment, shipping) is governed by the partner’s privacy policy.
                </p>
            </section>

        </div>
    </section>

    <section class="bg-red-600 py-16 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Understanding Your Rights and Rules</h2>
            <p class="text-lg sm:text-xl text-red-100 mb-8">
                For detailed rules governing use and tracking, refer to our legal documents:
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="terms-of-service.php" class="legal-link terms">Terms of Service</a>
                <a href="cookie-policy.php" class="legal-link cookie">Cookie Policy</a>
            </div>
        </div>
    </section>
</main>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white p-10 text-center">
    <p>&copy; <?= date("Y") ?> <?= htmlspecialchars($company_name) ?>. All rights reserved.</p>
</footer>

<!-- SCRIPTS -->
<script>
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
    feather.replace();
</script>

<!-- TAILWIND/STYLE HELPERS -->
<style>
    .nav-link { color: #6B7280; font-weight: 500; font-size: 1rem; padding: 0.25rem 1rem; border-bottom: 2px solid transparent; transition: color 0.2s, border-color 0.2s; }
    .nav-link:hover, .nav-link:focus { color: #374151; border-bottom: 2px solid #D1D5DB; }
    .nav-link-active { color: #111827; border-bottom: 2px solid #EF4444; font-weight: 600; }
    .nav-link-mobile { display: block; padding: 0.75rem 1.25rem; color: #374151; background: none; border-radius: 0.375rem; font-weight: 500; }
    .nav-link-mobile:hover, .nav-link-mobile:focus { color: #111827; background: #F9FAFB; }
    .nav-link-mobile-active { color: #EF4444; font-weight: 700; }
    .nav-mobile-btn { background: none; border: none; padding: 0.5rem; cursor: pointer; color: #6B7280; border-radius: 0.375rem; }
    .nav-mobile-btn:hover, .nav-mobile-btn:focus { color: #374151; background: #F3F4F6; }
    .section-heading { font-size: 2rem; font-weight: 700; color: #111827; border-bottom: 1px solid #E5E7EB; padding-bottom: 0.5rem; }
    .legal-link { display: inline-flex; justify-content: center; align-items: center; font-size: 1rem; font-weight: 500; padding: 0.75rem 2rem; border-radius: 0.375rem; transition: background 0.2s, color 0.2s, box-shadow 0.2s; box-shadow: 0 1px 6px rgba(0,0,0,0.08); }
    .legal-link.terms { color: #EF4444; background: #fff; border: none; }
    .legal-link.cookie { color: #fff; background: none; border: 2px solid #fff; }
    .legal-link:hover, .legal-link:focus { background: #F3F4F6; color: #EF4444; }
</style>
</body>
</html>
