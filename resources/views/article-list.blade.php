@extends('layouts.master')

@section('frontend')


        <div class="container-fluid py-5">
            <div class="container" id="">

            <div class="row" id="allarticledata">

</div>
           </div>
        </div>

        <script>
            $(document).ready(function(){
                $.ajax({
                    url : "{{route('article-list_daata')}}",
                    dataType : "json",
                    success : function(response){
                        $.each(response.article, function(index, article) {
                            var id = article.id;
                            var html = ` 
                        <div class="text-center rounded col-6">
                <div class="card">
                    <img class="card-img-top" src="public/articles/${article.image}" style="width:100%!important;" alt="Card image cap">
                    <div class="card-body text-white">
                        <p class="text-dark text-start">${article.title}</p>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">
                                <span>${article.date}</span>
                            </div>
                            <div class="col-5 text-end">
                            <button type="button" data-csm-track="true" data-id="${article.id}" class="btn btn-primary btn-sm newurl">Read More</button>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        `;

                        $('#allarticledata').append(html);
                        });
                    }
                });
            });

            $(document).on('click', '.newurl', function () {
    var id = $(this).data('id');
    // console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("artical-top-data") }}?id=' + id;
    }
});

        </script>


@endsection

