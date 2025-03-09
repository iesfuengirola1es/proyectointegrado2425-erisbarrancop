document.addEventListener("DOMContentLoaded", function () {
    var amountField = document.getElementById("amount");
    var artistEmail = document.getElementById("artist-email").value;
    var trackFile = document.getElementById("track-file").value; // Get the track URL

    // Update the amount when a preset button is clicked
    var presetButtons = document.querySelectorAll(".preset-amount");
    presetButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var amount = button.getAttribute("data-amount");
            amountField.value = amount;  // Update the hidden field
        });
    });

    // Update the amount when a custom amount is entered
    var customAmountInput = document.getElementById("custom-amount-input");
    customAmountInput.addEventListener("input", function () {
        var customAmount = customAmountInput.value;
        if (parseFloat(customAmount) >= 1) {
            amountField.value = customAmount;  // Update the hidden field with custom amount
        }
    });

    // PayPal button setup
    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: amountField.value, // Use the selected or custom amount
                        currency_code: 'EUR'  // Set currency to EUR
                    },
                    payee: {
                        email_address: artistEmail // Dynamic PayPal email
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert("Payment successful! Transaction ID: " + details.id);

                // Trigger the download of the track
                if (trackFile) {
                    var a = document.createElement("a");
                    a.href = trackFile;
                    a.download = trackFile.split("/").pop(); // Set the filename for the download
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            });
        },
        onError: function (err) {
            console.error("PayPal error:", err);
            alert("Payment failed. Please try again.");
        }
    }).render("#paypal-button-container");

    
});
