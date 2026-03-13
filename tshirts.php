<?php
session_start();
// NOTE: Make sure 'database/db_connection.php' correctly establishes a $con variable.
require_once 'database/db_connection.php';

/* ---------------- FETCH T-SHIRTS ---------------- */

// Changed to sort by ID DESC (newest first) as suggested by Code 2's improvement
$query = "SELECT id, name, price, image_url_1, alt_text FROM tshirts ORDER BY id DESC";
$result = mysqli_query($con, $query);

$tshirts = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Alias 'alt_text' to 'alt' for consistency with the HTML rendering loop
        $row['alt'] = $row['alt_text'];
        unset($row['alt_text']);
        $tshirts[] = $row;
    }
}

// Close the database connection
if ($con) {
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormAndFit - T-Shirts Collection</title>

    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        
        /* Product Card Hover Effect for Actions (From Code 1) */
        .product-card .product-actions {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease-out;
        }
        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }
        .dropdown:hover .dropdown-menu { display: block; }
        html { scroll-behavior: smooth; }

        /* Vanta background styling (From Code 1) */
        #vanta-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* ------------------------------------------------------------------ */
        /* --- CRITICAL FIXES FOR PRODUCT CARD ALIGNMENT (From Code 2) --- */
        /* ------------------------------------------------------------------ */
        
        /* Ensures all product titles have a maximum height, preventing alignment issues */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Enhanced Mobile Layout for Product Cards (From Code 2) */
        @media (max-width: 640px) {
            .product-card > .p-4 {
                padding: 0.5rem; /* Tighter padding for mobile */
            }
            .product-card .text-lg.font-medium {
                margin-top: 0.125rem !important;
                font-size: 1rem;
            }
            .product-card .product-actions {
                 margin-top: 0.5rem !important; 
            }
        }
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
                        <a href="index.php" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Home</a>
                        <div class="dropdown relative">
                            <button class="border-red-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Shop
                                <i data-feather="chevron-down" class="ml-1 w-4 h-4"></i>
                            </button>
                            <div class="dropdown-menu absolute hidden bg-white shadow-lg rounded-md mt-1 py-1 w-48 z-20">
                                <a href="tshirts.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-semibold text-red-600">T-Shirts</a>
                                <a href="hoodies.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hoodies</a> 
                                <a href="accessories.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Accessories</a>
                            </div>
                        </div>
                        <a href="index.php#new-arrivals" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">New Arrivals</a>
                        <a href="index.php#bestsellers" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Bestsellers</a>
                    </div>
                </div>
                
                <div class="-mr-2 flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <i data-feather="menu"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>

        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-64 bg-white shadow-lg z-50 transform translate-x-full">
            <div class="flex justify-end p-4">
                <button id="close-menu" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
                <a href="tshirts.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-gray-900 hover:bg-gray-50">T-Shirts</a>
                <a href="hoodies.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Hoodies</a> 
                <a href="accessories.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Accessories</a>
                <a href="index.php#new-arrivals" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">New Arrivals</a>
                <a href="index.php#bestsellers" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Bestsellers</a>
                <div class="pt-4 border-t border-gray-200">
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Cart (3)</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-gray-900 overflow-hidden" id="hero-section">
        <div id="vanta-bg"></div>
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-gray-900/90 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
                    <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block">The Ultimate</span>
                                <span class="block text-red-400">T-Shirt Collection</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                High-quality fabrics, perfect fits, and unique designs.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="#tshirts-collection" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10">
                                        Shop T-Shirts Now
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="index.php#bestsellers" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                        View Bestsellers
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <div class="h-56 sm:h-72 md:h-96 lg:h-full w-full relative z-10">
                <img class="w-full h-full object-cover rounded-bl-3xl" 
                    src="Data/hoo.png" 
                    alt="Model wearing a FormAndFit t-shirt">
            </div>
        </div>
    </div>

    <div class="bg-white" id="tshirts-collection">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center">T-Shirts Collection</h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto text-center">
                High-quality fabrics, perfect fits, and unique designs.
            </p>
            <div class="mt-8 grid grid-cols-2 gap-y-6 gap-x-4 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php foreach ($tshirts as $tshirt): ?>
                    <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                            <img src="admin/<?php echo htmlspecialchars($tshirt['image_url_1']); ?>" 
                                alt="<?php echo htmlspecialchars($tshirt['alt']); ?>" 
                                class="w-full h-full object-center object-cover group-hover:opacity-75"
                                loading="lazy">
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm text-gray-700 h-14 line-clamp-3"> 
                                <a href="tshirt_details.php?id=<?php echo htmlspecialchars($tshirt['id']); ?>">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    <?php echo htmlspecialchars($tshirt['name']); ?>
                                </a>
                            </h3>
                            <p class="text-lg font-medium text-gray-900">$<?php echo number_format($tshirt['price'], 2); ?></p>
                            <div class="product-actions mt-2"> 
                                <a href="tshirt_details.php?id=<?php echo htmlspecialchars($tshirt['id']); ?>" 
                                    class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($tshirts)): ?>
                    <div class="col-span-full text-center py-10">
                        <p class="text-xl text-gray-600">No T-Shirts found in the collection.</p>
                        <p class="text-gray-500">Please check the database connection and the 'tshirts' table.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // --- Mobile Menu Logic (From Code 1) ---
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMenuButton = document.getElementById('close-menu');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

        function openMobileMenu() {
            mobileMenu.classList.remove('translate-x-full'); // Start animation
            mobileMenu.classList.add('open');
            mobileMenuOverlay.classList.add('open');
            document.body.style.overflow = 'hidden'; 
            feather.replace();
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('open');
            mobileMenu.classList.add('translate-x-full'); // Animate out
            mobileMenuOverlay.classList.remove('open');
            document.body.style.overflow = 'auto'; 
        }

        mobileMenuButton.addEventListener('click', openMobileMenu);
        closeMenuButton.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);

        // Feather icons initialization
        feather.replace();

        // --- Vanta background initialization (From Code 1) ---
        VANTA.WAVES({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x222222,
            shininess: 30.00,
            waveHeight: 15.00,
            zoom: 0.75
        });
    </script>
</body>
</html>