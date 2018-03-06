(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// Logout function
    function td_import_images() {

        $(document).on('click', '.td-demo-import-item-button', function(e){
            e.preventDefault();

            $.ajax({
                url: tdSettings.td_ajaxurl,
                type: "POST",
                dataType: 'json',
                context: this,
                data: {
                    'action':'import_demo_images'
                },
                beforeSend: function(){
                    jQuery("li.import-images").removeClass("inactive");
                    jQuery("li.import-images").addClass("pending");
                },
                success: function (data) {
                    jQuery("li.import-images").removeClass("pending");
                    jQuery("li.import-images").addClass("success");
                    td_import_work();
                },
                error: function (data) {
                	jQuery("li.import-images").removeClass("pending");
                    jQuery("li.import-images").addClass("error");
                    td_import_work();
                }
            });

        });
    }
    
    function td_import_work() {
    	$.ajax({
            url: tdSettings.td_ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: {
                'action':'import_demo_work'
            },
            beforeSend: function(){
                jQuery("li.import-work").removeClass("inactive");
                jQuery("li.import-work").addClass("pending");
            },
            success: function (data) {
                jQuery("li.import-work").removeClass("pending");
                jQuery("li.import-work").addClass("success");
                td_import_testimonials();
            },
            error: function (data) {
            	jQuery("li.import-work").removeClass("pending");
                jQuery("li.import-work").addClass("error");
                td_import_testimonials();
            }
        });
    }

    function td_import_testimonials() {
    	$.ajax({
            url: tdSettings.td_ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: {
                'action':'import_demo_testimonials'
            },
            beforeSend: function(){
                jQuery("li.import-testimonials").removeClass("inactive");
                jQuery("li.import-testimonials").addClass("pending");
            },
            success: function (data) {
                jQuery("li.import-testimonials").removeClass("pending");
                jQuery("li.import-testimonials").addClass("success");
                td_import_team();
            },
            error: function (data) {
            	jQuery("li.import-testimonials").removeClass("pending");
                jQuery("li.import-testimonials").addClass("error");
                td_import_team();
            }
        });
    }

    function td_import_team() {
    	$.ajax({
            url: tdSettings.td_ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: {
                'action':'import_demo_team'
            },
            beforeSend: function(){
                jQuery("li.import-team").removeClass("inactive");
                jQuery("li.import-team").addClass("pending");
            },
            success: function (data) {
                jQuery("li.import-team").removeClass("pending");
                jQuery("li.import-team").addClass("success");
                td_import_partners();
            },
            error: function (data) {
            	jQuery("li.import-team").removeClass("pending");
                jQuery("li.import-team").addClass("error");
                td_import_partners();
            }
        });
    }

    function td_import_partners() {
    	$.ajax({
            url: tdSettings.td_ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: {
                'action':'import_demo_partners'
            },
            beforeSend: function(){
                jQuery("li.import-partners").removeClass("inactive");
                jQuery("li.import-partners").addClass("pending");
            },
            success: function (data) {
                jQuery("li.import-partners").removeClass("pending");
                jQuery("li.import-partners").addClass("success");
                td_import_posts();
            },
            error: function (data) {
            	jQuery("li.import-partners").removeClass("pending");
                jQuery("li.import-partners").addClass("error");
                td_import_posts();
            }
        });
    }

    function td_import_posts() {
    	$.ajax({
            url: tdSettings.td_ajaxurl,
            type: "POST",
            dataType: 'json',
            context: this,
            data: {
                'action':'import_demo_posts'
            },
            beforeSend: function(){
                jQuery("li.import-posts").removeClass("inactive");
                jQuery("li.import-posts").addClass("pending");
            },
            success: function (data) {
                jQuery("li.import-posts").removeClass("pending");
                jQuery("li.import-posts").addClass("success");
                td_import_pages();
            },
            error: function (data) {
            	jQuery("li.import-posts").removeClass("pending");
                jQuery("li.import-posts").addClass("error");
                td_import_pages();
            }
        });
    }

    function td_import_pages() {

    }

    td_import_images();

})( jQuery );
