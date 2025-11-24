document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const updateCartCount = () => {
        document.getElementById('cart-count').textContent = cart.length;
    };
    updateCartCount();

    // Add to cart
   document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
        const product = {
            id: btn.dataset.id,
            name: btn.dataset.name,
            price: btn.dataset.price,
            image: btn.dataset.image  // add this
        };
        cart.push(product);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        alert(`${product.name} added to cart!`);
    });
});


    // Price filter
    const priceFilter = document.getElementById('price-filter');
    const priceValue = document.getElementById('price-value');

    priceFilter.addEventListener('input', () => {
        const maxPrice = parseFloat(priceFilter.value);
        priceValue.textContent = maxPrice;

        document.querySelectorAll('.product-card').forEach(card => {
            const price = parseFloat(card.dataset.price);
            card.style.display = price <= maxPrice ? 'block' : 'none';
        });
    });
});
