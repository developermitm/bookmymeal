/*$(document).ready(function() {
    ('.owl-carousel').owlCarousel({
    autoplay: true,
    autoplayHoverPause:true,
    items:4,
    center:false,
    loop:true,
    dots:false,
    margin: 10,
    nav:true, 
    navText:['<i class="fa fa-arrow-left"></i>','<i class="fa fa-arrow-right"></i>']
    });
}); */

$(document).ready(function() {
 
  //Sort random function
  function random(owlSelector){
    owlSelector.children().sort(function(){
        return Math.round(Math.random()) - 0.5;
    }).each(function(){
      $(this).appendTo(owlSelector);
    });
  }
 
  $("#owl-demo").owlCarousel({
    navigation: true,
    navigationText: [
      "<i class='icon-chevron-left icon-white'></i>",
      "<i class='icon-chevron-right icon-white'></i>"
      ],
    beforeInit : function(elem){
      //Parameter elem pointing to $("#owl-demo")
      random(elem);
    }
 
  });
 
});

