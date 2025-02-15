<?php

//
// VALIDATE all fields 
//

//print_r($_POST);
for($i = 1; $i <= $field_count; $i++) {

			if ( !$custom ) 
				$field_stat = explode('$#$', get_option('cforms'.$no.'_count_field_' . ((int)$i+(int)$off) ));
			else
				$field_stat = explode('$#$', $customfields[((int)$i+(int)$off) - 1]);

			// filter non input fields
			while ( $field_stat[1] == 'fieldsetstart' || $field_stat[1] == 'fieldsetend' || $field_stat[1] == 'textonly' ) {
					$off++;

					if ( !$custom ) 
                        $field_stat = explode('$#$', get_option('cforms'.$no.'_count_field_' . ((int)$i+(int)$off) ));
                    else
                        $field_stat = explode('$#$', $customfields[((int)$i+(int)$off) - 1]);
                        
					if( $field_stat[1] == '')
							break 2; // all fields searched, break both while & for
			}
			

		// custom error set?
		$c_err = explode('|err:', $field_stat[0], 2);
				
		$field_name = $c_err[0];
		$field_type = $field_stat[1];
		$field_required = $field_stat[2];
		$field_emailcheck = $field_stat[3];


		// ommit certain fields
		if( in_array($field_type,array('author','url','email')) ){
			if ( $user->ID )
				continue;
		}


		//input field names & label
		$custom_names = (get_option('cforms'.$no.'_customnames')=='1')?true:false;
		
		if ( $custom_names ){
			preg_match('/^([^#\|]*).*/',$field_name,$input_name);
			$current_field = stripslashes( $_POST[ str_replace(' ','_',$input_name[1]) ] );
		}
		else
			$current_field = stripslashes( $_POST['cf'.$no.'_field_' . ((int)$i+(int)$off)] );

		//echo "***".$input_name[1].'***'.$current_field."***<br>";
		
		if( $field_emailcheck ) {  // email field
		
				// special email field in WP Commente
				if ( $field_type=='email' )		
					$validations[$i+$off] = cforms_is_email( $_POST['email']) || (!$field_required && $_POST['email']=='');
				else
					$validations[$i+$off] = cforms_is_email( $current_field ) || (!$field_required && $current_field=='');

				if ( !$validations[$i+$off] && $err==0 ) $err=1;
			
		}
		else if( $field_required ) { // just required

				if( in_array($field_type,array('pwfield','textfield','datepicker','textarea','yourname','youremail','friendsname','friendsemail')) ){

						// textfields empty ?
						$validations[$i+$off] = !empty($current_field);

						// regexp set for textfields?
						$obj = explode('|', $c_err[0], 3);
						
		  				if ( $obj[2] <> '') {
		  					if (  isset($_POST[$obj[2]]) && $_POST[$obj[2]]<>'' ){

								if( $current_field <> $_POST[$obj[2]] )
								    $validations[$i+$off] = false;

		  					}
		  					else {
								$reg_exp = str_replace('/','\/',stripslashes($obj[2]) );
								if( !preg_match('/'.$reg_exp.'/', $current_field) )
								    $validations[$i+$off] = false;
							}
								    
						}						
						

				}else if( $field_type=="checkbox" ) {
//echo $current_field."<br>";
							$validations[$i+$off] = !empty($current_field);

				}else if( $field_type=="selectbox" || $field_type=="emailtobox" ) {

							$validations[$i+$off] = !($current_field == '-' );

				}else if( $field_type=="multiselectbox" ) {
				
							// how many multiple selects ?
                            $all_options = $current_field;
							if ( count($all_options) == 0 )                               
									$validations[$i+$off] = false;
                            else						    
									$validations[$i+$off] = true;

				}else if( $field_type=="upload" ) {  // prelim upload check

							$validations[$i+$off] = !($_FILES['cf_uploadfile'.$no][name][$filefield++]=='');
							if ( !$validations[$i+$off] && $err==0 )
									{ $err=3; $fileerr = get_option('cforms_upload_err2'); }
				
				}else if( in_array($field_type,array('author','url','email','comment')) ) {  // prelim upload check

						$validations[$i+$off] = !empty($_POST[$field_type]);

						// regexp set for textfields?
						$obj = explode('|', $c_err[0], 3);
						
		  				if ( $obj[2] <> '') {
		  				
							$reg_exp = str_replace('/','\/',stripslashes($obj[2]) );
							if( !preg_match('/'.$reg_exp.'/',$_POST[$field_type]) )
							    $validations[$i+$off] = false;
									    
						}						

				}

				if ( !$validations[$i+$off] && $err==0 ) $err=1;

		}
		else if( $field_type == 'verification' ){  // visitor verification code
		
        		$validations[$i+$off] = 1;
				if ( $_POST['cforms_a'.$no] <> md5(rawurlencode(strtolower($_POST['cforms_q'.$no]))) ) {
						$validations[$i+$off] = 0;
						$err = !($err)?2:$err;
						}
						
		}
		else if( $field_type == 'captcha' ){  // captcha verification
		
        		$validations[$i+$off] = 1;
				if ( $_SESSION['turing_string_'.$no] <> strtolower($_POST['cforms_captcha'.$no]) ) {
						$validations[$i+$off] = 0;
						$err = !($err)?2:$err;
						}
				
		}
		else
			$validations[$i+$off] = 1;

		$all_valid = $all_valid && $validations[$i+$off];
		
		if ( $c_err[1] <> '' && $validations[$i+$off] == false ){
			$c_errflag=4;
			
			if ( get_option('cforms_liID')=='1' ){
				$custom_error .= '<li><a href="#li-'.$no.'-'.($i+$off).'">'.stripslashes($c_err[1]).' &raquo;</li></a>';
			} else
				$custom_error .= '<li>' . stripslashes($c_err[1]) . '</li>';
			
		}

	}


