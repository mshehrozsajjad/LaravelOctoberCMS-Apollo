$(document).ready(function () {

    step1 = document.getElementById("step-div-one").style;
    step2 = document.getElementById("step-div-two").style;
    step3 = document.getElementById("step-div-three").style;
    step4 = document.getElementById("step-div-four").style;
    step2.display = 'none';
    step3.display = 'none';
    step4.display = 'none';
    step1.display = 'block';
    //    $(".colorchange").removeClass("nav-link");
    //               $(".demochange").addClass("navbar-up");
    //               $(".demochange").removeClass("navbar-brand");
    //               $(".colorchange").addClass("nav-up");
    //             $(".mainheader").removeClass("sticky-header");
    //             $(".mainheader").removeClass("active");
    //             $(".mainheader").addClass("ind");


});

function stepone() {
    $(".step-two").removeClass("active");
    $(".step-three").removeClass("active");
    $(".step-four").removeClass("active");
    line = document.getElementById("line").style;
    step1 = document.getElementById("step-div-one").style;
    step2 = document.getElementById("step-div-two").style;
    step3 = document.getElementById("step-div-three").style;
    step4 = document.getElementById("step-div-four").style;
    step2.display = 'none';
    step3.display = 'none';
    step4.display = 'none';
    step1.display = 'block';
    line.width = '25%';

}

function steptwo() {
    $(".step-two").addClass("active");
    $(".step-three").removeClass("active");
    $(".step-four").removeClass("active");
    line = document.getElementById("line").style;
    step1 = document.getElementById("step-div-one").style;
    step2 = document.getElementById("step-div-two").style;
    step3 = document.getElementById("step-div-three").style;
    step4 = document.getElementById("step-div-four").style;
    step2.display = 'block';
    step3.display = 'none';
    step4.display = 'none';
    step1.display = 'none';
    line.width = '50%';

}

function stepthree() {
    $(".step-two").addClass("active");
    $(".step-three").addClass("active");
    $(".step-four").removeClass("active");
    line = document.getElementById("line").style;
    step1 = document.getElementById("step-div-one").style;
    step2 = document.getElementById("step-div-two").style;
    step3 = document.getElementById("step-div-three").style;
    step4 = document.getElementById("step-div-four").style;
    step2.display = 'none';
    step3.display = 'block';
    step4.display = 'none';
    step1.display = 'none';
    line.width = '75%';

}

function stepfour() {
    $(".step-two").addClass("active");
    $(".step-three").addClass("active");
    $(".step-four").addClass("active");
    line = document.getElementById("line").style;
    step1 = document.getElementById("step-div-one").style;
    step2 = document.getElementById("step-div-two").style;
    step3 = document.getElementById("step-div-three").style;
    step4 = document.getElementById("step-div-four").style;
    step2.display = 'none';
    step3.display = 'none';
    step4.display = 'block';
    step1.display = 'none';
    line.width = '100%';

}