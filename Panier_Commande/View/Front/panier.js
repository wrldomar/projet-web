document.addEventListener('DOMContentLoaded', () => {
    // Select elements
    const cartItems = document.querySelectorAll('.cart-item');
    const totalPriceElement = document.querySelector('.cart-total');

    // Function to update total price
    function updateTotal() {
        let total = 0;
        cartItems.forEach((item) => {
            const price = parseFloat(item.querySelector('.item-price').textContent.replace('$', ''));
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            total += price * quantity;
        });
        totalPriceElement.textContent = `$${total.toFixed(2)}`;
    }

    // Add event listeners to buttons
    cartItems.forEach((item) => {
        const quantityInput = item.querySelector('.quantity-input');
        const decreaseButton = item.querySelector('.quantity-button:first-child'); // First button (-)
        const increaseButton = item.querySelector('.quantity-button:last-child'); // Last button (+)
        const removeButton = item.querySelector('.remove-button');

        // Decrease quantity
        decreaseButton.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
                updateTotal();
            }
        });

        // Increase quantity
        increaseButton.addEventListener('click', () => {
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
            updateTotal();
        });

        // Remove item
        removeButton.addEventListener('click', () => {
            item.remove(); // Remove the item from the DOM
            updateTotal(); // Recalculate total
        });
    });

    // Initial total calculation
    updateTotal();
});
