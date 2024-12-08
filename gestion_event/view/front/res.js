// Function to handle real-time validation of form fields
function validateField(
  fieldId,
  messageId,
  validationFn,
  successMessage,
  errorMessage
) {
  const field = document.getElementById(fieldId);
  const message = document.getElementById(messageId);

  // Attach 'input' event listener for real-time validation
  field.addEventListener("input", function () {
    const value = field.value;
    if (validationFn(value)) {
      message.textContent = successMessage;
      message.style.color = "green"; // Success color
    } else {
      message.textContent = errorMessage;
      message.style.color = "red"; // Error color
    }
  });
}

// Validation functions for each field
const firstNameValid = (value) => value.length >= 3 && value !== "";
const lastNameValid = (value) => value.length >= 3 && value !== "";
const emailValid = (value) => /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(value);
const phoneValid = (value) =>
  /^[0-9]+$/.test(value) && value.length >= 8 && value !== "";
const ticketsValid = (value) => value > 0 && value !== "";

// Attach validation to input fields
validateField(
  "first-name",
  "first-name-message",
  firstNameValid,
  "First name looks good!",
  "Not valid, at least 3 characters."
);
validateField(
  "last-name",
  "last-name-message",
  lastNameValid,
  "Last name looks good!",
  "Not valid, at least 3 characters."
);
validateField(
  "email",
  "email-message",
  emailValid,
  "Email is valid!",
  "Not a valid email address."
);
validateField(
  "phone",
  "phone-message",
  phoneValid,
  "Phone number looks good!",
  "Phone number is not valid."
);
validateField(
  "tickets",
  "tickets-message",
  ticketsValid,
  "Ticket count looks good!",
  "Not a valid number of tickets."
);

// Function to load reCAPTCHA and append the token to the form
function loadReCaptcha() {
  const siteKey = "YOUR_SITE_KEY"; // Replace with your reCAPTCHA site key
  grecaptcha.ready(function () {
    grecaptcha.execute(siteKey, { action: "submit" }).then(function (token) {
      document.getElementById("g-recaptcha-response").value = token;
    });
  });
}

// Check form validity before submission
document
  .querySelector(".reserve-btn")
  .addEventListener("click", function (event) {
    const isValid =
      firstNameValid(document.getElementById("first-name").value) &&
      lastNameValid(document.getElementById("last-name").value) &&
      emailValid(document.getElementById("email").value) &&
      phoneValid(document.getElementById("phone").value) &&
      ticketsValid(document.getElementById("tickets").value);

    const captchaToken = document.getElementById("g-recaptcha-response").value;
    const captchaMessage = document.getElementById("recaptcha-message");

    if (!captchaToken) {
      // Display message if reCAPTCHA is not filled
      captchaMessage.textContent = "reCAPTCHA is required!";
      captchaMessage.style.color = "red";
      event.preventDefault(); // Prevent form submission
      return;
    } else {
      captchaMessage.textContent = ""; // Clear error message if reCAPTCHA is filled
    }

    if (isValid) {
      // Load reCAPTCHA token
      loadReCaptcha();

      // Optionally, submit the form here using fetch() for asynchronous submission
      setTimeout(() => {
        document.querySelector("form").submit(); // Submit form after token is ready
      }, 1000); // Delay form submission to allow reCAPTCHA token generation
    } else {
      // Form is not valid, show alert and prevent submission
      alert("Please fix the errors before submitting.");
      event.preventDefault(); // Prevent form submission
    }
  });

// Add the event listener for form submission and display success message
document
  .getElementById("reservation-form")
  .addEventListener("submit", function (e) {
    // Prevent the form from submitting immediately
    e.preventDefault();

    // Check if the form is valid
    const isValid =
      firstNameValid(document.getElementById("first-name").value) &&
      lastNameValid(document.getElementById("last-name").value) &&
      emailValid(document.getElementById("email").value) &&
      phoneValid(document.getElementById("phone").value) &&
      ticketsValid(document.getElementById("tickets").value);

    const captchaToken = document.getElementById("g-recaptcha-response").value;
    const captchaMessage = document.getElementById("recaptcha-message");

    if (!captchaToken) {
      // Display message if reCAPTCHA is not filled
      captchaMessage.textContent = "reCAPTCHA is required!";
      captchaMessage.style.color = "red";
      e.preventDefault(); // Prevent form submission
      return;
    } else {
      captchaMessage.textContent = ""; // Clear error message if reCAPTCHA is filled
    }

    if (isValid) {
      // Show the success message
      const successMessage = document.createElement("div");
      successMessage.id = "success-message";
      successMessage.style.color = "green";
      successMessage.textContent = "Reservation successful!";
      document.querySelector(".reservation-form").appendChild(successMessage);

      // Optionally, submit the form asynchronously using fetch (to prevent page reload)
      setTimeout(() => {
        e.target.submit(); // Submit form after success message is shown
      }, 2000); // Delay form submission by 2 seconds to show success message
    } else {
      alert("Please fix the errors before submitting.");
      e.preventDefault(); // Prevent form submission
    }
  });
