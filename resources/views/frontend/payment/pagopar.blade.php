@extends('frontend.frontend_master')

@section('title')
    Al Araf Fashion - Stripe Page
@endsection

@section('frontend_style')

<style>

    /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;
  height: 40px;
  padding: 10px 12px;
  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}
.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}
.StripeElement--invalid {
  border-color: #fa755a;
}
.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;}
</style>
@endsection

@section('frontend_content')
    <div class="pagopar-box">
        <div class="row">
          <div class="col-md-9">
            <div class="container">
              <form action="/action_page.php">

                <div class="row">
                  <div class="col-md-6">
                    <h3>Billing Address</h3>
                    <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                    <input type="text" id="fname" name="firstname" placeholder="John M. Doe">
                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                    <input type="text" id="email" name="email" placeholder="john@example.com">
                    <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                    <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                    <label for="city"><i class="fa fa-institution"></i> City</label>
                    <input type="text" id="city" name="city" placeholder="New York">

                    <div class="row">
                      <div class="col-md-6">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" placeholder="NY">
                      </div>
                      <div class="col-md-6">
                        <label for="zip">Zip</label>
                        <input type="text" id="zip" name="zip" placeholder="10001">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 hidden">
                    <h3>Payment</h3>
                    <label for="fname">Accepted Cards</label>
                    <div class="icon-container">
                      <i class="fa fa-cc-visa" style="color:navy;"></i>
                      <i class="fa fa-cc-amex" style="color:blue;"></i>
                      <i class="fa fa-cc-mastercard" style="color:red;"></i>
                      <i class="fa fa-cc-discover" style="color:orange;"></i>
                    </div>
                    <label for="cname">Name on Card</label>
                    <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                    <label for="ccnum">Credit card number</label>
                    <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                    <label for="expmonth">Exp Month</label>
                    <input type="text" id="expmonth" name="expmonth" placeholder="September">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="expyear">Exp Year</label>
                        <input type="text" id="expyear" name="expyear" placeholder="2018">
                      </div>
                      <div class="col-md-6">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="352">
                      </div>
                    </div>
                  </div>

                </div>
                <label>
                  <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                </label>
                <input type="submit" value="Continue to checkout" class="btn">
              </form>
            </div>
          </div>
          <div class="col-md-3">
            <div class="container">
              <h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b>4</b></span></h4>
              <p><a href="#">Product 1</a> <span class="price">$15</span></p>
              <p><a href="#">Product 2</a> <span class="price">$5</span></p>
              <p><a href="#">Product 3</a> <span class="price">$8</span></p>
              <p><a href="#">Product 4</a> <span class="price">$2</span></p>
              <hr>
              <p>Total <span class="price" style="color:black"><b>${{ $cart_total }}</b></span></p>
            </div>

            <div class="container">
              <form action="{{ route('stripe.order') }}" method="post" id="payment-form">
                @csrf
                <div class="form-row">

                    <input type="hidden" name="shipping_name" value="{{ $data['shipping_name'] }}">
                    <input type="hidden" name="shipping_email" value="{{ $data['shipping_email'] }}">
                    <input type="hidden" name="shipping_phone" value="{{ $data['shipping_phone'] }}">
                    <input type="hidden" name="shipping_postCode" value="{{ $data['shipping_postCode'] }}">
                    <input type="hidden" name="division_id" value="{{ $data['division_id'] }}">
                    <input type="hidden" name="district_id" value="{{ $data['district_id'] }}">
                    <input type="hidden" name="state_id" value="{{ $data['state_id'] }}">
                    <input type="hidden" name="shipping_address" value="{{ $data['shipping_address'] }}">
                    <input type="hidden" name="shipping_notes" value="{{ $data['shipping_notes'] }}">

                    <!-- Used to display Element errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <br>
                <!-- <button class="btn btn-primary">Submit Payment</button> -->
              </form>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('frontend_script')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    // Create a Stripe client.
var stripe = Stripe('pk_test_51H8TlFIWhXor2KLbagYIph0uQXZ0LIyCTFJLjNgQeoq8IrIPW3KZjRkd1eMz6SPIAB9VaUdb2CKV3B3agInaiFVp004WznlHuO');
// Create an instance of Elements.
var elements = stripe.elements();
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});
// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);
  // Submit the form
  form.submit();
}
</script>
@endsection

