// Get the header element
const header = document.querySelector('header');

// Variable to track the last scroll position
let lastScrollY = window.scrollY;

// Function to handle scroll events
function handleScroll() {
    if (window.scrollY > lastScrollY) {
        // Scrolling down: hide the header
        header.classList.add('hidden');
    } else {
        // Scrolling up: show the header
        header.classList.remove('hidden');
    }

    // Update the last scroll position
    lastScrollY = window.scrollY;
}

// Add event listener for scroll events
window.addEventListener('scroll', handleScroll);
