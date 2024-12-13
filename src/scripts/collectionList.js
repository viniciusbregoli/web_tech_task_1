// Function to add product to collection list
function addToCollection(productId) {
    const collectionItems = document.getElementById("collection-items");

    if (productId === "product1" && document.getElementById("quantity1")) {
        const productName1 = document.querySelector("h1").innerText.split(" & ")[0];
        const quantity1 = document.getElementById("quantity1").value;
        const color1 = document.getElementById("color1").value;
        const storage1 = document.querySelector('input[name="storage1"]:checked').value;

        const listItem1 = document.createElement("li");
        listItem1.innerText = `${productName1} - Quantity: ${quantity1} - Color: ${color1} - Storage: ${storage1}GB`;
        collectionItems.appendChild(listItem1);
    }

    if (productId === "product2" && document.getElementById("quantity2")) {
        const productName2 = document.querySelector("h1").innerText.split(" & ")[1];
        const quantity2 = document.getElementById("quantity2").value;
        const color2 = document.getElementById("color2").value;
        const storage2 = document.querySelector('input[name="storage2"]:checked').value;

        const listItem2 = document.createElement("li");
        listItem2.innerText = `${productName2} - Quantity: ${quantity2} - Color: ${color2} - Storage: ${storage2}GB`;
        collectionItems.appendChild(listItem2);
    }
}

// Function to calculate price with taxes
function getTotalPrice(priceWOTax) {
    const taxRate = 0.19;
    return priceWOTax * (1 + taxRate);
}

// Function to update prices
function updatePrices() {
    const taxRate = 0.19;

    if (document.getElementById("priceWOTax1")) {
        const priceWOTax1 = parseFloat(document.getElementById("priceWOTax1").value) || 0;
        const totalPriceWithTax1 = priceWOTax1 * (1 + taxRate);
        document.getElementById("priceWithTax1").innerText = `Price with Tax: €${totalPriceWithTax1.toFixed(2)}`;

        // Store value in hidden input
        document.getElementById("priceWithTaxInput1").value = totalPriceWithTax1.toFixed(2);
    }

    if (document.getElementById("priceWOTax2")) {
        const priceWOTax2 = parseFloat(document.getElementById("priceWOTax2").value) || 0;
        const totalPriceWithTax2 = priceWOTax2 * (1 + taxRate);
        document.getElementById("priceWithTax2").innerText = `Price with Tax: €${totalPriceWithTax2.toFixed(2)}`;

        // Store value in hidden input
        document.getElementById("priceWithTaxInput2").value = totalPriceWithTax2.toFixed(2);
    }
}
function applyDiscount(discountRate) {
    if (discountRate < 0 || discountRate > 1) {
        console.error("Invalid discount rate. It should be between 0 and 1.");
        return;
    }

    if (document.getElementById("priceWOTax1")) {
        const priceWOTaxElement1 = document.getElementById("priceWOTax1");
        const priceWOTax1 = parseFloat(priceWOTaxElement1.value) || 0;
        const discountedPrice1 = priceWOTax1 * (1 - discountRate);
        const totalPriceWithTax1 = getTotalPrice(discountedPrice1);
        document.getElementById("priceWithTax1").innerText = `Price with Tax (Discounted): €${totalPriceWithTax1.toFixed(2)}`;
    }

    if (document.getElementById("priceWOTax2")) {
        const priceWOTaxElement2 = document.getElementById("priceWOTax2");
        const priceWOTax2 = parseFloat(priceWOTaxElement2.value) || 0;
        const discountedPrice2 = priceWOTax2 * (1 - discountRate);
        const totalPriceWithTax2 = getTotalPrice(discountedPrice2);
        document.getElementById("priceWithTax2").innerText = `Price with Tax (Discounted): €${totalPriceWithTax2.toFixed(2)}`;
    }
}

function resetPrices() {
    const confirmation = confirm("Are you sure you want to reset the prices?");
    if (confirmation) {
        if (document.getElementById("priceWOTax1")) {
            const originalPrice1 = document.getElementById("priceWOTax1").getAttribute("data-original-price");
            document.getElementById("priceWOTax1").value = originalPrice1;
        }
        if (document.getElementById("priceWOTax2")) {
            const originalPrice2 = document.getElementById("priceWOTax2").getAttribute("data-original-price");
            document.getElementById("priceWOTax2").value = originalPrice2;
        }
        updatePrices();
        console.log("Prices have been reset to the original values.");
    } else {
        console.log("Price reset action was canceled.");
    }
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
if (document.getElementById("apply-discount1")) {
    document.getElementById("apply-discount1").addEventListener("click", () => applyDiscount(0.1));
}
if (document.getElementById("apply-discount2")) {
    document.getElementById("apply-discount2").addEventListener("click", () => applyDiscount(0.1));
}
if (document.getElementById("reset-prices1")) {
    document.getElementById("reset-prices1").addEventListener("click", resetPrices);
}
if (document.getElementById("reset-prices2")) {
    document.getElementById("reset-prices2").addEventListener("click", resetPrices);
}

// Initialize prices on page load
updatePrices();
