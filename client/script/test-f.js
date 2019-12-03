////////////////////////////////////////////////////////////////////////////////
// Constants
////////////////////////////////////////////////////////////////////////////////

var TEST_EMAIL = 'testuser@example.com';
var TEST_USERNAME = 'testuser';
var TEST_PASSWORD = '724Abc!';
var LOGOUT_TOKEN_NAME = 'LogOutToken';
var LOG_FILE_URL = 'http://localhost/default.log';
var ACTIVATE_ACCOUNT_TOKEN_RE = /http:\/\/localhost\/activate-account.php\?token=(.+)/;
var RESET_PASSWORD_TOKEN_RE = /http:\/\/localhost\/reset-password.php\?token=(.+)/;

////////////////////////////////////////////////////////////////////////////////
// Test
////////////////////////////////////////////////////////////////////////////////

function Test()
{
	this.Name = this.constructor.name;
}

// Static Methods
Test.Verify = function(x) {
	if (!x) throw new Error('Verification failed.');
}
Test.ExtractToken = function(data, re) {
	var token = '';
	var lines = data.split('\n');
	for (var i = 0, ii = lines.length; i < ii; ++i) {
		var result = lines[i].match(re);
		if (result !== null)
			token = result[1];
		// continue loop to find the latest token.
	}
	return token;
}

// Operations
Test.prototype.Run = function() {
	this.Pass(); // default action.
}
Test.prototype.Pass = function() {
	gController.OnTestPass();
}
Test.prototype.Fail = function(e) {
	gController.OnTestFail(Helper.FormatString('%s failed.<br><br>%s: %s',
		this.Name, e.name, e.message));
}

////////////////////////////////////////////////////////////////////////////////
// Dummy < Test
////////////////////////////////////////////////////////////////////////////////

