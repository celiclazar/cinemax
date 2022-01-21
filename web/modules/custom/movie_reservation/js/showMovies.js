function showMovies(){
    const MovieGenre = $("#movie-genre");
    $("#movie-genre").on( "change", (function (){
      $.ajax({
        url: './movie-reservation?genreID=' + MovieGenre.val(),
        type: 'GET',
        success:function(){
          window.location.href = './movie-reservation?genreID=' + MovieGenre.val(); 
        }
      });
    }));
  }
  $(".movie-content").click (function(){
    const id = $(this).attr("id");
    const popup_ID = "#popup-"+id;
    const reserve_btn_ID = "#reserve-btn-"+id;
    const submit_reservation_ID = "#submit-reservation"+id;
    
    $(this).toggleClass("movie-content-clicked");
    $(reserve_btn_ID).toggleClass("show");
    $(reserve_btn_ID).click(function(){
      $(popup_ID).show(); 
    });
    $('input[type="radio"]').click(function(){
      $(submit_reservation_ID).addClass("show");
      $(submit_reservation_ID).click(function(){
        
        $(".reserve-btn").validate({
          rules: {
            customerName: {
              required: true,
              number: false,
              maxlength: 10
            },
            messages: {
              required: "Please enter your name",
              maxlength: "Name should be at most 10 characters",
              number: "Name can't contain number"
            }
          }
        }) 
        alert("Unos uspesan");
      }) 
    });
    $(popup_ID).hide();
  });
showMovies();
  showMovies();
 