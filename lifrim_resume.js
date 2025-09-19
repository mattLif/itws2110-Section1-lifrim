

$(document).ready(function () {
   
   // example event handler:
   $('#labButton').click(function () {
      alert('You\'ve clicked the lab button');
   });
   
   $('em.myName').click(function() {
      $(this).html("Matthew Lifrieri").css({
         "font-variant":"small-caps",
         "font-size":"125%",
         "color":"red"
      });
   });
   
   $('a#hideText').click(function() {
      $("div#showHideBlock p").hide(1000);
   });

   $('a#showText').click(function() {
      $("div#showHideBlock p").show(2100);
   });
   
   $('#AddListItem').click(function () {
         var itemNum = $("#labList li").length + 1;
         $("<li>List item " + itemNum + "</li>").appendTo('ul#labList');
   });
   $(document).on("click","#labList li",function() {
      $(this).toggleClass("red");
   });
   $('a#toggleText').click(function() {
      $("div#showHideBlock p").toggle(1000);
   });
});
