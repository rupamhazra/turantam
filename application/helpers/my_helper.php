<?php

function pre($array, $die='')
{
	if($die==1){
		echo "<pre>";
		print_r($array);
		echo "</pre>";
		die();
	}else{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}

/* draws a calendar */
function draw_calendar($month,$year){

	/* date settings */
    $month = (int) (isset($_GET['month']) ? $_GET['month'] : date('m'));
    $year = (int)  (isset($_GET['year']) ? $_GET['year'] : date('Y'));

    /* select month control */
    $month_year_header = date('F',mktime(0,0,0,$month,1,$year)).'&nbsp;'.$year.'&nbsp;';
    $select_month_control = '<select name="month" id="month">';
    for($x = 1; $x <= 12; $x++) {
      $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
    }
    $select_month_control.= '</select>';

    /* select year control */
    $year_range = 20;
    $select_year_control = '<select name="year" id="year">';
    for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
      $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
    }
    $select_year_control.= '</select>';

    /* "next month" control */
    $next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month >></a>';

    /* "previous month" control */
    $previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><<  Previous Month</a>';

    /* bringing the controls together */
    $controls = '<form method="get">'.$month_year_header.$select_month_control.$select_year_control.' <input type="submit" name="submit" value="Go" />      '.$previous_month_link.'     '.$next_month_link.' </form>';

    echo $controls;




	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

function footer_dyanamic_portions(){
	$CI = get_instance();
    $CI->load->model('sitemodel','Sitemodel');
    
    $data=array(); 
	$data['page'] = $CI->sitemodel->get_page_by_url('destinations');
	//pre($data['page'],1);

	$category_in_page = explode(",",json_decode($data['page']['category_ids']));
	$data['destinations'] = $CI->categorygmodel->get_all_category($category_in_page,6);

	$CI->load->model('categorymodel','Categorymodel');
	$data['page'] = $CI->sitemodel->get_page_by_url('tours');
	//pre($data['page'],1);
	$category_in_page = explode(",",json_decode($data['page']['category_ids']));
	$data['tours'] = $CI->categorygmodel->get_all_category($category_in_page,6);
	//pre($data['tours'],1);

	$html = '<div class="col-lg-3 col-md-3 col-sm-6 col-sm-6 no-padding"><div class="footer-block"><h6>Recent Tours</h6>';
    foreach ($data['tours'] as $key => $value) { 
    	if($key>2) break; 

    $html .= '<div class="f_news clearfix"><a class="f_news-img black-hover" href="#"><img class="img-responsive" src="'.base_url().'uploads/category_pics/'.$value['pic'].'" alt=""><div class="tour-layer delay-1"></div>
		</a><div class="f_news-content"><a class="f_news-tilte color-white link-red" href="#">'.$value['title'].'</a><span class="date-f">'.$value['created_at'].'</span><a href="'.base_url().'tours/'.$value['url'].'" class="r-more">read more</a></div></div>';
	}                        
    $html.= '</div></div><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="footer-block"><h6>Recent Destinations</h6>';
	foreach ($data['destinations'] as $key => $value) { 
		if($key>2) break;
    $html.= '<div class="f_news clearfix"><a class="f_news-img black-hover" href="#">
		<img class="img-responsive" src="'.base_url().'uploads/category_pics/'.$value['pic'].'" alt=""><div class="tour-layer delay-1"></div></a><div class="f_news-content"><a class="f_news-tilte color-white link-red" href="#">'.$value['title'].'</a><span class="date-f">'.$value['created_at'].'</span><a href="'.base_url().'destinations/'.$value['url'].'" class="r-more">read more</a></div></div>';
    }
    $html.= '</div></div>';
    echo $html;                       
}
function footer_from_admin($postion){
	$CI = get_instance();
    $CI->load->model('settingsmodel','Settingsmodel');

    $data=array(); 
	$data['footer_details'] = $CI->settingsmodel->get_footer_by_id('',$postion);
	//pre($data['footer_details'],1);
	$html = $data['footer_details']['content'];
	//$html = str_replace('<img', '<img src="hanoi-logo.png" alt="" class="logo-footer" />', $html);
	echo $html;

	                    
}
function getOrderConfigDetails($type='',$cus_id,$price){
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
	require_once("paytm/config_paytm.php");
	require_once("paytm/encdec_paytm.php");
	$checkSum = "";
	$paramList = $data = [];
	$paramList["MID"] = PAYTM_MERCHANT_MID;
	$paramList["ORDER_ID"] =  "ORDS" . rand(10000,99999999);
	$paramList["CUST_ID"] = $cus_id;
	$paramList["INDUSTRY_TYPE_ID"] = 'Retail';
	$paramList["TXN_AMOUNT"] = $price;
	if($type == 'web'){
		$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		$paramList["CHANNEL_ID"] = 'WEB';
	}
	else{
		$paramList["WEBSITE"] = 'APPSTAGING';
		$paramList["CHANNEL_ID"] = 'WAP';
	}

	//Here checksum string will return by getChecksumFromArray() function.
	$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
	$paramList['CHEKSUMHASH'] = $checkSum;
	if($type == 'web'){
		$paramList["CALLBACK_URL"] = base_url('/').'api/updateorder';
	}
	else{
		$paramList["CALLBACK_URL"] = 'https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID='.$paramList["ORDER_ID"];
	}
	return $paramList;
}

function sms($data){
	/*
	* Requirements: your PHP installation needs cUrl support, which not all PHP installations
	* include by default.
	*/
	$username = 'shail';
	$password = '6209';
	/*
	* Your phone number, only 10 digit number, i.e. 8107887472 in this case:
	*/
	$numbers = $data['contact'];
	/*
	* your 6 characters Sender ID
	*/
	$sender = 'BLKsMs';
	$message = $data['message'];
	$message = urlencode($message);
	$url = "http://sms.faresms.com/api/pushsms.php";
	$url = $url."?username=".urlencode($username)."&password=".urlencode($password)."&sender=". $sender ."&message=". $message."&numbers=".$numbers;
	//Use file_get_contents to GET the URL in question.
	$contents = file_get_contents($url);
	//If $contents is not a boolean FALSE value.
	if($contents !== false){
    return $contents;
	}
}
function send_mail($data,$for=''){
	//pre($data,1);
	$from_email = $from_name = $to_email='';
	$CI = get_instance();
	$CI->load->model('Settingsmodel','settingsmodel');
	$link = 'https://www.shyamfuture.com/';
	$mail_config = $CI->settingsmodel->get_mail_config();
	$mail_config = (array)json_decode($mail_config['settings_v']);
	//pre($mail_config,1);
	if($for == 'contact-us')
	{
		$from_email = 'support@turantam.com';
		$from_name = 'Turantam Contact';
		$to_email = 'rupam@shyamfuture.com';
		$email_body = $CI->settingsmodel->get_templates_by_code('contact-us');
		$html = str_replace('[[name]]',$data['name'],$email_body['content']);
		$html = str_replace('[[email]]',$data['email'],$html);
		$html = str_replace('[[phone]]',$data['phone'],$html);
		$html = str_replace('[[message]]',$data['message'],$html);
	}
	else
	{
		$from_email = 'support@turantam.com';
		$from_name = 'Turantam';
		$to_email = $data['email'];
		$email_body = $CI->settingsmodel->get_templates_by_code('user-register');
		$html = str_replace('[[name]]',$data['name'],$email_body['content']);
		$html = str_replace('[[email]]',$data['email'],$html);
		$html = str_replace('[[link]]',$link,$html);
		$html = str_replace('[[password]]',$data['password'],$html);
	}
	
	//pre($html,1);
    $final_html = $html;
    //pre($final_html,1);
    $CI->load->library("PhpMailerLib");
	$mail = $CI->phpmailerlib->load();
	try {
	     //Server settings
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = $mail_config['host'];//'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = $mail_config['username']; //'noreply@shyamfuture.com';                 // SMTP username
	    $mail->Password = $mail_config['password']; //'noreply123';                           // SMTP password
	    $mail->SMTPSecure = ($mail_config['ssl_tls'] == 1) ? 'ssl':''; //'ssl';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port =  $mail_config['port']; //465;                                    // TCP port to connect to
	    //Recipients
	    $mail->setFrom($from_email, $from_name);
	    $mail->addAddress($to_email);     // Add a recipient

		 	//$mail->addCC('contact@shyamfuture.com');
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $email_body['subject'];
	    $mail->Body    = $final_html;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	    if($for == 'contact-us') return $mail->send();
	    else $mail->send();
	    //die('123');
	    //echo 'Message has been sent';
	} catch (Exception $e) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
		//die;
}
?>
