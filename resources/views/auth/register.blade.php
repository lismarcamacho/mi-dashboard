<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Clave') }}" />
                <x-input id="password" class="block mt-1 w-full p-12" type="password" name="password" required
                    autocomplete="new-password" />
                {{-- Botón para ver/ocultar contraseña --}}
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    {{-- Puedes usar un icono de ojo aquí, por ejemplo, SVG o de una librería de iconos --}}
                    <svg id="eyeOpen" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeClosed" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .984 0 1.947.165 2.868.441M15 12a3 3 0 11-6 0 3 3 0 016 0zm0 0l-1.47 1.47M9 9l-1.47-1.47" />
                    </svg>
                </button>
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirme Clave') }}" />


                <x-input id="password_confirmation" class="block mt-1 w-full pr-12" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <button type="button" id="togglePasswordConfirmation"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    {{-- Puedes usar un icono de ojo aquí, por ejemplo, SVG o de una librería de iconos --}}
                    <svg id="eyeOpenConfirmation" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeClosedConfirmation" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .984 0 1.947.165 2.868.441M15 12a3 3 0 11-6 0 3 3 0 016 0zm0 0l-1.47 1.47M9 9l-1.47-1.47" />
                    </svg>
                </button>
                <x-input-error for="password_confirmation" class="mt-2" />


            </div>




            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Ya te registraste?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para aplicar la lógica de ver/ocultar a un campo de contraseña
        function setupPasswordToggle(inputId, toggleButtonId, eyeOpenId, eyeClosedId) {
            const toggleButton = document.getElementById(toggleButtonId);
            const passwordInput = document.getElementById(inputId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            if (toggleButton && passwordInput && eyeOpen && eyeClosed) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                    passwordInput.setAttribute('type', type);

                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }
        }

        // Configurar el campo de contraseña principal
        setupPasswordToggle('password', 'togglePassword', 'eyeOpen', 'eyeClosed');

        // Configurar el campo de confirmación de contraseña
        setupPasswordToggle('password_confirmation', 'togglePasswordConfirmation', 'eyeOpenConfirmation',
            'eyeClosedConfirmation');
    });
</script>
