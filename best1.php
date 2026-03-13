<?php
// Dummy data setup (Replaces session_start, db_connection, and all database queries)
// You can directly paste your four image links into the $image_urls array below.

// Dummy T-shirt ID (used for links/tracking only)
$tshirt_id = "1-T";

// Dummy Product Data
$tshirt = [
    'id' => $tshirt_id,
    'name' => 'Pink Skull Blade : Pink Venom T-Shirt',
    'price' => '16',
    'description' => 'An intense, anime-inspired design featuring a fierce, pink-haired samurai assassin clad in futuristic, black tactical gear. She stands ready for battle, wielding a glowing, neon-pink katana. Behind her, two menacing, cracked skulls with glowing eyes are set against a backdrop of aggressive pink ink splatters and grunge textures, creating a striking contrast of dark intensity and vibrant neon. This design is perfect for fans of cyberpunk, Japanese street style, manga, and dark anime.',
    'alt_text' => "Pink Venom",
    'buy_link' => 'https://www.teepublic.com/t-shirt/82686712-pink-skull-blade-pink-venom?store_id=4178111', // Dummy buy link
    // Removed unused 'image_url_X' entries from $tshirt array for clarity
];

// 🔴 CRITICAL FIX: Replaced relative 'admin/...' paths with working external placeholders.
// You MUST replace these placeholder links with your actual image URLs.
$DUMMY_IMAGE_LINKS = [
    // === PASTE YOUR ACTUAL IMAGE LINKS HERE ===
    'admin/image_uploads/tshirts_1-T_1.png', // <-- Replace this with your first link
    'admin/image_uploads/tshirts_1-T_2.png', // <-- Replace this with your second link
    'admin/image_uploads/tshirts_1-T_3.png', // <-- Replace this with your third link
    'admin/image_uploads/tshirts_1-T_4.png'  // <-- Replace this with your fourth link
    // ===================================
];

// Collect all dummy image URLs into an array for the gallery
$image_urls = array_filter($DUMMY_IMAGE_LINKS);

// Default values for other variables to prevent errors
$user_id = null;
$message = '';
$is_wishlisted = false;
// Note: AJAX handler is fully removed as it relies on live session/database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tshirt['name']); ?> - FormAndFit</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        
        /* Thumbnail gallery styles */
        .thumbnail-selected {
            border: 2px solid #dc2626; /* Tailwind red-600 */
            opacity: 1;
        }

        /* Notification style (Hidden for dummy code, but styles kept) */
        #notification-box {
            position: fixed; top: 1rem; right: 1rem; z-index: 100; padding: 0.75rem 1.5rem; border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            opacity: 0; transform: translateY(-20px); transition: opacity 0.3s ease-out, transform 0.3s ease-out;
            pointer-events: none;
        }
        #notification-box.show { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-gray-50">

    <div id="notification-box" class="bg-red-500 text-white hidden"></div>

    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="tshirts.php" class="flex items-center text-gray-600 hover:text-red-600 transition">
                <i data-feather="chevron-left" class="w-5 h-5 mr-1"></i>
                Back to T-Shirts
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div>
                <img id="main-product-image" 
                    src="<?php echo htmlspecialchars($image_urls[0] ?? ''); ?>" 
                    alt="<?php echo htmlspecialchars($tshirt['alt_text'] ?? 'Product image'); ?>" 
                    class="w-full h-auto object-cover rounded-xl shadow-lg transition-opacity duration-300">
                
                <div class="mt-4 flex space-x-3 overflow-x-auto p-1">
                    <?php foreach ($image_urls as $index => $url): ?>
                        <?php if (!empty($url)): ?>
                        <button 
                            onclick="changeImage('<?php echo htmlspecialchars($url); ?>', this)"
                            class="thumbnail-btn w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden border-2 border-transparent hover:border-red-400 focus:outline-none focus:border-red-600 transition <?php echo ($index === 0) ? 'thumbnail-selected' : 'opacity-75'; ?>"
                            data-image-url="<?php echo htmlspecialchars($url); ?>"
                            aria-label="View product image <?php echo $index + 1; ?>">
                            <img src="<?php echo htmlspecialchars($url); ?>" 
                                alt="Thumbnail <?php echo $index + 1; ?>" 
                                class="w-full h-full object-cover">
                        </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight"><?php echo htmlspecialchars($tshirt['name']); ?></h1>
                
                <p class="mt-3 text-3xl text-red-600 font-bold">
                    $<?php echo number_format((float)$tshirt['price'], 2); ?>
                </p>
                
                <div class="mt-6 p-4 bg-gray-100 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Product Details</h2>
                    
                    <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($tshirt['description'])); ?></p>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Specs & Quality</h3>
                    
                    <p class="text-gray-700 whitespace-pre-line"><?php echo nl2br(htmlspecialchars($tshirt['alt_text'] ?? 'No detailed specs available.')); ?></p>
                </div>
                <hr class="my-8">

                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    
                    <?php if (!empty($tshirt['buy_link'])): ?>
                        <a href="<?php echo htmlspecialchars($tshirt['buy_link']); ?>" target="_blank"
                            class="track-buy-now flex-1 text-center px-8 py-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150 ease-in-out uppercase tracking-wider"
                            data-product-id="<?php echo htmlspecialchars($tshirt['id']); ?>"
                            data-product-name="<?php echo htmlspecialchars($tshirt['name']); ?>"
                            data-product-category="T-Shirts" 
                            data-buy-link="<?php echo htmlspecialchars($tshirt['buy_link']); ?>">
                            🛒 Buy Now
                        </a>
                    <?php else: ?>
                        <button disabled
                            class="flex-1 px-8 py-4 bg-gray-400 text-white font-semibold rounded-lg shadow-md uppercase tracking-wider cursor-not-allowed">
                            Link Not Available
                        </button>
                    <?php endif; ?>
                    
                    <button id="share-button" onclick="openShareModal()"
                        class="flex-1 px-8 py-4 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-150 ease-in-out uppercase tracking-wider"
                        data-product-id="<?php echo htmlspecialchars($tshirt['id']); ?>"
                        data-product-name="<?php echo htmlspecialchars($tshirt['name']); ?>"
                        data-product-category="T-Shirts" >
                        <i data-feather="share-2" class="w-4 h-4 inline mr-1"></i>
                        Share Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="share-modal-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-40" onclick="closeShareModal()"></div>

    <div id="share-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-lg shadow-2xl max-w-sm w-full p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Share This Product</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-700">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>

            <p class="text-sm text-gray-600 mb-4">Copy the affiliate link below or share directly:</p>

            <div class="flex mb-6">
                <input id="product-share-link" type="text" readonly
                    value="<?php echo htmlspecialchars($tshirt['buy_link'] ?? ''); ?>" 
                    class="flex-1 p-2 border border-gray-300 rounded-l-md text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                <button onclick="copyShareLink()" class="px-4 py-2 bg-red-600 text-white rounded-r-md hover:bg-red-700 text-sm font-semibold">
                    Copy
                </button>
            </div>

            <div class="flex space-x-4 justify-center">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($tshirt['buy_link'] ?? ''); ?>&text=Check out this awesome <?php echo urlencode($tshirt['name']); ?> from FormAndFit!" target="_blank" class="text-blue-400 hover:text-blue-500" aria-label="Share on Twitter">
                    <i data-feather="twitter" class="w-7 h-7"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($tshirt['buy_link'] ?? ''); ?>" target="_blank" class="text-blue-600 hover:text-blue-700" aria-label="Share on Facebook">
                    <i data-feather="facebook" class="w-7 h-7"></i>
                </a>
                <a href="mailto:?subject=Cool T-Shirt from FormAndFit!&body=I found this awesome t-shirt, the <?php echo htmlspecialchars($tshirt['name']); ?>. Check it out here: <?php echo urlencode($tshirt['buy_link'] ?? ''); ?>" target="_blank" class="text-gray-700 hover:text-gray-900" aria-label="Share via Email">
                    <i data-feather="mail" class="w-7 h-7"></i>
                </a>
            </div>
        </div>
    </div>

