$(document).ready( function () {

    $('.nav-item a ').click(function(){
        $(".nav-item a ").not($(this)).removeClass('active');

        $(this).addClass('active');
    });


    $('#table_subscribers').DataTable({
        "ordering": false
    });
    $('.table').DataTable({
        "ordering":false
    });
});



function getnewsDetails(id){
    alert(id);
}
