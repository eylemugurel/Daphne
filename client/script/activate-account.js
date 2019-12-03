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
//  PageModel < AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.ActivateAccount = function(data, onSuccess) {
		this.Post(Model.ActionURL('ActivateAccount'), data, onSuccess);
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

	mActivateAccountForm = new ActivateAccountForm();

	this.Init = function() {
		mActivateAccountForm.Submit();
	}
}

Element.Inherit(PageController, AppController);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();

	gController.Init();
});
