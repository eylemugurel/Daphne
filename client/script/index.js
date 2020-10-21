/**
 * Provides functionality for the index page.
 *
 * @namespace
 */
var index = {};

/**
 * @summary Manages communication with the server.
 *
 * @class
 * @augments AppModel
 */
index.Model = function()
{
	AppModel.call(this);
}

Element.Inherit(index.Model, AppModel);

/**
 * @summary Manages the components on the page.
 *
 * @class
 * @augments AppController
 */
index.Controller = function()
{
	AppController.call(this);
}

Element.Inherit(index.Controller, AppController);

/**
 * The global model object.
 *
 * @global
 * @type {index.Model}
 */
var gModel;

/**
 * The global controller object.
 *
 * @global
 * @type {index.Controller}
 */
var gController;

$(document).ready(function()
{
	gModel = new index.Model();
	gController = new index.Controller();
});
