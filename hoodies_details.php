<?php
// hoodies_detail.php
// This page fetches and displays details for a single product from the 'hoodies' table.

// Include DB connection
// FIX: Using the correct path for db_connection.php
require_once "database/db_connection.php"; 

// Get the Hoodie ID from URL
if (!isset($_GET['id'])) {
    // It's safer to redirect than to die
    header("Location: hoodies.php");
    exit();
}
$hoodie_id = $_GET['id'];

// Prepare and execute query for the 'hoodies' table
$query = "SELECT id, name, price, description, image_url_1, image_url_2, image_url_3, image_url_4, alt_text, buy_link FROM hoodies WHERE id = ?";
$stmt = $con->prepare($query);

// Use string binding ("s")
$stmt->bind_param("s", $hoodie_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Close resources before exiting
    $stmt->close();
    // Do not close the main connection here, as a common footer might try to use it
    if ($con) mysqli_close($con); 
    die("Hoodie product not found.");
}

$hoodie = $result->fetch_assoc();
$stmt->close();

// Collect all image URLs into an array for the gallery
// ⚠️ IMAGE PATH FIX: Prepend the path to correctly display images.
// Assuming images are stored in a folder relative to this script.
$image_base_path = 'admin/'; // <--- Keep this if your admin folder holds the image uploads!

$image_urls = array_filter([
    ($hoodie['image_url_1'] ?? null) ? $image_base_path . $hoodie['image_url_1'] : null, 
    ($hoodie['image_url_2'] ?? null) ? $image_base_path . $hoodie['image_url_2'] : null, 
    ($hoodie['image_url_3'] ?? null) ? $image_base_path . $hoodie['image_url_3'] : null,
    ($hoodie['image_url_4'] ?? null) ? $image_base_path . $hoodie['image_url_4'] : null 
]);

