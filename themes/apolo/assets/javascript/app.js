/*
 * Application
 */

$(document).tooltip({
    selector: "[data-toggle=tooltip]"
})

/*
 * Auto hide navbar
 */
jQuery(document).ready(function($){
    var $header = $('.navbar-autohide'),
        scrolling = false,
        previousTop = 0,
        currentTop = 0,
        scrollDelta = 10,
        scrollOffset = 150

    $(window).on('scroll', function(){
        if (!scrolling) {
            scrolling = true

            if (!window.requestAnimationFrame) {
                setTimeout(autoHideHeader, 250)
            }
            else {
                requestAnimationFrame(autoHideHeader)
            }
        }
    })

    function autoHideHeader() {
        var currentTop = $(window).scrollTop()

        // Scrolling up
        if (previousTop - currentTop > scrollDelta) {
            $header.removeClass('is-hidden')
        }
        else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
            // Scrolling down
            $header.addClass('is-hidden')
        }

        previousTop = currentTop
        scrolling = false
    }
});

var scores = {
    satScore:0,
    gpaScore:0,
    actScore:0,
    collegeName:null,
};

function satChanged(){

    $.request('onRefreshResult',{
        update: {'site/result/result': '#result'}

    });

    var satScore = document.getElementById("SAT").value;
    scores.satScore = satScore;

    $(this).request('Scores::onSatChanged',{data:{value:satScore}});


    var result = document.getElementById("search_result");
        result.innerHTML = JSON.stringify(scores,null,3);
        $.request('onDoSomething', {
        flash: 1,
        handleFlashMessage: function(message, type) {
            $.oc.flashMsg({ text: message, class: type })
        }
    })
    console.log(scores)
}


function actChanged(){
    var actScore = document.getElementById("ACT").value;
    scores.actScore = actScore;

    var result = document.getElementById("search_result");
        result.innerHTML = JSON.stringify(scores,null,3);
    console.log(scores)
}
//handle college name change event
function collegeChanged(){
    var collegeName = document.getElementById("college").value;
    scores.collegeName = collegeName;
    var result = document.getElementById("search_result");
    result.innerHTML = scores.collegeName;
    console.log(scores)

}


