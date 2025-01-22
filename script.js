/*Nevigation*/
function toggleMenu() {
    const nav = document.querySelector('header nav');
    nav.classList.toggle('active');
}

// Dropdown Menu Interaction
const dropdowns = document.querySelectorAll('.dropdown');
dropdowns.forEach(dropdown => {
    dropdown.addEventListener('mouseover', () => {
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        dropdownContent.style.display = 'block';
    });

    dropdown.addEventListener('mouseout', () => {
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        dropdownContent.style.display = 'none';
    });
});

/*HeroSection*/
const slides = document.querySelectorAll('.slide');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');
let index = 0;

function showSlide(i) {
    slides.forEach((slide, idx) => {
        slide.style.transform = `translateX(-${i * 100}%)`;
        slide.classList.toggle('active', idx === i);
    });
}

function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide(index);
}

function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    showSlide(index);
}

prev.addEventListener('click', prevSlide);
next.addEventListener('click', nextSlide);

// Auto-slide every 5 seconds
setInterval(nextSlide, 5000);

// Script for Animating Add to Cart Button (Optional)
document.querySelectorAll('.add-to-cart-btn').forEach((button) => {
  button.addEventListener('click', () => {
    button.textContent = "Added!";
    button.style.backgroundColor = "#28a745";
    setTimeout(() => {
      button.textContent = "Add to Cart";
      button.style.backgroundColor = "#007bff";
    }, 1500);
  });
});

// Highlight the category name on hover (Optional)
document.querySelectorAll('.category-card').forEach((card) => {
  card.addEventListener('mouseenter', () => {
    card.querySelector('.category-name').style.background = " linear-gradient(to right, #1f1c2c, #928DAB)";
    card.querySelector('.category-name').style.color = "#fff";
  });

  card.addEventListener('mouseleave', () => {
    card.querySelector('.category-name').style.background = "rgba(0, 0, 0, 0.6)";
    card.querySelector('.category-name').style.color = "#fff";
  });
});


// Newsletter Form Submission Handler
document.querySelector('.newsletter-form').addEventListener('submit', function (e) {
  e.preventDefault();
  alert('Thank you for subscribing to our newsletter!');
});


/*Shop Page*/
document.addEventListener("DOMContentLoaded", () => {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const viewDetailsButtons = document.querySelectorAll(".view-details");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", () => {
      alert("Item added to the cart!");
    });
  });

  viewDetailsButtons.forEach((button) => {
    button.addEventListener("click", () => {
      alert("Viewing product details!");
    });
  });
});


// Cart page functionality
document.addEventListener('DOMContentLoaded', function() {
    // Function to update the total price of the cart
    function updateTotalPrice() {
        const cartItems = document.querySelectorAll('.cart-table tr');
        let total = 0;
        cartItems.forEach(item => {
            // Get price and quantity
            const price = parseFloat(item.querySelector('td:nth-child(2)').innerText.replace('$', ''));
            const quantity = item.querySelector('.quantity').value;
            const itemTotal = price * quantity;
            item.querySelector('.item-total').innerText = `$${itemTotal.toFixed(2)}`;
            total += itemTotal;
        });
        document.getElementById('total-price').innerText = `$${total.toFixed(2)}`;
    }

    // Update the total price initially
    updateTotalPrice();

    // Event listener to update total price when quantity is changed
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotalPrice);
    });

    // Remove item from cart
    const removeButtons = document.querySelectorAll('.remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove the row that contains the clicked "Remove" button
            const row = this.closest('tr');
            row.remove();
            // Recalculate the total price after removal
            updateTotalPrice();
        });
    });
});





// Signup form validation
document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Validate register fields
    const fullName = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const phone = document.getElementById('register-phone').value;
    const password = document.getElementById('register-password').value;

    if (!fullName || !email || !phone || !password) {
        alert('Please fill in all fields.');
        return;
    }

    alert('Signup successful! Please login to your account.');
    // Optionally, reset the form
    document.getElementById('register-form').reset();
});

// Login form validation
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // Validate login fields
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    if (!email || !password) {
        alert('Please fill in all fields.');
        return;
    }

    alert('Login successful!');
    // Optionally, reset the form or redirect to a different page
    document.getElementById('login-form').reset();
});

// Switch to Register form when link is clicked
document.getElementById('switch-to-register').addEventListener('click', function() {
    document.querySelector('.login-form').style.display = 'none';
    document.querySelector('.register-form').style.display = 'block';
});


//productdetails
// Script to switch main image on thumbnail click
document.querySelectorAll('.thumbnail').forEach(thumbnail => {
    thumbnail.addEventListener('click', function() {
        // Change the main image to the clicked thumbnail's image
        const mainImage = document.getElementById('main-image');
        mainImage.src = this.src;
        
        // Remove the 'selected' class from all thumbnails
        document.querySelectorAll('.thumbnail').forEach(item => item.classList.remove('selected'));
        
        // Add 'selected' class to the clicked thumbnail
        this.classList.add('selected');
    });
});

//showing password

