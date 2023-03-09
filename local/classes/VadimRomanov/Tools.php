<?php


namespace VadimRomanov;


class Tools
{
    protected static $logFile = '__mylog.txt';

    public static function logFile($val, $header = null, $filePath = null) {
        \Bitrix\Main\Diag\Debug::writeToFile($val, !empty($header) ? $header : '', !empty($filePath) ? $filePath : self::$logFile);
    }

    public static function dumpConsole($arr, $msg = 'console debug'){
        global $USER;
            echo '<script>';
            echo 'console.log("'. $msg .'",'.json_encode($arr).')';
            echo '</script>';
    }
    public static function dumpEcho($arr){
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
    }

    public static function checkRights($tab)
    {
        $rights = [];

        $permissions = \InformUnity\ORM\EntityObject\ObjectPermission::getUserPermissionList();
        $rights['VIEW'] = $permissions[$tab]['view'];
        $rights['EDIT'] = $permissions[$tab]['edit'];

        return $rights;
    }

}