//
// have to upload a file?
//
$uploadedfile='';
$filefield=0;   // for multiple file upload fields

if( isset($_FILES['cf_uploadfile'.$no]) && $all_valid){

	foreach( $_FILES['cf_uploadfile'.$no][name] as $value ) {
		
		if(!empty($value)){   // this will check if any blank field is entered

			  	$file = $_FILES['cf_uploadfile'.$no];
				
				$fileerr = '';
				// A successful upload will pass this test. It makes no sense to override this one.
				if ( $file['error'][$filefield] > 0 )
						$fileerr = get_option('cforms_upload_err1');
						
				// A successful upload will pass this test. It makes no sense to override this one.
				$fileext[$filefield] = substr($value,strrpos($value, '.')+1,strlen($value));
				$allextensions = explode(',' ,  preg_replace('/\s/', '', get_option('cforms'.$no.'_upload_ext')) );
				
				if ( get_option('cforms'.$no.'_upload_ext')<>'' && !in_array($fileext[$filefield], $allextensions) )
						$fileerr = get_option('cforms_upload_err5');

				// A non-empty file will pass this test.
				if ( !( $file['size'][$filefield] > 0 ) )
						$fileerr = get_option('cforms_upload_err2');

				// A non-empty file will pass this test.
				if ( $file['size'][$filefield] >= (int)get_option('cforms'.$no.'_upload_size') * 1024 )
						$fileerr = get_option('cforms_upload_err3');


				// A properly uploaded file will pass this test. There should be no reason to override this one.
				if (! @ is_uploaded_file( $file['tmp_name'][$filefield] ) )
						$fileerr = get_option('cforms_upload_err4');
		
				if ( $fileerr <> '' ){

						$err = 3;
						$all_valid = false;

				} else {

						// cool, got the file!

				  		$uploadedfile = file($file['tmp_name'][$filefield]);
			
			            $fp = fopen($file['tmp_name'][$filefield], "rb"); //Open it
			            $fdata = fread($fp, filesize($file['tmp_name'][$filefield])); //Read it
			            $filedata[$filefield] = chunk_split(base64_encode($fdata)); //Chunk it up and encode it as base64 so it can emailed
			            fclose($fp);
	
				} // file uploaded

        } // if !empty
		$filefield++;
        
    } // while all file

} // no file upload triggered

