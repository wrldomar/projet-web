document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        // Prevent form submission for validation
        event.preventDefault();

        // Clear previous error messages
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach((message) => message.remove());

        let isValid = true;

        // Validate Farmer ID
        const farmerId = document.getElementById("id_farmer");
        if (!farmerId.value || farmerId.value <= 0) {
            showError(farmerId, "Farmer ID must be a positive number.");
            isValid = false;
        }

        // Validate Category
        const category = document.getElementById("id_categorie");
        if (!category.value) {
            showError(category, "Please select a category.");
            isValid = false;
        }

        // Validate Product Name
        const productName = document.getElementById("name_product");
        const nameRegex = /^[A-Za-z\s]+$/; // Only letters and spaces are allowed
        if (!productName.value.trim()) {
            showError(productName, "Product name cannot be empty.");
            isValid = false;
        } else if (!nameRegex.test(productName.value.trim())) {
            showError(productName, "Product name must contain only letters.");
            isValid = false;
        }

        // Validate Product Price
        const productPrice = document.getElementById("product_price");
        if (!productPrice.value || productPrice.value <= 0) {
            showError(productPrice, "Product price must be a positive number.");
            isValid = false;
        }

        // Validate Quantity
        const quantity = document.getElementById("quantite");
        if (!quantity.value || quantity.value <= 0) {
            showError(quantity, "Quantity must be a positive number.");
            isValid = false;
        }

        // Validate Product Image
        const productImage = document.getElementById("product_image");
        if (!productImage.value) {
            showError(productImage, "Please upload a product image.");
            isValid = false;
        }

        // If all validations pass, submit the form
        if (isValid) {
            form.submit();
        }
    });

    // Function to display error messages
    function showError(input, message) {
        const error = document.createElement("div");
        error.className = "error-message";
        error.style.color = "red";
        error.style.marginTop = "5px";
        error.style.fontSize = "14px";
        error.innerText = message;
        input.parentElement.appendChild(error);
    }
});























