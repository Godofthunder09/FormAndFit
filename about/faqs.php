<?php
// PHP variables for dynamic content
$page_title = "FAQs - FormAndFit Design Showcase";
$company_name = "FormAndFit";
$contact_email = "yash.p.patil821509@gmail.com"; 

// UPDATED FAQ data structure focusing purely on Design, Concepts, and Use Rights
$faqs = [
    [
        'question' => 'What is the philosophy behind FormAndFit designs?',
        'answer' => 'Our philosophy is "Form Follows Function." We believe that great design is not just about aesthetics, but about creating intuitive, efficient, and comfortable products. We meticulously balance modern style (Form) with practical usability and physical contour (Fit).'
    ],
    [
        'question' => 'How can I license a FormAndFit design concept?',
        'answer' => 'All design concepts displayed are proprietary intellectual property of FormAndFit. Licensing arrangements for exclusive use can be discussed by submitting an inquiry via our <a href="contact-us.php" class="text-red-600 hover:underline">Contact Us page</a> under the "Licensing Inquiry" subject.'
    ],
    [
        'question' => 'What is your typical design concept timeline?',
        'answer' => 'The timeline depends heavily on the concept\'s complexity. A typical conceptual design project includes four phases: **Discovery & Blueprint** (1-2 weeks), **Conceptual Design & Iteration** (3-4 weeks), **Prototyping & Testing** (4-6 weeks), and **Finalization & Handover** (1-2 weeks). A full cycle usually takes 3 to 4 months.'
    ],
    [
        'question' => 'Do you provide design revisions and what is the process?',
        'answer' => 'Yes, our standard design concept package includes two major revision cycles (Iteration Phase) to ensure the design meets your vision. Minor adjustments are managed through a dedicated review platform during the Prototyping Phase.'
    ],
    [
        'question' => 'What deliverables are included with a finalized design concept?',
        'answer' => 'A finalized design concept package typically includes high-resolution 3D models (STEP/IGES), 2D technical drawings (CAD/PDF), a detailed Bill of Materials (BOM), and a comprehensive Design Rationale document outlining the core principles and intended functionality.'
    ],
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

        /* Custom Accordion Styling */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
        }
        .faq-item.active .faq-answer {
            max-height: 500px; /* Large enough value to reveal content */
            padding-top: 1rem;
        }
        .faq-item.active .faq-toggle i {
            transform: rotate(180deg);
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
                        
                        <a href="faqs.php" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium">FAQ's</a>

                        <a href="size-guide.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Size Guide</a>
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
                <a href="faqs.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">FAQs</a>
                <a href="size-guide.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Size Guide</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                Frequently Asked Questions
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                Quick answers to the most common questions about our design process and service concepts.
            </p>
        </div>
    </header>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">Design Concept & Licensing Inquiries</h2>
            
            <div class="space-y-6" id="faq-container">
                <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item border border-gray-200 rounded-lg shadow-md bg-white">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left focus:outline-none" data-index="<?php echo $index; ?>">
                        <span class="text-lg font-semibold text-gray-900"><?php echo $faq['question']; ?></span>
                        <i data-feather="chevron-down" class="w-6 h-6 text-red-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-answer px-6 pb-6 text-gray-700">
                        <p><?php echo $faq['answer']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            </div>
    </section>

    <section class="py-16 bg-red-600">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white">Any Further Queries?</h2>
            <p class="mt-4 text-xl text-red-100">Contact us or find guidance for your perfect design fit.</p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="contact-us.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg">
                    <i data-feather="mail" class="w-5 h-5 mr-2"></i>
                    Contact Our Team
                </a>
                <a href="size-guide.php" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-red-700">
                    <i data-feather="ruler" class="w-5 h-5 mr-2"></i>
                    View Size Guide
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white p-10 text-center">
        <p>&copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. All rights reserved.</p>
    </footer>

    <script>
        // Mobile menu toggle (Copied from previous versions)
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

        // FAQ Accordion Logic
        document.getElementById('faq-container').addEventListener('click', function(e) {
            const toggleButton = e.target.closest('.faq-toggle');
            if (toggleButton) {
                const faqItem = toggleButton.closest('.faq-item');
                
                // Close all other open FAQs
                document.querySelectorAll('.faq-item.active').forEach(item => {
                    if (item !== faqItem) {
                        item.classList.remove('active');
                    }
                });

                // Toggle the clicked FAQ
                faqItem.classList.toggle('active');
            }
        });

        // Feather icons
        feather.replace();
    </script>
</body>
</html>