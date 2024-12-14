// Function to filter cart items based on the search query
function searchCart() {
    // Get the search query and convert it to lowercase
    const query = document.getElementById("searchbar").value.toLowerCase();
    
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