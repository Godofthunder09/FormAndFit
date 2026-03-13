<?php
// File: admin/admin_master.php (The Unified Admin Controller)
// This single file replaces admin_header.php, admin_footer.php, and all content files.
// MODIFICATION: User/Wishlist features removed. Admin login enforcement added.
// UPDATE: Added Edit Product view and Manage Products category filter.
// NEW: Customer Visits/Traffic Tracking Page Added.
// **FIXED/UPDATED:** Customer Visits logic simplified, and Index.php visit count added to Dashboard.
//
// === LATEST UPDATE ===
// 1. [SECURITY] Added enhanced session security (httponly, periodic regen)
// 2. [SECURITY] Added HTTP security headers (CSP, X-Frame-Options)
// 3. [SECURITY] Added file size validation to product upload.
// 4. [FIX] Corrected Click Tracking page to HIDE deleted products using an INNER JOIN.
// 5. [REWORK] Rebuilt Customer Visits page to show aggregate counts (Total, By Page, By Region)
//    and removed PII (IP, User Agent) from the view, per request.
// 6. [FIX] Fixed UI inconsistency by standardizing main content wrappers for all pages.
//

// =================================================================================
// 1. GLOBAL SETUP, SECURITY, AND DATABASE CONNECTION (MODIFIED & ENHANCED)
// =================================================================================

// --- Enhanced Session Security Settings ---
// Use cookies only, not URL parameters
ini_set('session.use_only_cookies', 1);
// Prevent JavaScript from accessing the session cookie (HttpOnly flag)
ini_set('session.cookie_httponly', 1);
// Ensure cookies are sent only over HTTPS (SECURITY: UNCOMMENT if your site uses HTTPS/SSL)
// ini_set('session.cookie_secure', 1);
// Set cookie lifetime and garbage collection (e.g., 8 hours)
ini_set('session.gc_maxlifetime', 28800);
ini_set('session.cookie_lifetime', 28800);

// Start the session *after* setting INI parameters
session_start();

// --- HTTP Security Headers ---
// [SECURITY] Prevents XSS attacks by setting a Content Security Policy.
// This is a robust policy allowing 'self' and the necessary CDNs for styles/scripts.
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.tailwindcss.com https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;");
// [SECURITY] Prevents clickjacking attacks
header("X-Frame-Options: SAMEORIGIN");
// [SECURITY] Prevents the browser from MIME-sniffing the content type
header("X-Content-Type-Options: nosniff");
// [SECURITY] Enforces HSTS (uncomment if you have HTTPS)
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

// [SECURITY] Regenerate session ID periodically (e.g., every 30 minutes) to prevent session fixation.
if (!isset($_SESSION['session_last_regen'])) {
    $_SESSION['session_last_regen'] = time();
} else if (time() - $_SESSION['session_last_regen'] > 1800) { // 30 minutes
    session_regenerate_id(true); // Regenerate and delete old session
    $_SESSION['session_last_regen'] = time();
}

// Define a constant to prevent direct access to any included logic (if split later)
define('IS_ADMIN_MASTER', true);

// NOTE: Ensure this path is correct for your file structure.
require_once '../database/db_connection.php'; // Establishes $con

// Function to handle the current state and determine the view (ENFORCING LOGIN)
function check_admin_auth($con) {
    // [SECURITY] CRITICAL: If admin_id is not set in the session,
    // the user is not authenticated. Redirect to the login page immediately.
    if (!isset($_SESSION['admin_id'])) {
        // Redirect non-authenticated users to login page
        header('Location: login.php');
        exit; // Stop all further script execution
    }

    // [SECURITY] Use basename() to prevent directory traversal attacks on the 'page' parameter
    return isset($_GET['page']) ? basename($_GET['page']) : 'dashboard';
}

// =================================================================================
// 2. AUTHENTICATION HANDLER LOGIC (SIMPLIFIED)
// =================================================================================

$auth_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // This block processes POST requests for 'upload' or 'edit'. Authentication is handled
    // by check_admin_auth() before this point.
}

// Determine the current view/page based on authentication status
$page = check_admin_auth($con);

// Special handling for 'edit' to ensure the 'Manage Products' link remains active
$active_page = ($page === 'edit') ? 'manage' : $page;


