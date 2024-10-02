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

        <div class="container-fluid py-5">
            <div class="container" id="">

            <div class="row" id="allarticledata">
            <h1 class="listing_heading font-weight-bold">Latest News</h1>

          

              </div>
           </div>
        </div>

        <style>
            .lisitingCard_right>img{
                height: 151px !important;
    width: 216px !important;
            }
            .lisitingCard_right{
                margin-left: 20px 
            }
            .listing_card_dropdown_content span{
                olor: #000;
    display: block;
    padding: 4px 16px;
    text-decoration: none;
    /* transition: all .1s ease-in-out; */
    -webkit-transition: all .1s ease-in-out;
            }
            .listing_card_dropdown_content{
                background-color: #f1f1f1;
    box-shadow: 0 8px 16px 0 #0003;
    display: none;
    min-width: 160px;
    position: absolute;
    right: 0;
    z-index: 1;
            }
            .listing_card_dropbtn{
                background-color: initial; */
    border: none;
    font-size: 16px;
            }
.listing_heading{
            font: var(--listing-main-heading-font);
        } 
        .listingNews{
            margin-bottom: 30px;
        }
        .listingCard{
            border-bottom: 1px solid #ccc;
    box-sizing: border-box !important;
    color: #2a2a2a !important;
    cursor: pointer;
    justify-content: space-between !important;
    padding: 20px 0;
        }
        .flex_display{
            align-items: center;
    display: flex;
    justify-content: flex-start;
        }
        .news_desktop_adjust_width{
            width: 100%;
        }
        .listingCard_left{
            align-items: flex-start;
    display: flex;
    flex-direction: column;
    height: 151px;
    justify-content: space-between !important;
    padding-right: 20px;
    width: calc(100% - 236px);
        }
        a{
            color: inherit;
    text-decoration: none !important;
        }
        .listingCard_left_bottom{
            justify-content: space-between !important;
    margin-top: 15px;
    width: 100%;
        }
        .listingCard_timestamp{
            color: #707070;
    font: normal 12px / 16px normal;
        }
        .listingCard_timestamp>a{
            color: #5a5695 !important;
    font: normal 12px / 16px normal;
        }
        .listing_card_dropdown{
            display: inline-block;
    position: relative;
        }
        </style>
        
        <script>
            $(document).ready(function(){
                $.ajax({
                    url : "{{route('news-list_daata')}}",
                    dataType : "json",
                    success : function(response){
                        $.each(response.article, function(index, article) {
                            var id = article.id;
                            var html = ` 
                            <div class="col-lg-12">
            <div class="listingNews">
                <div class="listingCard">
                  <div class="flex_display">
                    <div class="flex_display news_desktop_adjust_width desktop_display">
                        <div class="listingCard_left">
                        <a href="{{route('news-single-data')}}?id=${article.id}">
                            <h3><span class="news_liveButton news_liveButtonlg flex_display">
                            </span>${article.title}</h3>
                            </a>
                    <div class="listingCard_left_bottom flex_display desktop_display">
                        <div class="listingCard_leftBottom_left">
                            <span class="listingCard_timestamp">
                            <!-- <a href="/author/15252785">Vagisha Kaushi </a> -->
                          ${article.date}
                            </span>
                        </div>
                        <div class="listing_card_dropdown">
                          <div class="listing_card_dropdown_content">
                 
                    </div>   
                    </div>
                    </div>    
                    </div>

                    <a href="{{route('news-single-data')}}?id=${article.id}" class="lisitingCard_right desktop_display">
                    <img src="public/news/${article.image}" width="216" height="151" alt="Listing Card Image">
                    </a>
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
    console.log(id); 
    if (id !== null) {
        window.location.href = '{{ route("artical-top-data") }}?id=' + id;
    }
});

       </script>

@endsection

