<?php
/**
 * @file Mailer.php
 * Contains the `Mailer` class.
 *
 * @version 1.4
 * @date    June 23, 2019 (10:34)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

require_once __DIR__ . '/../library/PHPMailer/SMTP.mod.php';
require_once __DIR__ . '/../library/PHPMailer/Exception.php';
require_once __DIR__ . '/../library/PHPMailer/PHPMailer.mod.php';

/**
 * Sends SMTP emails.
 *
 * The `%Mailer` class internally uses the <a href="https://github.com/PHPMailer/PHPMailer" target="_blank">PHPMailer</a>
 * library for creation and transfer of the emails.
 */
class Mailer
{
	/**
	 * Internal instance of the `PHPMailer` class.
	 */
	private $handle = null;

	/**
	 * Returns a new `%Mailer` object based on the configured credentials.
	 */
	public function __construct()
	{
		$this->handle = new \PHPMailer\PHPMailer\PHPMailer(true);
		$this->handle->CharSet = 'UTF-8';
		$this->handle->isSMTP();
		$this->handle->Host = Config::MAILER_HOST;
		$this->handle->Port = 587;
		$this->handle->SMTPAuth = true;
		$this->handle->Username = Config::MAILER_USERNAME;
		$this->handle->Password = Config::MAILER_PASSWORD;
		$this->handle->isHTML();
		$this->handle->setFrom(Config::MAILER_USERNAME, Config::TITLE);
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{
		$this->handle = null;
	}

	/**
	 * Sends an email.
	 *
	 * @param string $address The email address to send to.
	 * @param string $subject The subject of the message.
	 * @param string $body An HTML message body.
	 * @return If the method succeeds, the return value is `true`, otherwise
	 * it's `false`.
	 * @note In the debugging mode, this method does not send any email but
	 * writes an information line to the log file.
	 */
	public function Send($address, $subject, $body)
	{
		// The localhost cannot send email. Check log file for email details.
		if (Config::DEBUG) {
			if (Config::LOG)
				Log::Info('Simulating mail to `' . $address . '` with subject `'
					. $subject . '`: ' . $body);
			return true;
		}

		$this->handle->addAddress($address);
		$this->handle->Subject = $subject;
		$this->handle->Body = $body;

		try
		{
			$this->handle->send();
		}
		catch (\PHPMailer\PHPMailer\Exception $ex)
		{
			if (Config::LOG)
				Log::Error($ex->getMessage()); // errorMessage() has html tags.
			return false;
		}

		return true;
	}
}
?>
