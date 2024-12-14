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


document.addEventListener("DOMContentLoaded", () => {
    const mainContent = document.getElementById("main-content");
    const isClient = mainContent.getAttribute("data-is-client") === "true";

    // Désactiver le champ "Create Event" si l'utilisateur est un client
    if (isClient) {
        const createEventLink = document.querySelector('a[href="../evenement/create_event.html"]');
        if (createEventLink) {
            createEventLink.style.pointerEvents = "none"; // Désactive les clics
            createEventLink.style.opacity = "0.5"; // Grise le lien
            createEventLink.title = "Access réservé";
        }
    }
});



