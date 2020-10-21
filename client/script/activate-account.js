//////////////////////////////////////////////////////////////////////////////
//  ActivateAccountForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function ActivateAccountForm()
{
	Form.call(this, '#ActivateAccountForm');
	var me = this;

	function onSubmit(e) {
		Form.PreventDefault(e);
		gModel.ActivateAccount(
			me.GetSubmitString(),
			function() { location.replace('login.php'); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(ActivateAccountForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < app.Model < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	app.Model.call(this);

	this.ActivateAccount = function(data, onSuccess) {
		this.Post(Model.ActionURL('ActivateAccount'), data, onSuccess);
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

	mActivateAccountForm = new ActivateAccountForm();

	this.Init = function() {
		mActivateAccountForm.Submit();
	}
}

Element.Inherit(PageController, app.Controller);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();

	gController.Init();
});