// Note: The database connection closing logic is removed here to prevent the "mysqli object is already closed" error if a common footer is included and attempts to use the connection.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hoodie['name']); ?> - FormAndFit Hoodies</title>
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
            <a href="hoodies.php" class="flex items-center text-gray-600 hover:text-red-600 transition">
                <i data-feather="chevron-left" class="w-5 h-5 mr-1"></i>
                Back to Hoodies
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div>
                <img id="main-product-image" 
                    src="<?php echo htmlspecialchars($image_urls[0] ?? ''); ?>" 
                    alt="<?php echo htmlspecialchars($hoodie['alt_text'] ?? 'Product image'); ?>" 
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
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight"><?php echo htmlspecialchars($hoodie['name']); ?></h1>
                
                <p class="mt-3 text-3xl text-red-600 font-bold">
                    $<?php echo number_format((float)$hoodie['price'], 2); ?>
                </p>
                
                <div class="mt-6 p-4 bg-gray-100 rounded-lg shadow-inner">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Product Details</h2>
                    <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($hoodie['description'])); ?></p>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Specs & Quality</h3>
                    <p class="text-gray-700 whitespace-pre-line"><?php echo nl2br(htmlspecialchars($hoodie['alt_text'] ?? 'No detailed specs available.')); ?></p>
                </div>
                <hr class="my-8">

                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    
                    <?php if (!empty($hoodie['buy_link'])): ?>
                        <a href="<?php echo htmlspecialchars($hoodie['buy_link']); ?>" target="_blank"
                            class="track-buy-now flex-1 text-center px-8 py-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150 ease-in-out uppercase tracking-wider"
                            data-product-id="<?php echo htmlspecialchars($hoodie['id']); ?>"
                            data-product-name="<?php echo htmlspecialchars($hoodie['name']); ?>"
                            data-product-category="Hoodies"  
                            data-buy-link="<?php echo htmlspecialchars($hoodie['buy_link']); ?>" >
                            🛒 Buy Now
                        </a>
                    <?php else: ?>
                        <button disabled
                            class="flex-1 px-8 py-4 bg-gray-400 text-white font-semibold rounded-lg shadow-md uppercase tracking-wider cursor-not-allowed">
                            Link Not Available
                        </button>
                    <?php endif; ?>
                    
                    <button id="share-button"
                        class="flex-1 px-8 py-4 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-150 ease-in-out uppercase tracking-wider"
                        data-product-id="<?php echo htmlspecialchars($hoodie['id']); ?>"
                        data-product-name="<?php echo htmlspecialchars($hoodie['name']); ?>"
                        data-product-category="Hoodies"  
                        onclick="openShareModal()">
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
                    value="<?php echo htmlspecialchars($hoodie['buy_link'] ?? ''); ?>" 
                    class="flex-1 p-2 border border-gray-300 rounded-l-md text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                <button onclick="copyShareLink()" class="px-4 py-2 bg-red-600 text-white rounded-r-md hover:bg-red-700 text-sm font-semibold">
                    Copy
                </button>
            </div>

            <div class="flex space-x-4 justify-center">
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($hoodie['buy_link'] ?? ''); ?>&text=Check out this awesome <?php echo urlencode($hoodie['name']); ?> from FormAndFit!" target="_blank" class="text-blue-400 hover:text-blue-500" aria-label="Share on Twitter">
                    <i data-feather="twitter" class="w-7 h-7"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($hoodie['buy_link'] ?? ''); ?>" target="_blank" class="text-blue-600 hover:text-blue-700" aria-label="Share on Facebook">
                    <i data-feather="facebook" class="w-7 h-7"></i>
                </a>
                <a href="mailto:?subject=Cool Hoodie from FormAndFit!&body=I found this awesome hoodie, the <?php echo htmlspecialchars($hoodie['name']); ?>. Check it out here: <?php echo urlencode($hoodie['buy_link'] ?? ''); ?>" target="_blank" class="text-gray-700 hover:text-gray-900" aria-label="Share via Email">
                    <i data-feather="mail" class="w-7 h-7"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Initialize Feather Icons
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

            // Image fade effect
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = newImageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }

        // --- SHARE MODAL LOGIC (Mobile Friendly) ---
        function openShareModal() {
            // NEW: Track the 'share' click event before showing the modal
            sendTrackingRequest('share');

            document.getElementById('share-modal-overlay').classList.remove('hidden');
            document.getElementById('share-modal').classList.remove('hidden');
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
                // Fallback for older browsers
                document.execCommand('copy');
                alert("Link copied (fallback).");
            }
        }
        // --- END SHARE MODAL LOGIC ---


        // --- UNIVERSAL TRACKING LOGIC (Buy and Share) ---
        
        // Helper function to send the tracking data
        function sendTrackingRequest(clickType) {
            const dataElement = document.getElementById('share-button') || document.querySelector('.track-buy-now');

            if (!dataElement) {
                console.error('Could not find product data element for tracking.');
                return;
            }

            const productId = dataElement.getAttribute('data-product-id');
            const productName = dataElement.getAttribute('data-product-name');
            const productCategory = dataElement.getAttribute('data-product-category');
            
            const postData = new URLSearchParams();
            postData.append('id', productId);
            postData.append('name', productName);
            postData.append('category', productCategory);
            // CRITICAL: Send the click type for the database
            postData.append('click_type', clickType); 

            fetch('track_click.php', { 
                method: 'POST',
                body: postData,
                keepalive: true // Helps ensure the request completes even if the user navigates away
            })
            .then(response => {
                console.log(`Tracking (${clickType}) response status:`, response.status); 
            })
            .catch(error => {
                console.error(`Tracking (${clickType}) failed:`, error); 
            });
        }


        document.addEventListener('DOMContentLoaded', () => {
            const buyButton = document.querySelector('.track-buy-now');

            if (buyButton) {
                buyButton.addEventListener('click', function(e) {
                    // 1. Prevent default navigation 
                    e.preventDefault(); 
                    
                    const buyLink = this.getAttribute('data-buy-link');
                    
                    // 2. Track the 'buy' click event
                    sendTrackingRequest('buy');
                    
                    // 3. Redirect the user immediately
                    // Using a small delay to allow the tracking request to be sent first (though keepalive helps a lot)
                    setTimeout(() => {
                        window.open(buyLink, '_blank');
                    }, 50); 
                });
            }
        });
        // --- END UNIVERSAL TRACKING LOGIC ---
    </script>

</body>
</html>