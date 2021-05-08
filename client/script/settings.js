/**
 * Provides functionality for the settings page.
 *
 * @namespace
 * @version 2.0
 * @author Eylem Ugurel
 * @license MIT
 */
var settings = {};

/**
 * @summary Form for updating an account's password.
 *
 * @class
 * @augments Form
 */
settings.PasswordForm = function()
{
	Form.call(this, '#PasswordForm');

	/**
	 * Alias to the class level `this`.
	 *
	 * @type {settings.PasswordForm}
	 */
	var _this = this;

	/**
	 * The button which submits the form.
	 *
	 * @type {Button}
	 */
	var _submitButton = new Button('#PasswordForm_SubmitButton');

	/**
	 * Function to be called if the [UpdatePassword]{@link settings.Model#UpdatePassword}
	 * method succeeds. Displays a success message to the user.
	 *
	 * @param message {string} Contains a human readable message.
	 */
	function onUpdatePasswordSuccess(message) {
		gController.ShowSuccess(message);
	}

	/**
	 * Function to be called when the [UpdatePassword]{@link settings.Model#UpdatePassword}
	 * method finishes. Stops the loading indicator of the submit button.
	 */
	function onUpdatePasswordComplete() {
		_submitButton.SetLoading(false);
	}

	/**
	 * Function to be called when the form is submitted. Starts the loading
	 * indicator of the submit button, and calls the [UpdatePassword]{@link settings.Model#UpdatePassword}
	 * method.
	 *
	 * @param e {jQuery.Event} A jQuery Event object.
	 */
	function onSubmit(e) {
		Form.PreventDefault(e);
		if (_this.HasErrors())
			return;
		_submitButton.SetLoading(true);
		gModel.UpdatePassword(
			_this.GetSubmitString(),
			onUpdatePasswordSuccess,
			onUpdatePasswordComplete);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(settings.PasswordForm, Form);

/**
 * @summary Manages all the data-related logic.
 *
 * @class
 * @augments app.Model
 */
settings.Model = function()
{
	app.Model.call(this);

	/**
	 * Updates an account's password with a new one.
	 *
	 * @param data {string} Form data (x-www-form-urlencoded) containing the
	 * following fields:
	 *   * PasswordToken
	 *   * Password
	 *   * NewPassword
	 * @param onSuccess {function} A function to be called if the request
	 * succeeds. The function gets passed a string containing a human readable
	 * message.
	 * @param onComplete {function} A function to be called when the request
	 * finishes.
	 */
	this.UpdatePassword = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('UpdatePassword'), data, onSuccess, onComplete);
	}
}

Element.Inherit(settings.Model, app.Model);

/**
 * @summary Manages the components on the page.
 *
 * @class
 * @augments app.Controller
 */
settings.Controller = function()
{
	app.Controller.call(this);

	/**
	 * The form for updating an account's password.
	 *
	 * @type {settings.PasswordForm}
	 */
	var _passwordForm = new settings.PasswordForm();
}

Element.Inherit(settings.Controller, app.Controller);

/**
 * The global model object.
 *
 * @global
 * @type {settings.Model}
 */
var gModel;

/**
 * The global controller object.
 *
 * @global
 * @type {settings.Controller}
 */
var gController;

$(document).ready(function()
{
	gModel = new settings.Model();
	gController = new settings.Controller();
});
