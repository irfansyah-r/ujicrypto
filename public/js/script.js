$(document).ready(function(){
    $(".sideMenuToggler").on("click", function(){
        $(".wrapper").toggleClass("active");
    });
    table = $('#data').DataTable( {
        "pageLength": 15,
        "responsive": false
    } );
});