<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>

<script>

function initialize() {
        var input = document.getElementById('address');
        var places = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(places, 'place_changed', function() {
            var place = places.getPlace();
            let form_addr = place.address_components;
            console.log('fa');
            console.log(form_addr);
            let state = '';
            let zipcode = '';
            let country_code = '';
            let city = '';

            if(form_addr.length > 0){
               
                form_addr.forEach((comp)=>{
                    // console.log('INNN');
                    // console.log();
                    let types = comp.types;

                   if(types.length > 0){
                     for( let c in types){

                        if(types[c] == 'postal_code'){
                          zipcode = comp['long_name'];
                        }

                        if(types[c] == 'country'){
                          country_code = comp['short_name'].toLowerCase();
                        }

                        if(types[c] == "locality"){
                          city = comp['long_name'];
                        }

                        if(types[c] == "administrative_area_level_1"){
                          state = comp['long_name'];
                        }

                     }
                   }
                });
            }

            console.log('F:',state,city,zipcode,country_code);

            document.getElementById("city").value = city;
            document.getElementById("state").value = state;
            document.getElementById("zipcode").value = zipcode;

            $('#country option[value="'+country_code+'"]').prop('selected',true);

             // var latitude = place.geometry.location.lat();
            // var longitude = place.geometry.location.lng();

        });

    }

    
    $(document).ready(function() {

        google.maps.event.addDomListener(window, 'load', initialize);
        
        $('.showhide').click(function() {
            $('.showhide').show();
            $(this).hide();
        });

            $('body').delegate('.view_more', 'click', function(e) {
                var long = $(this).attr('long');
                var short = $(this).attr('short');
                var html = long + `<a class="view_less" long="@if(isset($job)){!! $job->description !!}@endif" short="@if(isset($job)){!! Str::limit($job->description, 200, ' ...') !!}@endif">View
                                less</a>`;
                $(this).parent().html(html)
            });

            $('body').delegate('.view_less', 'click', function(e) {
                var long = $(this).attr('long');
                var short = $(this).attr('short');
                var html = short + `<a class="view_more" long="@if(isset($job)){!! $job->description !!}@endif" short="@if(isset($job)){!! Str::limit($job->description, 200, ' ...') !!}@endif">View
                                more</a>`;
                $(this).parent().html(html)
            });

    });
</script>
<script>
    $(".alert-dismissible").fadeTo(6000, 500).slideUp(500, function() {
        $(".alert-dismissible").slideUp(500);
    });
</script>
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@if (Auth::guard('web')->check())
<script>
function getUnseenMessages(scroll_div = false) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var formData = {
    };
    $.ajax({
        type: 'POST',
        url: '{{ route("chats.unseen-message-count") }}',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            console.log("Before Loading");
        },
        success: function(res, status) {
            $('#employer-chat-count').html(res.message);
        },
        error: function(res, status) {
            console.log(res);
        }
    });
}
</script>
<script>
    setInterval(function() {
        getUnseenMessages();
    }, 3000);
    getUnseenMessages();
</script>
@endif
@if (Auth::guard('employee')->check())
<script>
function getUnseenMessages(scroll_div = false) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
        }
    });
    var formData = {
    };
    $.ajax({
        type: 'POST',
        url: '{{ route("employee.chats.unseen-message-count") }}',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            console.log("Before Loading");
        },
        success: function(res, status) {
            $('#employee-chat-count').html(res.message);
        },
        error: function(res, status) {
            console.log(res);
        }
    });
}
</script>
<script>
    setInterval(function() {
        getUnseenMessages();
    }, 3000);
    getUnseenMessages();
</script>
@endif
@stack('scripts')
