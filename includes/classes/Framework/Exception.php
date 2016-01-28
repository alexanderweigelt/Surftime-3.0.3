<?php
    
 /**
 * Base exception for Framework
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 

 namespace Framework;


class Exception extends \Exception {
	
	/** Eigenschaften definieren */
	private $previous;

/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param 
 *
 * @return 
 */
 
    public function __construct($msg, $code = 0, Exception $previous = null)
    {
        if (!$code) {
            $nsL = strpos(__CLASS__, '\\') + 1;
            $ns = substr(__CLASS__, 0, $nsL);
            foreach (debug_backtrace() as $i => $trace) {
                if ($i > 0 && substr($trace['class'], 0, $nsL) == $ns) {
                    $code = crc32(substr($trace['class'], $nsL));
                    break;
                }
            }
        }
        parent::__construct($msg, (int) $code, $previous);
    }
	
	public function __toString(){
            return $this->message;
	} 

}