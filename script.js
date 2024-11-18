// Reservation Form Validation and Submission Confirmation
document.querySelector('form').addEventListener('submit', function(event) {
    // Perform validation
    const name = document.getElementById('name').value.trim();  // Trim to remove any extra spaces
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const guests = document.getElementById('guests').value;
    const slots = document.getElementById('slots').value;

    // Basic validation for empty fields
    if (name === "" || date === "" || time === "" || guests === "" || slots === "") {
        alert("Please fill in all fields.");
        event.preventDefault();  // Prevent submission if validation fails
        return false;
    }

    // Check if guests number is valid (greater than 0)
    if (parseInt(guests) <= 0 || isNaN(guests)) {
        alert("Please enter a valid number of guests.");
        event.preventDefault();  // Prevent submission if validation fails
        return false;
    }

    // If validation passes, PHP will handle form submission
});

