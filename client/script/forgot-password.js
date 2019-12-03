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
//  PageModel < AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.SendPasswordResetLink = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('SendPasswordResetLink'), data, onSuccess, onComplete);
	}
}

Element.Inherit(PageModel, AppModel);

//////////////////////////////////////////////////////////////////////////////
//  PageController < AppController < Controller
//
//
//////////////////////////////////////////////////////////////////////////////

function PageController()
{
	AppController.call(this);

	mForgotPasswordForm = new ForgotPasswordForm();
}

Element.Inherit(PageController, AppController);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
