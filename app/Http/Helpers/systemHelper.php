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

if (!function_exists('optionCanChecker')) {
    function optionCanChecker($permission)
    {
        $role = \Auth::user()->roles[0];
        if ($permission != null || $permission != '') {
            if ($role->hasPermissionTo($permission)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('getNoRoleUserList')) {
    function getNoRoleUserList()
    {
        return App\Models\Auth\User::whereDoesntHave('roles')->get();
    }
}
if (!function_exists('getAllPermission')) {
    function getAllPermission()
    {
        return Spatie\Permission\Models\Permission::all();
    }
}

if (!function_exists('AgentList')) {
    function AgentList()
    {
        return App\User::role('Agent')->get();
    }
}
if (!function_exists('UserList')) {
    function UserList()
    {
        return App\User::role('User')->get();
    }
}
if (!function_exists('DoctorList')) {
    function DoctorList()
    {
        return App\User::role('Doctor')->get();
    }
}
if (!function_exists('AdminList')) {
    function AdminList()
    {
        return App\User::role('Admin')->get();
    }
}

if (!function_exists('TemplatSMSBuilder')) {
    function TemplatSMSBuilder($arr, $chk_data)
    {
        return DynamicMailTemplateFormatter($chk_data->body, $chk_data->variables, $arr);
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        return  App\Models\Setting::where('key',$key)->first()->value ?? 0;
    }
}
if (!function_exists('getSiteManagement')) {
    function getSiteManagement($code)
    {
        return  App\Models\SiteContentManagement::where('code', '=', $code)->first()->value ?? '';
    }
}
if (!function_exists('getBackendLogo')) {
    function getBackendLogo($img_name)
    {
        return asset('storage/backend/logos/'.$img_name);
    }
}
if (!function_exists('getFrontendLogo')) {
    function getFrontendLogo($img_name)
    {
        return asset('storage/frontend/logos/'.$img_name);
    }
}
if (!function_exists('getOrderHashCode')) {
    function getOrderHashCode($o_id)
    {
        return '#OID'.$o_id;
    }
}
if (!function_exists('getWalletHashCode')) {
    function getWalletHashCode($w_id)
    {
        return '#ZTRWID'.$w_id;
    }
}


if (!function_exists('getTypeNameById')) {
    function getTypeNameById($id)
    {
        $arr = [
        ['id'=>0,"name"=>"Mail"],
        ['id'=>1,"name"=>"SMS"],
     ];

        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

if (!function_exists('UserStatus')) {
    // 0->Inactive | 1->Active | 2->Lock | 3->Blocked
    function UserStatus($id)
    {
        if ($id == 0) {
            return "Inactive";
        }
        if ($id == 1) {
            return "Active";
        }
        if ($id == 2) {
            return "Lock";
        }
        if ($id == 3) {
            return "Blocked";
        }
    }
}
if (!function_exists('orderStatus')) {
    // 0->Inactive | 1->Active | 2->Lock | 3->Blocked
    function orderStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>1,"name"=>'Idle','color'=>'warning'],
                ['id'=>2,"name"=>'Packed','color'=>'info'],
                ['id'=>3,"name"=>'Shipped','color'=>'secondary'],
                ['id'=>4,"name"=>'Delivered','color'=>'primary'],
                ['id'=>5,"name"=>'Completed','color'=>'success'],
                ['id'=>6,"name"=>'Cancelled','color'=>'danger'],
                ['id'=>7,"name"=>'Hold','color'=>'dark'],
            ];
        }else{
            foreach(orderStatus() as $row){
                if($id==$row['id']){
                    return $row;
                }
            }
            return ['id'=>0,"name"=>'','color'=>'light'];
        }
    }
}
if (!function_exists('paymentStatus')) {
    // 0->Inactive | 1->Active | 2->Lock | 3->Blocked
    function paymentStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>1,"name"=>'Unpaid','color'=>'warning'],
                ['id'=>2,"name"=>'Paid','color'=>'success'],
                ['id'=>3,"name"=>'Refund Processing','color'=>'secondary'],
                ['id'=>4,"name"=>'Hold','color'=>'dark'],
                ['id'=>5,"name"=>'Refunded','color'=>'danger'],
            ];
        }else{
            foreach(paymentStatus() as $row){
                if($id==$row['id']){
                    return $row;
                }
            }
            return ['id'=>0,"name"=>'','color'=>'light'];
        }
    }
}





if (!function_exists('NameById')) {
    function NameById($id)
    {
        $user = \App\User::whereId($id)->first();
        $first_name = $user->first_name ?? '';
        $last_name = $user->last_name ?? '';
        return $first_name.' '.$last_name ?? '-';
    }
}

if (!function_exists('CountryById')) {
    function CountryById($id)
    {
        return \App\Models\Country::whereId($id)->first()->name ?? ' ';
    }
}
if (!function_exists('StateById')) {
    function StateById($id)
    {
        return \App\Models\State::whereId($id)->first()->name ?? ' ';
    }
}
if (!function_exists('CityById')) {
    function CityById($id)
    {
        return \App\Models\City::whereId($id)->first()->name ?? ' ';
    }
}

if (!function_exists('UserRole')) {
    function UserRole($id)
    {
        return App\User::find($id)->roles[0];
    }
}
// for make log
if (!function_exists('makeLog')) {
    function makeLog($activity, $ip)
    {
        if(getSetting('wallet_activatio') == 1){
            $data = new App\Models\UserLog;
            $data->user_id = auth()->id();
            $data->ip_address = $ip;
            $data->activity = $activity;
            $data->name = getBrowser()['name'];
            $data->version = getBrowser()['version'];
            $data->platform = getBrowser()['platform'];
            // $data->pattern = getBrowser()['pattern'];
            $data->save();
        }
        
    }
}

if (!function_exists('pushOnSiteNotification')) {
    function pushOnSiteNotification($data)
    {
        
        App\Models\Notification::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'link' => $data['link'],
            'notification' => $data['notification'],
            'is_readed' => 0,
        ]);
    }
}
if (!function_exists('markAsReadedOnSiteNotification')) {
    function markAsReadedOnSiteNotification($id, $status =1)
    {
       $data = App\Models\Notification::whereId($id)->update(['is_readed'=>$status]);
       if($data->link != null || $data->link != '#'){
            return redirect($data->link);
       }else{
           return back();
       }
    }
}







// -----------  Parul ----------------------



if (!function_exists('AuthRole')) {
    function AuthRole()
    {
        return   ucWords(auth()->user()->roles[0]->name ?? '');
    }
}

// -----for unlink any file
if (!function_exists('unlinkfile')) {
    function unlinkfile($filepath, $filename)
    {
        if ($filename != null) {
            $file = $filepath.'/'.$filename;
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}

// -----for fetching first record or any column
if (!function_exists('fetchFirst')) {
    function fetchFirst($model, $id, $col = null, $default = 'Not Available!')
    {
        if ($col != null) {
            return    $model::whereId($id)->first()->$col ?? $default;
        } else {
            return    $model::whereId($id)->first();
        }
    }
}

// -----for fetching data with single conditions -----

if (!function_exists('fetchAll')) {
    function fetchAll($model, $sort_col = null, $sort_type = 'ASC')
    {
        if ($sort_col != null) {
            return    $model::orderBy($sort_col, $sort_type)->get();
        } else {
            return    $model::all();
        }
    }
}

if (!function_exists('fetchGet')) {
    function fetchGet($model, $condition, $col, $operator, $value, $sort_col = null, $sort_type = 'ASC')
    {
        if ($sort_col != null) {
            return    $model::$condition($col, $operator, $value)->orderBy($sort_col, $sort_type)->get();
        } else {
            return    $model::$condition($col, $operator, $value)->get();
        }
    }
}
// -----for fetching data with single conditions -----

if (!function_exists('fetchGetIN')) {
    function fetchGetIN($model, $col, $value, $sort_col = null, $sort_type = 'ASC')
    {
        if ($sort_col != null) {
            return    $model::whereIn($col, $value)->orderBy($sort_col, $sort_type)->get();
        } else {
            return    $model::whereIn($col, $value)->get();
        }
    }
}

// -----for fetching data with multiple conditions -----


if (!function_exists('short_code_parser')) {
    function short_code_parser($content, $replacements)
    {    
        $content = preg_replace_callback(
                    '/{[^}]*\}/',
                    function (array $m) use ($replacements) {
                        $item = strtr(trim($m[0]), ['{' => '', '}' =>'']);
                        return array_key_exists($item, $replacements) ? $replacements[$item] : '';
                    },
                    $content
                );
        return $content;
    }
}
function AmountInWordsNational(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees' : '') . $get_paise;
}
function AmountInWordsInternational($num)
{

    $ones = array(
        0 =>"ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
    );
    $tens = array( 
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
    ); 
    $hundreds = array( 
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
    ); /*limit t quadrillion */
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr,1); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){
        
    while(substr($i,0,1)=="0")
            $i=substr($i,1,5);
        if($i < 20){ 
        /* echo "getting:".$i; */
        $rettxt .= $ones[$i]; 
        }elseif($i < 100){ 
            if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
            if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
        }else{ 
            if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
            if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0){ 
        $rettxt .= " ".$hundreds[$key]." "; 
        }
    } 
    if($decnum > 0){
        $rettxt .= " Ringgit and ";
        if($decnum < 20){
        $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
        $rettxt .= $tens[substr($decnum,0,1)];
        $rettxt .= " ".$ones[substr($decnum,1,1)]." Cents";
        }
    }
    return $rettxt;
}

if (!function_exists('encodeNumber')) {
    function encodeNumber($id)
    {
        return Crypt::encrypt($id);
    }
}
if (!function_exists('decodeNumber')) {
    function decodeNumber($id)
    {
        return Crypt::decrypt($id);
    }
}

if (!function_exists('getPrefixZeros')) {
    function getPrefixZeros($id)
    {
        $var = '_'.(1000000 +$id);
        return str_replace('_1','',$var);
    }
}
if (!function_exists('deleteSubCategory')) {
    function deleteSubCategory($id)
    {
        $subcat = App\Models\Category::whereParentId($id)->get();
        foreach($subcat as $cat){
                deleteSubCategory($cat);
                $cat->delete();
        }
        return true;
    }
}

if (!function_exists('getCategoryNameById')) {
    function getCategoryNameById($id)
    {
        return App\Models\Category::whereId($id)->first();
    }
}

if (!function_exists('fetchGetData')) {
    function fetchGetData($model, $columns, $values, $sort_col = null, $sort_type = 'ASC')
    {
        $query = $model::query();
        foreach ($values as $index => $value) {
            $query->where($columns[$index], '=', $value);
        }
        if ($sort_col != null) {
            return $query->orderBy($sort_col, $sort_type)->get();
        } else {
            return $query->get();
        }
    }
}
if (!function_exists('getSocialLinks')) {
    function getSocialLinks()
    {
        $social_links = [];

        if (getSetting('facebook_login_active')) {
            $social_links[] = "<a href='".route('social.login', 'facebook')."' class='btn social-btn btn-facebook'><i class='fab fa-facebook-f'></i></a>";
        }

        if (getSetting('google_login_active')) {
            $social_links[] = "<a href='".route('social.login', 'google')."' class='btn social-btn btn-google'><i class='fab fa-google'></i></a>";
        }

        if (getSetting('linkedin_login_active')) {
            $social_links[] = "<a href='".route('social.login', 'linkedin')."' class='btn social-btn btn-linkedin'><i class='fab fa-linkedin'></i></a>";
        }

        if (getSetting('twitter_login_active')) {
            $social_links[] = "<a href='".route('social.login', 'twitter')."' class='btn social-btn btn-twitter'><i class='fab fa-twitter'></i></a>";
        }

        // if (config('github_login_active')) {
        // $social_links[] = "<a href='".route('social.login', 'github')."' class=' btn-sm btn-outline-dark   p-1 px-2  m-1 my-3'><i class='ik ik-github'></i></a>";
        // }

        return $social_links;
    }
}


if (!function_exists('toLocalTime')) {
    function toLocalTime(\Carbon\Carbon $date, $format = 'Y-m-d h:i:s', $bool = false)
    {
        return Timezone::convertToLocal($date, $format, $bool);
    }
}

if (!function_exists('fromLocalTime')) {
    function fromLocalTime($date)
    {
        // return Carbon::parse("2021-12-12 07:01:00", auth()->user()->timezone)->setTimezone('UTC');
        return Timezone::convertFromLocal($date);
    }
}
if (!function_exists('getDateFormat')) {
    function getDateFormat()
    {
        return [
            ['id'=>0,"name"=>"DD-MM-YYYY", "ex" => \Carbon\Carbon::now()->format('d-m-Y'), 'value'=>"d-m-Y", 'format_type'=>'format'],
            ['id'=>1,"name"=>"DD MM YYYY", "ex" => \Carbon\Carbon::now()->format('d m Y'), 'value'=>"d m Y", 'format_type'=>'format'],
            ['id'=>2,"name"=>"Dth MMMM YYYY", "ex" => \Carbon\Carbon::now()->format('jS F Y '), 'value'=>"jS F Y ", 'format_type'=>'format'],
            ['id'=>3,"name"=>"Dth MMM YYYY", "ex" => \Carbon\Carbon::now()->format('jS M Y '), 'value'=>"jS M Y ", 'format_type'=>'format'],
            ['id'=>4,"name"=>"DAY Dth", "ex" => \Carbon\Carbon::now()->format('l jS '), 'value'=>"l jS ", 'format_type'=>'format'],
            ['id'=>5,"name"=>"DAY Dth MM YYYY", "ex" => \Carbon\Carbon::now()->format('l jS m Y'), 'value'=>"l jS m Y", 'format_type'=>'format'],
            ['id'=>6,"name"=>"DAY Dth MMM YYYY", "ex" => \Carbon\Carbon::now()->format('l jS M YYYY'), 'value'=>"l jS M Y", 'format_type'=>'format'],
            ['id'=>7,"name"=>"DAY Dth MMMM YYYY", "ex" => \Carbon\Carbon::now()->format('l jS F Y '), 'value'=>"l jS F Y ", 'format_type'=>'format'],
            ['id'=>8,"name"=>"DD/MM/YYYY", "ex" => \Carbon\Carbon::now()->format('d/m/Y'), 'value'=>"d/m/Y", 'format_type'=>'format'],
            ['id'=>9,"name"=>"D MMM YYYY", "ex" => \Carbon\Carbon::now()->format('d M Y '), 'value'=>"d M Y ", 'format_type'=>'format'],
        ];
    }
}
if (!function_exists('getDateTimeFormat')) {
    function getDateTimeFormat()
    {
        return [
            ['id'=>0,"name"=>"DD MM YYYY HH:mm:ss", "ex" => \Carbon\Carbon::now()->format('d m Y H:i:s'), 'value'=>"d m Y H:i:s", 'format_type'=>'format'],
            ['id'=>1,"name"=>"DD MM YYYY, hh:mm:ss a", "ex" => \Carbon\Carbon::now()->format('d M Y, h:i:s a'), 'value'=>"d M Y, h:i:s a", 'format_type'=>'format'],
            ['id'=>2,"name"=>"YYYY MM DD HH:mm:ss", "ex" => \Carbon\Carbon::now()->format('Y m d H:i:s'), 'value'=>"Y-m-d H:i:s", 'format_type'=>'format'],
            ['id'=>3,"name"=>"Dth MMMM YYYY, hh:mm:ss a", "ex" => \Carbon\Carbon::now()->format('jS F Y, h:i:s a'), 'value'=>"jS F Y, h:i:s a", 'format_type'=>'format'],
            ['id'=>4,"name"=>"MMMM DTh YYYY, HH:mm:ss", "ex" => \Carbon\Carbon::now()->format('F jS Y, H:i:s '), 'value'=>"F jS Y, H:i:s ", 'format_type'=>'format'],
            ['id'=>5,"name"=>"Dth MMMM YYYY, HH:mm", "ex" => \Carbon\Carbon::now()->format('jS F Y, H:i'), 'value'=>"jS F Y, H:i", 'format_type'=>'format'],
            ['id'=>6,"name"=>"Dth MMMM YYYY, hh:mm a", "ex" => \Carbon\Carbon::now()->format('jS F Y, h:i a'), 'value'=>"jS F Y, h:i a", 'format_type'=>'format'],
        ];
    }
}

