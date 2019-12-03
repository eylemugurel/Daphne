<?php
/**
 * @file Action.php
 * Contains the `Action` class.
 *
 * @version 1.3
 * @date    November 30, 2019 (17:30)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 *
 */
class Action
{
	/** */
	private $guards = null;
	/** */
	private $handler = '';
	/** */
	private $parameters = null;

	/**
	 *
	 *
	 * @param object $guard An IGuard object.
	 * @return This instance.
	 */
	public function AddGuard($guard)
	{
		if ($this->guards === null)
			$this->guards = array();
		array_push($this->guards, $guard);
		return $this;
	}

	/**
	 *
	 * @return This instance.
	 */
	public function SetHandler($handler)
	{
		$this->handler = $handler;
		return $this;
	}

	/**
	 *
	 * @return This instance.
	 */
	public function AddGETParameter($name, $type =RequestParameter::TYPE_STRING)
	{
		$this->addParameter(new GETParameter($name, $type));
		return $this;
	}

	/**
	 *
	 * @return This instance.
	 */
	public function AddPOSTParameter($name, $type =RequestParameter::TYPE_STRING)
	{
		$this->addParameter(new POSTParameter($name, $type));
		return $this;
	}

	/**
	 *
	 * @return This instance.
	 */
	public function AddConstantParameter($value)
	{
		$this->addParameter(new ConstantParameter($value));
		return $this;
	}

	/**
	 *
	 */
	public function Dispatch()
	{
		if ($this->guards !== null)
			foreach ($this->guards as $guard)
				if ($guard->Check() === false)
					return Response::Error(Error::ACCESS_DENIED);
		if ($this->parameters === null) {
			return call_user_func($this->handler);
		} else {
			$values = array();
			foreach ($this->parameters as $parameter)
				array_push($values, $parameter->GetValue());
			return call_user_func_array($this->handler, $values);
		}
	}

	/**
	 * @param object $parameter An IParameter object.
	 */
	private function addParameter($parameter)
	{
		if ($this->parameters === null)
			$this->parameters = array();
		array_push($this->parameters, $parameter);
	}
}
?>
