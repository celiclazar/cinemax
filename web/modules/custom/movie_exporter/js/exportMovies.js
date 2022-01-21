$(document).ready(function () {
    $("#movie_file_type").on("change", function() {
        const MovieFileType = $("#movie_file_type").val();
        $.ajax({
            url: './movie-exporter?fileType=' + MovieFileType,
            type: 'GET',
            success:function(){
                window.location.href = './movie-exporter?fileType=' + MovieFileType; 
              }    
        });
    });
});
 