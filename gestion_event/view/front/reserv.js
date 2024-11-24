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
  field.addEventListener("input", function () {
    const value = field.value;
    if (validationFn(value)) {
      message.textContent = successMessage;
      message.style.color = "green";
    } else {
      message.textContent = errorMessage;
      message.style.color = "red";
    }
  });
}

// Validation functions for each field
const firstNameValid = (value) => value.length >= 3 && value !== "";
const lastNameValid = (value) => value.length >= 3 && value !== "";
const emailValid = (value) => /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(value);
const phoneValid = (value) =>/^[0-9]+$/.test(value) && value !== "" && value.length >= 8;
const ticketsValid = (value) => value > 0 && value !== "";

// Attach validation to input fields
validateField(
  "first-name",
  "first-name-message",
  firstNameValid,
  "First name looks good!",
  "not valid at least 3 characters."
);
validateField(
  "last-name",
  "last-name-message",
  lastNameValid,
  "Last name looks good!",
  "not valid at least 3 characters."
);
validateField(
  "email",
  "email-message",
  emailValid,
  "Email is valid!",
  "not valid email address."
);
validateField(
  "phone",
  "phone-message",
  phoneValid,
  "Phone number looks good!",
  "Phone number not valid."
);
validateField(
  "tickets",
  "tickets-message",
  ticketsValid,
  "Tickets count looks good!",
  "not valid number of tickets."
);

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
      // Form is valid, submit the form
      document.querySelector("form").submit();
    } else {
      // Form is not valid, show alert and prevent submission
      alert("Please fix the errors before submitting.");
      event.preventDefault(); // Prevent form submission
    }
  });
