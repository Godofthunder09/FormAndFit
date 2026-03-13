<?php
session_start();
require_once "database/db_connection.php";

$user_id = $_SESSION['user_id'] ?? null;
$message = '';

// --- AJAX WISHLIST HANDLER ---
// The AJAX logic for the wishlist remains unchanged.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist_product_id_ajax'])) {
    header('Content-Type: application/json');

    if (!$user_id) {
        // Redirect to login, then back to this detail page
        // ------------------------------------------------------------------
        // CHANGED FOLDER NAME FROM /threadvibe/ TO /formandfit/
        $current_url = '/formandfit/tshirts_detail.php?id=' . $_POST['wishlist_product_id_ajax'];
        echo json_encode(['status' => 'redirect', 'url' => '/formandfit/login.php?redirect=' . urlencode($current_url)]);
        // ------------------------------------------------------------------
        exit;
    }

    $product_id = mysqli_real_escape_string($con, $_POST['wishlist_product_id_ajax']);
    $product_type = 'tshirts';
    $action = '';

    $check_query = "SELECT id FROM wishlist WHERE user_id = ? AND product_type = ? AND product_id = ?";
    $stmt_check = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt_check, "iss", $user_id, $product_type, $product_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Item exists, remove it
        $remove_query = "DELETE FROM wishlist WHERE user_id = ? AND product_type = ? AND product_id = ?";
        $stmt_remove = mysqli_prepare($con, $remove_query);
        mysqli_stmt_bind_param($stmt_remove, "iss", $user_id, $product_type, $product_id);
        mysqli_stmt_execute($stmt_remove);
        $action = 'removed';
        mysqli_stmt_close($stmt_remove);
    } else {
        // Item does not exist, add it
        $insert_query = "INSERT INTO wishlist (user_id, product_type, product_id) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "iss", $user_id, $product_type, $product_id);
        mysqli_stmt_execute($stmt_insert);
        $action = 'added';
        mysqli_stmt_close($stmt_insert);
    }

    echo json_encode(['status' => 'success', 'action' => $action]);
    exit;
}
// --- END AJAX WISHLIST HANDLER ---

// Get the T-shirt ID from URL
if (!isset($_GET['id'])) {
    die("No product specified.");
}
$tshirt_id = $_GET['id'];

// Prepare and execute query
$query = "SELECT id, name, price, description, image_url_1, image_url_2, image_url_3, image_url_4, alt_text, buy_link FROM tshirts WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $tshirt_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Before exiting, close the statement and connection
    $stmt->close();
    if ($con) mysqli_close($con);
    die("Product not found.");
}

$tshirt = $result->fetch_assoc();
$stmt->close();

// Fetch user's current wishlist status (logic kept for completeness but button removed)
$is_wishlisted = false;
if ($user_id) {
    $wishlist_query = "SELECT id FROM wishlist WHERE user_id = ? AND product_type = 'tshirts' AND product_id = ?";
    $stmt_wishlist = mysqli_prepare($con, $wishlist_query);
    mysqli_stmt_bind_param($stmt_wishlist, "is", $user_id, $tshirt_id);
    mysqli_stmt_execute($stmt_wishlist);
    $result_wishlist = mysqli_stmt_get_result($stmt_wishlist);
    if (mysqli_num_rows($result_wishlist) > 0) {
        $is_wishlisted = true;
    }
    mysqli_stmt_close($stmt_wishlist);
}

// Collect all image URLs into an array for the gallery
// NOTE: Prepending 'admin/' to the paths to fix image display.
$image_urls = array_filter([
    $tshirt['image_url_1'] ? 'admin/' . $tshirt['image_url_1'] : null,
    $tshirt['image_url_2'] ? 'admin/' . $tshirt['image_url_2'] : null,
    $tshirt['image_url_3'] ? 'admin/' . $tshirt['image_url_3'] : null,
    $tshirt['image_url_4'] ? 'admin/' . $tshirt['image_url_4'] : null
]);

// Close the database connection (Keep this here if no footer is included, otherwise remove it)
if ($con) {
    mysqli_close($con);
}
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

        /* Notification style */
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
        // Use the Buy button for data, since it's the primary product data carrier.
        // If it doesn't exist (e.g., link not available), use the Share button.
        const dataElement = document.querySelector('.track-buy-now') || document.getElementById('share-button');

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

        // Use fetch with keepalive to ensure the request is sent even if the user navigates quickly
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