<?php
// PHP variables for dynamic content
$page_title = "Contact Us - FormAndFit Design Showcase";
$company_name = "FormAndFit";
// >>> YOUR EMAIL (Provided by you) <<<
$contact_email = "yash.p.patil821509@gmail.com"; 
$response_time = "1-2 business days";
$form_status = ""; // Variable to hold success/error messages

// --- 1. FORM SUBMISSION LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer (basic validation)
    if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
        $form_status = "<div class='text-red-600 text-center font-semibold'>Oops! Please complete all form fields and ensure the email is valid.</div>";
    } else {
        // Build the email content
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers
        $email_headers = "From: $name <$email>\r\n";
        // BCC for reliable delivery (optional, often better to skip unless you know your server setup)
        // $email_headers .= "BCC: another_email@yourdomain.com\r\n"; 

        // Send the email. The 'subject' in the mail() function is the subject line you see.
        $success = mail($contact_email, "New Contact Message: $subject", $email_content, $email_headers);

        if ($success) {
            $form_status = "<div class='text-green-600 text-center font-semibold'>Thank You! Your message has been sent successfully. We'll reply within $response_time.</div>";
            // Clear the form fields after successful submission (optional)
            unset($name, $email, $subject, $message); 
        } else {
            $form_status = "<div class='text-red-600 text-center font-semibold'>Error: The server failed to send your message. Please email us directly at $contact_email.</div>";
        }
    }
}
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
                        <a href="contact-us.php" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-red-500 text-sm font-medium">Contact Us</a> 
                        <a href="faqs.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">FAQ'S</a>
                        <a href="size-guide.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Size Guide</a>
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
                <a href="contact-us.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">Contact Us</a>
                <a href="faqs.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">FAQ'S</a>
                <a href="size-guide.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Size Guide</a>
            </div>
        </div>
    </nav>

    <header class="bg-gray-900 py-20 sm:py-24 lg:py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl tracking-tight font-extrabold text-white mb-4">
                Let's Connect.
            </h1>
            <p class="mt-3 text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto">
                Whether you have a design inquiry, a collaboration proposal, or a general question, we're here to help.
            </p>
        </div>
    </header>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                
                <div class="lg:col-span-1 space-y-8">
                    <div class="p-6 bg-red-600 rounded-lg shadow-xl text-white">
                        <h3 class="text-2xl font-bold mb-4 flex items-center">
                            <i data-feather="mail" class="w-6 h-6 mr-3"></i>
                            Get In Touch
                        </h3>
                        <p class="mb-4">
                            For all project and design inquiries, please use our direct email. We aim to respond within 
                            **<?php echo $response_time; ?>**.
                        </p>
                        <p class="text-lg font-semibold break-words">
                            <a href="mailto:<?php echo $contact_email; ?>" class="hover:underline">
                                <?php echo $contact_email; ?>
                            </a>
                        </p>
                    </div>

                    <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i data-feather="share-2" class="w-5 h-5 mr-3 text-red-500"></i>
                            Follow Our Journey
                        </h3>
                        <p class="text-gray-600 mb-4">
                            See more of our design work and conceptual ideas on social platforms.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" target="_blank" class="text-gray-600 hover:text-red-600 transition duration-150">
                                <i data-feather="linkedin" class="w-6 h-6"></i>
                            </a>
                            <a href="#" target="_blank" class="text-gray-600 hover:text-red-600 transition duration-150">
                                <i data-feather="instagram" class="w-6 h-6"></i>
                            </a>
                            <a href="#" target="_blank" class="text-gray-600 hover:text-red-600 transition duration-150">
                                <i data-feather="twitter" class="w-6 h-6"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0 lg:col-span-2 p-8 bg-white rounded-lg shadow-xl border border-gray-200">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    <?php echo $form_status; ?>

                    <form action="contact-us.php" method="POST" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject / Inquiry Type</label>
                            <input type="text" name="subject" id="subject" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="message" name="message" rows="4" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                                Send Message
                            </button>
                            <p class="mt-2 text-xs text-gray-500 text-center">
                                *Note: The form is now configured to send mail via PHP, but requires a functional mail server setup.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-red-600">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white">Need More Information?</h2>
            <p class="mt-4 text-xl text-red-100">Find answers to common questions and check sizing details.</p>
            <div class="mt-8 flex justify-center space-x-4">
                <a href="faqs.php" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-100 shadow-lg">
                    Check Our FAQ's
                </a>
                <a href="size-guide.php" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-red-700">
                    View Size Guide
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