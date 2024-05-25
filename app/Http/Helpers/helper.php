<?php 
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

use Twilio\Rest\Client;
// from shn

// for dynamic mail

if (!function_exists('DynamicMailTemplateFormatter')) {
    function DynamicMailTemplateFormatter($body, $variable_names, $var_list)
    {
        // Make it Foreachable
        // return $variable_names;
        $variable_names = explode(', ', $variable_names);
        $i = 1;
        $data = "";
        foreach ($variable_names as $item) {
            if ($i == 1) {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $body);
                    $i += 1;
                }
            } else {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $data);
                }
            }
        }
        return $data;
    }
}
// get auth profile image

if (!function_exists('getAuthProfileImage')) {
    function getAuthProfileImage($path){
        if(\Str::contains($path, 'https:')){
            return $path;
        }
        $profile_img = $path;
        if($profile_img != null){
            return $profile_img;
        }
    }
}

if (!function_exists('getArticleImage')) {
    function getArticleImage($path){
        $profile_img = asset($path);
        if($profile_img){
            return $profile_img;
        }else{
            asset('backend/default/default-avatar.png');
        }
    }
}

// custommail template with template table
if (!function_exists('asset')) {
    function asset($path,$secure=null){
        $timestamp = @filemtime(public_path($path)) ?: 0;
        return asset($path, $secure) . '?' . $timestamp;
    }
}

if (!function_exists('getSupportTicketStatus')) {
    function getSupportTicketStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>0,'name'=>'Under Working','color'=>'info'],
                ['id'=>1,'name'=>'Reply Received','color'=>'warning'],
                ['id'=>2,'name'=>'Resolved','color'=>'success'],
                ['id'=>3,'name'=>'Rejected','color'=>'danger'],
                ['id'=>4,'name'=>'Close','color'=>'danger'],
                ];
            }else{
                foreach(getSupportTicketStatus() as $row){
                if($row['id'] == $id){
                return $row;
                }
            }
        }
    }
}
if (!function_exists('getWalletStatus')) {
    function getWalletStatus($id = -1)
        {
            if($id == -1){
                return [
                    ['id'=>0,'name'=>'Requested','color'=>'info'],
                    ['id'=>1,'name'=>'Accepted','color'=>'success'],
                    ['id'=>2,'name'=>'Declined','color'=>'danger'],
                    ];
            }else{
                foreach(getWalletStatus() as $row){
                    if($row['id'] == $id){
                        return $row;
                    return $row;
                    }
                }
                return ['id'=>$id,'name'=>'','color'=>''];
            }
    }
}
if (!function_exists('getWorkingUpdateStatus')) {
    function getWorkingUpdateStatus($id = -1)
        {
            if($id == -1){
                return [
                    ['id'=>0,'name'=>'Available','color'=>'success'],
                    ['id'=>1,'name'=>'Unavailable','color'=>'danger'],
                    ['id'=>2,'name'=>'Busy','color'=>'warning'],
                    ];
            }else{
                foreach(getWorkingUpdateStatus() as $row){
                    if($row['id'] == $id){
                        return $row;
                    return $row;
                    }
                }
                return ['id'=>$id,'name'=>'','color'=>''];
            }
    }
}
  
    if(!function_exists('getSupportTicketPrefix')){
        function getSupportTicketPrefix($id){
            return '#SUPTICK'.$id;
        }
    }
    //article prefix
    if(!function_exists('articlePrefix')){
        function articlePrefix($id){
            return '#ARTID'.$id;
        }
    }
    
    if(!function_exists('getUserPrefix')){
        function getUserPrefix($id){
            return '#HDUID'.$id;
        }
    }
    if(!function_exists('getPatientFilePrefix')){
        function getPatientFilePrefix($id){
            return '#HDPFID'.$id;
        }
    }
    if(!function_exists('getStoryPrefix')){
        function getStoryPrefix($id){
            return '#HDSTRID'.$id;
        }
    }
    if(!function_exists('getFollowUpPrefix')){
        function getFollowUpPrefix($id){
            return '#HDFUID'.$id;
        }
    }
    if(!function_exists('getDiagnosticCentersPrefix')){
        function getDiagnosticCentersPrefix($id){
            return '#HDDCID'.$id;
        }
    }
    if(!function_exists('getPostPrefix')){
        function getPostPrefix($id){
            return '#HDPID'.$id;
        }
    }
    if(!function_exists('getPostLikePrefix')){
        function getPostLikePrefix($id){
            return '#HDPLID'.$id;
        }
    }
    if(!function_exists('getPostCommentPrefix')){
        function getPostCommentPrefix($id){
            return '#HDPCID'.$id;
        }
    }
    if(!function_exists('getDoctorReferralPrefix')){
        function getDoctorReferralPrefix($id){
            return '#HDDRID'.$id;
        }
    }
    if(!function_exists('getScanLogPrefix')){
        function getScanLogPrefix($id){
            return '#HDSLID'.$id;
        }
    }
    if(!function_exists('getSubscriptionsPrefix')){
        function getSubscriptionsPrefix($id){
            return '#HDSUBID'.$id;
        }
    }
    if(!function_exists('getSubscriberPrefix')){
        function getSubscriberPrefix($id){
            return '#HDSUBRID'.$id;
        }
    }
    if(!function_exists('getDoctorRankPrefix')){
        function getDoctorRankPrefix($id){
            return '#HDDRID'.$id;
        }
    }
    if(!function_exists('getRevenuePrefix')){
        function getRevenuePrefix($id){
            return '#HDREID'.$id;
        }
    }
    if(!function_exists('getExperiencePrefix')){
        function getExperiencePrefix($id){
            return '#HDEXID'.$id;
        }
    }
    if(!function_exists('getEducationPrefix')){
        function getEducationPrefix($id){
            return '#HDEDUID'.$id;
        }
    }
    if(!function_exists('getAccessDoctorPrefix')){
        function getAccessDoctorPrefix($id){
            return '#DOC'.$id;
        }
    }
    
    if (!function_exists('getMyPatientLists')) {
    function getMyPatientLists($doc_id)
        {
            $userids = App\Models\Scanlog::where('doctor_id',$doc_id)->pluck('user_id');
            $users = App\User::whereIn('id',$userids)->orWhere('doctor_id',$doc_id)->get();
            return $users;
        }
    }
  
