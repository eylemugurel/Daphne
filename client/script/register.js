//////////////////////////////////////////////////////////////////////////////
//  RegisterForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function RegisterForm()
{
	Form.call(this, '#RegisterForm');
	var me = this;

	var mSubmitButton = new Button('#RegisterForm_SubmitButton');

	function onSubmit(e) {
		Form.PreventDefault(e);
		if (me.HasErrors())
			return;
		mSubmitButton.SetLoading(true);
		gModel.RegisterAccount(
			me.GetSubmitString(),
			function(message) { gController.ShowSuccess(message); },
			function() { mSubmitButton.SetLoading(false); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(RegisterForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < app.Model < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	app.Model.call(this);

	this.RegisterAccount = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('RegisterAccount'), data, onSuccess, onComplete);
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

	mRegisterForm = new RegisterForm();
}

Element.Inherit(PageController, app.Controller);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
