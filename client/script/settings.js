//////////////////////////////////////////////////////////////////////////////
//  PasswordForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function PasswordForm()
{
	Form.call(this, '#PasswordForm');
	var me = this;

	var mSubmitButton = new Button('#PasswordForm_SubmitButton');

	function onSubmit(e) {
		Form.PreventDefault(e);
		if (me.HasErrors())
			return;
		mSubmitButton.SetLoading(true);
		gModel.UpdatePassword(
			me.GetSubmitString(),
			function(message) { gController.ShowSuccess(message); },
			function() { mSubmitButton.SetLoading(false); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(PasswordForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.UpdatePassword = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('UpdatePassword'), data, onSuccess, onComplete);
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

	mPasswordForm = new PasswordForm();
}

Element.Inherit(PageController, AppController);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
