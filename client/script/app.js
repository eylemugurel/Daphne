//////////////////////////////////////////////////////////////////////////////
//  AppModel < Model
//
//
//////////////////////////////////////////////////////////////////////////////

function AppModel()
{
	Model.call(this);
}

Element.Inherit(AppModel, Model);

// Operations
AppModel.prototype.LogOut = function() {
	this.Post(
		Model.ActionURL('LogOut'),
		{ LogOutToken: Helper.GetMetaContent('LogOutToken') },
		function() { location.reload(); }
	);
}

//////////////////////////////////////////////////////////////////////////////
//  AppController < Controller
//
//
//////////////////////////////////////////////////////////////////////////////

function AppController()
{
	Controller.call(this);

	var mLogOut = Element.Construct('#LogOut', 'Button'); // practically an <A>

	function onLogOutClick() {
		gModel.LogOut();
	}

	if (mLogOut !== null)
		mLogOut.OnClick(onLogOutClick);
}

Element.Inherit(AppController, Controller);
