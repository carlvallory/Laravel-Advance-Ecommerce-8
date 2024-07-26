@extends('frontend.frontend_master')

@section('title')
    Al Araf Fashion - Stripe Page
@endsection

@section('frontend_style')

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
                    <label for="fname"><i class="fa fa-user"></i> Nombre completo</label>
                    <input type="text" id="fname" name="firstname" placeholder="John M. Doe" value="{{ $data['shipping_name'] }}">
                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                    <input type="text" id="email" name="email" placeholder="john@example.com" value="{{ $data['shipping_email'] }}">
                    <label for="adr"><i class="fa fa-address-card-o"></i> Dirección </label>
                    <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" value="{{ $data['shipping_address'] }}">
                    <label for="city"><i class="fa fa-institution"></i> Ciudad</label>
                    <input type="text" id="city" name="city" placeholder="New York">

                    <div class="row">
                      <div class="col-md-6">
                        <label for="state">Departamento</label>
                        <input type="text" id="state" name="state" placeholder="NY">
                      </div>
                      <div class="col-md-6">
                        <label for="zip">Zip</label>
                        <input type="text" id="zip" name="zip" placeholder="10001" value="{{ $data['shipping_postCode'] }}">
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
<script type="text/javascript">

</script>
@endsection

