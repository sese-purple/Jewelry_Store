@extends('layout.main_page')

@section('title', 'Create Account - Elegant Jewelry & Co')

@section('content')
<div class="auth-container fade-in">
    <div class="auth-card">
        <!-- Header Section -->
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Create Account</h1>
            <p>Join our exclusive community and discover the world's finest jewelry</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="auth-alert auth-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="auth-alert auth-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (session('success'))
            <div class="auth-alert auth-alert-success">
                <i class="fas fa-check-circle"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="post" action="{{ route('store_user') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">
                    <i class="fas fa-user"></i>
                    Full Name
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       class="form-control {{ $errors->has('name') ? 'error' : '' }}" 
                       placeholder="Enter your full name"
                       value="{{ old('name') }}"
                       required
                       autocomplete="name">
                @if($errors->has('name'))
                    <span class="error-message">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i>
                    Email Address
                </label>
                <input type="email" 
                       name="email" 
                       id="email"
                       class="form-control {{ $errors->has('email') ? 'error' : '' }}" 
                       placeholder="Enter your email address"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email">
                @if($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    Password
                </label>
                <div class="password-input-wrapper">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="form-control {{ $errors->has('password') ? 'error' : '' }}" 
                           placeholder="Create a strong password"
                           required
                           autocomplete="new-password"
                           minlength="8">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-eye"></i>
                    </button>
                </div>
                @if($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
                <div class="password-requirements">
                    <small>Password must be at least 8 characters long</small>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    <i class="fas fa-lock"></i>
                    Confirm Password
                </label>
                <div class="password-input-wrapper">
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation"
                           class="form-control" 
                           placeholder="Confirm your password"
                           required
                           autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>
        </form>

       
        <!-- Footer -->
        <div class="auth-footer">
            <p>Already have an account? 
                <a href="{{ route('login') }}" class="auth-link">Sign In</a>
            </p>
        </div>
    </div>

    <!-- Side Image/Content -->
    <div class="auth-side">
        <div class="auth-side-image">
            <img src="{{ asset('images/products/registration.jpeg') }}" alt="Luxury Jewelry Collection" class="side-image">
            <div class="auth-side-overlay">
            </div>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: linear-gradient(135deg, var(--diamond-white) 0%, var(--tiffany-pale) 100%);
    margin: -2rem -2rem 0 -2rem;
    padding: 2rem;
    gap: 3rem;
    align-items: center;
}

.auth-card {
    background: var(--white);
    border-radius: var(--border-radius-large);
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    padding: 3rem;
    max-width: 500px;
    width: 100%;
    justify-self: end;
    border: 1px solid var(--light-gray);
    max-height: 90vh;
    overflow-y: auto;
}

.auth-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.auth-logo {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--luxury-gold), var(--tiffany-blue));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: var(--white);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.auth-header h1 {
    color: var(--deep-blue);
    margin-bottom: 0.5rem;
    font-size: 2rem;
    font-weight: 600;
}

.auth-header p {
    color: var(--warm-gray);
    font-size: 1rem;
    line-height: 1.5;
}

.auth-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.auth-alert-error {
    background: #ffeaea;
    border: 1px solid #ffcdd2;
    color: var(--danger);
}

.auth-alert-success {
    background: #e8f5e8;
    border: 1px solid #c8e6c9;
    color: var(--success);
}

.auth-alert i {
    font-size: 1.1rem;
    margin-top: 0.1rem;
}

.auth-alert p {
    margin: 0;
    line-height: 1.4;
}

.auth-form {
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--deep-blue);
    font-weight: 600;
    font-size: 0.9rem;
}

.form-group label i {
    color: var(--tiffany-blue);
    margin-right: 0.5rem;
    width: 16px;
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--warm-gray);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 4px;
    transition: var(--transition);
}

.password-toggle:hover {
    color: var(--tiffany-blue);
    background: var(--diamond-white);
}

.form-control.error {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(244, 67, 54, 0.1);
}

