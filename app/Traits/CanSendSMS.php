<?php
namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CanSendSMS
{
    public $driver = 'nimbus';
    public $number;
    public $message;
    public $templateId;

    public function sms()
    {
        return $this;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }


    public function driver($driver)
    {
        $this->driver = $driver;
        return $this;
    }

    public function to($number)
    {
        $this->number = $number;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function template($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }


    public function send()
    {
        $Phno= $this->number;
        $Msg=$this->message;
        $Password='zvor9882ZV';
        $SenderID='GOFINX';
        $UserID='satyamiit';
        $EntityID='1701162824834055338';
        $TemplateID = $this->templateId;
        Http::get('http://www.nimbusit.biz/api/SmsApi/SendSingleApi?UserID='.$UserID.'&Password='.$Password.'&SenderID='.$SenderID.'&Phno='.$Phno.'&Msg='.urlencode($Msg).'&EntityID='.$EntityID.'&TemplateID='.$TemplateID);

        return true;
    }

}
