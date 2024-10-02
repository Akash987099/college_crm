@extends('layouts.master')

@section('frontend')



        <script>
            function toggleButtons() {
        if ($(window).width() <= 767) { // Adjust the breakpoint according to your needs
            $('#desktopButtons').hide();
            $('#mobileButtons').show();
        } else {
            $('#desktopButtons').show();
            $('#mobileButtons').hide();
        }
    }

    // Initial call to set the initial state
    toggleButtons();

    // Call the function on window resize
    $(window).resize(function () {
        toggleButtons();
    });
        </script>


<div class="container-fluid">
<div class="container" id="articledata">



</div>
</div>

<script>
     $(document).ready(function(){
        function getUrlParameter(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    var idFromUrl = getUrlParameter('id');

    $.ajax({
        url : "{{route('get-news-getbyid')}}",
        type : "GET",
        data: { id: idFromUrl },
        success : function(response){
            // $('#articledata').append(imageHtml);
            $.each(response.news, function (index, news) {
        var imageHtml = `
        <div>
        <br>
        <img src="{{asset('public/news/${news.image}')}}">
           <h5>${news.title}</h5>
           <br>
           ${news.description}
           </div>
           <br>
        `;

        $('#articledata').append(imageHtml);
    });
        }
    });

});
</script>

@endsection