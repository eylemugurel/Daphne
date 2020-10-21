//////////////////////////////////////////////////////////////////////////////
//  LogInForm < Form
//
//
//////////////////////////////////////////////////////////////////////////////

function LogInForm()
{
	Form.call(this, '#LogInForm');
	var me = this;

	var mSubmitButton = new Button('#LogInForm_SubmitButton');

	function onSubmit(e) {
		Form.PreventDefault(e);
		if (me.HasErrors())
			return;
		mSubmitButton.SetLoading(true);
		gModel.LogIn(
			me.GetSubmitString(),
			function() { location.replace(Helper.GetURLParameter('referer') || 'index.php'); },
			function() { mSubmitButton.SetLoading(false); }
		);
	}

	this.OnSubmit(onSubmit);
}

Element.Inherit(LogInForm, Form);

//////////////////////////////////////////////////////////////////////////////
//  PageModel < app.Model < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	app.Model.call(this);

	this.LogIn = function(data, onSuccess, onComplete) {
		this.Post(Model.ActionURL('LogIn'), data, onSuccess, onComplete);
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

	mLogInForm = new LogInForm();
}

Element.Inherit(PageController, app.Controller);

//////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