.error-message {
    display: block;
    color: var(--danger);
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

.password-requirements {
    margin-top: 0.5rem;
}

.password-requirements small {
    color: var(--warm-gray);
    font-size: 0.8rem;
}

.checkbox-wrapper {
    display: flex;
    align-items: flex-start;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--warm-gray);
    line-height: 1.4;
}

.checkbox-wrapper input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--light-gray);
    border-radius: 3px;
    margin-right: 0.75rem;
    margin-top: 0.1rem;
    position: relative;
    transition: var(--transition);
    flex-shrink: 0;
}

.checkbox-wrapper input[type="checkbox"]:checked + .checkmark {
    background: var(--tiffany-blue);
    border-color: var(--tiffany-blue);
}

.checkbox-wrapper input[type="checkbox"]:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: -2px;
    left: 2px;
    color: var(--white);
    font-size: 12px;
    font-weight: bold;
}

.btn-full {
    width: 100%;
    padding: 1rem;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.auth-divider {
    text-align: center;
    margin: 2rem 0;
    position: relative;
}

.auth-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--light-gray);
}

.auth-divider span {
    background: var(--white);
    padding: 0 1rem;
    color: var(--warm-gray);
    font-size: 0.9rem;
}

.social-login {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.btn-social {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid var(--light-gray);
    background: var(--white);
    color: var(--warm-gray);
    font-weight: 500;
    transition: var(--transition);
}

.btn-social:hover {
    border-color: var(--tiffany-blue);
    color: var(--tiffany-blue);
    transform: translateY(-1px);
}

.btn-google:hover {
    border-color: #db4437;
    color: #db4437;
}

.btn-facebook:hover {
    border-color: #4267B2;
    color: #4267B2;
}

.auth-footer {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--light-gray);
}

.auth-footer p {
    color: var(--warm-gray);
    margin: 0;
}

.auth-link {
    color: var(--tiffany-blue);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.auth-link:hover {
    color: var(--deep-blue);
    text-decoration: underline;
}

.auth-side {
    border-radius: var(--border-radius-large);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-side-image {
    position: relative;
    width: 100%;
    height: 100%;
    min-height: 600px;
}

.side-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--border-radius-large);
}



.auth-side-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--white);
    padding: 2rem;
}

.auth-side-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 300;
}

.auth-side-content p {
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    line-height: 1.6;
}

.auth-features {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.auth-feature {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 1rem;
    background: rgba(255,255,255,0.1);
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
}

.auth-feature i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--white);
}

.auth-feature span {
    font-size: 0.9rem;
    font-weight: 500;
}

.auth-testimonial {
    background: rgba(255,255,255,0.1);
    padding: 2rem;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
}

.auth-testimonial blockquote {
    font-size: 1.1rem;
    font-style: italic;
    margin: 0 0 1rem 0;
    line-height: 1.5;
}

.auth-testimonial cite {
    font-size: 0.9rem;
    opacity: 0.8;
}

@media (max-width: 1024px) {
    .auth-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .auth-card {
        justify-self: center;
        max-width: 600px;
        max-height: none;
    }
    
    .auth-side {
        order: -1;
        min-height: 400px;
    }
    
    .auth-features {
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .auth-feature {
        padding: 0.75rem 0.5rem;
    }
    
    .auth-feature i {
        font-size: 1.5rem;
    }
    
    .auth-feature span {
        font-size: 0.8rem;
    }
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem;
        margin: -1rem -1rem 0 -1rem;
    }
    
    .auth-card {
        padding: 2rem;
    }
    
    .auth-side-content h2 {
        font-size: 2rem;
    }
    
    .auth-features {
        grid-template-columns: 1fr 1fr;
    }
    
    .social-login {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .auth-card {
        padding: 1.5rem;
    }
    
    .auth-header h1 {
        font-size: 1.5rem;
    }
    
    .auth-testimonial {
        padding: 1.5rem;
    }
}
</style>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(inputId + '-eye');
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Password strength indicator
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.auth-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Password confirmation validation
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    }
});
</script>
@endsection
