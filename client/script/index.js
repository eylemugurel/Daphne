/**
 * Provides functionality for the index page.
 *
 * @namespace
 */
var index = {};

/**
 * @summary Manages all the data-related logic.
 *
 * @class
 * @augments app.Model
 */
index.Model = function()
{
	app.Model.call(this);
}

Element.Inherit(index.Model, app.Model);

/**
 * @summary Manages the components on the page.
 *
 * @class
 * @augments app.Controller
 */
index.Controller = function()
{
	app.Controller.call(this);
}

Element.Inherit(index.Controller, app.Controller);

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
