//////////////////////////////////////////////////////////////////////////////
//  ResetPasswordForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function ResetPasswordForm()
{
	Form.call(this, '#ResetPasswordForm');
	var me = this;

	var mSubmitButton = new Button('#ResetPasswordForm_SubmitButton');

	function onSubmit(e) {
		Form.PreventDefault(e);
		if (me.HasErrors())
			return;
		mSubmitButton.SetLoading(true);
		gModel.ResetPassword(
			me.GetSubmitString(),
			function() { location.replace('login.php'); },
			function() { mSubmitButton.SetLoading(false); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(ResetPasswordForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.ResetPassword = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('ResetPassword'), data, onSuccess, onComplete);
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

	mResetPasswordForm = new ResetPasswordForm();
}

Element.Inherit(PageController, AppController);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
