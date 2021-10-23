<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paytabs Payment | Manarat</title>    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('public/assets/front/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/bootstrap.min.js') }}"></script>

@section('styles')
    <style>
        .PT_open_iframe{
            display:none !important;
        }
    </style>
</head>
<body>
<script src="https://www.paytabs.com/express/v4/paytabs-express-checkout.js"
        id="paytabs-express-checkout"
        data-secret-key="teY7r3ieVCxHOBi08bu324CtputrfqBIFAP6D8lzKThyuAyDM3GO7jhwOKY3bzMQaBXNJimubE2GeBj0E0OMk6j9Qhd2RZS1APOk"
        data-merchant-id="10067123"
        data-url-redirect="{{ route('paytabs_response') }}"
        data-url-cancel="{{ route('paytabs_cancel') }}"
        data-amount="{{round($order->pay_amount * $darham->value , 2)}}"
        data-currency="AED"
        data-title="{{$user->name}}"
        data-product-names="Products"
        data-order-id="{{ $order->id }}"
        data-customer-phone-number="{{$order->customer_phone}}"
        data-customer-email-address="{{$user->email}}"
        data-customer-country-code="973"
     >
     </script>

        <script>
            $(document).ready(function(){
                $('#en_button').click();
            });
        </script>
</body>
</html> -->

<!-- For Brisktrips -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paytabs Payment | Offer bazar</title>    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('public/assets/front/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/vendor/modernizr-3.7.1.min.js') }}"></script>
    <script src="{{ asset('public/assets/front/js/plugins.min.js') }}"></script>

@section('styles')
    <style>
        .PT_open_iframe{
            display:none !important;
        }
    </style>
</head>
<body>
<script src="https://www.paytabs.com/express/v4/paytabs-express-checkout.js"
        id="paytabs-express-checkout"
        data-secret-key="L1hEqAe5cREL64LHqb0KsyOeFMQxF10r3h5tSjz4adQhiCYIOZtgyhvd3lLJnLar3fVVzu0JHR0ZtZIiYbzwt4KxqvhOhrfkHagg"
        data-merchant-id="10068463"
        data-url-redirect="{{ route('paytabs_response') }}"
        data-url-cancel="{{ route('paytabs_cancel') }}"
        data-amount="{{round($order->pay_amount * $darham->value , 2)}}"
        data-currency="AED"
        data-title="{{$user->name}}"
        data-product-names="Products"
        data-order-id="{{ $order->id }}"
        data-customer-phone-number="{{$order->customer_phone}}"
        data-customer-email-address="{{$user->email}}"
        data-customer-country-code="973"
     >
     </script>

        <script>
            $(document).ready(function(){
                $('#en_button').click();
            });
        </script>
</body>
</html>