//
// what kind of error message?
//
switch($err){
	case 0: break;
	case 1:
			$usermessage_text = preg_replace ( array("|\\\'|",'/\\\"/','|\r\n|'),array('&#039;','&quot;','<br />'), get_option('cforms'.$no.'_failure') );
			break;
	case 2:
			$usermessage_text = preg_replace ( array("|\\\'|",'/\\\"/','|\r\n|'),array('&#039;','&quot;','<br />'), get_option('cforms_codeerr') );
			break;
	case 3:
			$usermessage_text = preg_replace ( array("|\\\'|",'/\\\"/','|\r\n|'),array('&#039;','&quot;','<br />'), $fileerr);
			break;
	case 4:
			$usermessage_text = preg_replace ( array("|\\\'|",'/\\\"/','|\r\n|'),array('&#039;','&quot;','<br />'), get_option('cforms'.$no.'_failure') );
			break;
			
}
if ( $err<>0 && $c_errflag ) 
	$usermessage_text .= '<ol>'.$custom_error.'</ol>';

//
// all valid? get ready to send
//
if( isset($_POST['sendbutton'.$no]) && $all_valid ) {

		$usermessage_text = preg_replace ( '|\r\n|', '<br />', stripslashes(get_option('cforms'.$no.'_success')) );

		$formdata = '';
		$htmlformdata = '';

		$track = array();
		$trackinstance = array();

  		$to_one = "-1";
		$ccme = false;
		$field_email = '';

		$filefield=0;
		$taf_youremail = false;
		$taf_friendsemail = false;
		$send2author = false;

		$key = 0;
		
		$customspace = (int)(get_option('cforms'.$no.'_space')>0)?get_option('cforms'.$no.'_space'):30;

		for($i = 1; $i <= $field_count; $i++) {

			if ( !$custom ) 
				$field_stat = explode('$#$', get_option('cforms'.$no.'_count_field_' . $i ));
			else
				$field_stat = explode('$#$', $customfields[$i-1]);


			// filter non input fields
			while ( $field_stat[1] == 'fieldsetstart' || $field_stat[1] == 'fieldsetend' || $field_stat[1] == 'textonly' ) {

					if ( $field_stat[1] <> 'textonly' ){ // include and make only fieldsets pretty!

						//just for email looks
						$space='-'; 
						$n = ((($customspace*2)+2) - strlen($field_stat[0])) / 2;
						$n = ($n<0)?0:$n;							
						if ( strlen($field_stat[0]) < (($customspace*2)-2) )
							$space = str_repeat("-", $n );
							
						$formdata .= substr("\n$space$field_stat[0]$space",0,($customspace*2)) . "\n\n";
						$htmlformdata .= '<tr><td class=3D"fs-td" colspan=3D"2">' . $field_stat[0] . '</td></tr>';
						
						if ( $field_stat[1] == 'fieldsetstart' )
							$track['Fieldset'.$fieldsetnr++] = $field_stat[0];
						
					}
					
					//get next in line...
					$i++;

					if ( !$custom ) 
  						$field_stat = explode('$#$', get_option('cforms'.$no.'_count_field_' . $i ));
					else
       					$field_stat = explode('$#$', $customfields[$i-1]);

					if( $field_stat[1] == '')
							break 2; // all fields searched, break both while & for
			}

			$field_name = $field_stat[0];
  			$field_type = $field_stat[1];


			if ( $custom_names ){
				preg_match('/^([^#\|]*).*/',$field_name,$input_name);
				$current_field = str_replace(' ','_',$input_name[1]);
			}
			else
				$current_field = 'cf'.$no.'_field_' . $i;
			

			// strip out default value
			if ( ($pos=strpos($field_name,'|')) )
			    $field_name = substr($field_name,0,$pos);

			// special Tell-A-Friend fields
			if ( !$taf_friendsemail && $field_type=='friendsemail' && $field_stat[3]=='1')
					$field_email = $taf_friendsemail = $_POST[$current_field];

			if ( !$taf_youremail && $field_type=='youremail' && $field_stat[3]=='1')
					$taf_youremail = $_POST[$current_field];

			if ( $field_type=='friendsname' )
					$taf_friendsname = $_POST[$current_field];

			if ( $field_type=='yourname' )
					$taf_yourname = $_POST[$current_field];


			// special email field in WP Commente
			if ( $field_type=='email' )
					$field_email = (isset($_POST['email']))?$_POST['email']:$user->user_email;


			// special radio button WP Comments
			if( $field_type=='send2author' && $_POST['send2author']=='1') {
				$send2author=true;
				continue; // don't record it.
			}

			// find email address
			if ( $field_email == '' && $field_stat[3]=='1')
					$field_email = $_POST[$current_field];


			// special case: select box & radio box
			if ( $field_type == "checkboxgroup" || $field_type == "multiselectbox" || $field_type == "selectbox" || $field_type == "radiobuttons" ) { //only needed for field name
			  $field_name = explode('#',$field_name);
			  $field_name = $field_name[0];
			}


			// special case: check box
			if ( $field_type == "checkbox" || $field_type == "ccbox" ) {
			  $field_name = explode('#',$field_name);
			  $field_name = ($field_name[1]=='')?$field_name[0]:$field_name[1];
				// if ccbox
			  if ($field_type == "ccbox" && isset($_POST[$current_field]) )
			      $ccme = true;
			}


		if ( $field_type == "emailtobox" ){  				//special case where the value needs to bet get from the DB!

            $field_name = explode('#',$field_stat[0]);  //can't use field_name, since '|' check earlier
            $to_one = $_POST[$current_field];
            
            $offset = (strpos($field_name[1],'|')===false) ? 1 : 2; // names come usually right after the label
            
            $value 	= $field_name[(int)$to_one+$offset];  // values start from 0 or after!
            $field_name = $field_name[0];
 		}
 		else if ( $field_type == "upload" ){
 		
 			//$fsize = $file['size'][$filefield]/1000;
 			$value = $file['name'][$filefield++];

 		}	 		
 		else if ( $field_type == "multiselectbox" || $field_type == "checkboxgroup"){
 		    
            $all_options = $_POST[$current_field];
 		    if ( count($all_options) > 0)
                $value = implode(',', $all_options);
            else
                $value = '';
                
        }	            			
		else if ( $field_stat[1] == 'captcha' ) // captcha response

			$value = $_POST['cforms_captcha'.$no];
			
		else if ( $field_stat[1] == 'verification' ) { // verification Q&A response

			$value = $_POST['cforms_q'.$no]; // add Q&A label!
			$field_name = __('Q&A','cforms');

		}
		else if( $field_type == 'author' )  // WP Comments special fields
			$value = ($user->display_name<>'')?$user->display_name:$_POST[$field_type];

		else if( $field_type == 'url')
			$value = ($user->user_url<>'')?$user->user_url:$_POST[$field_type];					

		else if( $field_type == 'email' )
			$value = ($user->user_email<>'')?$user->user_email:$_POST[$field_type];

		else if( $field_type == 'comment' )
			$value = $_POST[$field_type];

		else if( $field_type == 'hidden' )
			$value = rawurldecode($_POST[$current_field]);

		else
			$value = $_POST[$current_field];       // covers all other fields' values


		//check boxes
		if ( $field_type == "checkbox" || $field_type == "ccbox" ) {
		
				if ( isset($_POST[$current_field]) )
					$value = 'X';
				else
					$value = '-';

		} else if ( $field_type == "radiobuttons" ) {

				if ( ! isset($_POST[$current_field]) )
					$value = '-';

		} 

		//for db tracking
		$inc='';
		$trackname = trim( ($field_type == "upload")?$field_name.'[*]':$field_name ); 
		if ( array_key_exists($trackname, $track) ){
			if ( $trackinstance[$trackname]==''  )
				$trackinstance[$trackname]=2;
			$inc = '___'.($trackinstance[$trackname]++);
		}
		$track[$trackname.$inc] = $value;

		//for all equal except textareas!
		$htmlvalue = str_replace("=","=3D",$value);
		$htmlfield_name = $field_name;
		
		// just for looks: break for textarea
		if ( $field_type == "textarea" || $field_type=="comment" ) {
				$field_name = "\n" . $field_name;
				$htmlvalue = str_replace(array("=","\n"),array("=3D","<br />\n"),$value);
				$value = "\n" . $value . "\n";
		}


		// for looks
		$space='';
		if ( strlen(stripslashes($field_name)) < $customspace )
			  $space = str_repeat(" ", $customspace - strlen(stripslashes($field_name)));

		$field_name .= ': ' . $space;


		if ( $field_stat[1] <> 'verification' && $field_stat[1] <> 'captcha' ){
				$formdata .= stripslashes( $field_name ) . $value . "\n";
				$htmlformdata .= '<tr><td class=3D"data-td">' . $htmlfield_name . '</td><td>' . $htmlvalue . '</td></tr>';
		}

	} //for all fields

	// assemble html formdata
	$htmlformdata = '<div class=3D"datablock"><table width=3D"100%" cellpadding=3D"2">' . stripslashes( $htmlformdata ) . '</table></div><span class=3D"cforms">powered by <a href=3D"http://www.deliciousdays.com/cforms-plugin">cformsII</a></span>';

	//
	// FIRST into the database is required!
	//
	
	$subID = ( get_option('cforms'.$no.'_tellafriend')=='2' && !$send2author )?'noid':write_tracking_record($no,$field_email);
		
	//
	// Files uploaded??
	//
	$filefield=0;
    $temp = explode( '$#$',stripslashes(htmlspecialchars(get_option('cforms'.$no.'_upload_dir'))) );
    $fileuploaddir = $temp[0];
	if ( isset($_FILES['cf_uploadfile'.$no]) ) {
		foreach( $_FILES['cf_uploadfile'.$no][tmp_name] as $tmpfile ) {
            //copy attachment to local server dir
            if ( $tmpfile <> '')
            	copy($tmpfile,$fileuploaddir.'/'.$subID.'-'.$file['name'][$filefield]);
        	$filefield++;
		}	 
	}

	//
	//set reply-to & watch out for T-A-F
	//
	$replyto = preg_replace( array('/;|#|\|/'), array(','), stripslashes(get_option('cforms'.$no.'_email')) );

	// multiple recipients? and to whom is the email sent?
	if ( get_option('cforms'.$no.'_tellafriend')=='2' ){
			$to = get_userdata( $wpdb->get_var("SELECT post_author FROM $wpdb->posts WHERE ID = {$_POST['comment_post_ID']}") );		
			$to = ($to->user_email<>'')?$to->user_email:$replyto;
	}
	else if ( $to_one <> "-1" ) {
			$all_to_email = explode(',', $replyto);
			$replyto = $to = $all_to_email[ $to_one ];
	} else
			$to = $replyto;

	//T-A-F? then overwrite
	if ( $taf_youremail && $taf_friendsemail && substr(get_option('cforms'.$no.'_tellafriend'),0,1)=='1' )
		$replyto = "\"{$taf_yourname}\" <{$taf_youremail}>";


	//
	// allow the user to use form data for other apps
	//
	$trackf['id'] = $no;
	$trackf['data'] = $track;
	do_action('cforms_data',$trackf);
	

	//
	// ready to send email
	// email header 
	//
	$eol = "\n";

	if ( ($frommail=stripslashes(get_option('cforms'.$no.'_fromemail')))=='' )
		$frommail = '"'.get_option('blogname').'" <wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])) . '>';	
	
	$headers = "From: ". $frommail . $eol;
	$headers.= "Reply-To: " . $field_email . $eol;

	if ( ($tempBcc=stripslashes(get_option('cforms'.$no.'_bcc'))) != "")
	    $headers.= "Bcc: " . $tempBcc . $eol;

	$headers.= "MIME-Version: 1.0"  .$eol;
	$headers.= "Content-Type: multipart/mixed; boundary=\"----MIME_BOUNDRY_main_message\"";

	// prep message text, replace variables
	$message	= get_option('cforms'.$no.'_header');
	$message	= check_default_vars($message,$no);
	$message	= check_cust_vars($message,$track);
	
	// text & html message
	$fmessage = "This is a multi-part message in MIME format."  . $eol;
	$fmessage .= "------MIME_BOUNDRY_main_message"  . $eol;


	// HTML message part?
	$html_show = ( substr(get_option('cforms'.$no.'_formdata'),2,1)=='1' )?true:false;

	if ($html_show) {
		$fmessage .= "Content-Type: multipart/alternative; boundary=\"----MIME_BOUNDRY_sub_message\"" . $eol . $eol;
		$fmessage .= "------MIME_BOUNDRY_sub_message"  . $eol;
		$fmessage .= "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"" . $eol;
		$fmessage .= "Content-Transfer-Encoding: quoted-printable"  . $eol . $eol;
	}
	else
		$fmessage .= "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"" . $eol . $eol;

	$fmessage .= $message . $eol;
	
	// need to add form data summary or is all in the header anyway?
	if(substr(get_option('cforms'.$no.'_formdata'),0,1)=='1')
		$fmessage .= $eol . $formdata . $eol;


	// HTML text
	if ( $html_show ) {
	
		// actual user message
		$htmlmessage = get_option('cforms'.$no.'_header_html');					
		$htmlmessage = check_default_vars($htmlmessage,$no);
		$htmlmessage = str_replace('=','=3D', stripslashes( check_cust_vars($htmlmessage,$track) ) );


		$fmessage .= "------MIME_BOUNDRY_sub_message"  . $eol;	
		$fmessage .= "Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"". $eol;
		$fmessage .= "Content-Transfer-Encoding: quoted-printable"  . $eol . $eol;;

		$fmessage .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">"  . $eol;

		$fmessage .= "<HTML>" . $eol;
		$fmessage .= $styles;
		$fmessage .= "<BODY>" . $eol;

		$fmessage .= $htmlmessage;

		// need to add form data summary or is all in the header anyway?
		if(substr(get_option('cforms'.$no.'_formdata'),1,1)=='1')
			$fmessage .= $eol . $htmlformdata;

		$fmessage .= "</BODY></HTML>"  . $eol . $eol;
	}

	// end of sub message
	
	$attached='';
	// possibly add attachment
	if ( isset($_FILES['cf_uploadfile'.$no]) && $filedata[0]<>'' && !get_option('cforms'.$no.'_noattachments') ) {

			// different header for attached files
	 		//
	 		$all_mime = array("txt"=>"text/plain", "htm"=>"text/html", "html"=>"text/html", "gif"=>"image/gif", "png"=>"image/x-png",
	 						 "jpeg"=>"image/jpeg", "jpg"=>"image/jpeg", "tif"=>"image/tiff", "bmp"=>"image/x-ms-bmp", "wav"=>"audio/x-wav",
	 						 "mpeg"=>"video/mpeg", "mpg"=>"video/mpeg", "mov"=>"video/quicktime", "avi"=>"video/x-msvideo",
	 						 "rtf"=>"application/rtf", "pdf"=>"application/pdf", "zip"=>"application/zip", "hqx"=>"application/mac-binhex40",
	 						 "sit"=>"application/x-stuffit", "exe"=>"application/octet-stream", "ppz"=>"application/mspowerpoint",
							 "ppt"=>"application/vnd.ms-powerpoint", "ppj"=>"application/vnd.ms-project", "xls"=>"application/vnd.ms-excel",
							 "doc"=>"application/msword");

			if ( $html_show )
				$fmessage .= "------MIME_BOUNDRY_sub_message--"  . $eol;

			for ( $filefield=0; $filefield < count($_FILES['cf_uploadfile'.$no][name]); $filefield++) {

				if ( $filedata[$filefield] <> '' ){
					$mime = (!$all_mime[$fileext[$filefield]])?'application/octet-stream':$all_mime[$fileext[$filefield]];
	
					$attached .= "------MIME_BOUNDRY_main_message" . $eol;		
					$attached .= "Content-Type: $mime;\n\tname=\"" . $file['name'][$filefield] . "\"" . $eol;
					$attached .= "Content-Transfer-Encoding: base64" . $eol;
					$attached .= "Content-Disposition: inline;\n\tfilename=\"" . $file['name'][$filefield] . "\"\n" . $eol;
					$attached .= $eol . $filedata[$filefield]; 	//The base64 encoded message
				}				
				
			}
		
	}


	//
	// finally send mails
	//

	//either use configured subject or user determined
	//now replace the left over {xyz} variables with the input data
	$vsubject = get_option('cforms'.$no.'_subject');
	$vsubject = check_default_vars($vsubject,$no);
	$vsubject = stripslashes( check_cust_vars($vsubject,$track) );

	// SMTP server or native PHP mail() ?
	if ( $smtpsettings[0]=='1' )
		$sentadmin = cforms_phpmailer( $no, $frommail, $field_email, $to, $vsubject, $message, $formdata, $htmlmessage, $htmlformdata, $fileext );
	else
		$sentadmin = @mail($to, encode_header($vsubject), $fmessage.$attached, $headers);	

	if( $sentadmin==1 ) {
			  // send copy or notification?
		    if ( (get_option('cforms'.$no.'_confirm')=='1' && $field_email<>'') || $ccme )  // not if no email & already CC'ed
		    {
						if ( ($frommail=stripslashes(get_option('cforms'.$no.'_fromemail')))=='' )
							$frommail = '"'.get_option('blogname').'" <wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])) . '>';	
						
						// HTML message part?
						$html_show_ac = ( substr(get_option('cforms'.$no.'_formdata'),3,1)=='1' )?true:false;
						$automsg = '';

						$headers2 = "From: ". $frommail . $eol;
						$headers2.= "Reply-To: " . $replyto . $eol;

						if ( substr(get_option('cforms'.$no.'_tellafriend'),0,1)=='1' ) //TAF: add CC
							$headers2.= "CC: " . $replyto . $eol;

						$headers2.= "MIME-Version: 1.0"  .$eol;

						if( $html_show_ac || ($html_show && $ccme ) ){
							$headers2.= "Content-Type: multipart/alternative; boundary=\"----MIME_BOUNDRY_main_message\"";
							$automsg .= "This is a multi-part message in MIME format."  . $eol;
							$automsg .= "------MIME_BOUNDRY_main_message"  . $eol;
							$automsg .= "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"; format=flowed" . $eol;
							$automsg .= "Content-Transfer-Encoding: quoted-printable"  . $eol . $eol;								
						} 
						else
							$headers2.= "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"; format=flowed";
						

						// actual user message
						$cmsg = get_option('cforms'.$no.'_cmsg');					
						$cmsg = check_default_vars($cmsg,$no);
						$cmsg = check_cust_vars($cmsg,$track);
	
				
						// text text
						$automsg .= $cmsg . $eol;
	
						// HTML text
						if ( $html_show_ac ) {
						
							// actual user message
							$cmsghtml = get_option('cforms'.$no.'_cmsg_html');					
							$cmsghtml = check_default_vars($cmsghtml,$no);
							$cmsghtml = str_replace('=','=3D', check_cust_vars($cmsghtml,$track));
	
							$automsg .= "------MIME_BOUNDRY_main_message"  . $eol;
							$automsg .= "Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"". $eol;
							$automsg .= "Content-Transfer-Encoding: quoted-printable"  . $eol . $eol;;
		
							$automsg .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">"  . $eol;
							$automsg .= "<HTML><BODY>"  . $eol;
							$automsg .= $cmsghtml;
							$automsg .= "</BODY></HTML>"  . $eol . $eol;
						}							
						
					 	$subject2 = get_option('cforms'.$no.'_csubject');
						$subject2 = check_default_vars($subject2,$no);
						$subject2 = check_cust_vars($subject2,$track);

						// different cc & ac subjects?
						$t=explode('$#$',$subject2);
						$t[1] = ($t[1]<>'') ? $t[1] : $t[0];

						// email tracking via 3rd party?
						$field_email = (get_option('cforms'.$no.'_tracking')<>'')?$field_email.get_option('cforms'.$no.'_tracking'):$field_email;
    
						// if in Tell-A-Friend Mode, then overwrite header stuff...
						if ( $taf_youremail && $taf_friendsemail && substr(get_option('cforms'.$no.'_tellafriend'),0,1)=='1' )
							$field_email = "\"{$taf_friendsname}\" <{$taf_friendsemail}>";

						if ( $ccme ) {
							if ( $smtpsettings[0]=='1' )
								$sent = cforms_phpmailer( $no, $frommail, $replyto, $field_email, stripslashes($t[1]), $message, $formdata, $htmlmessage, $htmlformdata, 'ac' );
							else
								$sent = @mail($field_email, encode_header(stripslashes($t[1])), $fmessage, $headers2); //the admin one
						}
						else {
							if ( $smtpsettings[0]=='1' )
								$sent = cforms_phpmailer( $no, $frommail, $replyto, $field_email, stripslashes($t[0]) , $cmsg , '', $cmsghtml, '', 'ac' );
							else
								$sent = @mail($field_email, encode_header(stripslashes($t[0])), stripslashes($automsg), $headers2); //takes the above
						}
				
		  		if( $sent<>'1' )
			  			$usermessage_text = __('Error occurred while sending the auto confirmation message: ','cforms')." ($sent)";
		    }

		// redirect to a different page on suceess?
		if ( get_option('cforms'.$no.'_redirect')==1 ) {
			?>
			<script type="text/javascript">
				location.href = '<?php echo get_option('cforms'.$no.'_redirect_page') ?>';
			</script>
			<?php 
		}		
		
  	} // if first email already failed
	else
		$usermessage_text = __('Error occurred while sending the message: ','cforms') . '<br />'. $smtpsettings[0]?'<br />'.$sentadmin:'';

} //if isset & valid sendbutton

function cforms_is_email($string){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $string);
}	
?>
