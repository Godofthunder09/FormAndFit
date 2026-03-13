<?php
session_start();
// NOTE: Make sure 'database/db_connection.php' correctly establishes a $con variable.
// This file is assumed to exist for database operations.
require_once 'database/db_connection.php';

// --- SUCCESS MESSAGE LOGIC (Removed Account related check) ---
$registration_success = false;

// --- NEW ARRIVALS LOGIC (MODIFIED) ---
// Fetch the 4 latest products (T-shirts or Hoodies) based on their ID.
// This assumes higher ID means newer, and IDs are unique across both tables, 
// which is required for a simple 'latest 4' logic across two tables without a unified timestamp.

$new_arrivals = [];

// 1. Fetch latest T-shirts and Hoodies with a 'type' and 'detail_page' identifier
$tshirts_query = "SELECT id, name, price, image_url_1, alt_text, 'tshirt_details.php' as detail_page, 'tshirts' as type FROM tshirts";
$hoodies_query = "SELECT id, name, price, image_url_1, alt_text, 'hoodies_details.php' as detail_page, 'hoodies' as type FROM hoodies";

// 2. Union the results and order by ID descending to get the newest, then limit to 4
$latest_products_query = "
    ({$tshirts_query})
    UNION ALL
    ({$hoodies_query})
    ORDER BY id DESC
    LIMIT 4
";

$latest_products_result = mysqli_query($con, $latest_products_query);

if ($latest_products_result) {
    while ($row = mysqli_fetch_assoc($latest_products_result)) {
        $row['alt'] = $row['alt_text'];
        unset($row['alt_text']);
        $new_arrivals[] = $row;
    }
}

