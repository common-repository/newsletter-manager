<?php
if ( ! defined( 'ABSPATH' ) )
    exit;
    header( 'Content-Type: text/javascript' );
    include(dirname( __FILE__ ) . '/emoji.php');
    if ( ! is_user_logged_in() )
        die('You must be logged in to access this script.');            
         global $wpdb;        
         $buttonName_html = 'xyz_em_selector_emoji';  
                     ?>
	(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.xyz_em_emoji', {
          init : function(ed, url) {
               /**
               * Inserts shortcode content
               */
               ed.addButton( '<?php echo $buttonName_html;?>', {
            	    title: 'XYZ Newsletter Emoji',
		            type: 'menubutton',
		            icon: 'icon xyz-em-own-html-icon',
		            menu: [
			            	
			            	
			           		<?php foreach ($xyz_em_emojis as $key=>$val) { ?>  
			           			{
			            		text: '<?php echo $key;?>',
			            		value: '<?php echo $val; ?>',
			            		onclick: function() {
			            		
			            			
			            			ed.insertContent(this.value());
			            		}
			           		},
							<?php } ?>  
						
	           ]
                    
               });
               /**
               * Adds HTML tag to selected content
               */
              
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'xyz_em_buttons', tinymce.plugins.xyz_em_emoji );
})();
	
