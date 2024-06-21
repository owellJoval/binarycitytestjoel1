// Wait for the DOM to be ready
document.addEventListener("DOMContentLoaded", function () {
    // Function to generate a client code based on client name
    function generateClientCode(clientName) {
        // Convert client name to uppercase
        const upperCaseName = clientName.toUpperCase();
        // Remove spaces and non-alphanumeric characters
        const cleanedName = upperCaseName.replace(/[^a-zA-Z0-9]/g, "");
        // Ensure client code is 6 characters long
        const paddedCode = cleanedName.padEnd(6, "X");
        // Return the formatted client code
        return paddedCode.substring(0, 3) + "001";
    }

    // Function to handle client form submission
    function handleClientFormSubmit(event) {
        event.preventDefault(); // Prevent form submission
        const clientNameInput = document.getElementById("clientName");
        const clientCodeInput = document.getElementById("clientCode");

        // Generate client code based on client name
        const generatedCode = generateClientCode(clientNameInput.value);
        clientCodeInput.value = generatedCode; // Set the generated code in the form
        // Other form submission logic (e.g., AJAX request) can go here
    }

    // Attach event listener to client form submit button
    const clientForm = document.getElementById("clientForm");
    clientForm.addEventListener("submit", handleClientFormSubmit);

    // Function to handle contact form submission
    function handleContactFormSubmit(event) {
        event.preventDefault(); // Prevent form submission
        const emailInput = document.getElementById("email");

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            alert("Please enter a valid email address.");
            return;
        }

        // Other form submission logic (e.g., AJAX request) can go here
    }

    // Attach event listener to contact form submit button
    const contactForm = document.getElementById("contactForm");
    contactForm.addEventListener("submit", handleContactFormSubmit);
});
