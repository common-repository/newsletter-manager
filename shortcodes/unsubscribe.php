<div style="color: #757575;"><?php 
		
		
if(isset($_REQUEST['result']) && ($_REQUEST['result'] == "success"))
	{
		if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == "true") // unsubscribed
		{
				_e( 'Your email was successfully unsubscribed.', 'newsletter-manager' );
		}
		else // user already unsubscribed.
		{
		_e( 'Your email is already unsubscribed.', 'newsletter-manager' );
		}
		
			
	}
	if(isset($_REQUEST['result']) && $_REQUEST['result'] == "failure")
	{
		_e( 'Unsubscription unsuccessful, try again!!!', 'newsletter-manager' );
			
	}
		
	?></div>