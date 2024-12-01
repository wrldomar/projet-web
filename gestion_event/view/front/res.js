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

// Request permission for notifications
if ("Notification" in window) {
  Notification.requestPermission().then(function (permission) {
    if (permission === "granted") {
      console.log("Notification permission granted.");
    }
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

    if (isValid) {
      // Form is valid, show success message
      alert("Your reservation was successful!");

      // Show notification with reservation details
      const title = "Reservation Successful!";
      const options = {
        body: `Event: ${document.getElementById("event-name").value}\nDate: ${
          document.getElementById("event-date").value
        }\nTickets: ${document.getElementById("tickets").value}`,
        icon: "notification-icon.png", // Replace with your icon
        tag: "reservation-notification",
      };

      if (Notification.permission === "granted") {
        new Notification(title, options);
      }

      // Optionally, submit the form here using fetch() for asynchronous submission
      document.querySelector("form").submit();
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
