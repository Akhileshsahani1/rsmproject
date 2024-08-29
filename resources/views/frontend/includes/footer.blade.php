<div class="main-footer destop-view">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="nav-footer">
                        <div class="title">
                            @php
                                 $company        = \App\Models\CompanySetting::find(1);
                                 $company->logo  = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : Helper::getlogo();
                            @endphp

                           <!--<div class="footerLogo">
                             <img src="{{$company->logo}}" >
                           </div>-->
                           <div class="footerLogo">
                            <img src="{{ asset('assets/images/logo-white.svg') }}" alt="user-image" height="40px" >
                           </div>
                        </div>
                        <div class="contxt">
                            <ul>
                                <li><p>{{ \App\Models\CompanySetting::first()->description }}</p></li>
                            </ul>
                        </div>
                        <div class="social-menu">
                            <div class="title titledf">
                                Connect with us
                            </div>
                            <ul class="list-inline">
                                <li><a href="{{ \App\Models\CompanySetting::first()->facebook_link }}" target="blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->instagram_link }}" target="blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->twitter_link }}" target="blank"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->linkedin_link }}" target="blank"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 candidates">
                    <div class="nav-footer">
                        <div class="title titledf">
                            Information
                        </div>
                        <div class="contxt">
                            <ul>
                                <!-- <li><a href="#"><i class="fa fa-caret-right mr-3"></i>Browse Jobs</a></li> -->
                                <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                <li><a href="{{ route('page', 'privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('page', 'terms-conditions') }}">Terms & Conditions</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 employers">
                    <div class="nav-footer">
                        <div class="title titledf">
                            Employers
                        </div>
                        <div class="contxt">
                            <ul>
                                <li><a  href="{{ route('post-job') }}">Post a Job</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="nav-footer apply-go">
                        <div class="title titledf">
                            Apply on the go
                            <p>Get real time job updates on our App</p>
                        </div>

                        <div class="contxt">
                            <ul class="d-flex-button">
                                <li>
                                    <a href="{{ \App\Models\CompanySetting::first()->google_play_link }}" target="blank"><img src="{{asset('assets/images/icons/android-footer.png')}}" alt="" srcset=""></a>

                                </li>
                                <li>

                                    <a href="{{ \App\Models\CompanySetting::first()->apple_store_link }}" target="blank"><img src="{{asset('assets/images/icons/iphone-footer.png')}}" alt="" srcset=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="action text-right">
                <i class="fab fa-facebook-square"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-linkedin-in"></i>
                <i class="fab fa-instagram"></i>
            </div>  --}}

            <div class="line"></div>
            <div class="text-center end_footer">
                <span>© 2024 </span> RMS. <span>All right Reserved.</span>
            </div>
        </div>

    </footer>
</div>



<div class="mobile-footer mobile-view">
    <div class="container">
        <div class="title">
            @php
                 $company        = \App\Models\CompanySetting::find(1);
                 $company->logo  = isset($company->logo) ? asset('storage/uploads/company/'.$company->logo) : Helper::getlogo();
            @endphp

           <!--<div class="footerLogo">
             <img src="{{$company->logo}}" >
           </div>-->
           <div class="footerLogo">
            <img src="{{ asset('assets/images/logo-white.svg') }}" alt="user-image" height="40px" >
           </div>
        </div>
        <div class="contxt">
            <p>{{ \App\Models\CompanySetting::first()->description }}</p>
        </div>
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0 mt-0">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-plus"></i>Connect with us</button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="social-menu">
                            <ul class="list-inline">
                                <li><a href="{{ \App\Models\CompanySetting::first()->facebook_link }}" target="blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->instagram_link }}" target="blank"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->twitter_link }}" target="blank"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{{ \App\Models\CompanySetting::first()->linkedin_link }}" target="blank"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0 mt-0">
                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-plus"></i>Information</button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="contxt">
                            <ul>
                                <!-- <li><a href="#"><i class="fa fa-caret-right mr-3"></i>Browse Jobs</a></li> -->
                                <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                <li><a href="{{ route('page', 'privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('page', 'terms-conditions') }}">Terms & Conditions</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0 mt-0">
                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"><i class="fa fa-plus"></i>Employers</button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="contxt">
                            <ul>
                                <li><a  href="{{ route('post-job') }}">Post a Job</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0 mt-0">
                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour"><i class="fa fa-plus"></i>Get App From Store</button>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="contxt">
                            <ul class="d-flex-button">
                                <li>
                                    <a href="{{ \App\Models\CompanySetting::first()->google_play_link }}" target="blank"><img src="{{asset('assets/images/icons/android-footer.png')}}" alt="" srcset=""></a>

                                </li>
                                <li>

                                    <a href="{{ \App\Models\CompanySetting::first()->apple_store_link }}" target="blank"><img src="{{asset('assets/images/icons/iphone-footer.png')}}" alt="" srcset=""></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center end_footer">
            <span>© 2024 </span> RMS. <span>All right Reserved.</span>
        </div>
    </div>
</div>


@push('scripts')

<script>
    $(document).ready(function () {
  // Add minus icon for collapse element which is open by default
  $(".collapse.show").each(function () {
    $(this)
      .prev(".card-header")
      .find(".fa")
      .addClass("fa-minus")
      .removeClass("fa-plus");
  });

  // Toggle plus minus icon on show hide of collapse element
  $(".collapse")
    .on("show.bs.collapse", function () {
      $(this)
        .prev(".card-header")
        .find(".fa")
        .removeClass("fa-plus")
        .addClass("fa-minus");
    })
    .on("hide.bs.collapse", function () {
      $(this)
        .prev(".card-header")
        .find(".fa")
        .removeClass("fa-minus")
        .addClass("fa-plus");
    });
});
</script>
@endpush
