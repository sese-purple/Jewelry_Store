<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Elegant Jewelry & Watches')</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <nav class="navbar">
            <div class="container">
                <a href="{{ route('welcome') }}" class="brand">
                    <i class="fas fa-gem"></i> Elegant Jewelry & Co
                </a>
                <ul class="menu">
                    <li><a href="{{ route('welcome') }}">Home</a></li>
                    <li><a href="{{ route('all_products') }}">Jewelry</a></li>
                    @auth
<li><a href="{{ route('wishlist.index') }}" class="nav-icon">
    <i class="fas fa-heart"></i> Wishlist
    <span class="wishlist-count" id="wishlistCount">{{ auth()->user()->wishlist_count ?? 0 }}</span>
</a></li>
                        <li><a href="{{ route('cart.index') }}" class="nav-icon">
                            <i class="fas fa-shopping-bag"></i> Cart
                            <span class="cart-count" id="cartCount">{{ auth()->user()->cart_count ?? 0 }}</span>
                        </a></li>
                        <li><a href="{{ route('orders.index') }}">Orders</a></li>
                        <li><a href="{{ route('logout') }}">Sign Out</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('registration_form') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
        <main>
            <div class="container">
                @if (session('message'))
                    <div class="success">
                        <i class="fas fa-check-circle"></i> {{session('message')}}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $one_error)
                                <li>{{$one_error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} Elegant Jewelry & Co. A legacy of exceptional craftsmanship and timeless design.</p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem; opacity: 0.8;">
                <i class="fas fa-gem" style="color: var(--tiffany-blue);"></i> 
                Luxury • Elegance • Forever
            </p>
            
            @auth
                <!-- Discrete Admin Panel -->
                <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.8rem; opacity: 0.7;">
                    <p style="margin-bottom: 0.5rem;">Store Management:</p>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('product_form') }}" style="color: var(--tiffany-blue); text-decoration: none; padding: 0.25rem 0.5rem; border: 1px solid var(--tiffany-blue); border-radius: 3px; transition: var(--transition);"
                           onmouseover="this.style.background='var(--tiffany-blue)'; this.style.color='white';" 
                           onmouseout="this.style.background='transparent'; this.style.color='var(--tiffany-blue)';">
                            Add Product
                        </a>
                    </div>
                </div>
            @endauth
    </footer>

    <!-- Wishlist Notification Script -->
    <script>
        function showWishlistNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                ${message}
            `;
            
            // Add styles
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                background: ${type === 'success' ? 'var(--success)' : 'var(--error)'};
                color: white;
                border-radius: var(--radius);
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 500;
                animation: slideInRight 0.3s ease-out;
            `;
            
            // Add to body
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Listen for wishlist events
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a wishlist message in session
            @if(session('wishlist_message'))
                showWishlistNotification('{{ session("wishlist_message") }}');
            @endif
            
            // Handle AJAX wishlist requests
            document.addEventListener('click', function(e) {
                if (e.target.closest('[data-wishlist-toggle]')) {
                    e.preventDefault();
                    const button = e.target.closest('[data-wishlist-toggle]');
                    const productId = button.dataset.productId;
                    const url = `/wishlist/toggle/${productId}`;
                    
                    // Show loading state
                    const originalHtml = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show notification
                        showWishlistNotification(data.message);
                        
                        // Update wishlist count
                        const wishlistCount = document.getElementById('wishlistCount');
                        if (wishlistCount) {
                            const currentCount = parseInt(wishlistCount.textContent);
                            if (data.status === 'added') {
                                wishlistCount.textContent = currentCount + 1;
                            } else {
                                wishlistCount.textContent = Math.max(0, currentCount - 1);
                            }
                        }
                        
                        // Update button state
                        if (data.status === 'added') {
                            button.innerHTML = '<i class="fas fa-heart"></i> Remove from Wishlist';
                            button.classList.add('wishlist-active');
                        } else {
                            button.innerHTML = '<i class="fas fa-heart"></i> Add to Wishlist';
                            button.classList.remove('wishlist-active');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showWishlistNotification('An error occurred', 'error');
                        button.innerHTML = originalHtml;
                    })
                    .finally(() => {
                        button.disabled = false;
                    });
                }
            });
        });
    </script>
</body>
</html>