// --- USER LOGIC FOR ACCOUNT MODAL (REMOVED) ---

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
    <title>FormAndFit - Trendy Apparel & Accessories</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Product Card Hover Effect for Actions */
        .product-card .product-actions {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease-out;
        }
        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .mobile-menu {
            transition: all 0.3s ease;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        html {
            scroll-behavior: smooth;
        }
        /* Ensure the Vanta element covers the section */
        #vanta-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0; /* Behind content */
        }
        /* MODIFIED: Custom CSS for tighter product card layout on mobile */
        @media (max-width: 640px) { /* Tailored for mobile/small screens */
            .product-card .p-4 {
                /* Reduce padding for tighter fit and remove blank space */
                padding: 0.5rem; /* Equivalent to p-2 */
            }
            .product-card .product-actions {
                 margin-top: 0.5rem; /* Equivalent to mt-2 */
            }
            .product-card .mt-1 {
                margin-top: 0.25rem; /* Equivalent to mt-1, but can be adjusted */
            }
            .product-card .text-sm, .product-card .text-xs {
                font-size: 0.875rem; /* text-sm default, but ensures consistency */
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if ($registration_success): ?>
    <div id="success-alert" class="fixed top-0 inset-x-0 z-50 p-4">
        <div class="max-w-7xl mx-auto bg-green-500 text-white p-3 rounded-lg shadow-xl flex items-center justify-between">
            <div class="flex items-center">
                <i data-feather="check-circle" class="w-6 h-6 mr-3"></i>
                <span class="font-medium">Success! Your account has been created.</span>
            </div>
            <button onclick="document.getElementById('success-alert').remove()" class="text-white hover:text-green-200">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-gray-900">FormAndFit</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#" class="border-red-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                        <div class="dropdown relative">
                            <button class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">
                                Shop
                                <i data-feather="chevron-down" class="ml-1 w-4 h-4"></i>
                            </button>
                            <div class="dropdown-menu absolute hidden bg-white shadow-lg rounded-md mt-1 py-1 w-48">
                                <a href="tshirts.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">T-Shirts</a>
                                <a href="hoodies.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hoodies</a>
                                <a href="accessories.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Accessories</a>
                            </div>
                        </div>
                        <a href="#new-arrivals" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">New Arrivals</a>
                        <a href="#bestsellers" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Bestsellers</a>
                        <a href="#styled-looks" class="text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Styled Looks</a>
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
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>
                <a href="tshirts.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">T-Shirts</a>
                <a href="hoodies.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Hoodies</a>
                <a href="accessories.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Accessories</a>
                <a href="#new-arrivals" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">New Arrivals</a>
                <a href="#bestsellers" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Bestsellers</a>
                <a href="#styled-looks" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Styled Looks</a>
                <div class="pt-4 border-t border-gray-200">
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Cart (3)</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-gray-900 overflow-hidden">
        <div id="vanta-bg"></div> 
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-gray-900/90 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
                    <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block">Elevate Your</span>
                                <span class="block text-red-400">Everyday Style</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Premium quality t-shirts, hoodies, and accessories designed for comfort and style.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="#new-arrivals" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10">
                                        Shop New Arrivals
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="#bestsellers" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                        View Bestsellers
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 lg:p-0">
            <img class="w-full object-cover h-96 sm:h-128 lg:w-full lg:h-full relative z-10 rounded-xl lg:rounded-none" 
                 src="Data/fr.png" alt="Model wearing our product" loading="eager">
        </div>
        </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center">Shop by Category</h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto text-center">
                Discover our curated collections
            </p>
            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div id="tshirts" class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75">
                        <img src="Data/accessories2.png" alt="T-Shirts collection" class="w-full h-full object-center object-cover" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="tshirts.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                T-Shirts
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Classic & graphic tees for every occasion</p>
                        <div class="mt-4">
                            <a href="tshirts.php" class="text-sm font-medium text-red-600 hover:text-red-500">Shop now <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
                <div id="hoodies" class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75">
                        <img src="Data/accessories3.png" alt="Hoodies collection" class="w-full h-full object-center object-cover" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="hoodies.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Hoodies & Sweatshirts
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Comfort meets style for cooler days</p>
                        <div class="mt-4">
                            <a href="hoodies.php" class="text-sm font-medium text-red-600 hover:text-red-500">Shop now <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
                <div id="accessories" class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                    <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75">
                        <img src="Data/accessories.png" alt="Accessories collection" class="w-full h-full object-center object-cover" loading="lazy">
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="accessories.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Accessories
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Complete your look with our stylish extras</p>
                        <div class="mt-4">
                            <a href="accessories.php" class="text-sm font-medium text-red-600 hover:text-red-500">Shop now <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="bestsellers" class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                <h2 class="text-3xl font-extrabold text-gray-900">Bestsellers</h2>
             
            </div>


            <div class="mt-8 grid grid-cols-2 gap-y-4 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                
                <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                        <img src="admin/image_uploads/tshirts_1-T_1.png" alt="Minimalist White Tee" class="w-full h-full object-center object-cover group-hover:opacity-75" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-gray-700">
                            <a href="best1.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Pink Skull Blade : Pink Venom T-Shirt
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">$16.00</p>
                        <div class="product-actions mt-3 flex justify-center">
                            <a href="best1.php" class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">View</a>
                        </div>
                    </div>
                </div>

                <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                        <img src="Data/ha.jpeg" alt="" class="w-full h-full object-center object-cover group-hover:opacity-75" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-gray-700">
                            <a href="best2.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                The Engine of Worlds(Abstract Machine Flow) T-Shirt
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">$16.00</p>
                        <div class="product-actions mt-3 flex justify-center">
                            <a href="best2.php" class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">View</a>
                        </div>
                    </div>
                </div>

                <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                        <img src="admin/image_uploads/hoodies_1-H_1.png" alt="Graphic Print Tee - Sunset" class="w-full h-full object-center object-cover group-hover:opacity-75" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-gray-700">
                            <a href="best3.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Lost In Thought - Serpent/Vine Graphic Tee
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">$32.00</p>
                        <div class="product-actions mt-3 flex justify-center">
                            <a href="best3.php" class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">View</a>
                        </div>
                    </div>
                </div>
                
                <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                        <img src="admin/image_uploads/tshirts_6-T_1_1764653715.png" alt="Corduroy Dad Cap" class="w-full h-full object-center object-cover group-hover:opacity-75" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-gray-700">
                            <a href="best4.php">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                Stronger Than You Think - Neon Boxing Motivation Tee
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">$16.00</p>
                        <div class="product-actions mt-3 flex justify-center">
                            <a href="best4.php" class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">View</a>
                        </div>
                    </div>
                </div>

            </div>
            </div>
    </div>

    <div id="new-arrivals" class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">New Arrivals</h2>
                </div>

            <div class="mt-8 grid grid-cols-2 gap-y-4 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <?php foreach ($new_arrivals as $item): ?>
                <div class="group relative product-card bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <span class="absolute top-0 right-0 m-2 px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full z-10">NEW</span>
                    <div class="w-full bg-gray-200 aspect-square rounded-t-lg overflow-hidden lg:h-80 lg:aspect-none">
                        <img src="admin/<?php echo htmlspecialchars($item['image_url_1']); ?>" alt="<?php echo htmlspecialchars($item['alt']); ?>" class="w-full h-full object-center object-cover group-hover:opacity-75" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm text-gray-700">
                            <a href="<?php echo htmlspecialchars($item['detail_page']); ?>?id=<?php echo htmlspecialchars($item['id']); ?>">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">$<?php echo number_format($item['price'], 2); ?></p>
                        <div class="product-actions mt-3 flex justify-center">
                            <a href="<?php echo htmlspecialchars($item['detail_page']); ?>?id=<?php echo htmlspecialchars($item['id']); ?>" class="w-full text-xs font-medium text-gray-900 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition flex items-center justify-center">View</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($new_arrivals)): ?>
                    <div class="col-span-full text-center py-10">
                        <p class="text-xl text-gray-600">No new arrivals found in T-Shirts or Hoodies collection.</p>
                        <p class="text-gray-500">Please check the database connection and the 'tshirts'/'hoodies' tables.</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>
    </div>

    <div id="styled-looks" class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-center">Styled Looks</h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-300 mx-auto text-center">
                Get inspired by how our community styles ThreadVibe pieces
            </p>
            
            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                <div class="group relative overflow-hidden rounded-lg shadow-xl">
                    <img src="http://static.photos/people/600x600/50" alt="Street style look featuring a ThreadVibe hoodie" class="w-full h-full object-cover aspect-square" loading="lazy">
                    <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-10 transition duration-300 flex items-end">
                        <div class="p-4 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="text-xl font-bold text-white">The Urban Comfort</h3>
                            <p class="text-sm text-gray-300">Features: Heavyweight Hoodie, Classic Cap</p>
                            <a href="#" class="mt-2 inline-flex items-center text-sm font-medium text-red-400 hover:text-red-300">Shop Look <span aria-hidden="true" class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-lg shadow-xl">
                    <img src="http://static.photos/people/600x600/51" alt="Minimalist look featuring a ThreadVibe t-shirt" class="w-full h-full object-cover aspect-square" loading="lazy">
                    <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-10 transition duration-300 flex items-end">
                        <div class="p-4 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="text-xl font-bold text-white">The Essential Layer</h3>
                            <p class="text-sm text-gray-300">Features: Classic Fit Tee, Woven Key Chain</p>
                            <a href="#" class="mt-2 inline-flex items-center text-sm font-medium text-red-400 hover:text-red-300">Shop Look <span aria-hidden="true" class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-lg shadow-xl">
                    <img src="http://static.photos/people/600x600/52" alt="Casual outdoor look featuring a ThreadVibe sweatshirt" class="w-full h-full object-cover aspect-square" loading="lazy">
                    <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-10 transition duration-300 flex items-end">
                        <div class="p-4 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="text-xl font-bold text-white">Weekend Explorer</h3>
                            <p class="text-sm text-gray-300">Features: Oversized Sweatshirt, Utility Pouch</p>
                            <a href="#" class="mt-2 inline-flex items-center text-sm font-medium text-red-400 hover:text-red-300">Shop Look <span aria-hidden="true" class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-10 text-center">
                <a href="#styled-looks" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                    Shop The Looks
                </a>
            </div>
        </div>
    </div>

<div class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center">What Our Customers Say</h2>
            <div class="mt-10 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/1" alt="Customer photo">
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                            </div>
                            <div class="text-sm font-medium text-gray-900 mt-1">Sarah J.</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            "The hoodies are so comfortable and the quality is amazing. I've already ordered three different colors!"
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/2" alt="Customer photo">
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4"></i> </div>
                            <div class="text-sm font-medium text-gray-900 mt-1">Michael T.</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            "Fast shipping and great customer service. The t-shirts are my new wardrobe staples."
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="http://static.photos/people/200x200/3" alt="Customer photo">
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                                <i data-feather="star" class="text-yellow-400 w-4 h-4 fill-current"></i>
                            </div>
                            <div class="text-sm font-medium text-gray-900 mt-1">Emma L.</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            "Love the minimalist designs! The quality is worth every penny. Will definitely shop here again."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                      <h3 class="text-sm font-semibold tracking-wider text-red-400 uppercase">Shop</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="tshirts.php" class="text-base text-gray-300 hover:text-white">T-Shirts</a></li>
                        <li><a href="hoodies.php" class="text-base text-gray-300 hover:text-white">Hoodies</a></li>
                        <li><a href="accessories.php" class="text-base text-gray-300 hover:text-white">Accessories</a></li>
                        <li><a href="#new-arrivals" class="text-base text-gray-300 hover:text-white">New Arrivals</a></li>
                        <li><a href="#bestsellers" class="text-base text-gray-300 hover:text-white">Bestsellers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold tracking-wider text-red-400 uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="./about/about-us.php" class="text-base text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="./about/our-story.php" class="text-base text-gray-300 hover:text-white">Our Story</a></li>
                        <li><a href="./about/sustainability.php" class="text-base text-gray-300 hover:text-white">Sustainability</a></li>
                        <li><a href="./about/careers.php" class="text-base text-gray-300 hover:text-white">Careers</a></li>
                    </ul>
                </div>
                <div>
                      <h3 class="text-sm font-semibold tracking-wider text-red-400 uppercase">Customer Services</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="./about/contact-us.php" class="text-base text-gray-300 hover:text-white">Contact Us</a></li>
                        <li><a href="./about/faqs.php" class="text-base text-gray-300 hover:text-white">FAQs</a></li>
                        <li><a href="./about/size-guide.php" class="text-base text-gray-300 hover:text-white">Size Guide</a></li>
                    </ul>
                </div>
                <div>
                      <h3 class="text-sm font-semibold tracking-wider text-red-400 uppercase">Legal</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="./about/privacy-policy.php" class="text-base text-gray-300 hover:text-white">Privacy Policy</a></li>
                        <li><a href="./about/terms-of-service.php" class="text-base text-gray-300 hover:text-white">Terms of Services</a></li>
                        <li><a href="./about/cookie-policy.php" class="text-base text-gray-300 hover:text-white">Cookie Policy</a></li>
                    </ul>
                    <div class="mt-8">
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Follow Us</h3>
                        <div class="flex space-x-6 mt-4">
                            <a href="https://www.instagram.com/form_and_fit_?igsh=c3Y0ZXRwaWh0N2Jy" class="text-gray-400 hover:text-white">
                                <i data-feather="instagram" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i data-feather="facebook" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i data-feather="twitter" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i data-feather="youtube" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-base text-gray-400">&copy; 2025 FormAndFit. All rights reserved.</p>
                
            </div>
        </div>
    </footer>

    <script>
        // Check PHP flag to determine user status in JS (Removed: const USER_SIGNED_IN = ...)

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.add('open');
                menu.classList.remove('translate-x-full');
            }, 10);
        });

        document.getElementById('close-menu').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.remove('open');
            menu.classList.add('translate-x-full');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        });

        // Modal Logic (Removed: openModal and closeModal functions)
        // Removed: document.getElementById('account-modal-overlay').addEventListener('click', ...)
        // WISHLIST OVERLAY LISTENER REMOVED (No functionality left)


        // Initialize Feather Icons
        feather.replace();

        // Initialize Vanta.js waves effect
        VANTA.WAVES({
            el: "#vanta-bg", // Target ID is now present in HTML
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x121212,
            shininess: 35.00,
            waveHeight: 15.00,
            waveSpeed: 0.50,
            zoom: 0.75
        });
    </script>
</body>
</html>