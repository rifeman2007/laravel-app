<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo"></x-slot>

        <div class="mb-10 text-sm text-center text-gray-600">            
            <h1 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Payment') }}
            </h1>
        </div>        

        <div class="mb-5 error-message" style="display: none;">
            <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600"></ul>
        </div>
        
        <form method="POST" action="{{ route('payment') }}">
            <div>
                <x-jet-label for="name" value="{{ __('Card Holder Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" id="card-holder-name" name="card-holder-name" :value="old('name')" required="required" autofocus />
            </div>

            <div class="mt-10">
                <div id="card-element"></div>
            </div>

            <div class="flex items-center text-center justify-end mt-10">
                <button id="card-button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                    Process Payment
                </button>
            </div>
        </form>        
    </x-jet-authentication-card>   
    @push('body-stack')    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script type="text/javascript" defer>
            window.addEventListener('DOMContentLoaded', () => {
                const stripe = Stripe('{{ $stripe_public_key }}');

                const elements = stripe.elements();
                const cardElement = elements.create('card');

                cardElement.mount('#card-element');

                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');

                cardButton.addEventListener('click', async (e) => {
                    e.preventDefault();

                    clearErrorMessage();

                    if ($('#card-holder-name').val().length === 0) {
                        addErrorMessage('Card Holder Name is required.');
                    }

                    const { paymentMethod, error } = await stripe.createPaymentMethod(
                        'card', cardElement, {
                            billing_details: { name: cardHolderName.value }
                        }
                    );

                    if (error) {                        
                        addErrorMessage(error.message);
                    } else {
                        $.ajax({
                            url: '{{ route('payment.post') }}',
                            type: 'POST',
                            data: {_token: "{{ csrf_token() }}", payment_method_id: paymentMethod.id},
                        }).done(function(data) {
                            if (data.success == false) {
                                addErrorMessage(data.error.message);
                            } else {
                                window.location.href = '{{ route('dashboard') }}';
                            }                            
                        });
                    }
                });

                function clearErrorMessage() {
                    $('.list-inside').html();
                    $('.list-inside').closest('.error-message').attr('style', 'display: none;');
                }

                function addErrorMessage(message) {
                    $('.list-inside').html('<li>'+message+'</li>');
                    $('.list-inside').closest('.error-message').removeAttr('style');
                }
            });
        </script>
    @endpush     
</x-guest-layout>


