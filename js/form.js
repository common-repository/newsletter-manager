//Nonce for unsubscription and subscription while displaying Optin form using HTML Code
jQuery(document).ready(function(){
        var data = {
            action: 'nlm_generate_nonce'
        };
jQuery.post(ajax_object.ajaxurl, data, function(response) {
  var nlm_nonces = JSON.parse(response);//alert(nonces.subscribe_nonce);
  jQuery('#subsc_nounce').val(nlm_nonces.subscribe_nonce);
        jQuery('#unsubsc_nounce').val(nlm_nonces.unsubscribe_nonce); // Update nonce field in your form
        });
});
