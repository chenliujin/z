<script type="text/javascript"><!--//

(function($) {
$(document).ready(function() {

 $('#mainWrapper').css({
     'max-width': '100%',
     'margin': 'auto'
 });
 $('#headerWrapper').css({
     'max-width': '100%',
     'margin': 'auto'
 });
 $('#navSuppWrapper').css({
     'max-width': '100%',
     'margin': 'auto'
 });

<?php if ( $_SESSION['layoutType'] == 'full' ){ ?>

 $('#mainWrapper').css({
     'width': '100%',
     'margin': 'auto'
 });
 $('#headerWrapper').css({
     'width': '100%',
     'margin': 'auto'
 });
 $('#navSuppWrapper').css({
     'width': '100%',
     'margin': 'auto'
 });

<?php } else { ?>

$('.leftBoxContainer').css('width', '');
$('.rightBoxContainer').css('width', '');
$('#mainWrapper').css('margin', 'auto');

<?php } ?>
$('a[href="#top"]').click(function(){
$('html, body').animate({scrollTop:0}, 'slow');
return false;
});

$(".categoryListBoxContents").click(function() {
window.location = $(this).find("a").attr("href"); 
return false;
});

$('.centeredContent').matchHeight();
$('.specialsListBoxContents').matchHeight();
$('.centerBoxContentsAlsoPurch').matchHeight();
$('.categoryListBoxContents').matchHeight();

$('.no-fouc').removeClass('no-fouc');
});

}) (jQuery);

//--></script>
