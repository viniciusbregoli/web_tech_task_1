// TASK 3 ========================================================================================

// Function to add product to collection list
function addToCollection() {
    const productName = document.querySelector("h1").innerText;
    const quantity = document.getElementById("quantity").value;
    const collectionItems = document.getElementById("collection-items");

    const listItem = document.createElement("li");
    listItem.innerText = `${productName} - Quantity: ${quantity}`;
    collectionItems.appendChild(listItem);
}

// TASK 4 =======================================================================================

// FIRST PART

// Function to calculate price with taxes
function getTotalPrice(priceWOTax) {
    const taxRate = 0.19;
    return priceWOTax * (1 + taxRate);
}

// Function to update prices
function updatePrices() {
    const priceWOTax = parseFloat(document.getElementById("priceWOTax").value); // Ensure 0 is used if input is empty or invalid
    const priceWithTax = getTotalPrice(priceWOTax);

    document.getElementById("priceWithTax").innerText = `Price with Tax: €${priceWithTax.toFixed(2)}`;
}

// SECOND PART: ADDITIONAL FUNCTIONALITY

// Function to apply discount
function applyDiscount(discountRate) {
    const priceWOTax = parseFloat(document.getElementById("priceWOTax").value); // Ensure 0 is used if input is empty or invalid
    console.log(priceWOTax);
    const discountedPrice = priceWOTax * (1 - discountRate);

    document.getElementById("priceWithTax").innerText = `Price with Tax (Discounted): €${getTotalPrice(discountedPrice).toFixed(2)}`;
}

// Function to reset prices
function resetPrices() {
    document.getElementById("priceWOTax").value = 0;
    updatePrices();
}

// Function to clear the collection list
function clearCollection() {
    const collectionItems = document.getElementById("collection-items");
    collectionItems.innerHTML = "";
}

// Function to validate quantity input
function validateQuantity(input) {
    if (input.value < 1) {
        input.value = 1;
    }
}

// Add event listeners for discount and reset buttons
document.getElementById("apply-discount").addEventListener("click", () => applyDiscount(0.1));
document.getElementById("reset-prices").addEventListener("click", resetPrices);

// Initialize prices on page load
updatePrices();
