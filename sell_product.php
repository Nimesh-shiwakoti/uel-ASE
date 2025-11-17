<?php
// sell_product.php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Products - Star Robotics and Toy Shop</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff; /* AliceBlue background */
            color: #333;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 1000px; /* Increased max-width for wider tables */
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Button Styles */
        .btn {
            background-color: #27ae60;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #219150;
        }

        .btn-secondary {
            background-color: #2980b9;
        }

        .btn-secondary:hover {
            background-color: #1f6391;
        }

        /* Input Styles */
        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            margin: 5px 0 15px 0;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1em;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #34495e;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table, th, td {
            border: 1px solid #bdc3c7;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Set specific widths for table columns */
        th:nth-child(1), td:nth-child(1) { width: 20%; } /* Product Name */
        th:nth-child(2), td:nth-child(2) { width: 10%; } /* Image */
        th:nth-child(3), td:nth-child(3) { width: 10%; } /* Remaining Stock */
        th:nth-child(4), td:nth-child(4) { width: 10%; } /* Selling Price */
        th:nth-child(5), td:nth-child(5) { width: 10%; } /* Quantity */
        th:nth-child(6), td:nth-child(6) { width: 12%; } /* Discount Amount */
        th:nth-child(7), td:nth-child(7) { width: 12%; } /* Discount Percentage */
        th:nth-child(8), td:nth-child(8) { width: 14%; } /* Total After Discount */
        th:nth-child(9), td:nth-child(9) { width: 8%; } /* Action */

        /* Image Styles */
        img.product-image {
            width: 60px;
            height: auto;
            border-radius: 5px;
        }

        /* Total and Summary Styles */
        .summary {
            margin-top: 20px;
            text-align: right;
            font-size: 1.1em;
        }

        .summary .total-label {
            font-weight: bold;
            margin-right: 10px;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px; /* Could be more or less, depending on screen size */
            border-radius: 10px;
            text-align: center;
        }

        .close-modal {
            background-color: #27ae60;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .close-modal:hover {
            background-color: #219150;
        }

        /* Progress Bar Styles */
        .progress-container {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin-top: 10px;
            display: none; /* Hidden by default */
        }

        .progress-bar {
            width: 0%;
            height: 20px;
            background-color: #27ae60;
            border-radius: 5px;
            transition: width 0.4s ease;
        }

        /* Nepal Currency Symbol */
        .currency-symbol {
            font-family: 'Noto Sans', sans-serif;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            th, td {
                padding: 8px;
            }

            .btn {
                width: 100%;
                margin-top: 10px;
            }

            .summary {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <button class="btn btn-secondary" type="button" onclick="window.location.href='index.php'">Home</button>
    <div class="container">
        <h1>Sell Products</h1>

        <div>
            <label for="product_id">Product ID:</label>
            <input type="number" id="product_id" placeholder="Enter Product ID" required>
            <button class="btn" type="button" onclick="addProduct()">Add Product</button>
            <!-- Progress bar for adding product -->
            <div class="progress-container" id="addProductProgress">
                <div class="progress-bar" id="addProductProgressBar"></div>
            </div>
        </div>

        <table id="productList">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Remaining Stock</th>
                    <th>Selling Price <span class="currency-symbol">रू</span></th>
                    <th>Quantity</th>
                    <th>Discount Amount <span class="currency-symbol">रू</span></th>
                    <th>Discount (%)</th>
                    <th>Total After Discount <span class="currency-symbol">रू</span></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Product rows will be dynamically added here -->
            </tbody>
        </table>

        <div class="summary">
            <div class="total">Total Amount: <span class="currency-symbol">रू</span><span id="totalAmount">0.00</span></div>
            
            <label for="tendered">Tender Amount <span class="currency-symbol">रू</span>:</label>
            <input type="number" id="tendered" placeholder="Enter Tender Amount" required oninput="calculateReturn()">
        
            <div class="total">Return Amount: <span class="currency-symbol">रू</span><span id="returnAmount">0.00</span></div>
        </div>
    
        <button class="btn" type="button" onclick="finalizeSale()">Finalize Sale</button>
        <!-- Progress bar for finalizing sale -->
        <div class="progress-container" id="finalizeSaleProgress">
            <div class="progress-bar" id="finalizeSaleProgressBar"></div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="saleModal" class="modal">
        <div class="modal-content">
            <h2>Sale Completed</h2>
            <p>Your sale has been successfully processed!</p>
            <button class="close-modal" onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        let productList = [];
        
        // Trigger addProduct() on Enter key press in product_id input
            document.getElementById('product_id').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission if inside a form
            addProduct(); // Call your function
                }
        });

        

        // Function to add a product to the sale
        function addProduct() {
            const productId = document.getElementById('product_id').value.trim();
            if (productId === "") {
                alert("Please enter a Product ID.");
                return;
            }

            // Check if the product is already in the list
            if (productList.some(product => product.id === productId)) {
                alert("Product is already added to the sale.");
                return;
            }

            // Show progress bar for adding product
            const addProductProgress = document.getElementById('addProductProgress');
            const addProductProgressBar = document.getElementById('addProductProgressBar');
            addProductProgress.style.display = 'block';
            addProductProgressBar.style.width = '0%';

            // Simulate progress (optional)
            let progress = 0;
            const progressInterval = setInterval(() => {
                if (progress >= 90) {
                    clearInterval(progressInterval);
                } else {
                    progress += 10;
                    addProductProgressBar.style.width = progress + '%';
                }
            }, 100);

            fetch('fetch_product_details.php?product_id=' + productId)
                .then(response => response.json())
                .then(data => {
                    clearInterval(progressInterval);
                    addProductProgressBar.style.width = '100%';
                    setTimeout(() => {
                        addProductProgress.style.display = 'none';
                        addProductProgressBar.style.width = '0%';
                    }, 500); // Hide progress bar after completion

                    if (data.success) {
                        const product = data;
                        const currentStock = parseInt(product.current_stock);
                        const sellingPrice = parseFloat(product.latest_selling_price) || 0;

                        // Check if current stock is 0
                        if (currentStock <= 0) {
                            alert('Out of stock. Cannot add this product.');
                            return; // Prevent adding the product
                        }

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.product_name}</td>
                            <td><img src="${product.image}" alt="${product.product_name}" class="product-image"></td>
                            <td class="currentStock">${currentStock}</td>
                            <td class="sellingPrice">रू ${sellingPrice.toFixed(2)}</td>
                            <td>
                                <input type="number" class="quantityInput" min="1" max="${currentStock}" value="1" onchange="handleQuantityChange(this, ${currentStock})">
                            </td>
                            <td>
                                <input type="number" class="discountAmountInput" min="0" value="0" onchange="handleDiscountChange(this, ${sellingPrice}, this.closest('tr'))">
                            </td>
                            <td>
                                <input type="number" class="discountPercentageInput" min="0" max="100" value="0" readonly>
                            </td>
                            <td class="totalAfterDiscount">रू 0.00</td>
                            <td>
                                <button class="btn btn-secondary" type="button" onclick="removeProduct(this)">Remove</button>
                            </td>
                        `;

                        document.getElementById('productList').querySelector('tbody').appendChild(row);
                        productList.push({ id: productId, name: product.product_name, stock: currentStock, price: sellingPrice });

                        // Initialize discount calculations
                        const quantityInput = row.querySelector('.quantityInput');
                        const discountAmountInput = row.querySelector('.discountAmountInput');
                        handleQuantityChange(quantityInput, currentStock);
                        handleDiscountChange(discountAmountInput, sellingPrice, row);

                        updateTotalAmount();
                        document.getElementById('product_id').value = ''; // Clear the input field
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    clearInterval(progressInterval);
                    addProductProgress.style.display = 'none';
                    addProductProgressBar.style.width = '0%';
                    console.error('Error fetching product details:', error);
                    alert('An error occurred while fetching product details.');
                });
        }

        // Handle quantity changes
        function handleQuantityChange(input, stock) {
            let quantity = parseInt(input.value);
            if (isNaN(quantity) || quantity < 1) {
                alert("Quantity must be at least 1.");
                input.value = 1;
                quantity = 1;
            }
            if (quantity > stock) {
                alert(`Quantity cannot exceed the remaining stock of ${stock}.`);
                input.value = stock;
                quantity = stock;
            }
            updateRowTotal(input.closest('tr'));
        }

        // Handle discount changes
        function handleDiscountChange(input, price, row) {
            const quantity = parseInt(row.querySelector('.quantityInput').value) || 1;
            let discountAmount = parseFloat(input.value) || 0;

            const maxDiscount = price * quantity;
            if (discountAmount > maxDiscount) {
                alert(`Discount amount cannot exceed रु ${maxDiscount.toFixed(2)}.`);
                discountAmount = maxDiscount;
                input.value = discountAmount.toFixed(2);
            }

            // Calculate discount percentage
            const discountPercentage = (discountAmount / (price * quantity)) * 100;
            row.querySelector('.discountPercentageInput').value = discountPercentage.toFixed(2);

            updateRowTotal(row);
        }

        // Update the total after discount for a row
        function updateRowTotal(row) {
            const quantity = parseInt(row.querySelector('.quantityInput').value) || 1;
            const priceText = row.querySelector('.sellingPrice').textContent;
            const price = parseFloat(priceText.replace('रू', '').trim()) || 0;
            const discountAmount = parseFloat(row.querySelector('.discountAmountInput').value) || 0;

            const totalBeforeDiscount = price * quantity;
            const totalAfterDiscount = totalBeforeDiscount - discountAmount;

            // Ensure total after discount is not negative
            row.querySelector('.totalAfterDiscount').textContent = `रू ${totalAfterDiscount >= 0 ? totalAfterDiscount.toFixed(2) : "0.00"}`;

            updateTotalAmount();
        }

        // Update the overall total amount
        function updateTotalAmount() {
            let totalAmount = 0;
            const rows = document.querySelectorAll('#productList tbody tr');

            rows.forEach(row => {
                const totalAfterDiscountText = row.querySelector('.totalAfterDiscount').textContent;
                const totalAfterDiscount = parseFloat(totalAfterDiscountText.replace('रू', '').trim()) || 0;
                totalAmount += totalAfterDiscount;
            });

            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
            calculateReturn();
        }

        // Calculate the return amount
        function calculateReturn() {
            const totalAmount = parseFloat(document.getElementById('totalAmount').textContent) || 0;
            const tenderedAmount = parseFloat(document.getElementById('tendered').value) || 0;
            const returnAmount = tenderedAmount - totalAmount;

            document.getElementById('returnAmount').textContent = returnAmount >= 0 ? returnAmount.toFixed(2) : "0.00";
        }

        // Remove a product from the sale
        function removeProduct(button) {
            const row = button.closest('tr');
            const productName = row.querySelector('td').textContent;
            const productId = productList.find(product => product.name === productName)?.id;

            // Remove from productList
            if (productId) {
                productList = productList.filter(product => product.id !== productId);
            }

            row.remove();
            updateTotalAmount();
        }

        // Finalize the sale
        function finalizeSale() {
            const saleData = [];
            const rows = document.querySelectorAll('#productList tbody tr');
            const userId = <?php echo json_encode($_SESSION['user_id']); ?>; // Get the user_id

            rows.forEach((row) => {
                const quantityInput = row.querySelector('.quantityInput');
                const quantity = parseInt(quantityInput.value) || 0;
                const discountAmountInput = row.querySelector('.discountAmountInput');
                const discountAmount = parseFloat(discountAmountInput.value) || 0;
                const totalAfterDiscountText = row.querySelector('.totalAfterDiscount').textContent;
                const totalAfterDiscount = parseFloat(totalAfterDiscountText.replace('रू', '').trim()) || 0;

                if (quantity > 0) {
                    const productName = row.querySelector('td').textContent;
                    const product = productList.find(p => p.name === productName);
                    if (product) {
                        saleData.push({
                            product_id: product.id,
                            quantity: quantity,
                            discount_amount: discountAmount,
                            total_price: totalAfterDiscount
                            // user_id will be handled separately
                        });
                    }
                }
            });

            if (saleData.length === 0) {
                alert("No products to finalize.");
                return;
            }

            // Show progress bar for finalizing sale
            const finalizeSaleProgress = document.getElementById('finalizeSaleProgress');
            const finalizeSaleProgressBar = document.getElementById('finalizeSaleProgressBar');
            finalizeSaleProgress.style.display = 'block';
            finalizeSaleProgressBar.style.width = '0%';

            // Simulate progress
            let progress = 0;
            const progressInterval = setInterval(() => {
                if (progress >= 90) {
                    clearInterval(progressInterval);
                } else {
                    progress += 10;
                    finalizeSaleProgressBar.style.width = progress + '%';
                }
            }, 100);

            // Send the sale data to the backend via an AJAX POST request
            fetch('save_sale.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(saleData), // Send the sale data as JSON
            })
            .then(response => response.json())
            .then(data => {
                clearInterval(progressInterval);
                finalizeSaleProgressBar.style.width = '100%';
                setTimeout(() => {
                    finalizeSaleProgress.style.display = 'none';
                    finalizeSaleProgressBar.style.width = '0%';
                }, 500); // Hide progress bar after completion

                if (data.success) {
                    // Show modal popup
                    showModal();
                } else {
                    alert('Failed to finalize sale: ' + data.message);
                }
            })
            .catch(error => {
                clearInterval(progressInterval);
                finalizeSaleProgress.style.display = 'none';
                finalizeSaleProgressBar.style.width = '0%';
                console.error('Error finalizing sale:', error);
                alert('An error occurred while finalizing the sale.');
            });
        }

        // Function to show the modal popup
        function showModal() {
            const modal = document.getElementById('saleModal');
            modal.style.display = 'block';
        }

        // Function to close the modal and reload the page
        function closeModal() {
            const modal = document.getElementById('saleModal');
            modal.style.display = 'none';
            location.reload();
        }

        // Close the modal when clicking outside of the modal content
        window.onclick = function(event) {
            const modal = document.getElementById('saleModal');
            if (event.target == modal) {
                modal.style.display = 'none';
                location.reload();
            }
        }
    </script
    <br>
    <br>
    <br>
    
</body>
</html>
