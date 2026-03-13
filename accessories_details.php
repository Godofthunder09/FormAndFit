<?php
// accessories_details.php
// This page fetches and displays details for a single product from the 'accessories' table.

// Include DB connection
require_once "database/db_connection.php";

// Get the Accessory ID from URL
if (!isset($_GET['id'])) {
    die("No product specified.");
}
$accessory_id = $_GET['id'];

// Prepare and execute query for the 'accessories' table
// Fetching all necessary columns, including 'alt_text' and 'buy_link'.
$query = "SELECT id, name, price, description, image_url_1, image_url_2, image_url_3, image_url_4, alt_text, buy_link FROM accessories WHERE id = ?";
$stmt = $con->prepare($query);
// Use string since id is VARCHAR
$stmt->bind_param("s", $accessory_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Close resources before exiting
    $stmt->close();
    if ($con) mysqli_close($con);
    die("Product not found.");
}

$accessory = $result->fetch_assoc();
$stmt->close();

// Collect all image URLs into an array for the gallery
// ⚠️ IMAGE PATH FIX: Prepend the correct base path for images.
$image_base_path = 'admin/'; // <--- ADJUST THIS PATH IF YOUR IMAGES ARE IN A DIFFERENT DIRECTORY!

$image_urls = array_filter([
    ($accessory['image_url_1'] ?? null) ? $image_base_path . $accessory['image_url_1'] : null, 
    ($accessory['image_url_2'] ?? null) ? $image_base_path . $accessory['image_url_2'] : null, 
    ($accessory['image_url_3'] ?? null) ? $image_base_path . $accessory['image_url_3'] : null,
    ($accessory['image_url_4'] ?? null) ? $image_base_path . $accessory['image_url_4'] : null 
]);

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
    <title><?php echo htmlspecialchars($accessory['name']); ?> - FormAndFit Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        
        .thumbnail-selected {
            border: 2px solid #dc2626; /* Tailwind red-600 */
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="accessories.php" class="flex items-center text-gray-600 hover:text-red-600 transition">
                <i data-feather="chevron-left" class="w-5 h-5 mr-1"></i>
                Back to Accessories
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div>
                <img id="main-product-image" 
                    src="<?php echo htmlspecialchars($image_urls[0] ?? ''); ?>" 
                    alt="<?php echo htmlspecialchars($accessory['alt_text'] ?? 'Product image'); ?>" 
                    class="w-full h-auto object-cover rounded-xl shadow-lg transition-opacity duration-300">
                
                <div class="mt-4 flex space-x-3 overflow-x-auto p-1">
                    <?php foreach ($image_urls as $index => $url): ?>
                        <?php if (!empty($url)): ?>
                        <button 
                            onclick="changeImage('<?php echo htmlspecialchars($url); ?>', this)"
                            class="thumbnail-btn w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-red-400 focus:outline-none focus:border-red-600 transition <?php echo ($index === 0) ? 'thumbnail-selected' : 'opacity-75'; ?>"
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
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight"><?php echo htmlspecialchars($accessory['name']); ?></h1>
                
                <p class="mt-3 text-3xl text-red-600 font-bold">
                    $<?php echo number_format((float)$accessory['price'], 2); ?>
                </p>
                
                <div class="mt-6 p-4 bg-gray-100 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Product Details</h2>
                    
                    <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($accessory['description'])); ?></p>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Specs & Quality</h3>
                    
                    <p class="text-gray-700 whitespace-pre-line"><?php echo nl2br(htmlspecialchars($accessory['alt_text'] ?? 'No detailed specs available.')); ?></p>
                </div>
                <hr class="my-8">

                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    
                    <?php if (!empty($accessory['buy_link'])): ?>
                        <a href="<?php echo htmlspecialchars($accessory['buy_link']); ?>" target="_blank"
                            class="track-buy-now flex-1 text-center px-8 py-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150 ease-in-out uppercase tracking-wider"
                            data-product-id="<?php echo htmlspecialchars($accessory['id']); ?>"
                            data-product-name="<?php echo htmlspecialchars($accessory['name']); ?>"
                            data-product-category="Accessories"   data-buy-link="<?php echo htmlspecialchars($accessory['buy_link']); ?>" >
                            🛒 Buy Now
                        </a>
                        <?php else: ?>
                        <button disabled
                            class="flex-1 px-8 py-4 bg-gray-400 text-white font-semibold rounded-lg shadow-md uppercase tracking-wider cursor-not-allowed">
                            Link Not Available
                        </button>
                    <?php endif; ?>
                    
                    <button onclick="openShareModal()"
                        class="track-share-product flex-1 px-8 py-4 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-150 ease-in-out uppercase tracking-wider">
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
                    value="<?php echo htmlspecialchars($accessory['buy_link'] ?? ''); ?>" 
                    class="flex-1 p-2 border border-gray-300 rounded-l-md text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                <button onclick="copyShareLink()" class="px-4 py-2 bg-red-600 text-white rounded-r-md hover:bg-red-700 text-sm font-semibold">
                    Copy
                </button>
            </div>

            <div class="flex space-x-4 justify-center">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($accessory['buy_link'] ?? ''); ?>&text=Check out this awesome <?php echo urlencode($accessory['name']); ?> from FormAndFit!" target="_blank" class="text-blue-400 hover:text-blue-500" aria-label="Share on Twitter">
                    <i data-feather="twitter" class="w-7 h-7"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($accessory['buy_link'] ?? ''); ?>" target="_blank" class="text-blue-600 hover:text-blue-700" aria-label="Share on Facebook">
                    <i data-feather="facebook" class="w-7 h-7"></i>
                </a>
                <a href="mailto:?subject=Cool Accessory from FormAndFit!&body=I found this awesome accessory, the <?php echo htmlspecialchars($accessory['name']); ?>. Check it out here: <?php echo urlencode($accessory['buy_link'] ?? ''); ?>" target="_blank" class="text-gray-700 hover:text-gray-900" aria-label="Share via Email">
                    <i data-feather="mail" class="w-7 h-7"></i>
                </a>
            </div>
        </div>
    </div>
    <script>
        // ADDED: Initialize Feather Icons
        feather.replace();

        // --- IMAGE GALLERY LOGIC ---
        function changeImage(newImageUrl, selectedButton) {
            const mainImage = document.getElementById('main-product-image');
            
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('thumbnail-selected');
                btn.classList.add('opacity-75');
            });

            selectedButton.classList.add('thumbnail-selected');
            selectedButton.classList.remove('opacity-75');

            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = newImageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }
        
        // --- SHARE MODAL LOGIC ---
        function openShareModal() {
            document.getElementById('share-modal-overlay').classList.remove('hidden');
            document.getElementById('share-modal').classList.remove('hidden');
            // TRack the share click when the modal is opened
            document.querySelector('.track-share-product').click();
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

        // --- START TRACKING JAVASCRIPT ---
        document.addEventListener('DOMContentLoaded', () => {
            const buyButton = document.querySelector('.track-buy-now');
            const shareButton = document.querySelector('.track-share-product');
            
            // Reusable function to get tracking data
            const getTrackingData = (clickType) => {
                const element = document.querySelector('.track-buy-now'); // Use buy button for data attributes
                if (!element) return null;

                const postData = new URLSearchParams();
                postData.append('id', element.getAttribute('data-product-id'));
                postData.append('name', element.getAttribute('data-product-name'));
                postData.append('category', element.getAttribute('data-product-category'));
                postData.append('click_type', clickType);
                return postData;
            };

            // 1. Buy Button Tracking
            if (buyButton) {
                buyButton.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    
                    const buyLink = this.getAttribute('data-buy-link');
                    const postData = getTrackingData('buy'); // Get tracking data for 'buy'

                    // Send the tracking request.
                    fetch('track_click.php', { 
                        method: 'POST',
                        body: postData,
                        keepalive: true
                    })
                    .then(response => {
                        console.log('Buy click tracked. Status:', response.status); 
                    })
                    .catch(error => {
                        console.error('Buy tracking failed:', error); 
                    })
                    .finally(() => {
                        // Redirect the user AFTER sending tracking request
                        window.open(buyLink, '_blank');
                    });
                });
            }
            
            // 2. Share Button Tracking
            if (shareButton) {
                // When the share button is clicked (to open the modal)
                shareButton.addEventListener('click', function() {
                    const postData = getTrackingData('share'); // Get tracking data for 'share'

                    if (postData) {
                        fetch('track_click.php', { 
                            method: 'POST',
                            body: postData,
                            keepalive: true // Ensure data is sent even if the user navigates away
                        })
                        .then(response => {
                            console.log('Share click tracked. Status:', response.status); 
                        })
                        .catch(error => {
                            console.error('Share tracking failed:', error); 
                        });
                    }
                });
            }
        });
        // END TRACKING JAVASCRIPT
    </script>

</body>
</html>