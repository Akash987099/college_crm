@extends('layouts.master')

@section('frontend')


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
        url : "{{route('get-article-data')}}",
        type : "GET",
        data: { id: idFromUrl },
        success : function(response){
            // $('#articledata').append(imageHtml);
            $.each(response.article, function (index, article) {
        var imageHtml = `
        <div>
        <br>
        <img src="public/articles/${article.image}">
           <h5>${article.title}</h5>
           ${article.description}
           </div>
        `;

        $('#articledata').append(imageHtml);
    });
        }
    });

});
</script>

@endsection