// custommail template with template table
if (!function_exists('customMail')) {
    function customMail($name,$to,$mailcontent_data,$arr,$cc = null ,$bcc = null ,$action_btn = null ,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null){
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $chk_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mailcontent_data->footer;
        $t_data = DynamicMailTemplateFormatter($chk_data->body ,$chk_data->variables ,$arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_btn;
        $data['attachment_path'] = $attachment_path;
        $data['attachment_name'] = $attachment_name;
        $data['cc'] = $cc == null ? [] : $cc;
        $data['bcc'] = $bcc == null ? [] : $cc;
        if($mailcontent_data->type == 1){
            if(getSetting('email_notify')){
                $mail = \Mail::to($to);
                if($cc != null){
                        $mail->cc($cc, getSetting('mail_from_name'));
                }
                if($bcc != null){
                    $mail->bcc($bcc, getSetting('mail_from_name'));
                }
        
                $mail->send(new App\Mail\CustomMail($data));

            }
        }
        if($mailcontent_data->type == 2){
            // sms
            manualSms($to,$t_data);
        }
        if($mailcontent_data->type == 3){
            // whatsapp
        }
    }
}
if(!function_exists('getEnquiryStatus')){
    function getEnquiryStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Schedule" ,'color' =>"primary"],
            ['id'=>1,'name'=>"Examined",'color' =>"success"],
            

        ];
        }else{
            foreach(getEnquiryStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];

        }
    }
}
if(!function_exists('getStoryStatus')){
    function getStoryStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"1. Under Working" ,'color' =>"primary"],
            ['id'=>1,'name'=>"2. Review Needed",'color' =>"warning"],
            ['id'=>2,'name'=>"3. Reviewed",'color' =>"success"],
            

        ];
        }else{
            foreach(getStoryStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];

        }
    }
}
if(!function_exists('chartKeyRange')){
    function chartKeyRange($name = -1, $type = 0){
        if($name == -1){
        return [
            //blood
            ['name'=>"Haemoglobin" ,'range_from' =>12,'range_to'=>15,'uom'=>' gm/dl'],
            ['name'=>"WBC" ,'range_from' =>4000,'range_to'=>11000,'uom'=>'µL'],
            ['name'=>"RBC" ,'range_from' =>4  ,'range_to'=>5.5,'uom'=>'lakh µL'],
            ['name'=>"Platlets" ,'range_from' =>1.5 ,'range_to'=>4,'uom'=>' lakh / µL'],
            ['name'=>"Retic count" ,'range_from' =>0.5 ,'range_to'=> 2.5,'uom'=>'gm'],
            ['name'=>"Htc" ,'range_from' =>37 ,'range_to'=> 47,'uom'=>'%'],
            ['name'=>"MCV" ,'range_from' =>83 ,'range_to'=>101 ,'uom'=>'fL'],
            //liver
            ['name'=>"Tot Bili" ,'range_from' =>0 ,'range_to'=>1,'uom'=>'mg/dl'],
            ['name'=>"Direct Bili" ,'range_from' =>0 ,'range_to'=>0.4,'uom'=>'mg/dl'],
            ['name'=>"Indirect Bili" ,'range_from' =>0,'range_to'=>0.6 ,'uom'=>'mg/dl'],
            ['name'=>"Protein" ,'range_from' =>6.3,'range_to'=>8.3 ,'uom'=>'mg/dl'],
            ['name'=>"Albumin" ,'range_from' =>3.6,'range_to'=>04.5 ,'uom'=>'mg/dl'],
            ['name'=>"AST" ,'range_from' =>0,'range_to'=>40 ,'uom'=>'iU/L'],
            ['name'=>"ALT" ,'range_from' =>10,'range_to'=>40 ,'uom'=>'iU/L'],
            ['name'=>"ALP" ,'range_from' =>40,'range_to'=>140 ,'uom'=>'iU/L'],

            // Kidney Function
            ['name'=>"Urea" ,'range_from' =>15,'range_to'=>40 ,'uom'=>' mg/dl'],
            ['name'=>"Creatinine" ,'range_from' =>0.5,'range_to'=>1.2 ,'uom'=>' mg/dl'],
            ['name'=>"BUN" ,'range_from' =>6,'range_to'=>24 ,'uom'=>' mg/dl'],
            ['name'=>"Sodium" ,'range_from' =>135,'range_to'=> 145 ,'uom'=>' mg/dl'],
            ['name'=>"Potassium" ,'range_from' =>3,'range_to'=> 5.5 ,'uom'=>' mg/dl'],
            ['name'=>"Calcium" ,'range_from' =>8.5 ,'range_to'=> 10.2 ,'uom'=>' mg/dl'],
            ['name'=>"uric acid" ,'range_from' =>1.3 ,'range_to'=> 6 ,'uom'=>' mg/dl'],
            // Lipid Profile
            ['name'=>"Total Cholesterol" ,'range_from' =>0 ,'range_to'=>200 ,'uom'=>' mg/dl'],
            ['name'=>"Triglyceride" ,'range_from' =>25 ,'range_to'=>175 ,'uom'=>' mg/dl'],
            ['name'=>"HDL" ,'range_from' =>60 ,'range_to'=>1000 ,'uom'=>' mg/dl'],
            ['name'=>"LDL" ,'range_from' =>0 ,'range_to'=>100 ,'uom'=>' mg/dl'],
            ['name'=>"VLDL" ,'range_from' =>7 ,'range_to'=>35 ,'uom'=>' mg/dl'],
            ['name'=>"LDL/HDL" ,'range_from' =>0.5 ,'range_to'=>3 ,'uom'=>' mg/dl'],
            //  Diabetes Screening
            ['name'=>"FBS" ,'range_from' =>70 ,'range_to'=>110 ,'uom'=>'mg/dl'],
            ['name'=>"PP2BS" ,'range_from' =>70 ,'range_to'=>140 ,'uom'=>'mf/dl'],
            ['name'=>"RBS" ,'range_from' =>70 ,'range_to'=>140 ,'uom'=>' mg/dl'],
            ['name'=>"OGT" ,'range_from' =>70 ,'range_to'=>140 ,'uom'=>'mg/dl'],
            ['name'=>"HbA1c" ,'range_from' =>4.5 ,'range_to'=>6 ,'uom'=>'%'],
            // Thyroid Function  (> 18 yr age)
            ['name'=>"TSH" ,'range_from' =>0.4 ,'range_to'=>5.0 ,'uom'=>'uIU/mL'],
            ['name'=>"T3" ,'range_from' =>70 ,'range_to'=> 204 ,'uom'=>'ng/dl'],
            ['name'=>"T4" ,'range_from' =>4.8,'range_to'=>13.5 ,'uom'=>'ug/dl' ],
            ['name'=>"Free T3" ,'range_from' =>2.10 ,'range_to'=>4.40,'uom'=>'ng/dl' ],
            ['name'=>"Free T4" ,'range_from' =>0.9 ,'range_to'=>2.5 ,'uom'=>'ug/dl'],
            ['name'=>"TBG" ,'range_from' =>1.5 ,'range_to'=>3.4 ,'uom'=>'gm'],
            ['name'=>"Anti TPO" ,'range_from' =>0 ,'range_to'=>0.8,'uom'=>'IU/ml'],
            // Urine Test
            ['name'=>"PH" ,'range_from' =>4.6,'range_to'=>8,'uom'=>'gm'],
            ['name'=>"Sugar" ,'range_from' =>0 ,'range_to'=>0 ,'uom'=>'gm'],
            ['name'=>"Ketones" ,'range_from' =>0 ,'range_to'=>0,'uom'=>'gm' ],
            ['name'=>"ProteinTest" ,'range_from' =>0 ,'range_to'=>0 ,'uom'=>'gm'],
            ['name'=>"Pus cells" ,'range_from' =>1 ,'range_to'=>5 ,'uom'=>'gm'],
            ['name'=>"Cast" ,'range_from' =>1 ,'range_to'=>5 ,'uom'=>'gm'],
            ['name'=>"Epithelial cell" ,'range_from' =>1 ,'range_to'=>5 ,'uom'=>'gm'],
   

        ];
        }else{
            foreach(chartKeyRange() as $row){
                if($name == $row['name']){
                    if($type == 1){
                        return $row;
                    }else{
                        return $row['range_from'].'-'.$row['range_to'].''.$row['uom'];
                    }
            }
        }
        return 'N/A';

        }
    }
}
if(!function_exists('getPayoutStatus')){
    function getPayoutStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Unpaid" ,'color' =>"warning"],
            ['id'=>1,'name'=>"Paid",'color' =>"success"],
            ['id'=>2,'name'=>"Rejected",'color' =>"danger"],

        ];
        }else{
            foreach(getPayoutStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getTransactionType')){
    function getTransactionType($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Credit" ,'color' =>"danger"],
            ['id'=>1,'name'=>"Debit",'color' =>"success"],

        ];
        }else{
            foreach(getTransactionType() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if (!function_exists('pushWalletLog')) {
    function pushWalletLog($user_id,$type,$amount,$after_balance,$remark)
    {
        $wallet_record = App\Models\WalletLog::create([
            'user_id'=>$user_id,
            'type'=>$type,
            'amount'=>$amount,
            'after_balance'=>$after_balance,
            'remark'=>$remark,
        ]);

    }
}

// custommail template with template table
if (!function_exists('TemplateMail')) {
    function TemplateMail($name, $code, $to, $mail_type, $arr, $mailcontent_data, $mail_footer = null, $action_button = null)
    {
        
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $chk_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $data['type_id'] = $mail_type;
        $type_id = $mail_type;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mail_footer;

        $t_data =  DynamicMailTemplateFormatter($chk_data->body, $chk_data->variables, $arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_button;

        if(getSetting('email_notify')){
            // Mail Sender
            \Mail::send('emails.dynamic-custom', $data, function ($message) use ($to, $name, $subject) {
                $message->to($to, $name)->subject($subject);
                $message->from(getSetting('mail_from_address'), getSetting('app_name'));
            });
        }
        return true;
    }
}

// manual Email without template table
if (!function_exists('StaticMail')) {
    function StaticMail($name, $to, $subject, $body, $mail_footer = null, $action_button = null, $cc = null, $bcc = null,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null)
    {
        if($cc == null){
            $cc = '';
        }
        if($bcc == null){
            $bcc = '';
        }
        $data['name'] = $name;
        $data['subject'] = $subject;
        $data['t_footer'] = $mail_footer;
        $data['t_data'] = $body;
        $data['action_button'] = $action_button;

        // Mail Sender
        try{
            if(getSetting('email_notify')){
                $mail = \Mail::to($to);
                if($cc != null){
                        $mail->cc($cc, getSetting('mail_from_name'));
                }
                if($bcc != null){
                    $mail->bcc($bcc, getSetting('mail_from_name'));
                }
                if($attachment_path != null)
                {
                    $mail->attach($attachment_path, [
                            'as'    => $attachment_name,
                            'mime'  => $attachment_mime,
                        ]);
                }
                $mail->send(new App\Mail\CustomMail($data));
                

                
                // \Mail::send('emails.dynamic-custom', $data, function ($body) use ($to, $name,$cc, $bcc, $subject,$attachment_path,$attachment_name,$attachment_mime) {
                //     $body->to($to, $name)->subject($subject);
                //     if($cc != null){
                //         $body->cc($cc,getSetting('mail_from_name'));
                //     }
                //     if($bcc != null){
                //         $body->bcc($bcc, getSetting('mail_from_name'));
                //     }
                //     if($attachment_path != null)
                //     {
                //         $body->attach($attachment_path, [
                //                 'as'    => $attachment_name,
                //                 'mime'  => $attachment_mime,
                //             ]);
                //     }
                //     $body->from(getSetting('mail_from_address'), getSetting('mail_from_name'));
                // });
            }
            return "done";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
// Send Sms By Api
if (!function_exists('sendSms')) {
    function sendSms($number,$msg,$template_id){

        // $number must be comma separated values
        // $msg must be normal text
        $response = Http::withHeaders([
            'authkey' => '366553Aka2FC7OmM612e3ed7P1',
            'accept' => 'application/json'
        ])->get('http://otpsms.vision360solutions.in/api/sendhttp.php', [
            'mobiles' => $number,
            'message' => $msg,
            'sender' => "DEZLTE",
            'route' => 4,
            'country' => 91,
            'response' => "json",
            'DLT_TE_ID' => $template_id,
        ]);
        if($response){
            return $response;
        }else{
            return false;
        }
    }
}

// manual SMS By Twilio Account
if (!function_exists('manualSms')) {
    function manualSms($number,$msg)
    {
        $accountSid = getSetting('twilio_account_sid');
        $authToken  = getSetting('twilio_auth_token');
        $accountnumber  = getSetting('twilio_account_number');
        $client = new Client($accountSid, $authToken);
        $client->messages->create('+91'.$number,
            array(
                'from' => $accountnumber,
                'body' => $msg
            )
        );
    }
}


// old data recover
if (!function_exists('selectSelecter')) {
    function selectSelecter($old_val, $updated_val, $compare_val)
    {
        if ($old_val != null) {
            $result = $old_val == $compare_val ? "selected" : '';
        } elseif ($updated_val != null) {
            $result = $updated_val == $compare_val ? "selected" : '';
        } else {
            $result = '';
        }
        return $result;
    }
}

// from DFV

// currency amount cleaner 
if (!function_exists('currencyAmountCleaner')) {
    function currencyAmountCleaner($val)
    {
        $x = substr($val, 1);
        return str_replace(',', '', $x);
    }
}

if (!function_exists('getOrderHashCode')) {
    function getOrderHashCode($order_id)
    {
        return '#OID'.$order_id;
    }
}
if (!function_exists('getTicketHashCode')) {
    function getTicketHashCode($ticket_id)
    {
        return '#SUPTIC'.$ticket_id;
    }
}
if (!function_exists('getLeadHashCode')) {
    function getLeadHashCode($lead_id)
    {
        return '#LID'.$lead_id;
    }
}


// from albuhaira
// Age Calculator
function ageCalculator($dob)
{
    if (!empty($dob)) {
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    } else {
        return 0;
    }
}
// get Browser
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version= $matches['version'][0];
        } else {
            $version= $matches['version'][1];
        }
    } else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {
        $version="?";
    }
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

// get Image
if(!function_exists('getImage')){
    function getImage($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}
if(!function_exists('uploaded_asset')){
    function uploaded_asset($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}

// check and create dir
if(!function_exists('checkAndCreateDir')){
    function checkAndCreateDir($path){
        // Create directory if not exist
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
    }
}
if(!function_exists('getPriorities')){
    function getPriorities($id = -1){
       if($id == -1){
        return [
            ['id'=>0,'name'=>"Low",'color'=>'info'],
            ['id'=>1,'name'=>"Medium",'color'=>'secondary'],
            ['id'=>2,'name'=>"High",'color'=>'success'],
        ];
       }else{
        foreach(getPriorities() as $row){
            if($row['id'] == $id){
                return $row;
            }
        }
        return ['id'=>0,'name'=>"",'color'=>''];
       }
    }
}

// Convert 1000 into 1k
function thousandsCurrencyFormat($number = null) {

    $suffixByNumber = function () use ($number) {
        if ($number < 1000) {
            return sprintf('%d', $number);
        }

        if ($number < 1000000) {
            return sprintf('%d%s', floor($number / 1000), 'K+');
        }

        if ($number >= 1000000 && $number < 1000000000) {
            return sprintf('%d%s', floor($number / 1000000), 'M+');
        }

        if ($number >= 1000000000 && $number < 1000000000000) {
            return sprintf('%d%s', floor($number / 1000000000), 'B+');
        }

        return sprintf('%d%s', floor($number / 1000000000000), 'T+');
    };

    return $suffixByNumber();
}
if (!function_exists('getPostManagementStatus')) {
    function getPostManagementStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>0,'name'=>'Pending','color'=>'info'],
                ['id'=>1,'name'=>'Approved','color'=>'success'],
            ];
        }else{
            foreach(getPostManagementStatus() as $row){
                if($row['id'] == $id){
                    return $row;
                }
            }
         return ['id'=>'','name'=>'','color'=>''];
        }
    }
}


function get_image_mime_type($image_path)
{
    $mimes  = array(
        IMAGETYPE_GIF => "image/gif",
        IMAGETYPE_JPEG => "image/jpg",
        IMAGETYPE_PNG => "image/png",
        IMAGETYPE_SWF => "image/swf",
        IMAGETYPE_PSD => "image/psd",
        IMAGETYPE_BMP => "image/bmp",
        IMAGETYPE_TIFF_II => "image/tiff",
        IMAGETYPE_TIFF_MM => "image/tiff",
        IMAGETYPE_JPC => "image/jpc",
        IMAGETYPE_JP2 => "image/jp2",
        IMAGETYPE_JPX => "image/jpx",
        IMAGETYPE_JB2 => "image/jb2",
        IMAGETYPE_SWC => "image/swc",
        IMAGETYPE_IFF => "image/iff",
        IMAGETYPE_WBMP => "image/wbmp",
        IMAGETYPE_XBM => "image/xbm",
        IMAGETYPE_ICO => "image/ico");

    if (($image_type = exif_imagetype($image_path))
        && (array_key_exists($image_type ,$mimes)))
    {
        return $mimes[$image_type];
    }
    else
    {
        return false;
    }
}
function get_file_type($image_path)
{
    return mime_content_type($image_path);
}
function getDoctorRank()
{
    return 1;

}
function getRevenue()
{
    return 100;
}
// function giveSubsciptionBonus($p_id,$package_id)
// {
//     $user = App\User::where('id',$p_id)->first();
//     if($user){
//         if($user->doctor_id != null){
//             $subscription = App\Models\Subscription::where('id',$package_id)->first();
//             if($subscription){
//                 $package_commission = getSetting('package_amount');
//                 $amount  = $subscription->price * $package_commission/100;
//                 App\Models\WalletLog::create([
//                     'user_id' => $user->doctor_id,
//                     'type' => 'credit',
//                     'model' => 'SubscriptionReward',
//                     'amount' => $amount,
//                     'remark' => "Rewarding for patient ".NameById($p_id)." take subscription"
//                 ]);
//                 App\Models\WalletLog::create([
//                     'user_id' => $user->doctor_id,
//                     'type' => 'credit',
//                     'model' => 'SubscriptionSuperBonus',
//                     'amount' => $amount,
//                     'remark' => "Patient ".NameById($p_id)." take subscription"
//                 ]);
//             }
//         }
//     }
// }

function giveSubsciptionBonus($p_id,$package_id)
{
    $user = App\User::where('id',$p_id)->first();
    if($user){
        if($user->invited_by != null){
            $subscription = App\Models\Subscription::where('id',$package_id)->first();
            if($subscription){
                $package_commission = getSetting('package_amount');
                $amount  = $subscription->price * $package_commission/100;
                App\Models\WalletLog::create([
                    'user_id' => $user->invited_by,
                    'type' => 'credit',
                    'model' => 'SubscriptionReward',
                    'amount' => $amount,
                    'remark' => "Rewarding for patient ".NameById($p_id)." take subscription"
                ]);
                App\Models\WalletLog::create([
                    'user_id' => $user->invited_by,
                    'type' => 'credit',
                    'model' => 'SubscriptionSuperBonus',
                    'amount' => $package_commission,
                    'remark' => "Patient ".NameById($p_id)." take subscription"
                ]);
                $inviter = App\User::where('id', $user->invited_by)->first();
                $inviter->update([
                    'wallet_balance' => $inviter->wallet_balance + $amount,
                ]);
            }
        }
    }
}

function getScanBonus($p_id,$d_id)
{
    $todayScan = App\Models\ScanLog::where('doctor_id',$d_id)->where('user_id',$p_id)->whereDate('created_at',now())->first();
    $monthScan = App\Models\ScanLog::where('doctor_id',$d_id)->where('user_id',$p_id)->whereMonth('created_at',now())->count();
    $yearScan = App\Models\ScanLog::where('doctor_id',$d_id)->where('user_id',$p_id)->whereYear('created_at',now())->count();
    $package = getSetting('scan_bonus');
    if($todayScan){
        return 1;
    }else if($monthScan > 3){
        return 2;
    }else if($yearScan > 20){
        return 3;
    }else{
       App\Models\WalletLog::create([
            'user_id' => $d_id,
            'type' => 'credit',
            'model' => 'ScanReward',
            'amount' => $package,
            'remark' => 'To Scan'.NameById($d_id),
        ]);
        
        return 1;
    }
}

function getScanBonusPatient($p_id, $d_id)
{

    $user = App\User::whereId($d_id)->first();

    $todayScan = App\Models\ScanLog::where('doctor_id',$d_id)
    ->where('user_id',$p_id)->whereDate('created_at',now())
    ->whereIsRewarded(1)->first();

    $monthScan = App\Models\ScanLog::where('doctor_id',$d_id)
    ->where('user_id',$p_id)->whereYear('created_at',now()->format('Y'))
    ->whereMonth('created_at',now()->format('m'))->whereIsRewarded(1)->count();

    $yearScan = App\Models\ScanLog::where('doctor_id',$d_id)
    ->where('user_id',$p_id)->whereYear('created_at',now()->format('Y'))
    ->whereIsRewarded(1)->count();

    $is_rewarded = 0;
    if($yearScan < 20){
        if(!$todayScan && $monthScan < 3){
            // dd("1");
            $is_rewarded = 1;
        }elseif($monthScan < 3){
            // dd("2");
            $is_rewarded = 1;
        }
    }

    if($is_rewarded == 0){
        return $is_rewarded;
    }else{
        App\Models\WalletLog::create([
            'user_id' => $d_id,
            'type' => 'credit',
            'model' => 'ScanReward',
            'amount' => getSetting('scan_bonus'), //10
            'remark' => "To Scan ".NameById($p_id)
        ]);

        $user->update([
            'wallet_balance' => (int)auth()->user()->wallet_balance + (int)getSetting('scan_bonus'),
        ]);

        return $is_rewarded;
    }
}

function getScanBonusalways($p_id, $d_id)
{
  return App\Models\WalletLog::create([
        'user_id' => $d_id,
        'type' => 'credit',
        'model' => 'ScanSuperBonus',
        'amount' => 100,
        'remark' => "To Scan ".NameById($p_id)
    ]);
}

if (!function_exists('pushSMSNotification')) {
    function pushSMSNotification($number, $message)
    {
        if (!\Illuminate\Support\Str::startsWith($number, '91')) {
            $number = '91' . $number;
        }

        // Whatsapp API
        // $response = \Illuminate\Support\Facades\Http::get('http://wts.vision360solutions.co.in/api/sendText?token=635cd997c85bd34bc14fddcd&phone=' . $number . '&message=' . $message);

        // Text SMS API
        $response = \Illuminate\Support\Facades\Http::get('http://otpsms.vision360solutions.in/api/sendhttp.php?authkey=385557AHvRjQ0XKe637dec92P1&mobiles='.$number.'&message='.$message.'&sender=HTDETL&route=4&country=0&DLT_TE_ID=1007904868170649199');

        return $response->json();
    }
}
if (!function_exists('callWhatsappNotification')) {
    function callWhatsappNotification($number, $message)
    {
        if (!\Illuminate\Support\Str::startsWith($number, '91')) {
            $number = '91' . $number;
        }

        // Whatsapp API
        $response = \Illuminate\Support\Facades\Http::get('http://wts.vision360solutions.co.in/api/sendText?token=635cd997c85bd34bc14fddcd&phone=' . $number . '&message=' . $message);

        return $response->json();
    }
}



if (!function_exists('WalletlogModels')) {
    function WalletlogModels()
    {
        return [
            ["id"=>1,"name"=>"ScanReward","color"=>"info"],
            ["id"=>2,"name"=>"ScanSuperBonus","color"=>"success"],
            ["id"=>3,"name"=>"SubscriptionReward","color"=>"warning"],
            ["id"=>4,"name"=>"SubscriptionSuperBonus","color"=>"primary"],
            ["id"=>5,"name"=>"InviteSuperBonus","color"=>"secondary"],
            ["id"=>6,"name"=>"UploadBonus","color"=>"danger"]

        ];
     
      
    }
}
if (!function_exists('FreezedBlogs')) {
    function FreezedBlogs()
    {
        return [12,9,11,13];
     
      
    }
}

if (!function_exists('getSalutation')) {
    function getSalutation()
    {
        return [
            ["id"=>1,"name"=>"Dr."],
            ["id"=>2,"name"=>"Mr."],
            ["id"=>3,"name"=>"Miss."],
            ["id"=>4,"name"=>"Mrs."],
        ];
     
      
    }
}

if (!function_exists('getFaqCategoyName')) {
    function getFaqCategoyName($name)
    {
        $category_id =   App\Models\CategoryType::where('name',$name)->first()->id;
         return App\Models\Category::where('category_type_id',$category_id)->get();
    }
}

if (!function_exists('getArticleCategoyName')) {
    function getArticleCategoyName($name)
    {
        $category_id = App\Models\CategoryType::where('name',$name)->first()->id;
        return App\Models\Category::where('category_type_id',$category_id)->get();
    }
}
if (!function_exists('getRandomEmail')) {
    function getRandomEmail()
    {
         $email = 'guest'.Str::random(4).'@gmail.com';
         $userEmail = App\User::where('email',$email)->first();
         if($userEmail){
            getRandomEmail();
         }
         return $email;
    }
}
// slider group by code
if (!function_exists('getSliderGroup')) {
    function getSliderGroup($sliderTitle) {
      $slider = App\Models\SliderType::where('title',$sliderTitle)->first();
        if($slider){
            return App\Models\Slider::where('slider_type_id',$slider->id)->get();
        }
        return [];
    }
}


if (!function_exists('toLocalTimeByUserId')) {
    function toLocalTimeByUserId(\Carbon\Carbon $date, $format = 'Y-m-d h:i:s', $bool = false, $user_id)
    {
        $timezone = (App\User::find($user_id)->timezone) ?? config('app.timezone');

        $date->setTimezone($timezone);

        if (is_null($format)) {
            return $date->format(config('timezone.format'));
        }

        $formatted_date_time = $date->format($format);

        // if ($format_timezone) {
        //     return $formatted_date_time . ' ' . $this->formatTimezone($date);
        // }

        return $formatted_date_time;
    }
    if(!function_exists('getArrKeyValue')){
        function getArrKeyValue($arr, $key){
            if(count($arr) > 0){
                foreach($arr as $child_key => $val){
                    if($child_key == $key){
                        return $val;
                    }
                }
            }
            return null;
        }
    }
    if (!function_exists('getScheduleCountByDay')) {
        function getScheduleCountByDay($day, $id)
        {
            // return $id;
            $availability = App\Models\Availability::where('day', $day)->where('user_id', $id)->first();
            // return ($availability->schedules);
            if ($availability) {
                $count = count($availability->schedules);
            } else {
                $count = 0;
            }
            return $count;
        }
    }
}