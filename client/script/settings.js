/**
 * Provides functionality for the settings page.
 *
 * @namespace
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
	 * Button which submits this form.
	 *
	 * @type {Button}
	 */
	var _submitButton = new Button('#PasswordForm_SubmitButton');

	/**
	 * Function to be called if the call to [UpdatePassword]{@link settings.Model#UpdatePassword}
	 * succeeds. Displays a success message to the user.
	 *
	 * @param message {string} Contains a human readable message.
	 */
	function onUpdatePasswordSuccess(message) {
		gController.ShowSuccess(message);
	}

	/**
	 * Function to be called when the call to [UpdatePassword]{@link settings.Model#UpdatePassword}
	 * finishes. Resets the submit button from loading to normal state.
	 */
	function onUpdatePasswordComplete() {
		_submitButton.SetLoading(false);
	}

	/**
	 * Triggered when the form is submitted. Changes the submit button to the
	 * loading state, and calls [UpdatePassword]{@link settings.Model#UpdatePassword}.
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
	 * Form for updating an account's password.
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
