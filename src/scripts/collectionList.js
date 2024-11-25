// TASK 3 ========================================================================================

// Function to add product to collection list
function addToCollection() {
    const productName = document.querySelector("h1").innerText;
    const quantity = document.getElementById("quantity").value;
    const color = document.getElementById("color").value;
    const collectionItems = document.getElementById("collection-items");

    const listItem = document.createElement("li");
    listItem.innerText = `${productName} - Quantity: ${quantity} - Color: ${color}`;
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

function applyDiscount(discountRate) {
    if (discountRate < 0 || discountRate > 1) {
        console.error("Invalid discount rate. It should be between 0 and 1.");
        return;
    }

    const priceWOTaxElement = document.getElementById("priceWOTax");
    const priceWOTax = parseFloat(priceWOTaxElement.value) || 0; // Ensure 0 is used if input is empty or invalid

    const discountedPrice = priceWOTax * (1 - discountRate);
    const totalPriceWithTax = getTotalPrice(discountedPrice);

    document.getElementById("priceWithTax").innerText = `Price with Tax (Discounted): €${totalPriceWithTax.toFixed(2)}`;
    console.log(
        `Applied discount: ${discountRate * 100}%. Original price: €${priceWOTax.toFixed(2)}, Discounted price: €${discountedPrice.toFixed(
            2
        )}, Total price with tax: €${totalPriceWithTax.toFixed(2)}`
    );
}

function resetPrices() {
    const confirmation = confirm("Are you sure you want to reset the prices?");
    if (confirmation) {
        document.getElementById("priceWOTax").value = 1199;
        updatePrices();
        console.log("Prices have been reset to the default value.");
    } else {
        console.log("Price reset action was canceled.");
    }
}

function updatePrices() {
    const priceWOTax = parseFloat(document.getElementById("priceWOTax").value) || 0;
    const totalPriceWithTax = getTotalPrice(priceWOTax);
    document.getElementById("priceWithTax").innerText = `Price with Tax: €${totalPriceWithTax.toFixed(2)}`;
}

function clearCollection() {
    const confirmation = confirm("Are you sure you want to clear the collection list?");
    if (confirmation) {
        const collectionItems = document.getElementById("collection-items");
        collectionItems.innerHTML = "";
        console.log("Collection list has been cleared.");
    } else {
        console.log("Clear collection action was canceled.");
    }
}

// Add event listeners for discount and reset buttons
document.getElementById("apply-discount").addEventListener("click", () => applyDiscount(0.1));
document.getElementById("reset-prices").addEventListener("click", resetPrices);

// Initialize prices on page load
updatePrices();
