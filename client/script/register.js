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
//  PageModel < AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.RegisterAccount = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('RegisterAccount'), data, onSuccess, onComplete);
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

	mRegisterForm = new RegisterForm();
}

Element.Inherit(PageController, AppController);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
