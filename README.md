ToysZone.com is a simple PHP-based web application for managing a toy shop's inventory and sales. 
This project includes user management, product listings, a shopping cart, and order checkout features.
All uploaded files (images, products, etc.) should be stored in the upload folder,
which must be in the project’s root directory.

toys/
│
├─ upload/              # Folder to store product images or uploads
├─ css/                 # CSS files
├─ js/                  # JavaScript files
├─ index.php            # Main landing page
├─ client_dashboard.php # User dashboard
├─ logout1.php          # Logout page
├─ other PHP files      # Other functionality (cart, checkout, etc.)
├─ bamshaw1_toys.sql    # Database dump
├─ README.md            # Project documentation

Note: Ensure the upload folder is present in the project root; all uploaded images 
and files are stored here.

Installation Steps
1. Extract Project Files

Download upload.rar, PHPMailer.zip in your PHP project folder.

Extract the contents of upload.rar and PHPMailer.zip.
toys/
|-PHPMailer
├─ upload/
├─ index.php
├─ client_dashboard.php
...


2. Set up Database

Open XAMPP Control Panel and start Apache and MySQL.

Open phpMyAdmin in your browser: http://localhost/phpmyadmin

Create a new database. For example:
Database name: bamshaw1_toys
Collation: utf8_general_ci

Import the database:

Click on your new database → Import tab → Choose File → select bamshaw1_toys.sql

Click Go to import.

Confirm all tables are created successfully.

3. Configure Database Connection

Open the PHP file that handles database connection (e.g., db.php or config.php).

Update credentials according to your XAMPP setup:

<?php
$host = "localhost";
$user = "root";          // default XAMPP username
$password = "";          // default XAMPP password
$database = "bamshaw1_toys";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

Make sure the database name matches the one you created.

4. Place the Upload Folder

The upload folder should always be in the root directory of the project.

Example structure:
BAMSHAW1_Toys/
├─ upload/
│   ├─ product1.jpg
│   ├─ product2.jpg
├─ index.php
├─ db.php
├─ other PHP files

All product images uploaded from the admin panel or form will go here.

5. Launch the Project

Open a browser.

Go to: http://localhost/toys/index.php

You should see the homepage of the toy shop.

Users can view products.

Admin can manage products (if the admin panel exists).

Cart and checkout functionalities work after the database is imported.


Copy the upload folder into your project root directory (where your PHP files are).

The project folder should now look like:
