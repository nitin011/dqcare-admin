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

use Illuminate\Support\Facades\Http;


if (!function_exists('getApi')) {
    function getApi($url,$params = null){
        if(is_array($params)){
            $response = Http::get($url, $params);
        }else{
            $response = Http::get($url);
        }
        return $response;
    }
}
if (!function_exists('postFormApi')) {
    function postFormApi($url,$params){
        $response = Http::asForm()->post($url, $params);
        return $response;
    }
}
if (!function_exists('postWithHeaderFormApi')) {
    function postWithHeaderFormApi($url,$params,$headers){
        if(is_array($headers)){
            if(is_array($params)){
                $response = Http::withHeaders($headers)->post($url, $params);
            }else{
                $response = Http::withHeaders($headers)->post($url);
            }
        }else{
            $response = "Headers data is invalid";
        }
        return $response;
    }
}
if (!function_exists('fileApi')) {
    function fileApi($url,$file_path){
        if(file_exists($file_path)){
            $response = Http::attach(
                'attachment', file_get_contents($file_path), $file_path
            )->post($url);
        }else{
            $response = "File doesn't exists!";
        }
        return $response;
    }
}
if (!function_exists('apiwithToken')) {
    function apiwithToken($url,$token){
        $response = Http::withToken($token)->post($url);
        return $response;
    }
}