<script>
    // Initialize Feather Icons
    feather.replace();

    // --- TRACKING LOGIC (Buy and Share) ---
    
    // Helper function to send the tracking data
    function sendTrackingRequest(clickType) {
        
        const dataElement = document.querySelector('.track-buy-now') || document.getElementById('share-button');

        if (!dataElement) {
            console.error('Could not find product data element for tracking.');
            return;
        }

        const productId = dataElement.getAttribute('data-product-id');
        const productName = dataElement.getAttribute('data-product-name');
        const productCategory = dataElement.getAttribute('data-product-category');
        
        console.log(`[Tracking] Attempting to send data: ID=${productId}, Name=${productName}, Type=${clickType}`);

        // 🟢 FIX: Uncommented the actual fetch request
        const postData = new URLSearchParams();
        postData.append('id', productId);
        postData.append('name', productName);
        postData.append('category', productCategory);
        postData.append('click_type', clickType); 

        fetch('track_click.php', { 
            method: 'POST',
            body: postData,
            keepalive: true
        })
        .then(response => {
            console.log(`Tracking (${clickType}) response status:`, response.status); 
        })
        .catch(error => {
            console.error(`Tracking (${clickType}) failed:`, error); 
        });
    }

    // --- IMAGE GALLERY LOGIC (Unchanged) ---
    function changeImage(newImageUrl, selectedButton) {
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.thumbnail-btn');

        thumbnails.forEach(btn => {
            btn.classList.remove('thumbnail-selected');
            btn.classList.add('opacity-75');
        });

        selectedButton.classList.add('thumbnail-selected');
        selectedButton.classList.remove('opacity-75');

        mainImage.src = newImageUrl;
    }

    // --- SHARE MODAL LOGIC (Updated with Tracking) ---
    function openShareModal() {
        // 1. Send tracking request for 'share' click
        sendTrackingRequest('share');
        
        // 2. Open the modal
        document.getElementById('share-modal-overlay').classList.remove('hidden');
        document.getElementById('share-modal').classList.remove('hidden');
        // Re-initialize Feather Icons inside the modal if needed
        feather.replace(); 
    }

    function closeShareModal() {
        document.getElementById('share-modal-overlay').classList.add('hidden');
        document.getElementById('share-modal').classList.add('hidden');
    }

    function copyShareLink() {
        const copyText = document.getElementById("product-share-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(copyText.value).then(() => {
                const copyButton = document.querySelector('#share-modal button.bg-red-600');
                const originalText = copyButton.textContent;
                
                copyButton.textContent = 'Copied!';
                copyButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                copyButton.classList.add('bg-green-600', 'hover:bg-green-700');

                setTimeout(() => {
                    copyButton.textContent = originalText;
                    copyButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                    copyButton.classList.add('bg-red-600', 'hover:bg-red-700');
                }, 1500);
            }).catch(err => {
                console.error('Could not copy text: ', err);
                alert("Could not copy link. Please manually copy the URL: " + copyText.value);
            });
        } else {
            document.execCommand('copy');
            alert("Link copied (fallback).");
        }
    }
    // --- END SHARE MODAL LOGIC ---

    // --- BUY NOW TRACKING INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        const buyButton = document.querySelector('.track-buy-now');

        if (buyButton) {
            buyButton.addEventListener('click', function(e) {
                // 1. Prevent default navigation 
                e.preventDefault(); 
                
                const buyLink = this.getAttribute('data-buy-link');

                // 2. Send tracking request for 'buy' click
                sendTrackingRequest('buy');
                
                // 3. Redirect the user to the external link after the tracking attempt
                setTimeout(() => {
                    window.open(buyLink, '_blank');
                }, 50); // Small delay to let tracking fetch fire first
            });
        }
    });
</script>
</body>
</html>