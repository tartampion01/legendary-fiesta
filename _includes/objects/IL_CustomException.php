<?php
/*
 * This code is free software; you can use it, redistribute it, and/or modify as you wish.
 * This code is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY - implied or otherwise.
 * This code is distributed "as is."  All risk and cost are assumed by the user of the code and not the creator thereof.
 * If you wish to give attribution, the original creator is Robert "Nilpo" Dunham (devnilpo@gmail.com)
 */

interface IException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
   
    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formatted string for display
    public function __construct($message = null, $code = 0);
}

abstract class IL_CustomException extends Exception implements IException
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }
   
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}
?>