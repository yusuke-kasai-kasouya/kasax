jQuery( document ).ready( function ( ) {
       jQuery("#output").html("<b>java TEST OK</b>");
} );


jQuery( document ).ready(function(){
       jQuery(".iro").hover(
            function() {
                jQuery(this).css("color", "red");
            },
            function() {
                jQuery(this).css("color", "black");
            }
        );
    });