function Dummy()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
	}
	//#endregion Test Data

	this.Run = function() { try {
		gModel.Dummy(me.Pass);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(Dummy, Test);

////////////////////////////////////////////////////////////////////////////////
// LogIn < Test
////////////////////////////////////////////////////////////////////////////////

function LogIn()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		Username: TEST_USERNAME,
		Password: TEST_PASSWORD
	}
	//#endregion Test Data

	this.Run = function() { try {
		gModel.LogIn(mData, me.Pass);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(LogIn, Test);

////////////////////////////////////////////////////////////////////////////////
// LogOut < Test
////////////////////////////////////////////////////////////////////////////////

function LogOut()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		LogOutToken: Helper.GetMetaContent(LOGOUT_TOKEN_NAME)
	}
	//#endregion Test Data

	this.Run = function() { try {
		gModel.LogOut(mData, me.Pass);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(LogOut, Test);

////////////////////////////////////////////////////////////////////////////////
// RegisterAccount < Test
////////////////////////////////////////////////////////////////////////////////

function RegisterAccount()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		Email: Helper.RandomString(6) + '@example.com',
		Username: Helper.RandomString(6),
		Password: Helper.RandomString(6)
	}
	//#endregion Test Data

	function onSuccess(/*message*/) { try {
		me.Pass();
	} catch (e) { me.Fail(e); }}

	this.Run = function() { try {
		gModel.RegisterAccount(mData, onSuccess);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(RegisterAccount, Test);

////////////////////////////////////////////////////////////////////////////////
// ActivateAccount < Test
//
// Note: The RegisterAccount test must be run prior to this one.
////////////////////////////////////////////////////////////////////////////////

function ActivateAccount()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		AccountActivateToken: '' // will be set by onGetLogFile
	}
	//#endregion Test Data

	function onGetLogFile(data) { try {
		var token = Test.ExtractToken(data, ACTIVATE_ACCOUNT_TOKEN_RE);
		Test.Verify(token !== '');
		mData.AccountActivateToken = token;
		gModel.ActivateAccount(mData, me.Pass);
	} catch (e) { me.Fail(e); }}

	this.Run = function() { try {
		$.get(LOG_FILE_URL, onGetLogFile, 'text');
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(ActivateAccount, Test);

////////////////////////////////////////////////////////////////////////////////
// SendPasswordResetLink < Test
////////////////////////////////////////////////////////////////////////////////

function SendPasswordResetLink()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		Email: TEST_EMAIL
	}
	//#endregion Test Data

	function onSuccess(/*message*/) { try {
		me.Pass();
	} catch (e) { me.Fail(e); }}

	this.Run = function() { try {
		gModel.SendPasswordResetLink(mData, onSuccess);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(SendPasswordResetLink, Test);

////////////////////////////////////////////////////////////////////////////////
// ResetPassword < Test
//
// Note: The SendPasswordResetLink test must be run prior to this one.
////////////////////////////////////////////////////////////////////////////////

function ResetPassword()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		PasswordResetToken: '', // will be set by onGetLogFile
		Password: TEST_PASSWORD // providing the same password
	}
	//#endregion Test Data

	function onGetLogFile(data) { try {
		var token = Test.ExtractToken(data, RESET_PASSWORD_TOKEN_RE);
		Test.Verify(token !== '');
		mData.PasswordResetToken = token;
		gModel.ResetPassword(mData, me.Pass);
	} catch (e) { me.Fail(e); }}

	this.Run = function() { try {
		$.get(LOG_FILE_URL, onGetLogFile, 'text');
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(ResetPassword, Test);

////////////////////////////////////////////////////////////////////////////////
// UpdatePassword < Test
////////////////////////////////////////////////////////////////////////////////

function UpdatePassword()
{
	Test.call(this);
	var me = this;

	//#region Test Data
	var mLogInData = {
		Token: Helper.GetMetaContent(DAPHNE_DEFAULT_TOKEN_NAME),
		Username: TEST_USERNAME,
		Password: TEST_PASSWORD
	}
	var mUpdatePasswordData = {
		PasswordToken: Helper.GetMetaContent('PasswordToken'),
		Password: TEST_PASSWORD,
		NewPassword: TEST_PASSWORD // providing the same password
	}
	var mLogOutData = {
		LogOutToken: Helper.GetMetaContent(LOGOUT_TOKEN_NAME)
	}
	//#endregion Test Data

	function onUpdatePassword() { try {
		gModel.LogOut(mLogOutData, me.Pass);
	} catch (e) { me.Fail(e); }}

	function onLogIn() { try {
		gModel.UpdatePassword(mUpdatePasswordData, onUpdatePassword);
	} catch (e) { me.Fail(e); }}

	this.Run = function() { try {
		gModel.LogIn(mLogInData, onLogIn);
	} catch (e) { me.Fail(e); }}
}

Element.Inherit(UpdatePassword, Test);

////////////////////////////////////////////////////////////////////////////////
// TestSuite
////////////////////////////////////////////////////////////////////////////////

function TestSuite()
{
	//#region Private Variables
	var mQueue = null;
	var mStartTime;
	var mEndTime;
	//#endregion Private Variables

	//#region Private Methods
	function initQueue() {
		mQueue = []; // FIFO
		mQueue.push(new Dummy());
		mQueue.push(new LogIn());
		mQueue.push(new LogOut());
		mQueue.push(new RegisterAccount());
		mQueue.push(new ActivateAccount());
		mQueue.push(new SendPasswordResetLink());
		mQueue.push(new ResetPassword());
		mQueue.push(new UpdatePassword());
	}
	//#endregion Private Methods

	//#region Public Methods
	this.Run = function() {
		mStartTime = new Date();
		initQueue();
		this.RunNext();
	}
	this.RunNext = function() {
		if (mQueue.length > 0) {
			var test = mQueue.shift();
			gController.OnTestRun(test.Name);
			test.Run();
		} else {
			mEndTime = new Date();
			gController.OnTestComplete((mEndTime - mStartTime) / 1000);
		}
	}
	//#endregion Public Methods
}

////////////////////////////////////////////////////////////////////////////////
// PageModel < AppModel < Model
////////////////////////////////////////////////////////////////////////////////

function PageModel()
{
	AppModel.call(this);

	this.Dummy = function(onSuccess) {
		this.Get(Model.ActionURL('Dummy'), onSuccess);
	}
	this.LogIn = function(data, onSuccess) {
		this.Post(Model.ActionURL('LogIn'), data, onSuccess);
	}
	this.LogOut = function(data, onSuccess) {
		this.Post(Model.ActionURL('LogOut'), data, onSuccess);
	}
	this.RegisterAccount = function(data, onSuccess) {
		this.Post(Model.ActionURL('RegisterAccount'), data, onSuccess);
	}
	this.ActivateAccount = function(data, onSuccess) {
		this.Post(Model.ActionURL('ActivateAccount'), data, onSuccess);
	}
	this.SendPasswordResetLink = function(data, onSuccess) {
		this.Post(Model.ActionURL('SendPasswordResetLink'), data, onSuccess);
	}
	this.ResetPassword = function(data, onSuccess) {
		this.Post(Model.ActionURL('ResetPassword'), data, onSuccess);
	}
	this.UpdatePassword = function(data, onSuccess) {
		this.Post(Model.ActionURL('UpdatePassword'), data, onSuccess);
	}
}

Element.Inherit(PageModel, AppModel);

////////////////////////////////////////////////////////////////////////////////
// PageController < AppController < Controller
////////////////////////////////////////////////////////////////////////////////

function PageController()
{
	AppController.call(this);

	//#region Private Variables
	var mTestSuite = new TestSuite();
	var mRunButton = new Button('#RunButton');
	var mOutput = new Element('#Output');
	//#endregion Private Variables

	//#region Public Variables
	//#endregion Public Variables

	//#region Private Methods
	function onRunButtonClick() {
		mRunButton.SetLoading(true);
		mOutput.RemoveChildren();
		mTestSuite.Run();
	}
	function passLast() {
		var lastChild = mOutput.GetLastChild();
		if (lastChild !== null)
			// The GetText method also returns the trailing `&ensp;`.
			// Therefore there's no need to set a spacer here again.
			lastChild.SetHTML(lastChild.GetText() + '<i class="fa fa-check"></i>');
	}
	function failLast() {
		var lastChild = mOutput.GetLastChild();
		if (lastChild !== null)
			// The GetText method also returns the trailing `&ensp;`.
			// Therefore there's no need to set a spacer here again.
			lastChild.SetHTML(lastChild.GetText() + '<i class="fa fa-times"></i>');
	}
	//#endregion Private Methods

	//#region Public Methods
	this.ShowError = function(message) { // override
		// The base method `ShowError` is overriden in order to make call to
		// `failLast` when an error occurs in base `Model` class handlers.
		failLast();
		// Because ShowError can also be called from the handlers of the base
		// Model class, this is the best place to stop the loading animation.
		mRunButton.SetLoading(false);
		AppController.prototype.ShowError.call(this, message); // call base method
	}
	this.OnTestRun = function(testName) {
		passLast();
		mOutput.AddChild('<p>' + testName + '&ensp;<i class="fa fa-spinner fa-spin"></i></p>');
	}
	this.OnTestPass = function() {
		mTestSuite.RunNext();
	}
	this.OnTestComplete = function(duration) {
		passLast();
		mRunButton.SetLoading(false);
		this.ShowSuccess(Helper.FormatString('Test completed in %s seconds.', duration));
	}
	this.OnTestFail = function(message) {
		this.ShowError(message);
	}
	//#endregion Public Methods

	mRunButton.OnClick(onRunButtonClick);
}

Element.Inherit(PageController, AppController);

////////////////////////////////////////////////////////////////////////////////

var gModel, gController;

$(document).ready(function()
{
	gModel = new PageModel();
	gController = new PageController();
});
