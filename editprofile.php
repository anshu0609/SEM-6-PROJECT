<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'furn') or die("Database Connection Error!");

$username = $_SESSION['username'];

// Fetch user data
$query = "SELECT * FROM register WHERE name = '$username'";
$result = mysqli_query($conn, $query);

// Check if user exists
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    $user = ['name' => '', 'email' => '', 'mobile' => '', 'address' => '']; // Ensure empty fields if no user found
}

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update_query = "UPDATE register SET name='$name', email='$email', mobile='$mobile', address='$address' WHERE name='$username'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['username'] = $name; // Update session name if the name was changed
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Furn</title>
    <link rel="stylesheet" href="editprofile.css">
</head>

<body>
    <div class="edit-container">
        <h2>Edit Profile</h2>
        <form method="POST">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="input-group">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>

            <button type="submit">Update Profile</button>
        </form>
        <a href="profile.php" class="back-link">Back to Profile</a>
    </div>
</body>
</html>
