<button type="button" id="{{ $id }}" class="{{ $class }}">
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $buttonText }}
</button>

@push('scripts')
    <script type="text/javascript">
        document.getElementById('{{ $id }}').addEventListener('click', function () {
            password = generatePassword();
            document.getElementById('{{ $passwordInputId }}').value = password;
            @if($confirmationPasswordInputId)
                document.getElementById('{{ $confirmationPasswordInputId }}').value = password;
            @endif
            navigator.clipboard.writeText(password);
            this.textContent = '{{ $buttonSuccessText }}';
            this.setAttribute('disabled', '')
        });

        function generatePassword() {
            var length = {{ config('laravel-helpers.validation.min_password_length') }},
                uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                lowercase = 'abcdefghijklmnopqrstuvwxyz',
                numbers = '0123456789',
                symbols = '~`!@#$%^&*()_-+={[}]|\:;"\'<,>.?/',
                charset = uppercase + lowercase + numbers + symbols,
                password = '';

            for (var i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(getRandomInt(n));
            }

            password = password.replaceAt(getRandomInt(length), uppercase.charAt(getRandomInt(uppercase.length)))
            password = password.replaceAt(getRandomInt(length), lowercase.charAt(getRandomInt(lowercase.length)))
            password = password.replaceAt(getRandomInt(length), numbers.charAt(getRandomInt(numbers.length)))
            password = password.replaceAt(getRandomInt(length), symbols.charAt(getRandomInt(symbols.length)))

            return password;
        }

        function getRandomInt(max) {
            return Math.floor(Math.random() * max);
        }

        String.prototype.replaceAt = function(index, replacement) {
            return this.substring(0, index) + replacement + this.substring(index + replacement.length);
        }
    </script>
@endpush
