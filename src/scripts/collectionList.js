// Function to add product to collection list
function addToCollection() {
    const productName = document.querySelector("h1").innerText;
    const quantity = document.getElementById("quantity").value;
    const collectionItems = document.getElementById("collection-items");

    const listItem = document.createElement("li");
    listItem.innerText = `${productName} - Quantity: ${quantity}`;
    collectionItems.appendChild(listItem);
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
