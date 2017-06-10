<?php
/**
 * PHP Mail
 *
 * *Description* A PHP class for sending emails.
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace Framework;


/**
 * Class Mail
 * @package Framework
 */

class Mail {

	/**
	 * @var array $to
	 */

	protected $to = [];

	/**
	 * @var string $subject
	 */

	protected $subject;

	/**
	 * @var string $message
	 */

	protected $message;

	/**
	 * @var array $headers
	 */

	protected $headers = [];

	/**
	 * @var array $debug
	 */

	protected $debug = [];

	/**
	 * @var bool
	 */

	protected $error = false;

	/**
	 * Reset vars
	 *
	 * @return $this
	 */

	public function reset() {
		$this->to = [];
		$this->headers = [];
		$this->subject = null;
		$this->message = null;
		$this->params = null;
		$this->debug = [];
		$this->error = false;

		return $this;
	}

	/**
	 * Set to address
	 *
	 * @param string $email
	 * @param string $name
	 */

	public function setTo($email, $name = '') {
		$header = $this->formatHeader($email, $name);
		$this->to[] = $header;
	}

	/**
	 * Returns an array of To addresses.
	 *
	 * @return array
	 */

	public function getTo() {
		return $this->to;
	}

	/**
	 * Set From address.
	 *
	 * @param string $email
	 * @param string $name
	 */

	public function setFrom($email, $name = '') {
		$this->addMailHeader('From', $email, $name);
	}

	/**
	 * Set Carbon copy
	 *
	 * @param string $email
	 * @param string $name
	 */

	public function setCc($email, $name = '') {
		$this->addMailHeaders('Cc', $email, $name);
	}

	/**
	 * Set blind carbon copy
	 *
	 * @param string $email
	 * @param string $name
	 */

	public function setBcc($email, $name = '') {
		$this->addMailHeaders('Bcc', $email, $name);
	}

	/**
	 * Set Reply To address
	 *
	 * @param string $email
	 * @param string $name
	 */

	public function setReplyTo($email, $name = '') {
		$this->addMailHeader('Reply-To', $email, $name);
	}

	/**
	 * Set mail subject
	 *
	 * @param string $subject The email subject
	 */

	public function setSubject($subject) {
		$this->checkUTF8((string) $subject, 'subject');
		$this->subject = $this->filterSubject((string) $subject);
	}

	/**
	 * Get mail subject
	 *
	 * @return string
	 */

	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Set a message
	 *
	 * @param string $message
	 */

	public function setMessage($message) {
		$this->checkUTF8($message, 'message');
		$this->message = str_replace("\n.", "\n..", (string) $message);
	}

	/**
	 * Get a message
	 *
	 * @return string
	 */

	public function getMessage() {
		return $this->message;
	}

	/**
	 * Send mail
	 *
	 * @return boolean
	 */

	public function send() {
		$to       = $this->getToForSend();
		$subject  = $this->getSubject();
		$message  = $this->getMessage();
		$headers  = $this->getHeadersForSend();

		if (!$this->error){
			if (mail($to, $subject, $message, $headers)) {
				return true;
			}
			else {
				$this->setError('Sending mail failed', 'send');
			}
		}
		return false;
	}

	/**
	 * Returns debug information
	 *
	 *  @return array
	 */

	public function debug() {
		if (!$this->error){
			$this->debug = ['There has no error'];
		}
		$message = [
			'errors' => $this->debug,
			'to' => $this->getToForSend(),
			'subject' => $this->getSubject(),
			'message' => $this->getMessage(),
			'headers' => $this->getHeadersForSend(),
		];

		return $message;
	}

	/**
	 * Set errors and debug messages
	 *
	 * @param string $debug
	 * @param string $param
	 */

	private function setError( $debug, $param  = 'element') {
		$this->error = true;
		$this->debug[] = strtoupper ( $param ).': '.$debug;
	}

	/**
	 * Add mail header
	 *
	 * *Description* respective headers From and ReplyTo
	 *
	 * @param string $header
	 * @param string $email
	 * @param string $name
	 */

	private function addMailHeader($header, $email, $name = null) {
		$this->headers[$header] = $this->formatHeader((string) $email, (string) $name);
	}

	/**
	 * Add mail headers
	 *
	 * *Description* respective headers Cc and Bcc
	 *
	 * @param string $header
	 * @param string $email
	 * @param string $name
	 */

	private function addMailHeaders($header, $email, $name = null) {
		$this->headers[$header][] = $this->formatHeader((string) $email, (string) $name);
	}

	/**
	 * Assemble header attachments
	 *
	 * @return string
	 */

	private function assembleAttachmentHeaders() {
		$header  = 'X-Mailer: PHP/'.phpversion();
		$header .= PHP_EOL.'Content-Transfer-Encoding: 8bit';
		$header .= PHP_EOL.'MIME-Version: 1.0';
		$header .= PHP_EOL.'Content-type: text/plain; charset=UTF-8';

		return $header;
	}

	/**
	 * Get header for send mail
	 *
	 * @return string
	 */

	private function getHeadersForSend() {
		$header = $this->assembleAttachmentHeaders();
		if (!empty($this->headers)) {
			foreach ($this->headers as $headers => $address) {
				if (is_array($address)){
					$address = join(', ', $address);
				}
				$header .= PHP_EOL.sprintf('%s: %s', $headers, $address);
			}
		}

		return $header;
	}

	/**
	 * Get To address for send mail
	 *
	 * @return string
	 */

	private function getToForSend() {
		if (empty($this->getTo())) {
			$this->setError('Unable to send, no To address has been set.', 'to');
			$this->setTo('empty@yourdomian.com', 'Empty address');
		}

		return implode(',', $this->getTo());
	}


	/**
	 * Formats a display address for emails
	 *
	 * @param string $email
	 * @param string $name
	 *
	 * @return string
	 */

	private function formatHeader($email, $name = null) {
		$email = $this->filterEmail((string) $email);
		if (empty($name)) {
			return $email;
		}
		$name = $this->filterName((string) $name);

		return sprintf('%s <%s>', $name, $email);
	}

	/**
	 * Check UTF-8 encoding
	 *
	 * @param string $value
	 *
	 * @return boolean
	 */

	private function checkUTF8($value, $method = '') {
		if (mb_detect_encoding($value, 'UTF-8', true)) {
			return true;
		}
		$this->setError( 'Invalid characters. Use UTF-8 only.', $method );

		return false;
	}

	/**
	 * Filter email address
	 *
	 * @param $email
	 *
	 * @return mixed
	 */

	private function filterEmail($email) {
		// Remove all illegal characters from email
		$_email = filter_var(
			$email,
			FILTER_SANITIZE_EMAIL
		);
		$_email = trim($_email);

		// Validate e-mail
		if (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
			$this->setError($_email.' is not a valid email address', 'email');
		}

		return $_email;
	}

	/**
	 * Filter name
	 *
	 * @param $name
	 *
	 * @return mixed
	 */

	private function filterName($name) {
		$_name = filter_var(
			$name,
			FILTER_SANITIZE_STRING,
			FILTER_FLAG_NO_ENCODE_QUOTES
		);
		return trim($_name);
	}

	/**
	 * Filter subject
	 *
	 * @param $param
	 *
	 *  @return mixed
	 */

	private function filterSubject( $param ) {
		return filter_var(
			$param,
			FILTER_UNSAFE_RAW,
			FILTER_FLAG_STRIP_LOW
		);
	}
}