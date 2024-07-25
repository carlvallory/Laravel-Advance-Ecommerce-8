@extends('frontend.frontend_master')

@section('title')
    Nacion Media - Checkout Page
@endsection

@section('frontend_content')
    <div class="checkout-box">
        <div class="row">
            <form class="shipping-form" method="POST" action="{{ route('checkout.store') }}">
                @csrf
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">

                            <div id="collapseOne" class="panel-collapse collapse in">
                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">

                                        <!-- guest-login -->
                                        <div class="col-md-6 col-sm-6 already-registered-login">
                                            <h4 class="checkout-subtitle"><b>Shipping Address</b></h4>

                                                <div class="form-group">
                                                    <label class="info-title" for="shippingName">Shipping
                                                        Name<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input"
                                                        id="shippingName" placeholder="Enter your name here"
                                                        name="shipping_name" value="{{ Auth::user()->name }}">
                                                        @error('shipping_name')
                                                            <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="shippingEmail">Shipping email
                                                        <span>*</span></label>
                                                    <input type="email" class="form-control unicase-form-control text-input"
                                                        id="shippingEmail" placeholder="Enter your email here"
                                                        name="shipping_email" value="{{ Auth::user()->email }}">
                                                        @error('shipping_email')
                                                            <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="shippingPhone">Shipping
                                                        Phone<span>*</span></label>
                                                    <input type="phone" class="form-control unicase-form-control text-input"
                                                        id="shippingPhone" placeholder="Enter your phone number"
                                                        name="shipping_phone" value="{{ Auth::user()->phone_number }}">
                                                        @error('shipping_phone')
                                                            <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="shippingPostCode">Shipping Post
                                                        Code<span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input"
                                                        id="shippingPostCode" placeholder="Enter your name here"
                                                        name="shipping_postCode">
                                                        @error('shipping_postCode')
                                                            <span class="alert text-danger">{{ $message }}</span>
                                                        @enderror
                                                </div>
                                        </div>
                                        <!-- guest-login -->

                                        <!-- already-registered-login -->
                                        <div class="col-md-6 col-sm-6 already-registered-login">
                                            <h4 class="checkout-subtitle"><b>Address Bar</b></h4>

                                            <div class="form-group">
                                                <h5>Departamento<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="hidden" name="division_id" value="1">
                                                    <select class="custom-select form-control unicase-form-control" aria-label="State Select" name="state_id">
                                                        <option selected="" disabled="">Select state Name</option>
                                                        <option value="18">Asunción</option>
                                                    </select>
                                                </div>
                                                @error('state_id')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <h5>Ciudad <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select class="custom-select form-control unicase-form-control" aria-label="District Select" name="district_id">
                                                        <option selected="" disabled="">Select district Name</option>
                                                        <option value="1">Asunción</option>
                                                    </select>
                                                </div>
                                                @error('district_id')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <label class="info-title" for="shippingAddrees">Shipping
                                                Addres<span>*</span></label>
                                            <textarea name="shipping_address" id="" cols="30" rows="10"
                                                class="form-control unicase-form-control text-input" id="shippingAddrees"
                                                placeholder="Example: H#05,R#02, Uttara Sector: 11, Uttara"></textarea>
                                                @error('shipping_address')
                                                    <span class="alert text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="form-group">
                                                    <label class="info-title" for="shippingNotes">Shipping Notes<span></span></label>
                                                    <textarea name="shipping_notes" id="" cols="30" rows="10" class="form-control unicase-form-control text-input" id="shippingNotes" placeholder="any Shipping notes"></textarea>
                                                </div>
                                        </div>
                                        <!-- already-registered-login -->

                                    </div>
                                </div>
                                <!-- panel-body  -->

                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div> <!-- col -->
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Checkout</h4>
                                </div>
                                <div class="___class_+?71___">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        @foreach ($carts as $item)
                                            <li>
                                                <strong>Image: </strong>
                                                <img src="{{ (!strpos($item->options->image, "http") === false) ? asset($item->options->image) : $item->options->image }}"
                                                    style="height: 50px; width: 50px;" alt="">
                                            </li>
                                            <li>
                                                <strong>Qty:</strong>
                                                {{ $item->qty }}
                                                {{-- <strong>Color:</strong>
                                                {{ $item->options->color }}
                                                <strong>Size:</strong>
                                                {{ $item->options->size }} --}}
                                            </li>
                                        @endforeach
                                        <hr>
                                        <li>
                                            @if (Session::has('coupon'))
                                                <strong>SubTotal: </strong> ${{ $cart_total }}
                                                <hr>
                                                <strong>Coupon Name: </strong> {{ session()->get('coupon')['coupon_name'] }}
                                                ( {{ session()->get('coupon')['coupon_discount'] }} %)
                                                <hr>
                                                <strong>Coupon Discount:
                                                </strong>(-)${{ session()->get('coupon')['discount_amount'] }}
                                                <hr>
                                                <strong>Grand Total: </strong>${{ session()->get('coupon')['total_amount'] }}
                                                <hr>
                                            @else
                                                <strong>SubTotal: </strong> ${{ $cart_total }}
                                                <hr>
                                                <strong>Grand Total: </strong> ${{ $cart_total }}
                                                <hr>
                                            @endif

                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- checkout-progress-sidebar -->

                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Select Payment Method</h4>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="radio" name="payment_method" value="bancard" class="block" style="margin:auto; margin-top:4px;">
                                            </div>
                                            <div class="col-md-9">
                                                <label for="">Bancard</label>
                                                <img src="{{ asset('frontend/assets/images/payments/bancard-200px.png') }}" height="20" alt="">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="radio" name="payment_method" value="pagopar" class="block" style="margin:auto; margin-top:4px;">
                                            </div>
                                            <div class="col-md-9">
                                                <label for="">Pagopar</label>
                                                <img src="{{ asset('frontend/assets/images/payments/pagopar-200px.png') }}" height="20" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label for="">Stripe</label>
                                        <input type="radio" name="payment_method" id="" value="stripe">
                                        <img src="{{ asset('frontend/assets/images/payments/4.png') }}" alt="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Card</label>
                                        <input type="radio" name="payment_method" id="" value="card">
                                        <img src="{{ asset('frontend/assets/images/payments/1.png') }}" alt="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">COD</label>
                                        <input type="radio" name="payment_method" id="" value="cod">
                                        <img src="{{ asset('frontend/assets/images/payments/6.png') }}" alt="">
                                    </div> --}}
                                    @error('payment_method')
                                        <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- col -->
                <hr>
                <button type="submit" class="btn btn-primary checkout-page-button">Order
                    Confirm</button>
            </form>
        </div><!-- /.row -->
    </div>
@endsection
