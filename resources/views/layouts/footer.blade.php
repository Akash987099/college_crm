
        <style>
            .bottom-link{
                font-weight: 500;
    font-size: 17px;
    line-height: 20px;
    color: #fff;
    transition: all .3s ease-in;
    display: inline-block;
    padding-left: 10px;
    position: relative;
    margin-right: 10px;
    margin-bottom: 10px;
}
            a{
                text-decoration:none;
            }
            a:hover{
                   color:green;
            }
            .flogo_links ul{
                display: flex;
    flex-wrap: wrap;
    text-align: center;
    padding: 12px 0;
    border-bottom: 1px solid;
    border-top: 1px solid;
    margin-top: 10px;
            }
            .flogo_links ul li a{
                color: #fff;
                font-size: 14px;
                margin: 5px;
            }
        </style>
        
        <!-- Footer Start -->
        <div class="container-fluid footer py-5">

        <!-- <div class="row">
            <h4 class="mb-4 text-white p-2">Explore options for you
                <br>
                <small>POPULAR COURSES</small>
            </h4>
            <div class="bottom-link">
                 <div class="intro-banner-text pt-2 pt-md-3" id="introTextWrap">
                         </div>
            </div>
            </div>

            <script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ route('get-all-progmas') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#introTextWrap");

                response.forEach(function(program){
                    
                    
                    var html = `
                    <a href="javascript:void(0)" class="bottom-link newurl" data-id="${program.name}">${program.name}</a>
                    `;

                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("view-details") }}?id=' + id;
    }
});

</script> -->
<!-- 
            <div class="row">
            <h4 class="mb-4 text-white p-2">
                <small>Top College </small>
            </h4>
            <div class="bottom-link">
                 <div class="intro-banner-text pt-2 pt-md-3" id="introTopcollege">

                 </div>
            </div>
            </div>

            <script>
    $(document).ready(function(){

        function generateUrlFriendlyName(name) {
    const urlFriendlyName = name.replace(/\s+/g, '/');
    return urlFriendlyName; 
}

        $.ajax({
            url: "{{ route('get-allTop-collge') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#introTopcollege");

                response.forEach(function(program){
                    var cleanedName = generateUrlFriendlyName(program.name);
                    var html = `
                <a href="javascript:void(0)" class="bottom-link newurl" data-id="${cleanedName}">${program.name}</a>
            `;
                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("view-details") }}?id=' + id;
    }
});

</script> -->

            <!-- <div class="row">
            <h4 class="mb-4 text-white p-2">
                <small>Top Collage in State</small>
            </h4>
            <div class="bottom-link">
                 <div class="intro-banner-text pt-2 pt-md-3" id="introTextWrapStatewise">
                 </div>
            </div>
            </div>

            <script>
            $(document).ready(function(){
        $.ajax({
            url: "{{ route('get-allTop-collgeStatewise') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#introTextWrapStatewise");

                response.forEach(function(program){
                    
                    
                    var html = `
                    <a href="javascript:void(0)" class="bottom-link newurl" data-id="${program.id}">${program.state_name}</a>
                    `;

                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("view-details") }}?id=' + id;
    }
});

</script> -->

            <!-- <div class="row">
            <h4 class="mb-4 text-white p-2">
                <small>Top Collage in Popular City</small>
            </h4>
            <div class="bottom-link">
                 <div class="intro-banner-text pt-2 pt-md-3" id="introTextWrapcollegecity">

                 </div>
            </div>
            </div>

            <script>
            $(document).ready(function(){
        $.ajax({
            url: "{{ route('get-allTop-collgeStatewise') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#introTextWrapcollegecity");

                response.forEach(function(program){
                    
                    
                    var html = `
                    <a href="javascript:void(0)" class="bottom-link newurl" data-id="${program.id}">${program.city_name}</a>
                    `;

                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("city-top-get") }}?id=' + id;
    }
});

</script> -->

            <div class="container py-5">

                <div class="row g-5 align-items-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">
                            <img src="{{asset('frontend/logo.png')}}" style="width:200px;" alt="Logo">
                            </h4>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-share fa-2x text-white me-2"></i>
                                <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn-square btn btn-primary rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                           
                            <div class="flogo_links">
                                <ul>
                                    <li><a href="">Article</a></li>
                                    <li><a href="">Article</a></li>
                                    <li><a href="">Article</a></li>
                                    <li><a href="">Article</a></li>
                                    <li><a href="">Article</a></li>
                                </ul>
                            </div>
                            <ul class="intro-banner-share-links d-flex flex-wrap">
                                
                                <li>
                                <a href=""><i class="fas fa-envelope me-2"></i> info@edulinker.site</a>
                                </li>
                                
                            </ul>
                           
                        </div>
                    </div>
                    </div>
                   
                    <div class="col-md-6 col-lg-12 col-xl-3">
                        <div class="footer-item d-flex flex-column" id="topfooteruniversity">
                            <h4 class="mb-4 text-white">University</h4>
                        </div>
                    </div>

                    <script>
            $(document).ready(function(){
                function generateUrlFriendlyName(name) {
    const urlFriendlyName = name.replace(/\s+/g, '/');
    return urlFriendlyName; 
}

        $.ajax({
            url: "{{ route('get-footer-universiry') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#topfooteruniversity");

                response.forEach(function(program){
                    var cleanedName = generateUrlFriendlyName(program.name);
                    var html = `
                <a href="javascript:void(0)" class="bottom-link newurl" data-id="${cleanedName}">${program.name}</a>
            `;

                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("city-top-get") }}?id=' + id;
    }
});

</script>

                    <div class="col-md-6 col-lg-12 col-xl-6">
                        <div class="footer-item d-flex flex-column" id="topcollegedatafooter">
                            <h4 class="mb-4 text-white">College</h4>
                        </div>
                    </div>
                          
                    <!--</div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!-- Footer End -->

        <script>
            $(document).ready(function(){

                function generateUrlFriendlyName(name) {
    const urlFriendlyName = name.replace(/\s+/g, '/');
    return urlFriendlyName; 
}

        $.ajax({
            url: "{{ route('get-footer-college') }}",
            type: "GET",
            dataType: "json",
            success: function(response){
                var introTextWrap = $("#topcollegedatafooter"); 

                response.forEach(function(program){
                    var cleanedName = generateUrlFriendlyName(program.name);
                    var html = `
                <a href="javascript:void(0)" class="bottom-link newurl" data-id="${cleanedName}">${program.name}</a>
            `;

                    introTextWrap.append(html);
                });
            }
        });
    });

    $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("city-top-get") }}?id=' + id;
    }
});

</script>
        
        <!-- Copyright Start -->
        <div class="container-fluid copyright text-body py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-end mb-md-0">
                        <i class="fas fa-copyright me-2"></i><a class="text-white" href="#">Edulinker</a>, All right reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-start">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="text-white" href="">Awc.</a> Distributed By <a href="">Edulinker</a>
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Copyright End -->

        
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('frontend/lib/easing/easing.min.js')}}"></script>
        <script src="{{asset('frontend/lib/waypoints/waypoints.min.js')}}"></script>
        <script src="{{asset('frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('frontend/lib/lightbox/js/lightbox.min.js')}}"></script>
        

        <!-- Template Javascript -->
        <script src="{{asset('frontend/js/main.js')}}"></script>
    </body>

</html>

