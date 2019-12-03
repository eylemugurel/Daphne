<?php
//----------------------------------------------------------------------------
// Server.php
//
// Revision     : 3.5
// Last Changed : October 24, 2019 (3:14)
// Author(s)    : Eylem Ugurel
//
// THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
// KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
// WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
//
// Copyright (C) 2019 Eylem Ugurel. All rights reserved.
//----------------------------------------------------------------------------

namespace Core;

class Server
{
	//-------------------------------------------------------------------------
	//  IsSecure [static]
	//
	//  Determines whether the server scheme is `https`.
	//-------------------------------------------------------------------------

	public static function IsSecure()
	{
		if (!array_key_exists('HTTPS', $_SERVER))
			return false;
		$https = $_SERVER["HTTPS"];
		// When using ISAPI with IIS, the value will be "off" if the request
		// was not made through the HTTPS protocol. Same behaviour has been
		// reported for IIS7 running PHP as a Fast-CGI application.
		return $https !== '' && $https !== 'off';
	}

	//-------------------------------------------------------------------------
	//  GetBaseURL [static]
	//
	//  Returns the current host name with the scheme, e.g. http://example.com/
	//-------------------------------------------------------------------------

	public static function GetBaseURL()
	{
		// Fix: $_SERVER['REQUEST_SCHEME'] was empty, therefore IsSecure is used
		// instead.
		return (self::IsSecure() ? 'https' : 'http') . '://'
			. $_SERVER['HTTP_HOST'] . Config::BASE_PATH;
	}

	//-------------------------------------------------------------------------
	//  GetPageFileName [static]
	//
	//  Returns the file name portion of the current url (e.g. 'song.php').
	//-------------------------------------------------------------------------

	public static function GetPageFileName()
	{
		return basename($_SERVER['SCRIPT_NAME']);
	}

	//-------------------------------------------------------------------------
	//  GetQueryString [static]
	//
	//  Returns the current query parameters with optionally a '?' character
	//  prepended.
	//-------------------------------------------------------------------------

	public static function GetQueryString($withQuestionMark =true)
	{
		$y = $_SERVER['QUERY_STRING'];
		if ($y !== '' && $withQuestionMark)
			$y = '?' . $y;
		return $y;
	}
}
?>
