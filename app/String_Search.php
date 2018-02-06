<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;
use Sinergi\BrowserDetector\Browser;

class String_Search extends Model
{
    protected $table = 'StringSearch';

    public static function create_table($search, $duplicate)
    {

        $Model = new self();
        $Model->Search_String = $search;
        $Model->duplicate = $duplicate;
        $Model->browser = self::browser_detect();
        $Model->operating_system = self::os_detect();
        $Model->device = self::device_detect();
        $Model->IP= self::ip_detect();
        $Model->save();
    }

    public static function device_detect()
    {
        $device = new Device();
        if($device->getName() !== [Device::IPAD,Device::IPHONE,Device::WINDOWS_PHONE]) return 'PC';
        else return $device->getName();
    }

    public static function os_detect()
    {
        $os= new Os();
        return $os->getName();
    }

    public static function browser_detect()
    {
        $browser = new Browser();
        return $browser->getName();
    }

    public static function ip_detect()
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
            else
            {
                 $ip=$_SERVER['REMOTE_ADDR'];
            }
        return $ip;
    }

    public static function String_Search_query()
    {
        $predictString = DB::table('StringSearch')->select('Search_String')->get();
        return $predictString;
    }

}
