<?php
/**
 * @file FormToken.php
 * Contains the `FormToken` class.
 *
 * @version 1.0
 * @date    October 18, 2019 (4:20)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UI;

/**
 * Represents an hidden input element containing a randomly generated string.
 */
class FormToken extends HiddenInput
{
	/** The Token object. */
	private $token = null;

	/**
	 * Constructs an hidden input element with a given name and a randomly
	 * generated value.
	 *
	 * @param string $name (optional) The name of the token. If not specified,
	 * the default name is used.
	 */
	public function __construct($name =\Core\Token::DEFAULT_NAME)
	{
		parent::__construct();
		$this->token = new \Core\Token;
		$this->SetName($name);
		$this->SetValue($this->token->GetValue());
	}

	/**
	 * Creates an HTTP cookie where the name equals to the token name, and the
	 * value is an hash string derived from the token value. The method then
	 * renders the token as an hidden input element.
	 */
	public function Render()
	{
		\Core\Cookies::Set($this->GetName(), $this->token->GetCookieValue());
		parent::Render();
	}
}
?>
