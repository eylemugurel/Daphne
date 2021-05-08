/**
 * Provides base functionality for all pages.
 *
 * @namespace
 * @version 2.1
 * @author Eylem Ugurel
 * @license MIT
 */
var app = {};

/**
 * @summary Represents the root element of the document, typically the `<html>`
 * tag.
 *
 * @class
 * @augments Element
 */
app.Root = function()
{
	Element.call(this, ':root');

	/**
	 * Holds the default cursor style to be restored when the loading indicator
	 * is stopped.
	 *
	 * @type {string}
	 */
	var _defaultCursorStyle = this.GetStyle('cursor');

	/**
	 * Starts/stops the loading indicator.
	 *
	 * @param isLoading {boolean} Controls whether to start or stop the loading
	 * indicator.
	 */
	this.SetLoading = function(isLoading) {
		if (isLoading === true)
			this.SetStyle('cursor', 'progress');
		else
			this.SetStyle('cursor', _defaultCursorStyle)
	}
}

Element.Inherit(app.Root, Element);

/**
 * @summary Manages all the data-related logic.
 *
 * @abstract
 * @class
 * @augments Model
 */
app.Model = function()
{
	Model.call(this);
}

Element.Inherit(app.Model, Model);

/**
 * Logs out the account of the current user.
 *
 * @param onSuccess {function} A function to be called if the request
 * succeeds.
 * @param onComplete {function} A function to be called when the request
 * finishes.
 */
app.Model.prototype.LogOut = function(onSuccess, onComplete) {
	this.Post(Model.ActionURL('LogOut'), { LogOutToken: Helper.GetMetaContent('LogOutToken') }, onSuccess, onComplete);
}

/**
 * @summary Manages the components on the page.
 *
 * @abstract
 * @class
 * @augments Controller
 */
app.Controller = function()
{
	Controller.call(this);

	/**
	 * The root element of the document.
	 *
	 * @type {Element}
	 */
	var _root = new app.Root();

	/**
	 * The link element that logs out when clicked.
	 *
	 * @type {Button}
	 */
	var _logOutLink = Element.Construct('#LogOut', 'Button');

	/**
	 * Function to be called if the [LogOut]{@link app.Model#LogOut} method
	 * succeeds. Reloads the current page.
	 */
	function onLogOutSuccess() {
		location.reload();
	}

	/**
	 * Function to be called when the [LogOut]{@link app.Model#LogOut} method
	 * finishes. Stops the loading indicator.
	 */
	function onLogOutComplete() {
		_root.SetLoading(false);
	}

	/**
	 * Function to be called when the log-out link is clicked. Starts the
	 * loading indicator, and calls the [LogOut]{@link app.Model#LogOut} method.
	 */
	function onLogOutLinkClick() {
		_root.SetLoading(true);
		gModel.LogOut(onLogOutSuccess, onLogOutComplete);
	}

	if (_logOutLink !== null) // if exists
		_logOutLink.OnClick(onLogOutLinkClick);
}

Element.Inherit(app.Controller, Controller);
