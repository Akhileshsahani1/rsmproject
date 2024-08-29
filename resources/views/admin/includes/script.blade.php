<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
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

            // var address = place.formatted_address;
          
            // var value = address.split(",");
            // count = value.length;
            // country = value[count - 1];
            // state = value[count - 2];
            // city = value[count - 3];
            // var z = state.split(" ");

            // document.getElementById("country").text = country;
            // var i = z.length;
            // document.getElementById("state").value = (z[1] ? z[1] : '') + (z[2] ? z[2] : '');
            // if (i > 2) {
            //     x = z;
            //     document.getElementById("zipcode").value = (z[3] ? z[3] : '');
            // }
            // document.getElementById("city").value = city;
            // var latitude = place.geometry.location.lat();
            // var longitude = place.geometry.location.lng();
            //var mesg = address;
            // document.getElementById("txtPlaces").value = mesg;
            // var lati = latitude;
            // document.getElementById("plati").value = lati;
            // var longi = longitude;
            // document.getElementById("plongi").value = longi;
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
<script>
    function updateTime() {
        var e, t = new Date,
            a = 10 > t.getMinutes() ? "0" + t.getMinutes() : t.getMinutes(),
            n = 10 > t.getSeconds() ? "0" + t.getSeconds() : t.getSeconds(),
            s = t.getHours() >= 12 ? " PM" : " AM",
            u = (e = 0 == t.getHours() ? 12 : t.getHours() > 12 ? t.getHours() - 12 : t.getHours()) + ":" + a + ":" + n;
        document.getElementsByClassName("hms")[0].innerHTML = u, document.getElementsByClassName("ampm")[0].innerHTML =
            s;
        var g = t.getDate(),
            d = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"][t.getDay()] + ", " + [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ][t.getMonth()] + " " + g;
        document.getElementsByClassName("date")[0].innerHTML = d
    }
    updateTime(), setInterval(function() {
        updateTime()
    }, 1e3);
</script>
@stack('scripts')