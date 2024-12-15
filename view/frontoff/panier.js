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

////CURSOR ANIMATION////
document.addEventListener('scroll', function() {
    var missionVision = document.getElementById('mission-vision');
    var position = missionVision.getBoundingClientRect();

    // Check if the section is in the viewport
    if (position.top <= window.innerHeight && position.bottom >= 0) {
        missionVision.classList.add('visible'); // Fade it in
    }
});

let lastScrollTop = 0; // to store the last scroll position



///////HEADER DISSEPEAR//////
window.addEventListener("scroll", function() {
    let header = document.getElementById("header");
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    // If scrolling down
    if (currentScroll > lastScrollTop) {
        header.classList.add("header-hidden"); // hide the header
    } else {
        header.classList.remove("header-hidden"); // show the header
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Prevent negative scroll values
});



///////transition body//////
// Wait until the page is fully loaded
window.addEventListener('load', function() {
    // Add the 'loaded' class to the body to trigger the fade-in effect
    document.body.classList.add('loaded');
});





////video////
document.addEventListener("DOMContentLoaded", () => {
    const splashVideo = document.getElementById("splash-video");
    const mainContent = document.getElementById("main-content");

    // Hide the splash video and show main content after video ends or 3 seconds
    splashVideo.addEventListener("ended", () => {
        splashVideo.style.display = "none";
        mainContent.style.display = "block";
    });

    // Fallback in case video does not trigger "ended"
    setTimeout(() => {
        splashVideo.style.display = "none";
        mainContent.style.display = "block";
    }, 5000);
});
