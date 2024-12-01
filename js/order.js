// Add event listeners for form inputs
document.getElementById('print-type').addEventListener('change', updateTotalPrice);
document.getElementById('print-size').addEventListener('change', updateTotalPrice);
document.getElementById('quantity-prints').addEventListener('input', updateTotalPrice);

// Function to update the total price
function updateTotalPrice() {
    // Get prices from selected options using data-price attribute
    var printTypePrice = parseInt(document.querySelector('#print-type option:checked').getAttribute('data-price')) || 0;
    var printSizePrice = parseInt(document.querySelector('#print-size option:checked').getAttribute('data-price')) || 0;
    var quantity = parseInt(document.getElementById('quantity-prints').value) || 1; // Default to 1 if no quantity is entered

    if (quantity > 0) {
        var totalPrice = (printTypePrice + printSizePrice) * quantity;
        document.getElementById('amount').value = "₱" + totalPrice.toFixed(2);
    }
}

// Handle payment process when "Proceed to Payment" button is clicked
document.getElementById('proceedToPayment').addEventListener('click', function () {
    var totalPrice = document.getElementById('amount').value.replace('₱', '');
    var amount = parseFloat(totalPrice.replace('₱', '').trim());

    var printType = document.getElementById('print-type').value;
    var printSize = document.getElementById('print-size').value;
    var quantity = document.getElementById('quantity-prints').value;
    var fileUpload = document.getElementById('file-upload').files[0];
    var amount = totalPrice;

    if (!fileUpload) {
        alert("Please upload an image.");
        return;
    }

    if (amount > 0) {
        var formData = new FormData();
        formData.append('file', fileUpload); // Assuming imageUpload is the file input element
        formData.append('print_type', printType);
        formData.append('print_size', printSize);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
    
        // Send the form data to PHP using POST
        fetch('checkout.php', {
            method: 'POST',
            body: formData,  // Use FormData to handle file uploads
        })
        .then(response => response.json())  // Parse the response as JSON
        .then(data => {
            if (data.checkout_url) {
                window.location.href = data.checkout_url; // Redirect to PayMongo payment page
            } else {
                alert('Payment initiation failed: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error);
        });
    } else {
        alert('Please ensure all fields are filled correctly.');
    }
});