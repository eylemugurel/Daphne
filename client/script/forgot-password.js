//////////////////////////////////////////////////////////////////////////////
//  ForgotPasswordForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function ForgotPasswordForm()
{
	Form.call(this, '#ForgotPasswordForm');
	var me = this;

	var mSubmitButton = new Button('#ForgotPasswordForm_SubmitButton');

	function onSubmit(e) {
		Form.PreventDefault(e);
		if (me.HasErrors())
			return;
		mSubmitButton.SetLoading(true);
		gModel.SendPasswordResetLink(
			me.GetSubmitString(),
			function(message) { gController.ShowSuccess(message); },
			function() { mSubmitButton.SetLoading(false); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(ForgotPasswordForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < app.Model < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	app.Model.call(this);

	this.SendPasswordResetLink = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('SendPasswordResetLink'), data, onSuccess, onComplete);
	}
}

Element.Inherit(PageModel, app.Model);

//////////////////////////////////////////////////////////////////////////////
//  PageController < app.Controller < Controller
//
//
//////////////////////////////////////////////////////////////////////////////

function PageController()
{
	app.Controller.call(this);

	mForgotPasswordForm = new ForgotPasswordForm();
}

Element.Inherit(PageController, app.Controller);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