if (!function_exists('getFormattedDate')) {
    function getFormattedDate($date)
    {
        $data = getDateFormat();
        $format = $data[getSetting('date_format')]['value'];
        $format_type = $data[getSetting('date_format')]['format_type'];
        return \Carbon\Carbon::parse($date)->$format_type($format);
    //    return toLocalTime(\Carbon\Carbon::parse($date),$format);
    }
}

if (!function_exists('getFormattedDateTime')) {
    function getFormattedDateTime($date)
    {
        $data = getDateTimeFormat();
        $format = $data[getSetting('date_time_format')]['value'];
        $format_type = $data[getSetting('date_time_format')]['format_type'];
        return \Carbon\Carbon::parse($date)->$format_type($format);
        // return toLocalTime(\Carbon\Carbon::parse($date),$format);
    }
}

//formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        if (App\Models\Setting::where('key', 'decimal_separator')->first()->value == 1) {
            $fomated_price = number_format($price, App\Models\Setting::where('key', 'no_of_decimal')->first()->value);
        } else {
            $fomated_price = number_format($price, App\Models\Setting::where('key', 'no_of_decimal')->first()->value, ',', '.');
        }

        if (App\Models\Setting::where('key', 'currency_position')->first()->value == 1) {
            return getSetting('app_currency').$fomated_price;
        }
        return $fomated_price.getSetting('app_currency');
    }
}


// file checker
if (!function_exists('fileExists')) {
    function fileExists($path)
    {
        return File::exists($path);
    }
}

// getGST
if (!function_exists('getGST')) {
    function getGST($amount, $percent = 18)
    {
        return ($amount*$percent)/100;
    }
}

if (!function_exists('getStatus')) {
    // 0->Inactive | 1->Active | 2->Lock | 3->Blocked
    function getStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>1,"name"=>"Active", 'color'=>"success"],
                ['id'=>0,"name"=>"Inactive", 'color'=>"danger"],
            ];
        }else{
            foreach(getStatus() as $row){
                if($id==$row['id']){
                    return $row;
                }
            }
            return ['id'=>0,"name"=>'','color'=>'light'];
        }
    }
}


// -------------------Shubham--------------------------------

if (!function_exists('getCategory')) {
    function getCategory($id = null)
    {
        if ($id == 1) {
            return ['id'=>1,"name"=>"Main"];
        } elseif ($id == 2) {
            return ['id'=>2,"name"=>"Sub",];
        } elseif ($id == 3) {
            return ['id'=>3,"name"=>"Sub-Sub",];
        } else {
            return [
                ['id'=>1,"name"=>"Main",],
                ['id'=>2,"name"=>"Sub",],
                ['id'=>3,"name"=>"Sub-Sub",],
            ];
        }
    }
}

