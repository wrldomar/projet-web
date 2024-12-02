const quantityInput = document.getElementById('quantity');

// Add an event listener for when the input value changes
quantityInput.addEventListener('input', function () {
// If the value is less than 1, reset it to 1
    if (this.value < 1) {
            alert("You can't put less than 1, if you want to remove it simply click on remove");
            this.value = 1;
    }
});

// Ensure the input starts with a minimum of 1
quantityInput.addEventListener('blur', function () {
if (this.value === "" || this.value < 1) {
        this.value = 1;
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const productButton = document.getElementById("product-column"); // The Product button
    const tableBody = document.querySelector("table tbody");

    let ascending = true; // Sorting direction

    productButton.addEventListener("click", function () {
        // Get all rows from the table
        const rows = Array.from(tableBody.querySelectorAll("tr"));

        // Sort rows based on the product name in the first column
        rows.sort((rowA, rowB) => {
            const productA = rowA.querySelector("td:first-child").textContent.trim().toLowerCase();
            const productB = rowB.querySelector("td:first-child").textContent.trim().toLowerCase();

            return ascending
                ? productA.localeCompare(productB)
                : productB.localeCompare(productA);
        });

        // Toggle sorting direction
        ascending = !ascending;

        // Clear and re-append sorted rows
        tableBody.innerHTML = "";
        rows.forEach(row => tableBody.appendChild(row));

        // Update button text to show sorting direction
        productButton.textContent = `Product ${ascending ? "▲" : "▼"}`;
    });
});


// Function to filter cart items based on the search query
function searchCart() {
// Get the search query and convert it to lowercase
const query = document.getElementById("search-bar").value.toLowerCase();

// Get all table rows
const rows = document.querySelectorAll("table tbody tr");

// Loop through each row and hide those that don't match the search query
rows.forEach(row => {
    const productName = row.querySelector("td:first-child").textContent.toLowerCase();
    if (productName.includes(query)) {
        row.style.display = "";  // Show row if it matches
    } else {
        row.style.display = "none";  // Hide row if it doesn't match
    }
});
}