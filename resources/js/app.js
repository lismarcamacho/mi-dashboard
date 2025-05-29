import './bootstrap';


// resources/js/app.js

// ... otros imports o código existente ... REVISAR ERROR

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');
    const eyeIcon = togglePasswordButton ? togglePasswordButton.querySelector('i') : null;
    const showPasswordLabel = document.getElementById('showPasswordLabel');

    if (togglePasswordButton) {
        togglePasswordButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                if (eyeIcon) {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
                if (showPasswordLabel) {
                    showPasswordLabel.textContent = "{{ __('Ocultar contraseña') }}";
                }
            } else {
                passwordInput.type = 'password';
                if (eyeIcon) {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
                if (showPasswordLabel) {
                    showPasswordLabel.textContent = "{{ __('Mostrar contraseña') }}";
                }
            }
        });
    }
});