if (!function_exists('getUserEnquiryStatus')) {
    function getUserEnquiryStatus($id)
    {
        $arr = [
        ['id'=>0,"name"=>"Pending"],
        ['id'=>1,"name"=>"Solved"],
     ];
        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

/**
 * @param array $routes
 * @param String $output
 * @param String $fallback
 * @return String
 */
if (!function_exists('activeClassIfRoutes')){
    function activeClassIfRoutes($routes, $output = 'active', $fallback = '')
    {
        if (in_array(Route::currentRouteName(), $routes)){
            return $output;
        } else {
            return $fallback;
        }
    }
}

/**
 * @param array $routes
 * @return boolean
 */
if (!function_exists('activeRoutes')){
    function activeRoutes($routes)
    {
        if (in_array(Route::currentRouteName(), $routes)){
            return true;
        } else {
            return false;
        }
    }
}

/**
 * @param String $route
 * @return boolean
 */
if (!function_exists('activeRoute')){
    function activeRoute($route)
    {
        if (Route::currentRouteName() == $route) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * @param String $route
 * @param String $output
 * @param String $fallback
 * @return String
 */
if (!function_exists('activeClassIfRoute')){
    function activeClassIfRoute($route, $output = 'active', $fallback = '')
    {
        if (Route::currentRouteName() == $route) {
            return $output;
        } else {
            return $fallback;
        }
    }
}
if (!function_exists('createOrder')){
    function createOrder($user_id, $order_items = [], $payment_gateway = "offline", $tax = 0, $discount = 0, $from = null,$to = null,$remark = null)
    {
        
        if(empty($order_items)){
            $order_items = [
                [
                    "item_type"=>"Product",
                    "item_id"=>1,
                    "price"=>100,
                    "qty"=>1,
                ],
                [
                    "item_type"=>"Product",
                    "item_id"=>1,
                    "price"=>100,
                    "qty"=>2,
                ],
            ];
        }

        // Order Creation
        $sub_total = 0;
        $total = 0;
        foreach($order_items as $item){
            $sub_total = $sub_total + ($item['price'] * $item['qty']);
        }
        $total = ($sub_total + $tax) - $discount;
        $txn_no = "ORD".rand(00000000,9999999999);

       $order = App\Models\Order::create([
            'user_id'=>$user_id,
            'txn_no'=>$txn_no,
            'discount'=>$discount,
            'tax'=>$tax,
            'sub_total'=>$sub_total,
            'total'=>$total,
            'payment_gateway'=>$payment_gateway,
            'from'=>$from,
            'to'=>$to,
            'remark'=>$remark,
        ]);
        foreach($order_items as $item){
            App\Models\OrderItem::create([
                'order_id'=>$order->id,
                'item_type'=>$item['item_type'],
                'item_id'=>$item['item_id'],
                'price'=>$item['price'],
                'qty'=>$item['qty'],
            ]);
        }
        return $order;
    }
}

function generateRandomString(int $n=0)
{
  $al = ['a','b','c','d','e','f','g','h','i','j','k'
  , 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
  'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
  'F','G','H','I','J','K', 'L', 'M', 'N', 'O', 'P',
  'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  '0', '2', '3', '4', '5', '6', '7', '8', '9'];

  $len = !$n ? random_int(7, 12) : $n; // Chose length randomly in 7 to 12

  $ddd = array_map(function($a) use ($al){
    $key = random_int(0, 60);
    return $al[$key];
  }, array_fill(0,$len,0));
  return implode('', $ddd);
}

function commentOutStart() 
{
  return "{{--";
}
function commentOutEnd() 
{
  return "--}}";
}

if (!function_exists('walletLogStatus')) {
    // 0->pending | 1->except | 2->Reject 
    function walletLogStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>0,"name"=>'Pending','color'=>'warning'],
                ['id'=>2,"name"=>'Except','color'=>'success'],
                ['id'=>3,"name"=>'Reject','color'=>'secondary'],
             
            ];
        }else{
            foreach(walletLogStatus() as $row){
                if($id==$row['id']){
                    return $row;
                }
            }
            return ['id'=>0,"name"=>'','color'=>'light'];
        }
    }
}