<?php
    
 /**
 * Response
 *
 * *Description* 
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Framework;


class Response {

    /**
     * Array of possible status code
     * @var array
     */
	
	protected $statusCode = array(
		// Informational 1xx
		100 => 'Continue',
		101 => 'Switching Protocols',
	
		// Success 2xx
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
	
		// Redirection 3xx
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',  // 1.1
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		// 306 is deprecated but reserved
		307 => 'Temporary Redirect',
	
		// Client Error 4xx
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
	
		// Server Error 5xx
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		509 => 'Bandwidth Limit Exceeded'
	);

    /**
     * Array of possible mime type
     * @var array
     */

	protected $listMimeType = array(
		'application/atom+xml',
		'application/json',
		'application/pdf',
		'application/rss+xml',
		'image/jpeg',
		'image/png',
		'image/gif',
		'text/css',
		'text/javascript',
		'text/plain',
		'text/xml',
		'text/html'
	);

    /**
     * Array of headers. Each header is an array with keys 'name' and 'value'
     * @var array
     */
	
	private $headers = array();

    /**
     * Normalize header
     *
     * *Description* Normalizes a header name
     *
     * @param  string $name
     * @return string
     */

	protected function _normalizeHeader($name){
		$filtered = str_replace(array('-', '_'), ' ', (string) $name);
		$filtered = ucwords(strtolower($filtered));
		$filtered = str_replace(' ', '-', $filtered);
		
        return $filtered;
    }

    /**
     * Modify header
     *
     * *Description*
     *
     * @param string $name
     * @param string $value
     * @param boolean $replace
     * @return
     */

	public function modifyHeader($name, $value, $replace = FALSE){
		$name  = $this->_normalizeHeader($name);
        $value = (string) $value;
		
		switch($name){
			case'Content-Type':
				$value = $this->setContentType($value);
				break;
			
			case'Status':
				$name = $_SERVER["SERVER_PROTOCOL"];
				$value = $this->setStatusCode($value);
				break;
		}
		
		if(!$value) return FALSE;
		
		if($replace) {
            foreach ($this->headers as $key => $header) {
                if ($name == $header['name']) {
                    unset($this->headers[$key]);
                }
            }
        }

        $this->headers[] = array(
            'name'    => $name,
            'value'   => $value,
            'replace' => $replace
        );
		
	}

    /**
     * Send all header information
     *
     * *Description*
     *
     * @param
     * @return
     */

	public function sendHeaders(){
		foreach($this->headers as $header){
			header($header['name'].': '.$header['value']);
			if($header['name'] == 'Location'){
				exit();
			}
		}
	}

    /**
     * Remove header
     *
     * *Description*
     *
     * @param string $header
     * @return
     */

	public function removeHeader($header = ''){
		if(headers_sent($header)){
			header_remove($header);
		}
		unset($this->headers[$header]);
	}

    /**
     * Dump header
     *
     * *Description*
     *
     * @param
     * @return void
     */

    public function dumpHeader(){
        $output = '';
        foreach($this->headers as $header){
            $output .= 'header('.$header['name'].' : '.$header['value'].')</br>'."\n";
        }
        echo $output;
    }

    /**
     * Set status code
     *
     * *Description*
     *
     * @param string $code
     * @return mixed Returns a string value upon success.  Returns false upon failure.
     */

	private function setStatusCode($code){	
		if(!empty($this->statusCode[$code])){
			return $code.' '.$this->statusCode[$code];
		}
		else{
			return FALSE;
		}
	}

    /**
     * Set content type
     *
     * *Description*
     *
     * @param string $type
     * @return mixed Returns a string value upon success.  Returns false upon failure.
     */

	private function setContentType($type){		
		if(in_array($type, $this->listMimeType)){
			return $type.'; charset='.\Framework\Utility::getCharset();
		}
		else{
			return FALSE;
		}
	}
    /**
     * PHP Error Reporting
     *
     * *Description*
     *
     * @param boolean $mode
     * @return void
     */

	public function errorReporting($mode = FALSE){
		// Error Reporting komplett abschalten
		if((defined('DEBUG_MODE') and DEBUG_MODE) or $mode){
			error_reporting(E_ALL ^ E_NOTICE);
		}
		else{
			error_reporting(0);
			ini_set("display_errors", 0);
    		ini_set("display_startip_errors", 0);
		}
		
	}
	
}