@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
    <section class="contact-bg">
        <div class="container">
            <div class="row justify-content-md-center align-items-center">
                <div class="col-12 col-md-11 col-lg-9 col-xl-8 col-xxl-7">
                    <h2 class="display-6">Contact Us</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-details">
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-5">
                    <div class="contact-info">
                        <ul class="list-unstyled">
                            <li class="list-item"><a href="tel:+6563841151"><span><i class="mdi mdi-phone"></i></span>
                                    {{ $company->dialcode }} {{ $company->phone }}</a>
                            </li>
                            <li class="list-item">
                                <hr>
                            </li>
                            <li class="list-item"><a href="mailto:enquiry@http://rsm.n2rdev.in/"><span><i
                                            class="mdi mdi-email"></i></span>
                                    {{ $company->email }}</a>
                            </li>
                            <li class="list-item">
                                <hr>
                            </li>
                            <li class="list-item"><a href="http://rsm.n2rdev.in/"><span><i class="mdi mdi-web"></i></span>
                                    {{ $company->website }}</a>
                            </li>
                            <li class="list-item">
                                <hr>
                            </li>
                            <li class="list-item"><span><i class="mdi mdi-map-marker-multiple"></i></span>
                                {{ $company->company }}<br><span class="padding-space">{{ $company->address_line_1 }},
                                    {{ $company->address_line_2 }}</span><br><span class="padding-space">{{ $company->city }},
                                    {{ $company->zipcode }}, {{ $company->state }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="contact-info-form">
                        @include('frontend.includes.flash-message')
                        <form action="{{ route('contact-us') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter your name" value="{{ old('name') }}">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" id="phone_number" name="phone_number" class="form-control"
                                    placeholder="Enter phone number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <span id="phone_number-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter message here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="contact-map"><iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31910.35745124515!2d103.79635723092863!3d1.2979075375397624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da199ab2bbc2cd%3A0x500f7acaedaa690!2sRiver%20Valley%2C%20Singapore!5e0!3m2!1sen!2sin!4v1710314575881!5m2!1sen!2sin"
            width="100%" height="400" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe></section>
@endsection