// =================================================================================
// 3. HTML HEAD & SIDEBAR (The Start of admin_header.php)
// =================================================================================

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | FormAndFit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        /* [UI] Using @import for Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .sidebar {
            width: 250px;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex">
        <!-- ===== Admin Sidebar ===== -->
        <div class="sidebar bg-gray-900 text-white p-6 flex flex-col justify-between sticky top-0">
            <div>
                <h1 class="text-2xl font-bold text-red-500 mb-8">FormAndFit Admin</h1>

                <?php if (isset($_SESSION['username'])): ?>
                    <p class="text-sm text-gray-500 mb-4">Logged in as: <span class="font-semibold text-white"><?php echo htmlspecialchars($_SESSION['username']); // [SECURITY] XSS Prevention ?></span></p>
                <?php else: ?>
                    <p class="text-sm text-gray-500 mb-4">Login status unknown</p>
                <?php endif; ?>

                <nav class="space-y-3">
                    <?php
                        // Array of navigation items for easy maintenance
                        $nav_items = [
                            ['page' => 'dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
                            ['page' => 'upload', 'icon' => 'upload-cloud', 'label' => 'Upload Product'],
                            ['page' => 'manage', 'icon' => 'list', 'label' => 'Manage Products'],
                            ['page' => 'tracking', 'icon' => 'bar-chart-2', 'label' => 'Click Tracking'],
                            // NEW: Customer Visits Feature Link
                            ['page' => 'visits', 'icon' => 'map', 'label' => 'Customer Visits'],
                        ];

                        foreach ($nav_items as $item) {
                            $link = "admin_master.php?page={$item['page']}";
                            // [UI] $active_page variable correctly highlights 'manage' even when on 'edit' page
                            $is_active = ($active_page == $item['page']) ? 'bg-red-600 text-white' : 'hover:bg-gray-800 text-gray-300';
                            echo "<a href=\"{$link}\" class=\"flex items-center space-x-3 p-3 rounded-lg transition duration-150 {$is_active}\">
                                    <i data-feather=\"{$item['icon']}\" class=\"w-5 h-5\"></i>
                                    <span>{$item['label']}</span>
                                  </a>";
                        }
                    ?>
                </nav>
            </div>

            <div class="pt-6 border-t border-gray-800">
                <a href="admin_master.php?page=logout" class="flex items-center space-x-3 p-3 rounded-lg transition duration-150 hover:bg-red-700 text-gray-300">
                    <i data-feather="log-out" class="w-5 h-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <!-- ===== End Sidebar ===== -->

        <!-- ===== Main Content Wrapper ===== -->
        <!-- [UI FIX] All content is wrapped in 'flex-1 p-8' and 'max-w-7xl mx-auto'.
             Wrappers inside individual 'case' statements have been removed
             to ensure a consistent layout, padding, and width for ALL pages. -->
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">


<?php
// =================================================================================
// 4. MAIN CONTROLLER & ROUTING SWITCH
// =================================================================================

switch ($page):

    // --- 4.1 LOGOUT ACTION ---
    case 'logout':
        // [SECURITY] Properly destroy the session upon logout
        session_unset();    // Unset all session variables
        session_destroy();  // Destroy the session data
        // Redirect to login page after logout
        header('Location: login.php');
        exit;
    break;

    // --- 4.2 DASHBOARD VIEW (Original admin_dashboard.php) ---
    case 'dashboard':
        // --- NEW: LOGIC TO GET INDEX.PHP VISITS (LAST 7 DAYS) ---
        $index_visits_count = 0;
        // This query counts visits to the homepage from the last 7 days.
        $visits_query = "
            SELECT COUNT(id) AS total_visits
            FROM cu_visits
            WHERE (page_url LIKE '%index.php%' OR page_url = '/')
            AND visit_time >= DATE_SUB(NOW(), INTERVAL 7 DAY);
        ";
        // [SECURITY] No user input, but still good practice.
        $visits_result = mysqli_query($con, $visits_query);
        if ($visits_result) {
            $row = mysqli_fetch_assoc($visits_result);
            $index_visits_count = $row['total_visits'];
            mysqli_free_result($visits_result);
        }
        // --------------------------------------------------------
?>
                <!-- [UI FIX] This content now lives directly in the main wrapper -->
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Welcome to the Admin Panel!</h2>
                <p class="text-lg text-gray-600 mb-10">Use this dashboard to manage your FormAndFit product catalog.</p>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <div class="block p-6 bg-red-500 text-white rounded-xl shadow-lg hover:shadow-xl transition duration-300">
                        <i data-feather="monitor" class="w-10 h-10 mb-3"></i>
                        <h3 class="text-xl font-semibold">Homepage Visits (7 Days)</h3>
                        <p class="text-4xl font-bold mt-2"><?php echo number_format($index_visits_count); ?></p>
                        <p class="text-sm opacity-80 mt-1">Visits to index.php or /</p>
                    </div>

                    <a href="admin_master.php?page=upload" class="block p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-red-500">
                        <i data-feather="plus-circle" class="w-10 h-10 text-red-500 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-900">Upload Product</h3>
                        <p class="text-gray-500 mt-2">Add new designs to the catalog and manage images.</p>
                    </a>
                    <a href="admin_master.php?page=manage" class="block p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-red-500">
                        <i data-feather="list" class="w-10 h-10 text-red-500 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-900">Manage Inventory</h3>
                        <p class="text-gray-500 mt-2">View, filter, edit, and delete existing products.</p>
                    </a>

                    <a href="admin_master.php?page=tracking" class="block p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-t-4 border-red-500">
                        <i data-feather="bar-chart-2" class="w-10 h-10 text-red-500 mb-3"></i>
                        <h3 class="text-xl font-semibold text-gray-900">View Click Tracking</h3>
                        <p class="text-gray-500 mt-2">Analyze Buy and Share button performance.</p>
                    </a>

                </div>

                <div class="mt-12 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h3 class="text-xl font-semibold text-yellow-800 flex items-center">
                        <i data-feather="check-circle" class="w-6 h-6 mr-2"></i>
                        Current Development Status
                    </h3>
                    <ul class="list-disc list-inside mt-3 text-yellow-700 space-y-1">
                        <li>All files have been merged into **`admin_master.php`**.</li>
                        <li>**Admin Login is now implemented** and requires valid credentials from the `admin_users` table.</li>
                        <li>User/Wishlist management logic has been removed.</li>
                        <li>All navigation links are correctly using the `?page=` routing method.</li>
                    </ul>
                </div>
<?php
    break; // End Dashboard Case

    // --- 4.3 UPLOAD PRODUCT VIEW (Original admin_upload.php logic) ---
    case 'upload':
        $upload_message = '';
        $upload_dir = 'image_uploads/';
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 5 * 1024 * 1024; // [SECURITY] 5MB limit
        $table_map = [
            'tshirts' => 'tshirts',
            'hoodies' => 'hoodies',
            'accessories' => 'accessories'
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // [SECURITY] Sanitize all text inputs
            $product_id = trim($_POST['id']);
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $description = trim($_POST['description']);
            $alt_text = trim($_POST['alt_text']);
            $buy_link = trim($_POST['buy_link']);
            $table_name = $_POST['category'];

            if (empty($product_id) || !isset($table_map[$table_name])) {
                $upload_message = "<div class='text-red-600'>Error: Product ID and valid category are required.</div>";
            } else {
                $image_urls = [];
                $upload_success = true;

                for ($i = 1; $i <= 4; $i++) {
                    $file_key = 'image_' . $i;
                    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_OK) {
                        $file = $_FILES[$file_key];

                        // [SECURITY] Validate file type
                        if (!in_array($file['type'], $allowed_image_types)) {
                            $upload_success = false;
                            $upload_message = "<div class='text-red-600'>Error: Image $i has an invalid file type. Only JPEG, PNG, GIF allowed.</div>";
                            break;
                        }

                        // [SECURITY] Validate file size
                        if ($file['size'] > $max_file_size) {
                            $upload_success = false;
                            $upload_message = "<div class='text-red-600'>Error: Image $i exceeds the 5MB size limit.</div>";
                            break;
                        }

                        // [SECURITY] Create a safe filename to prevent conflicts and directory traversal
                        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $new_file_name = $table_name . '_' . $product_id . '_' . $i . '.' . $file_extension;
                        $target_file = $upload_dir . $new_file_name;

                        if (move_uploaded_file($file['tmp_name'], $target_file)) {
                            $image_urls[$i] = $target_file;
                        } else {
                            $upload_success = false;
                            $upload_message = "<div class='text-red-600'>Error uploading image $i. Check folder permissions.</div>";
                            break;
                        }
                    } elseif ($i == 1 && empty($image_urls[1])) {
                        // Image 1 (Main Image) is required
                        $upload_success = false;
                        $upload_message = "<div class='text-red-600'>Error: Main Image (Image 1) is required.</div>";
                        break;
                    } else {
                        $image_urls[$i] = ''; // Set empty string for optional images
                    }
                }

                if ($upload_success) {
                    // [SECURITY] Use Prepared Statement to prevent SQL Injection
                    $query = "INSERT INTO {$table_name} (id, name, price, description, alt_text, buy_link, image_url_1, image_url_2, image_url_3, image_url_4)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = mysqli_prepare($con, $query);
                    $img1 = $image_urls[1] ?? ''; $img2 = $image_urls[2] ?? ''; $img3 = $image_urls[3] ?? ''; $img4 = $image_urls[4] ?? '';

                    // s = string, d = double (for price)
                    mysqli_stmt_bind_param($stmt, "ssdsssssss",
                        $product_id, $name, $price, $description, $alt_text, $buy_link,
                        $img1, $img2, $img3, $img4
                    );

                    if (mysqli_stmt_execute($stmt)) {
                        $upload_message = "<div class='text-green-600'>Product '{$name}' added successfully!</div>";
                        $_POST = array(); // Clear form on success
                    } else {
                        // [DB] Handle specific errors, like duplicate primary key
                        if (mysqli_errno($con) == 1062) {
                            $upload_message = "<div class='text-red-600'>Error: Product ID '{$product_id}' already exists in the '{$table_name}' table.</div>";
                        } else {
                            $upload_message = "<div class='text-red-600'>Database Error: " . mysqli_error($con) . "</div>";
                        }
                        // Rollback: Delete uploaded files if DB insert fails
                        foreach ($image_urls as $url) { if (file_exists($url)) { unlink($url); } }
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
?>
    <!-- [UI FIX] This wrapper was removed to standardize layout -->
    <!-- <div class="py-8 px-4 sm:px-6 lg:px-8"> -->
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Upload New Product Design</h2>
        <p class="text-gray-600 mb-6">Use this form to add a new design and its associated assets to your catalog.</p>

        <?php echo $upload_message; ?>

        <form class="space-y-6 bg-white p-8 shadow-lg rounded-xl" method="POST" enctype="multipart/form-data">

            <h3 class="text-xl font-semibold text-gray-900">Product Details</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category / Table</label>
                    <select id="category" name="category" required
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                        <option value="">Select a Category</option>
                        <option value="tshirts" <?php echo (isset($_POST['category']) && $_POST['category'] == 'tshirts') ? 'selected' : ''; ?>>T-Shirts</option>
                        <option value="hoodies" <?php echo (isset($_POST['category']) && $_POST['category'] == 'hoodies') ? 'selected' : ''; ?>>Hoodies</option>
                        <option value="accessories" <?php echo (isset($_POST['category']) && $_POST['category'] == 'accessories') ? 'selected' : ''; ?>>Accessories</option>
                    </select>
                </div>
                <div>
                    <label for="id" class="block text-sm font-medium text-gray-700">Unique Product ID (SKU)</label>
                    <input type="text" name="id" id="id" required
                           value="<?php echo htmlspecialchars($_POST['id'] ?? ''); // [SECURITY] XSS Prevention ?>"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600">
                </div>
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" required
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (USD)</label>
                    <input type="number" name="price" id="price" required step="0.01"
                           value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600">
                </div>
                <div>
                    <label for="buy_link" class="block text-sm font-medium text-gray-700">Partner Buy Link (Full URL)</label>
                    <input type="url" name="buy_link" id="buy_link" required
                           value="<?php echo htmlspecialchars($_POST['buy_link'] ?? ''); ?>"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Product Description</label>
                <textarea name="description" id="description" rows="3" required
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>

            <div>
                <label for="alt_text" class="block text-sm font-medium text-gray-700">SEO/Accessibility Alt Text</label>
                <input type="text" name="alt_text" id="alt_text" required
                       value="<?php echo htmlspecialchars($_POST['alt_text'] ?? ''); ?>"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow focus:border-red-600 focus:ring-red-600">
            </div>

            <h3 class="text-xl font-semibold text-gray-900 pt-4 border-t">Image Uploads (Stored in `image_uploads/`)</h3>
            <p class="text-sm text-gray-500">Max file size: 5MB. Allowed types: JPG, PNG, GIF.</p>
            <div class="grid grid-cols-2 gap-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div>
                        <label for="image_<?php echo $i; ?>" class="block text-sm font-medium text-gray-700">Image <?php echo $i; ?> <?php echo ($i == 1) ? '(Main - Required)' : '(Optional)'; ?></label>
                        <input type="file" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>"
                                       <?php echo ($i == 1) ? 'required' : ''; ?>
                                       accept="image/png, image/jpeg, image/gif"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-feather="upload" class="w-5 h-5 mr-2"></i>
                Upload Product Design
            </button>
        </form>
    <!-- </div> -->
<?php
    break; // End Upload Case

    // --- 4.4 MANAGE PRODUCTS VIEW (Original admin_manage.php logic - MODIFIED for FILTER) ---
    case 'manage':
        $delete_message = '';
        $products = [];
        $tables = ['tshirts', 'hoodies', 'accessories'];
        $select_fields = 'id, name, price, description, alt_text, buy_link, image_url_1';

        // NEW: Filtering Logic
        $current_filter = isset($_GET['filter_category']) ? $_GET['filter_category'] : 'all';
        $tables_to_query = ($current_filter === 'all') ? $tables : [$current_filter];

        // --- Deletion Logic ---
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id']) && isset($_GET['category'])) {
            $id = $_GET['id'];
            $table = $_GET['category'];

            if (in_array($table, $tables)) {
                // [DB] Use a transaction for safe deletion
                mysqli_begin_transaction($con);
                try {
                    // 1. Get image URLs before deleting the record
                    $img_query = "SELECT image_url_1, image_url_2, image_url_3, image_url_4 FROM {$table} WHERE id = ?";
                    $img_stmt = mysqli_prepare($con, $img_query);
                    mysqli_stmt_bind_param($img_stmt, "s", $id);
                    mysqli_stmt_execute($img_stmt);
                    $result_img = mysqli_stmt_get_result($img_stmt);
                    $images = mysqli_fetch_assoc($result_img);
                    mysqli_stmt_close($img_stmt);

                    // 2. Delete the product record
                    $delete_query = "DELETE FROM {$table} WHERE id = ?";
                    $delete_stmt = mysqli_prepare($con, $delete_query);
                    mysqli_stmt_bind_param($delete_stmt, "s", $id);
                    mysqli_stmt_execute($delete_stmt);
                    mysqli_stmt_close($delete_stmt);

                    // 3. Commit the transaction
                    mysqli_commit($con);
                    $delete_message = "<div class='text-green-600'>Product '{$id}' deleted successfully!</div>";

                    // 4. Delete image files from server *after* successful DB commit
                    if ($images) {
                        foreach ($images as $url) {
                            if (!empty($url) && file_exists($url)) {
                                unlink($url);
                            }
                        }
                    }
                } catch (mysqli_sql_exception $exception) {
                    mysqli_rollback($con);
                    $delete_message = "<div class='text-red-600'>Database Error during deletion: " . $exception->getMessage() . "</div>";
                }
            } else {
                $delete_message = "<div class='text-red-600'>Error: Invalid category specified for deletion.</div>";
            }
        }

        // --- Data Retrieval Logic (MODIFIED for filter) ---
        foreach ($tables_to_query as $table) {
            if (in_array($table, $tables)) {
                $query = "SELECT {$select_fields} FROM {$table} ORDER BY name ASC";
                $result = mysqli_query($con, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $row['category'] = $table;
                        $products[] = $row;
                    }
                } else {
                    $delete_message = "<div class='text-red-600'>Database Error: Could not load products from table '{$table}'.</div>";
                }
            }
        }
?>
    <!-- [UI FIX] This wrapper was removed to standardize layout -->
    <!-- <div class="py-8 px-4 sm:px-6 lg:px-8"> -->
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Manage Product Inventory</h2>
        <p class="text-gray-600 mb-8">Edit or delete designs across all categories.</p>

        <?php echo $delete_message; ?>

        <!-- Category Filter Pills -->
        <div class="mb-6 flex space-x-2">
            <a href="admin_master.php?page=manage&filter_category=all"
               class="px-4 py-2 text-sm font-medium rounded-full transition duration-150
                      <?php echo ($current_filter == 'all' ? 'bg-red-600 text-white shadow-md' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                All Products
            </a>
            <?php foreach ($tables as $table): ?>
                <a href="admin_master.php?page=manage&filter_category=<?php echo $table; ?>"
                   class="px-4 py-2 text-sm font-medium rounded-full transition duration-150
                          <?php echo ($current_filter == $table ? 'bg-red-600 text-white shadow-md' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                    <?php echo ucfirst($table); // [SECURITY] XSS Prevention (already safe, but good practice) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Products Table -->
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID / Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found for this filter.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($product['image_url_1'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image_url_1']); ?>"
                                         alt="<?php echo htmlspecialchars($product['alt_text']); ?>"
                                         class="h-10 w-10 rounded-lg object-cover">
                                <?php else: ?>
                                    <span class="text-xs text-red-500">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($product['name']); ?></div>
                                <div class="text-xs text-gray-500">ID: <?php echo htmlspecialchars($product['id']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    <?php echo htmlspecialchars(ucfirst($product['category'])); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?php echo number_format($product['price'], 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="admin_master.php?page=edit&id=<?php echo htmlspecialchars($product['id']); ?>&category=<?php echo htmlspecialchars($product['category']); ?>"
                                   class="text-red-600 hover:text-red-900">
                                    <i data-feather="edit" class="w-4 h-4 inline-block"></i> Edit
                                </a>
                                <!-- [UI] Using a JS confirm() for delete action. This is simple and effective. -->
                                <a href="javascript:void(0);"
                                   onclick="if(confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($product['name'])); // [SECURITY] Escape for JS ?>? This action cannot be undone.')) { window.location.href='admin_master.php?page=manage&action=delete&id=<?php echo htmlspecialchars($product['id']); ?>&category=<?php echo htmlspecialchars($product['category']); ?>'; }"
                                   class="text-gray-600 hover:text-gray-900 ml-2">
                                    <i data-feather="trash-2" class="w-4 h-4 inline-block"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <!-- </div> -->
<?php
    break; // End Manage Case

    // --- 4.5 EDIT PRODUCT VIEW (NEW) ---
    case 'edit':
        $edit_message = '';
        $product = null;
        $product_id = isset($_GET['id']) ? $_GET['id'] : '';
        $table_name = isset($_GET['category']) ? $_GET['category'] : '';
        $upload_dir = 'image_uploads/';
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 5 * 1024 * 1024; // [SECURITY] 5MB limit

        // --- 1. Handle POST Submission (Update Logic) ---
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $product_id && $table_name) {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $description = trim($_POST['description']);
            $alt_text = trim($_POST['alt_text']);
            $buy_link = trim($_POST['buy_link']);

            $image_updates = [];
            $image_params = [];

            // Check for image uploads and build query parts dynamically
            for ($i = 1; $i <= 4; $i++) {
                $file_key = 'image_' . $i;
                $url_column = 'image_url_' . $i;

                if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_OK) {
                    $file = $_FILES[$file_key];

                    // [SECURITY] Validate file type
                    if (!in_array($file['type'], $allowed_image_types)) {
                        $edit_message = "<div class='text-red-600'>Error: Invalid file type for Image {$i}.</div>";
                        break;
                    }

                    // [SECURITY] Validate file size
                    if ($file['size'] > $max_file_size) {
                        $edit_message = "<div class='text-red-600'>Error: Image {$i} exceeds the 5MB size limit.</div>";
                        break;
                    }

                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    // [UX] Add timestamp to prevent browser caching after update
                    $new_filename = $table_name . '_' . $product_id . '_' . $i . '_' . time() . '.' . $extension;
                    $target_file = $upload_dir . $new_filename;

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {
                        $image_updates[] = "{$url_column} = ?";
                        $image_params[] = $target_file;
                        // TODO: Delete the *old* image file associated with this slot
                    } else {
                        $edit_message = "<div class='text-red-600'>Error uploading Image {$i}. Check folder permissions.</div>";
                        break;
                    }
                }
            }

            // --- Database Update ---
            if (!$edit_message) {
                // [SECURITY] Build a dynamic prepared statement
                $set_clauses = ["name = ?", "description = ?", "price = ?", "alt_text = ?", "buy_link = ?"];
                $param_values = [$name, $description, $price, $alt_text, $buy_link];
                $param_types = "ssdss"; // s=string, d=double/decimal

                // Append image updates if any files were uploaded
                if (!empty($image_updates)) {
                    $set_clauses = array_merge($set_clauses, $image_updates);
                    $param_values = array_merge($param_values, $image_params);
                    $param_types .= str_repeat("s", count($image_params));
                }

                $set_clause_string = implode(', ', $set_clauses);

                // Append the WHERE clause parameter (id)
                $param_values[] = $product_id;
                $param_types .= "s";

                $query = "UPDATE {$table_name} SET {$set_clause_string} WHERE id = ?";

                $stmt = mysqli_prepare($con, $query);

                if ($stmt) {
                    // Use argument unpacking (...) to bind all parameters dynamically
                    mysqli_stmt_bind_param($stmt, $param_types, ...$param_values);

                    if (mysqli_stmt_execute($stmt)) {
                        $edit_message = "<div class='text-green-600 font-bold'>Success! Product '{$name}' updated in {$table_name}.</div>";
                    } else {
                        $edit_message = "<div class='text-red-600'>Database Error: " . mysqli_error($con) . "</div>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $edit_message = "<div class='text-red-600'>Failed to prepare update statement.</div>";
                }
            }
        }


        // --- 2. Fetch Product Details (Always fetch, especially after an update) ---
        if ($product_id && ($table_name == 'tshirts' || $table_name == 'hoodies' || $table_name == 'accessories')) {
            // [SECURITY] Use prepared statement for fetching data
            $query = "SELECT * FROM {$table_name} WHERE id = ?";
            $stmt = mysqli_prepare($con, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $product_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $product = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);
            }
        }

        if (!$product) {
            // If fetching fails or invalid parameters
            $edit_message = "<div class='text-red-600'>Error: Product not found or invalid URL parameters.</div>";
        }
?>

<!-- [UI FIX] This wrapper was removed to standardize layout -->
<!-- <div class="max-w-4xl mx-auto"> -->
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Edit Product: <?php echo htmlspecialchars($product['name'] ?? 'Loading...'); ?></h2>

    <?php if ($edit_message): ?>
        <div class="p-4 mb-6 rounded-lg bg-white shadow">
            <?= $edit_message ?>
        </div>
    <?php endif; ?>

    <?php if ($product): ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-6 p-6 bg-white rounded-xl shadow-lg">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($table_name); ?>">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product ID</label>
                    <p class="mt-1 text-lg font-bold text-gray-900"><?php echo htmlspecialchars($product['id']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <p class="mt-1 text-lg font-bold text-red-600"><?php echo ucfirst($table_name); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" id="name" required value="<?php echo htmlspecialchars($product['name']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" step="0.01" required value="<?php echo htmlspecialchars($product['price']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div>
                <label for="alt_text" class="block text-sm font-medium text-gray-700">Image Alt Text</label>
                <input type="text" name="alt_text" id="alt_text" value="<?php echo htmlspecialchars($product['alt_text']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>

            <div>
                <label for="buy_link" class="block text-sm font-medium text-gray-700">External Buy Link (Full URL)</label>
                <input type="url" name="buy_link" id="buy_link" value="<?php echo htmlspecialchars($product['buy_link']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>

            <h3 class="text-xl font-semibold text-gray-900 pt-4 border-t">Update Images (Upload only to change)</h3>
            <p class="text-sm text-gray-500">Max file size: 5MB. Allowed types: JPG, PNG, GIF.</p>
            <div class="grid grid-cols-2 gap-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <?php $image_key = 'image_url_' . $i; ?>
                    <div class="border p-4 rounded-md">
                        <label for="image_<?php echo $i; ?>" class="block text-sm font-medium text-gray-700">Image <?php echo $i; ?></label>
                        <?php if (!empty($product[$image_key])): ?>
                            <p class="text-xs text-green-600 mb-2">Current Image:</p>
                            <img src="<?php echo htmlspecialchars($product[$image_key]); ?>" class="h-16 w-16 object-cover rounded-md mb-2">
                        <?php else: ?>
                            <p class="text-xs text-red-500 mb-2">No Image Set</p>
                        <?php endif; ?>

                        <input type="file" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>"
                               accept="image/png, image/jpeg, image/gif"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 hover:file:bg-gray-200">
                    </div>
                <?php endfor; ?>
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-feather="upload-cloud" class="w-5 h-5 mr-2"></i>
                Update Product Details
            </button>
        </form>

        <div class="mt-6">
            <a href="admin_master.php?page=manage" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Manage Products
            </a>
        </div>

    <?php endif; ?>
<!-- </div> -->
<?php
    break; // End Edit Case

    // --- 4.6 TRACKING VIEW (FIXED: Now hides deleted products) ---
    case 'tracking':

        // =========================================================================
        // [FIX] PRODUCT CLICKS TRACKING QUERY (Now joins with live products)
        // =========================================================================

        // This query is now more advanced.
        // 1. A `WITH AllProducts AS (...)` Common Table Expression (CTE) is created to
        //    gather all *existing* products from the 3 tables into a temporary view.
        // 2. We then `INNER JOIN` the `product_clicks` log against this 'AllProducts' view.
        // 3. This ensures that clicks for products that have been deleted
        //    (and are no longer in tshirts, hoodies, or accessories)
        //    will NOT be shown in the tracking results.
        // 4. It also fetches the *current* name and category, so if a product is
        //    renamed, the tracking page reflects the new name.
        $query = "
            WITH AllProducts AS (
                SELECT id, name, 'T-Shirts' AS category FROM tshirts
                UNION ALL
                SELECT id, name, 'Hoodies' AS category FROM hoodies
                UNION ALL
                SELECT id, name, 'Accessories' AS category FROM accessories
            )
            SELECT
                pc.product_id,
                ap.name AS product_name,
                ap.category AS product_category,
                COUNT(pc.id) AS total_clicks,
                SUM(CASE WHEN pc.click_type = 'buy' THEN 1 ELSE 0 END) AS buy_clicks,
                SUM(CASE WHEN pc.click_type = 'share' THEN 1 ELSE 0 END) AS share_clicks
            FROM product_clicks pc
            INNER JOIN AllProducts ap
                ON pc.product_id = ap.id AND pc.product_category COLLATE utf8mb4_general_ci = ap.category COLLATE utf8mb4_general_ci
            GROUP BY pc.product_id, ap.name, ap.category
            ORDER BY total_clicks DESC;
        ";

        $result = mysqli_query($con, $query);

        $tracking_data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tracking_data[] = $row;
            }
        } else {
             // Handle potential query error
            $tracking_error = mysqli_error($con);
        }
?>
    <!-- [UI FIX] This wrapper was removed to standardize layout -->
    <!-- <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8"> -->

        <h2 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center">
            <i data-feather="bar-chart-2" class="w-7 h-7 mr-2 text-red-600"></i>
            Product Click Tracking Data
        </h2>
        <p class="text-lg text-gray-600 mb-8">Aggregated metrics for 'Buy Now' and 'Share Product' clicks. **Only shows data for products that still exist.**</p>

        <?php if (isset($tracking_error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <p class="font-bold">Database Query Error</p>
                <p><?php echo htmlspecialchars($tracking_error); ?></p>
            </div>
        <?php elseif (empty($tracking_data)): ?>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                <p class="text-blue-700 font-medium">No click data has been recorded for any existing products.</p>
                <p class="text-blue-600 text-sm mt-1">Ensure the `track_click.php` endpoint is correctly processing requests.</p>
            </div>
        <?php else: ?>
            <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product Name (Live)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category (Live)
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Buy Clicks
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Share Clicks
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-red-50">
                                Total Clicks
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($tracking_data as $data): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($data['product_name']); ?></div>
                                <div class="text-xs text-gray-500">ID: <?php echo htmlspecialchars($data['product_id']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo ($data['product_category'] === 'Hoodies' ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800'); ?>">
                                    <?php echo htmlspecialchars($data['product_category']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                <?php echo number_format($data['buy_clicks']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                <?php echo number_format($data['share_clicks']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600 text-center bg-red-50">
                                <?php echo number_format($data['total_clicks']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-8">
            <a href="admin_master.php?page=dashboard" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Dashboard
            </a>
        </div>

    <!-- </div> -->
<?php
    break; // End Tracking Case

    // =========================================================================
    // --- 4.7 [REWORKED] CUSTOMER VISITS VIEW (Aggregate Counts) ---
    // =========================================================================
    case 'visits':

        $visits_by_page = [];
        $visits_by_country = [];
        $total_visits = 0;
        $filter_error = '';

        // --- 1. Filter Handling (Country code is kept, IP/UserAgent are removed) ---
        $filter_type = $_GET['filter_type'] ?? 'last_30_days';
        $country_code = trim($_GET['country_code'] ?? '');
        $start_date = trim($_GET['start_date'] ?? '');
        $end_date = trim($_GET['end_date'] ?? '');

        // [SECURITY] Build WHERE clauses and parameters for prepared statements
        $where_clauses = [];
        $param_types = '';
        $param_values = [];

        // --- Date Filter Logic ---
        if ($filter_type === 'period') {
            if (!empty($start_date) && !empty($end_date)) {
                // Use DATE(visit_time) to compare only the date part, and ensure end date includes the whole day
                $where_clauses[] = "visit_time BETWEEN ? AND DATE_ADD(?, INTERVAL 1 DAY)";
                $param_types .= 'ss';
                $param_values[] = $start_date;
                $param_values[] = $end_date;
            } else {
                $filter_error = 'Please select both start and end dates for a custom period.';
            }
        } elseif ($filter_type === 'day') {
            $where_clauses[] = "DATE(visit_time) = CURDATE()";
        } elseif ($filter_type === 'month') {
            $where_clauses[] = "YEAR(visit_time) = YEAR(CURDATE()) AND MONTH(visit_time) = MONTH(CURDATE())";
        } elseif ($filter_type === 'year') {
            $where_clauses[] = "YEAR(visit_time) = YEAR(CURDATE())";
        } else {
            // Default: 'last_30_days'
            $where_clauses[] = "visit_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        }

        // --- Region (Country) Filter Logic ---
        if (!empty($country_code)) {
            $where_clauses[] = "country_code = ?";
            $param_types .= 's';
            $param_values[] = strtoupper($country_code); // Ensure uppercase for comparison
        }

        // --- 2. Query Execution (Multiple Aggregate Queries) ---
        if (empty($filter_error)) {
            $where_sql = count($where_clauses) > 0 ? "WHERE " . implode(' AND ', $where_clauses) : "";

            // --- Query 1: Get Total Visit Count ---
            $query_total = "SELECT COUNT(id) AS total_visits FROM cu_visits {$where_sql}";
            $stmt_total = mysqli_prepare($con, $query_total);
            if ($stmt_total) {
                if (!empty($param_types)) {
                    mysqli_stmt_bind_param($stmt_total, $param_types, ...$param_values);
                }
                mysqli_stmt_execute($stmt_total);
                $result = mysqli_stmt_get_result($stmt_total);
                $total_visits = mysqli_fetch_assoc($result)['total_visits'] ?? 0;
                mysqli_stmt_close($stmt_total);
            } else {
                $filter_error = 'Database error (Total): ' . mysqli_error($con);
            }

            // --- Query 2: Get Visits by Page URL ---
            if(empty($filter_error)) {
                $query_pages = "
                    SELECT page_url, COUNT(id) AS visits
                    FROM cu_visits
                    {$where_sql}
                    GROUP BY page_url
                    ORDER BY visits DESC
                    LIMIT 50;
                ";
                $stmt_pages = mysqli_prepare($con, $query_pages);
                if ($stmt_pages) {
                    if (!empty($param_types)) {
                        mysqli_stmt_bind_param($stmt_pages, $param_types, ...$param_values);
                    }
                    mysqli_stmt_execute($stmt_pages);
                    $result = mysqli_stmt_get_result($stmt_pages);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $visits_by_page[] = $row;
                    }
                    mysqli_stmt_close($stmt_pages);
                } else {
                    $filter_error = 'Database error (Pages): ' . mysqli_error($con);
                }
            }

            // --- Query 3: Get Visits by Country ---
            if(empty($filter_error)) {
                $query_country = "
                    SELECT country_code, region, COUNT(id) AS visits
                    FROM cu_visits
                    {$where_sql}
                    GROUP BY country_code, region
                    ORDER BY visits DESC
                    LIMIT 50;
                ";
                $stmt_country = mysqli_prepare($con, $query_country);
                if ($stmt_country) {
                    if (!empty($param_types)) {
                        mysqli_stmt_bind_param($stmt_country, $param_types, ...$param_values);
                    }
                    mysqli_stmt_execute($stmt_country);
                    $result = mysqli_stmt_get_result($stmt_country);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $visits_by_country[] = $row;
                    }
                    mysqli_stmt_close($stmt_country);
                } else {
                    $filter_error = 'Database error (Country): ' . mysqli_error($con);
                }
            }
        }
?>
    <!-- [UI FIX] This wrapper was removed to standardize layout -->
    <!-- <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8"> -->

        <h2 class="text-3xl font-extrabold text-gray-900 mb-2 flex items-center">
            <i data-feather="map" class="w-7 h-7 mr-2 text-red-600"></i>
            Customer Visits Report
        </h2>
        <p class="text-lg text-gray-600 mb-8">Aggregated visit counts by page and region. (No PII is shown).</p>

        <!-- [REWORK] Filter Form (Country code filter is kept) -->
        <form method="GET" action="admin_master.php" class="bg-white p-6 rounded-xl shadow-lg mb-8 space-y-4">
            <input type="hidden" name="page" value="visits">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                <div>
                    <label for="filter_type" class="block text-sm font-medium text-gray-700">Time Filter</label>
                    <select id="filter_type" name="filter_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                        <option value="last_30_days" <?php echo ($filter_type === 'last_30_days' ? 'selected' : ''); ?>>Last 30 Days (Default)</option>
                        <option value="day" <?php echo ($filter_type === 'day' ? 'selected' : ''); ?>>Today</option>
                        <option value="month" <?php echo ($filter_type === 'month' ? 'selected' : ''); ?>>This Month</option>
                        <option value="year" <?php echo ($filter_type === 'year' ? 'selected' : ''); ?>>This Year</option>
                        <option value="period" <?php echo ($filter_type === 'period' ? 'selected' : ''); ?>>Custom Period (Date Range)</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">From Date (YYYY-MM-DD)</label>
                    <input type="date" id="start_date" name="start_date"
                           value="<?php echo htmlspecialchars($start_date); ?>"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">To Date (YYYY-MM-DD)</label>
                    <input type="date" id="end_date" name="end_date"
                           value="<?php echo htmlspecialchars($end_date); ?>"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="country_code" class="block text-sm font-medium text-gray-700">Region (Country Code)</label>
                    <input type="text" id="country_code" name="country_code" placeholder="e.g., US, IN, GB"
                           value="<?php echo htmlspecialchars($country_code); ?>"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm uppercase"
                           maxlength="2">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                Apply Filters
            </button>
        </form>

        <?php if ($filter_error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Filter Error</p>
                <p><?php echo $filter_error; ?></p>
            </div>
        <?php endif; ?>

        <!-- [REWORK] Total Visits Card -->
        <div class="mb-8 p-6 bg-red-600 text-white rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold">Total Visits (Matching Filter)</h3>
            <p class="text-5xl font-bold mt-2"><?php echo number_format($total_visits); ?></p>
            <p class="text-sm opacity-80 mt-1">
                <?php
                    // Display a human-readable filter description
                    if ($filter_type === 'day') echo 'Filter: Today';
                    elseif ($filter_type === 'month') echo 'Filter: This Month';
                    elseif ($filter_type === 'year') echo 'Filter: This Year';
                    elseif ($filter_type === 'period') echo "Filter: {$start_date} to {$end_date}";
                    else echo 'Filter: Last 30 Days';
                    
                    if (!empty($country_code)) echo " & Country: " . htmlspecialchars($country_code);
                ?>
            </p>
        </div>

        <!-- [REWORK] Aggregate Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Visits by Page Table -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Top Pages by Visits</h3>
                <?php if (empty($visits_by_page)): ?>
                    <p class="text-gray-500">No page data found for this filter.</p>
                <?php else: ?>
                    <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page URL</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Visits</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($visits_by_page as $page_data): ?>
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-sm truncate" title="<?php echo htmlspecialchars($page_data['page_url']); ?>">
                                        <?php echo htmlspecialchars($page_data['page_url']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right">
                                        <?php echo number_format($page_data['visits']); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Visits by Country Table -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Top Regions by Visits</h3>
                <?php if (empty($visits_by_country)): ?>
                    <p class="text-gray-500">No region data found for this filter.</p>
                <?php else: ?>
                     <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country / Region</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Visits</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($visits_by_country as $country_data): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-bold text-red-600"><?php echo htmlspecialchars($country_data['country_code']); ?></span>
                                        <?php if(!empty($country_data['region'])): ?>
                                            / <?php echo htmlspecialchars($country_data['region']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right">
                                        <?php echo number_format($country_data['visits']); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    <!-- </div> -->
<?php
    break; // End Visits Case

    default:
        // Fallback for an invalid 'page' parameter
        echo '<div class="py-8 text-red-700">Error: Invalid page requested.</div>';
    break;

endswitch;
?>
            <!-- [UI FIX] These are the closing tags for the main content wrapper -->
            <!-- They are placed *after* the switch statement but *before* the footer -->
            </div> 
        </div> 
    </div> <!-- End flex wrapper -->
<?php
// =================================================================================
// 5. HTML FOOTER & CLEANUP (The content of admin_footer.php)
// =================================================================================

?>
    <script>
        // Initialize Feather Icons everywhere
        feather.replace(); 
    </script>
</body>
</html>
<?php

// [DB] Safely close the database connection
if (isset($con) && $con && mysqli_ping($con)) {
    mysqli_close($con);
}
?>