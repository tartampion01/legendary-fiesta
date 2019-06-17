<?php
class IL_Error
{
    private $message     = "";
    private $errorType   = 0; // DEFAULT
    private $destination = "/var/log/virtualmin/interlivraison.reseaudynamique.com_error_log";
    private $level       = 1;
    
    public static function log($message) {
        error_log($message, 0, "/var/log/virtualmin/interlivraison.reseaudynamique.com_error_log");
    }
}
?>