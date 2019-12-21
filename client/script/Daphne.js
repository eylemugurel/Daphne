//----------------------------------------------------------------------------
// Daphne.js
//
// Revision     : 8.0
// Last Changed : December 21, 2019 (11:52)
// Author(s)    : Eylem Ugurel
//
// THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
// KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
// WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
//
// CLASS HIERARCHY
// ---------------
// Element
//   Label
//   Button
//     ToggleButton
//   Input
//     CheckBox
//     ComboBox
//     MultiComboBox
//     FileInput
//     DateInput
//     DateTimeInput
//     Slider
//     Autocomplete
//   Accordion
//   Tab
//   Flip
//   Rating
//   Table
//   Map
//   Form
//   Dialog
//     SuccessDialog
//     ErrorDialog
//     ProgressDialog
//     WaitDialog
//     DeleteDialog
//
// Model
// Controller
// Helper
//
/*!Daphne Framework. Copyright (C) 2019 Eylem Ugurel. All rights reserved.*/
//----------------------------------------------------------------------------

//----------------------------------------------------------------------------
//  Configuration
//----------------------------------------------------------------------------

var DAPHNE_LANGUAGE = 'tr'; // todo: respect this in all language related things.

//----------------------------------------------------------------------------
//  Constants
//----------------------------------------------------------------------------

var DAPHNE_DEFAULT_TOKEN_NAME = 'Token';
var DAPHNE_CLIENT_DIRECTORY = 'client/';
var DAPHNE_CLIENT_IMAGE_DIRECTORY = DAPHNE_CLIENT_DIRECTORY + 'image/';

//----------------------------------------------------------------------------
//  Element
//----------------------------------------------------------------------------

function Element(selector)
{
	this.$ = $(selector);
	if (!this.Exists())
		console.warn('[Daphne] Selector not found: "' + selector + '"');
}

// Static Methods
Element.Inherit = function(child, parent) {
	child.prototype = Object.create(parent.prototype);
	child.prototype.constructor = child;
}
Element.Construct = function(selector, className/*='Element'*/) {
	var jq =  $(selector);
	if (jq.length === 0)
		return null;
	if (!className)
		className = 'Element';
	return new window[className](jq);
}

// Attributes
Element.prototype.GetDOMElement = function() {
	return this.$[0];
}
Element.prototype.Exists = function() {
	return this.$.length > 0;
}
Element.prototype.SetAttribute = function(name, value) {
	this.$.attr(name, value);
}
Element.prototype.GetAttribute = function(name) {
	return this.$.attr(name);
}
Element.prototype.SetData = function(name, value) {
	this.$.data(name, value);
}
Element.prototype.GetData = function(name) {
	return this.$.data(name);
}
Element.prototype.SetText = function(value) {
	this.$.text(value);
}
Element.prototype.GetText = function() {
	return this.$.text();
}
Element.prototype.SetHTML = function(value) {
	this.$.html(value);
}
Element.prototype.GetHTML = function() {
	return this.$.html();
}
Element.prototype.SetStyle = function(name, value) {
	this.$.css(name, value);
}
Element.prototype.GetStyle = function(name) {
	return this.$.css(name);
}
Element.prototype.IsEmpty = function() {
	return this.$.is(':empty');
}
Element.prototype.IsVisible = function() {
	return this.$.is(':visible');
}
Element.prototype.GetLastChild = function(className) {
	return Element.Construct(this.$.children().last(), className);
}

// Operations
Element.prototype.RemoveAttribute = function(name) {
	this.$.removeAttr(name);
}
Element.prototype.RemoveClassWithPrefix = function(prefix) {
	var regexp = new RegExp('\\b' + prefix + '\\S+', 'gi');
	this.$.removeClass(function(i, classes) {
		var matches = classes.match(regexp);
		return matches ? matches.join(' ') : '';
	});
}
Element.prototype.Find = function(query, className) {
	return Element.Construct(this.$.find(query), className);
}
Element.prototype.Focus = function() {
	this.$.focus();
}
Element.prototype.Show = function() {
	this.$.show();
}
Element.prototype.Hide = function() {
	this.$.hide();
}
Element.prototype.AddChild = function(content) {
	this.$.append(content);
}
Element.prototype.RemoveChildren = function() {
	this.$.empty();
}

// Events
Element.prototype.OnEvent = function(name, callback) {
	this.$.on(name, callback);
}
Element.prototype.OffEvent = function(name, callback) {
	this.$.off(name, callback);
}
Element.prototype.OnEventOnce = function(name, callback) {
	this.$.one(name, callback);
}
Element.prototype.OnDelegatedEvent = function(name, delegateeSelector, callback) {
	this.$.on(name, delegateeSelector, callback);
}
Element.prototype.OffDelegatedEvent = function(name, delegateeSelector) {
	this.$.off(name, delegateeSelector);
}
Element.prototype.OnDelegatedEventOnce = function(name, delegateeSelector, callback) {
	this.$.one(name, delegateeSelector, callback);
}

//----------------------------------------------------------------------------
//  Label < Element
//
//  Represents Bootstrap's Label component.
//----------------------------------------------------------------------------

function Label(selector)
{
	Element.call(this, selector);
}

Element.Inherit(Label, Element);

// Attributes
Label.prototype.SetText = function(text) { // override
	// Since the loading animation and the text is mutually exclusive,
	// unset the loading state first.
	if (this.IsLoading())
		this.SetLoading(false);
	Element.prototype.SetText.call(this, text); // call base method
}
Label.prototype.SetLoading = function(loading) {
	// If already in the requested state, then there's no action.
	if (loading === this.IsLoading())
		return;
	// Fix: If the label contains no text, it gets .label:empty {
	// display: none; } by Bootstrap. Also since the SPAN tag is
	// an inline element, it cannot be given a fixed width. To
	// overcome, a spacing character must be put in it.
	if (loading) {
		this.$.html('&emsp;');
		this.$.addClass('label-loading');
	} else {
		this.$.html('');
		this.$.removeClass('label-loading');
	}
}
Label.prototype.IsLoading = function() {
	return this.$.hasClass('label-loading');
}

//----------------------------------------------------------------------------
//  Button < Element
//
//  Represents <button>, <input type='button'>, and <input type='submit'>
//  elements.
//----------------------------------------------------------------------------

function Button(selector)
{
	Element.call(this, selector);
}

Element.Inherit(Button, Element);

// Attributes
Button.prototype.SetValue = function(value) {
	// Changes text of <input type='button'> and <input type='submit'>.
	this.$.val(value);
}
Button.prototype.SetDisabled = function(disabled) {
	disabled ? this.SetAttribute('disabled', '')
	         : this.RemoveAttribute('disabled');
}
Button.prototype.IsDisabled = function() {
	return this.$.is(':disabled');
}
Button.prototype.SetLoading = function(loading) {
	loading ? this.$.button('loading')
	        : this.$.button('reset');
}
Button.prototype.SetContextualClass = function(className) {
	// Fix: Size classes `.btn-lg`, `.btn-sm`, or `.btn-xs` should be kept.
	var match = this.$.attr('class').match(/\bbtn-(xs|sm|lg)/i);
	var sizeClassName = match === null ? '' : match[1];
	//
	this.RemoveClassWithPrefix('btn-');
	if (className !== '')
		this.$.addClass('btn-' + className);
	// Fix: Restore size class.
	if  (sizeClassName !== '')
		this.$.addClass('btn-' + sizeClassName);
}
Button.prototype.GetContextualClass = function() {
	var match = this.$.attr('class').match(
		/\bbtn-(default|primary|success|info|warning|danger|link)/i);
	return match === null ? '' : match[1];
}

// Events
Button.prototype.OnClick = function(callback) {
	this.OnEvent('click', callback);
}
Button.prototype.OffClick = function(callback) {
	this.OffEvent('click', callback);
}

//----------------------------------------------------------------------------
//  ToggleButton < Button < Element
//----------------------------------------------------------------------------

function ToggleButton(selector)
{
	Button.call(this, selector);
}

Element.Inherit(ToggleButton, Button);

// Attributes
ToggleButton.prototype.SetPressed = function(pressed) {
	if (pressed) {
		this.$.addClass('active');
		this.$.attr('aria-pressed', 'true');
	} else {
		this.$.removeClass('active');
		this.$.attr('aria-pressed', 'false');
	}
}
ToggleButton.prototype.IsPressed = function() {
	return this.$.attr('aria-pressed') === 'true';
}

// Events
ToggleButton.prototype.OnClick = function(callback) { // override
	var me = this;
	Button.prototype.OnClick.call(this, function() { // call base method
		// The 'aria-pressed' attribute returns the state prior to clicking
		// the button. Therefore, the invert of the attribute is passed.
		callback(me.IsPressed() ? false : true);
	});
}

//----------------------------------------------------------------------------
//  Input < Element
//
//  Represents <input>, <select>, and <textarea> elements.
//----------------------------------------------------------------------------

function Input(selector)
{
	Element.call(this, selector);
}

Element.Inherit(Input, Element);

// Attributes
Input.prototype.SetValue = function(value) {
	this.$.val(value);
}
Input.prototype.GetValue = function() {
	return this.$.val();
}
Input.prototype.SetDisabled = function(disabled) {
	disabled ? this.SetAttribute('disabled', '')
	         : this.RemoveAttribute('disabled');
}
Input.prototype.IsDisabled = function() {
	return this.$.is(':disabled');
}
Input.prototype.SetReadonly = function(readonly) {
	readonly ? this.SetAttribute('readonly', '')
	         : this.RemoveAttribute('readonly');
}
Input.prototype.SetLoading = function(loading) {
	loading ? this.$.addClass('input-loading')
	        : this.$.removeClass('input-loading');
}

// Operations
Input.prototype.Focus = function() { // extends
	Element.prototype.Focus.call(this);
	this.$.select();
}
Input.prototype.Clear = function() {
	this.$.val('');
}

// Events
Input.prototype.OnChange = function(callback) {
	this.OnEvent('change', callback);
}
Input.prototype.OnChangeEx = function(callback) {
	this.OnEvent('input propertychange', callback);
}

//----------------------------------------------------------------------------
//  CheckBox < Input < Element
//
//  Represents <input type="checkbox"> element.
//----------------------------------------------------------------------------

function CheckBox(selector)
{
	Input.call(this, selector);
}

Element.Inherit(CheckBox, Input);

// Attributes
CheckBox.prototype.SetChecked = function(checked) {
	this.$.prop('checked', checked);
}
CheckBox.prototype.IsChecked = function() {
	return this.$.is(':checked');
}

// Events
CheckBox.prototype.OnClick = function(callback) {
	// Internet Explorer only fires the `change` event when the checkbox
	// loses the focus (blur). So, `click` is more of a cross browser way.
	this.OnEvent('click', callback);
}

//----------------------------------------------------------------------------
//  ComboBox < Input < Element
//
//  Represents a <select> element.
//----------------------------------------------------------------------------

function ComboBox(selector)
{
	Input.call(this, selector);
}

Element.Inherit(ComboBox, Input);

// Attributes
ComboBox.prototype.SetText = function(text) { // override
	this.$.find('option').filter(function() {
		return $(this).text() === text;
	}).prop('selected', true);
}
ComboBox.prototype.GetText = function() { // override
	return this.$.find('option:selected').text();
}
ComboBox.prototype.SetPlaceholder = function(text) {
	// Requires '<option selected>' as the first child.
	this.$.find('option:first').text(text);
}

// Operations
ComboBox.prototype.AddItem = function(value, text) {
	this.GetDOMElement().options.add(new Option(text, value));
}
ComboBox.prototype.UpdateItem = function(value, text) {
	this.$.find('option[value="' + value + '"]').text(text);
}
ComboBox.prototype.RemoveItem = function(value) {
	this.$.find('option[value="' + value + '"]').remove();
}
ComboBox.prototype.RemoveItems = function(hasPlaceholder/*=false*/) {
	var q = hasPlaceholder ? 'option:not(:first)' : 'option';
	this.$.find(q).remove();
	// Fix: Whether or not there is a placeholder, make the first item
	// selected.
	this.$.find('option:first').prop('selected', true);
}
ComboBox.prototype.SortItems = function() {
	// Fix: Since option list is detached and re-attached, selected value must
	// be backed up and then restored.
	var value = this.GetValue();
	var options = this.$.find('option');
	options.detach().sort(function (a, b) {
		return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
	});
	options.appendTo(this.$);
	this.SetValue(value);
}
ComboBox.prototype.Populate = function(items, hasPlaceholder/*=false*/) {
	this.RemoveItems(hasPlaceholder);
	for (var i = 0, ii = items.length; i < ii; ++i) {
		var item = items[i];
		this.AddItem(item.ID, item.Name);
	}
}

//----------------------------------------------------------------------------
//  MultiComboBox < Input < Element
//
//  Represents <select> element extended with `bootstrap-multiselect` widget.
//
//  Remarks
//    http://davidstutz.de/bootstrap-multiselect/
//----------------------------------------------------------------------------

function MultiComboBox(selector, settings/*=MultiComboBox.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.multiselect(Helper.MergeObjects(MultiComboBox.DefaultSettings, settings));
}

Element.Inherit(MultiComboBox, Input);

// Static Variables
MultiComboBox.DefaultSettings = {
	buttonWidth: '100%',
	nonSelectedText: 'Seçiniz',
	allSelectedText: 'Tümü',
	includeSelectAllOption: true,
	selectAllText: 'Tümü',
	nSelectedText: ' öge seçili'
}

// Attributes
MultiComboBox.prototype.GetBitmask = function() {
	var bitmask = 0;
	var values = this.GetValue(); // returns checked values as an array.
	for (var i = 0, ii = values.length; i < ii; ++i)
		bitmask = bitmask | Helper.ConvertToInteger(values[i]);
	return bitmask;
}

// Operations
MultiComboBox.prototype.SetCheckedAll = function(checked) {
	if (checked)
		this.$.multiselect('selectAll', false);
	else
		this.$.multiselect('deselectAll', false);
	this.$.multiselect('updateButtonText');
}

//----------------------------------------------------------------------------
//  FileInput < Input < Element
//
//  Represents <input type="file"> element styled with Bootstrap FileStyle
//  plugin.
//
//  Remarks
//    http://markusslima.github.io/bootstrap-filestyle/1.2.3/
//----------------------------------------------------------------------------

function FileInput(selector, settings/*=FileInput.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.filestyle(Helper.MergeObjects(FileInput.DefaultSettings, settings));
}

Element.Inherit(FileInput, Input);

// Static Variables
FileInput.DefaultSettings = {
	buttonText: ''
}

// Attributes
FileInput.prototype.SetPlaceholder = function(text) {
	this.$.filestyle('placeholder', text);
}
FileInput.prototype.GetFiles = function() {
	return this.$.prop('files');
}
FileInput.prototype.GetFile = function() {
	var files = this.GetFiles();
	if (!files.length)
		return null;
	return files[0];
}
FileInput.prototype.GetFileName = function() {
	var file = this.GetFile();
	if (file === null)
		return '';
	return file.name;
}

// Operations
FileInput.prototype.Clear = function() { // override
	// Fix: Form.Clear does not clear the plugin.
	this.$.filestyle('clear');
}

//----------------------------------------------------------------------------
//  DateInput < Input < Element
//
//  Represents <input type="text"> element extended with bootstrap-datepicker
//  widget.
//
//  Remarks
//    https://bootstrap-datepicker.readthedocs.io/en/stable/index.html
//----------------------------------------------------------------------------

function DateInput(selector, settings/*=DateInput.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.datepicker(Helper.MergeObjects(DateInput.DefaultSettings, settings));
}

Element.Inherit(DateInput, Input);

// Static Variables
DateInput.DefaultSettings = {
	language: 'tr',
	format: 'dd.mm.yyyy',
	weekStart: 1,
	daysOfWeekHighlighted: '0,6',
	todayHighlight: true,
	autoclose: true
}

// Attributes
DateInput.prototype.SetValue = function(value) { // override
	// Fix: $.val does not work; setDate method must be used.
	this.$.datepicker('setDate', value);
}

// Operations
DateInput.prototype.Clear = function() { // override
	// Fix: Form.Clear clears the input element but does not clear the widget.
	// Also, .Clear() must be called BEFORE Form.Clear(), otherwise it will
	// trigger form validator.
	this.$.datepicker('clearDates');
}

//----------------------------------------------------------------------------
//  DateTimeInput < Input < Element
//
//  Represents <input type="text"> element extended with bootstrap-datetimepicker
//  widget.
//
//  Remarks
//    https://eonasdan.github.io/bootstrap-datetimepicker/
//----------------------------------------------------------------------------

function DateTimeInput(selector, settings/*=DateTimeInput.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.datetimepicker(Helper.MergeObjects(DateTimeInput.DefaultSettings, settings));
}

Element.Inherit(DateTimeInput, Input);

// Static Variables
DateTimeInput.DefaultSettings = {
	locale: 'tr',
	format: 'DD.MM.YYYY HH:mm:ss' // fix: for ':ss', to be compatiple with JS and MYSQL
}

// Attributes
DateTimeInput.prototype.GetPlugin = function() {
	return this.$.data('DateTimePicker');
}
DateTimeInput.prototype.SetDate = function(date) {
	this.GetPlugin().date(date)
}
DateTimeInput.prototype.GetUnixTimestamp = function () {
	var moment = this.GetPlugin().date();
	if (!moment)
		return 0;
	return moment.unix();
}

// Operations
DateTimeInput.prototype.Clear = function() { // override
	// Fix: Form.Clear clears the input element but does not clear the widget.
	this.GetPlugin().clear();
}

//----------------------------------------------------------------------------
//  Slider < Input < Element
//
//  Represents <input type="text"> element extended with Ion.RangeSlider
//  widget.
//
//  Remarks
//    http://ionden.com/a/plugins/ion.rangeSlider/en.html
//----------------------------------------------------------------------------

function Slider(selector, settings/*=Slider.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.ionRangeSlider(Helper.MergeObjects(Slider.DefaultSettings, settings));
}

Element.Inherit(Slider, Input);

// Static Variables
Slider.DefaultSettings = {
	type: 'double',
	min: 0,
	max: 0,
	from: 0,
	to: 0
}

// Attributes
Slider.prototype.GetPlugin = function() {
	return this.$.data('ionRangeSlider');
}
Slider.prototype.SetDisabled = function(disabled) { // override
	// If already in the requested state, then there's no action.
	if (disabled === this.IsDisabled())
		return;
	this.GetPlugin().update({ disable: disabled });
}
Slider.prototype.IsDisabled = function() { // override
	return this.GetPlugin().options.disable; // Fix: Not `this.$.data().disable`.
}
Slider.prototype.SetRange = function(min, max) {
	// Fix: In case `null` is returned from an AJAX call...
	min = min || 0;
	max = max || 0;
	this.GetPlugin().update({min: min, max: max, from: min, to: max });
}
Slider.prototype.GetMin = function() {
	return this.GetPlugin().options.min; // Fix: Not `this.$.data().min`.
}
Slider.prototype.GetMax = function() {
	return this.GetPlugin().options.max; // Fix: Not `this.$.data().max`.
}
Slider.prototype.GetFrom = function() {
	return this.$.data().from;
}
Slider.prototype.GetTo = function() {
	return this.$.data().to;
}
Slider.prototype.SetPostfix = function(postfix) {
	this.GetPlugin().update({ postfix: postfix });
}

// Operations
Slider.prototype.Clear = function() { // override
	this.GetPlugin().update({min: 0, max: 0, from: 0, to: 0 });
}

// Events
Slider.prototype.OnChange = function(callback) {
	this.GetPlugin().update({
		onFinish: function(data) { callback(data.from, data.to); }
	});
}

//----------------------------------------------------------------------------
//  Autocomplete < Input < Element
//
//  Represents Bootstrap-3-Typeahead component ported to BS3 by Bass Jobsen.
//
//  Remarks
//    https://github.com/bassjobsen/Bootstrap-3-Typeahead
//----------------------------------------------------------------------------

function Autocomplete(selector, settings/*=Autocomplete.DefaultSettings*/)
{
	Input.call(this, selector);

	this.$.typeahead(Helper.MergeObjects(Autocomplete.DefaultSettings, settings));
}

Element.Inherit(Autocomplete, Input);

// Static Variables
Autocomplete.DefaultSettings = {
	matcher: function(item) { return Autocomplete.Match(
		this.displayText(item).toLocaleLowerCase(DAPHNE_LANGUAGE),
		this.query.toLocaleLowerCase(DAPHNE_LANGUAGE)); },
		// default handler was ignoring language; was using `toLowerCase`.
	highlighter: function(text) { return Autocomplete.Highlight(
		text,
		text.toLocaleLowerCase(DAPHNE_LANGUAGE),
		this.query.toLocaleLowerCase(DAPHNE_LANGUAGE)); },
		// default handler was highlighting all.
	displayText: function(item) { return item.Name; },
		// default handler was looking for `.name` (JavaScript is case-sensitive).
	fitToElement: true
		// default was `false` which widens to the longest match.
}

// Static Methods
Autocomplete.Match = function(t, q) {
	t = Helper.DecodeHtmlEntities(t);
	q = Helper.DecodeHtmlEntities(q);
	return t.indexOf(q.trim()) !== -1;
}
Autocomplete.Highlight = function(to, t, q) {
	to = Helper.DecodeHtmlEntities(to);
	t = Helper.DecodeHtmlEntities(t);
	q = Helper.DecodeHtmlEntities(q);
	q = q.trim();
	var i = t.indexOf(q);
	if (i === -1)
		return to;
	var l = q.length;
	return to.substr(0, i) + '<strong>' + to.substr(i, l) + '</strong>' + to.substr(i + l);
}

// Attributes
Autocomplete.prototype.GetPlugin = function() {
	return this.$.data('typeahead');
}
Autocomplete.prototype.SetSource = function(source) {
	this.GetPlugin().source = source;
}
Autocomplete.prototype.GetSource = function() {
	return this.GetPlugin().source;
}
Autocomplete.prototype.GetItemCount = function() {
	return this.GetPlugin().source.length;
}
Autocomplete.prototype.GetActiveItem = function() {
	var item = this.$.typeahead('getActive');
	if (item === undefined)
		return null;
	if (item.Name.toLocaleLowerCase(DAPHNE_LANGUAGE)
		!== this.GetValue().toLocaleLowerCase(DAPHNE_LANGUAGE))
		return null;
	return item;
}

// Operations
Autocomplete.prototype.Lookup = function() {
	this.$.typeahead('lookup');
}

//----------------------------------------------------------------------------
//  Accordion < Element
//
//  Represents Bootstrap' Collapse component.
//
//  Remarks
//    http://getbootstrap.com/javascript/#collapse
//----------------------------------------------------------------------------

function Accordion(selector)
{
	Element.call(this, selector);
}

Element.Inherit(Accordion, Element);

// Attributes
Accordion.prototype.IsCollapsed = function() {
	return !this.$.attr('aria-expanded'); // todo: !== 'true'
}

// Operations
Accordion.prototype.SetCollapsed = function(collapsed) {
	collapsed ? this.$.collapse('hide')
	          : this.$.collapse('show');
}

//----------------------------------------------------------------------------
//  Tab < Element
//
//  Represents Bootstrap's Tab component.
//
//  Example
//    var mCompanyTab = new Tab('a[href="#companyTab"]');
//    mCompanyTab.OnShown(function() {
//        mCompanyTable.RecalculateResponsive();
//    });
//
//  Remarks
//    https://getbootstrap.com/docs/3.3/javascript/#tabs
//----------------------------------------------------------------------------

function Tab(selector)
{
	Element.call(this, selector);
}

Element.Inherit(Tab, Element);

// Operations
Tab.prototype.Show = function() { // override
	// Note that, there is no tab('hide') method.
	this.$.tab('show');
}

// Events
Tab.prototype.OnShown = function(callback) {
	this.OnEvent('shown.bs.tab', callback);
}
Tab.prototype.OnHidden = function(callback) {
	this.OnEvent('hidden.bs.tab', callback);
}

//----------------------------------------------------------------------------
//  Flip < Element
//
//  Represents Nattawat Nonsung's `flip` plugin for jQuery.
//
//  Remarks
//    http://nnattawat.github.io/flip/
//----------------------------------------------------------------------------

function Flip(selector, settings/*=Flip.DefaultSettings*/)
{
	Element.call(this, selector);

	this.$.flip(Helper.MergeObjects(Flip.DefaultSettings, settings));
}

Element.Inherit(Flip, Element);

// Static Variables
Flip.DefaultSettings = {
	trigger: 'manual'
}

// Attributes
Flip.prototype.IsFlipped = function() {
	return this.$.data('flip-model').isFlipped;
}

// Operations
Flip.prototype.Toggle = function() {
	this.$.flip('toggle');
}

//----------------------------------------------------------------------------
//  Rating < Element
//
//  Represents `Rate Yo!` plugin for jQuery.
//
//  Remarks
//    http://rateyo.fundoocode.ninja/
//----------------------------------------------------------------------------

function Rating(selector, settings/*=Rating.DefaultSettings*/)
{
	Element.call(this, selector);

	this.$.rateYo(Helper.MergeObjects(Rating.DefaultSettings, settings));
}

Element.Inherit(Rating, Element);

// Static Variables
Rating.DefaultSettings = {
	ratedFill: 'yellow'
}

// Events
Rating.prototype.OnSet = function(callback) { // (e, data)
	this.OnEvent('rateyo.set', callback);
}

//----------------------------------------------------------------------------
//  Table < Element
//
//  Represents datatables.net's DataTable plug-in.
//
//  Remarks
//    https://datatables.net/
//----------------------------------------------------------------------------

function Table(selector, settings/*=Table.DefaultSettings*/)
{
	Element.call(this, selector);

	this.$.DataTable(Helper.MergeObjects(Table.DefaultSettings, settings));
}

Element.Inherit(Table, Element);

// Static Variables
Table.DefaultSettings = {
	rowId: 'ID',
	language: { url: 'client/library/dataTables-1.10.15/plugins/i18n/Turkish.min.json' }, // todo: get from settings
	order: [], // No initial order (sort) to apply to the table (default is `[0, 'asc']`).
	processing: true,
	responsive: true,
	mark: true
}

// Static Methods
Table.GetRecord = function(row) {
	return row.data();
}
Table.UpdateRow = function(row, record) {
	// UX: The 'page' parameter is for keeping ordering, search, and the paging position.
	row.data(record).draw('page');
}
Table.RemoveRow = function(row) {
	row.remove().draw();
}

// Attributes
Table.prototype.GetPlugin = function() {
	return this.$.DataTable();
}
Table.prototype.GetWrapper = function() {
	return this.$.parents('.dataTables_wrapper').first();
}
Table.prototype.GetRowById = function(id) {
	// Requires `rowId` option to be defined in table settings.
	var row = this.GetPlugin().row('#' + id);
	if (row.length === 0)
		return null;
	return row;
}
Table.prototype.GetRowByChild = function(child) {
	var $tr = $(child).closest('tr');
	if ($tr.length === 0)
		return null;
	// Fix: In resposive mode, the child may appear inside a tr.child.
	// Our real row precedes that row.
	if ($tr.hasClass('child'))
		$tr = $tr.prev();
	var row = this.GetPlugin().row($tr);
	if (row.length === 0)
		return null;
	return row;
}
Table.prototype.GetRecords = function() {
	return this.GetPlugin().rows().data().toArray();
}
Table.prototype.GetRowCount = function() {
	return this.GetPlugin().rows().count();
}
Table.prototype.GetCheckedRowIds = function(columnIndex) {
	// Requires 'Table:Checkboxes' extension.
	return this.GetPlugin().column(columnIndex).checkboxes.selected().toArray();
}
Table.prototype.SetCheckedAll = function(columnIndex, checked) {
	// Requires 'Table:Checkboxes' extension.
	var cb = this.GetPlugin().column(columnIndex).checkboxes;
	if (checked)
		cb.select();
	else
		cb.deselectAll();
}
Table.prototype.IsVisible = function() { // override
	return this.GetWrapper().is(':visible');
}
Table.prototype.SetProcessing = function(value) {
	// Requires 'Table:Processing' plugin.
	this.GetPlugin().processing(value);
}

// Operations
Table.prototype.AjaxLoad = function(url) {
	this.GetPlugin().ajax.url(url).load();
}
Table.prototype.AjaxReload = function() {
	var ajax = this.GetPlugin().ajax;
	if (ajax.url()) // Fix: Check if ajax url exists.
		ajax.reload();
	else
		console.warn('[Daphne] Ajax url does not exist.');
}
Table.prototype.AddRows = function(records) {
	this.GetPlugin().rows.add(records).draw();
}
Table.prototype.AddRow = function(record) {
	this.GetPlugin().row.add(record).draw();
}
Table.prototype.ForEachRow = function(callback) {
	var breaked = false;
	this.GetPlugin().rows().every(function() {
		if (breaked)
			return;
		if (callback(this) === false)
			breaked = true;
	});
}
Table.prototype.Clear = function() {
	this.GetPlugin().clear().draw();
}
Table.prototype.RecalculateResponsive = function() {
	this.GetPlugin().columns.adjust().responsive.recalc();
}
Table.prototype.TriggerButton = function(buttonIndex) {
	this.GetPlugin().button(buttonIndex).trigger();
}
Table.prototype.GoToPage = function(set) {
	this.GetPlugin().page(set).draw('page');
}
Table.prototype.Show = function() { // override
	this.GetWrapper().show();
}
Table.prototype.Hide = function() { // override
	this.GetWrapper().hide();
}

// Events
Table.prototype.OnDraw = function(callback) { // (e, settings)
	this.OnEvent('draw.dt', callback);
}
Table.prototype.OnDrawOnce = function(callback) { // (e, settings)
	this.OnEventOnce('draw.dt', callback);
}
Table.prototype.OnAjax = function(callback) { // (e, settings, json, xhr)
	// Fix: Wrap the callback to filter out null value of `json`. Calling
	// AjaxReload (or AjaxLoad) without waiting for the previous response
	// cancels the previous call. In such case, the callback receives a
	// null `json` value (e.g. double clicking on a refresh button).
	this.OnEvent('xhr.dt', function(e, settings, json, xhr) {
		if (json !== null) callback(e, settings, json, xhr);
	});
}
Table.prototype.OnInlineButtonClick = function(buttonSelector, callback) {
	this.OnDelegatedEvent('click', buttonSelector, callback);
}

//----------------------------------------------------------------------------
//  Map < Element
//
//  Represents a map object of the Leaflet library.
//
//  Remarks
//    http://leafletjs.com/
//    LocateControl: https://github.com/domoritz/leaflet-locatecontrol
//    ContextMenu: https://github.com/aratcliffe/Leaflet.contextmenu
//    MarkerCluster: https://github.com/Leaflet/Leaflet.markercluster
//----------------------------------------------------------------------------

function Map(id, settings/*=Map.DefaultSettings*/)
{
	// Leaflet has no jQuery dependency. However, to make the Map class derived
	// from Element, base constructor is called with a jQuery selector by
	// prepending a '#' to the supplied DOM id.
	Element.call(this, '#' + id);

	settings = Helper.MergeObjects(Map.DefaultSettings, settings);

	// ContextMenu plugin must be binded when the map is created. For other
	// layer objects (marker, path) bindContextMenu() can be used.
	this.map = L.map(id, { contextmenu: settings.hasContextMenu });

	// Add the tile layer. Default settings use OpenStreetMap's public tiles.
	var tl = L.tileLayer(settings.urlTemplate, { attribution: settings.attribution });
	tl.addTo(this.map);

	// Create an empty layer for holding markers. Note that instead of L.layerGroup,
	// its extended class L.featureGroup (or markerClusterGroup)is used to get benefit
	// of its getBounds() method together with L.map's fitBounds() method.
	this.markers = settings.hasMarkerCluster
		? L.markerClusterGroup()
		: L.featureGroup();
	this.markers.addTo(this.map);
}

Element.Inherit(Map, Element);

// Static Variables
Map.DefaultSettings = {
	urlTemplate: 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
	hasContextMenu: false, // if true, requires ContextMenu plugin
	hasMarkerCluster: false // if true, requires MarkerCluster plugin
}

// Operations
Map.prototype.AddLocateControl = function() {
	var control = L.control.locate({
		locateOptions: {
			watch: true,
			enableHighAccuracy: true
		},
		icon: 'fa fa-location-arrow',
		strings: {
			title: 'Konumunuzu gösterin',
			metersUnit: 'metre',
			feetUnit: 'fit',
			popup: 'Bu noktadan {distance} {unit} yarıçap içerisindesiniz',
			outsideMapBoundsMsg: 'Harita sınırlarının dışında görünüyorsunuz'
		}
	});
	control.addTo(this.map);
}
Map.prototype.SetContextMenuItems = function(contextMenuItems) {
	for (var i = 0, ii = contextMenuItems.length; i < ii; ++i)
		this.map.contextmenu.addItem(contextMenuItems[i]);
}
Map.prototype.RefreshClusters = function() {
	this.markers.refreshClusters();
}
Map.prototype.SetView = function(coordinates, zoom) {
	this.map.setView(coordinates, zoom);
}
Map.prototype.PanTo = function(coordinates) {
	this.map.panTo(coordinates);
}
Map.prototype.UpdateSize = function() {
	this.map.invalidateSize();
}
Map.prototype.AddMarker = function(coordinates, contextMenuItems/*=undefined*/) {
	var marker = L.marker(coordinates);
	this.markers.addLayer(marker);
	if (contextMenuItems)
		marker.bindContextMenu({
			contextmenu: true,
			contextmenuInheritItems: false,
			contextmenuItems: contextMenuItems
		});
	return marker;
}
Map.prototype.RemoveMarker = function(marker) {
	this.map.removeLayer(marker);
}
Map.prototype.RemoveAllMarkers = function() {
	this.markers.clearLayers();
}
Map.prototype.FitMarkerBounds = function() {
	this.map.fitBounds(this.markers.getBounds());
}

//----------------------------------------------------------------------------
//  Form < Element
//
//  Represents <form> element with 1000hz's Validator plugin.
//
//  Remarks
//    http://1000hz.github.io/bootstrap-validator/
//----------------------------------------------------------------------------

function Form(selector, settings/*=Form.DefaultSettings*/)
{
	Element.call(this, selector);

	this.$.validator(Helper.MergeObjects(Form.DefaultSettings, settings))
		// UX: Disable validation when a control loses focus.
		.off('focusout.bs.validator');
}

Element.Inherit(Form, Element);

// Static Variables
Form.DefaultSettings = {
	disable: false // Do not disable the submit button even if the form is not valid.
}

// Static Methods
Form.PreventDefault = function(e) {
	e.stopPropagation();
	e.preventDefault();
}

// Attributes
Form.prototype.GetSubmitString = function() {
	return this.$.serialize();
}
Form.prototype.GetSubmitArray = function() {
	return this.$.serializeArray();
}
Form.prototype.GetSubmitObject = function() {
	var o = {};
	$.map(this.GetSubmitArray(), function(x) {
		o[x['name']] = x['value'];
	});
	return o;
}
Form.prototype.HasErrors = function() {
	return this.$.data('bs.validator').hasErrors();
}

// Operations
Form.prototype.Populate = function(record) {
	for (var key in record) {
		var value = record[key];
		var input = this.$.find('[name=' + key + ']');
		if (input.length)
			// If a control (or controls) with exact `name` is found,
			// set its value.
			input.val(value);
		else {
			// Otherwise, look for checkbox group where each has `name`
			// equal to the key followed by empty square brackets,
			// e.g. 'Balcony[]'. (See http://api.jquery.com/category/selectors/
			// escaping meta-characters).
			input = this.$.find('input:checkbox[name=' + key + '\\[\\]]');
			if (input.length)
				input.each(function() {
					// If the bitwise-AND result of record's value and
					// checkbox's value is non-zero, then tick it, otherwise
					// clear it.
					$checkbox = $(this);
					var bit = Helper.ConvertToInteger($checkbox.val());
					$checkbox.prop('checked', (value & bit) ? true : false);
				});
		}
	}
}
Form.prototype.Clear = function() {
	// Since there is no reset method in jQuery, DOM method is called instead.
	this.GetDOMElement().reset();
}
Form.prototype.Validate = function() {
	this.$.validator('validate');
}
Form.prototype.Submit = function() {
	this.$.submit();
}

// Events
Form.prototype.OnSubmit = function(callback) {
	this.OnEvent('submit', callback);
}

//----------------------------------------------------------------------------
//  Dialog < Element
//
//  Represents Bootstrap's Modal component.
//
//  Remarks
//    http://getbootstrap.com/javascript/#modals
//----------------------------------------------------------------------------

function Dialog(selector, parentDialog/*=undefined*/)
{
	Element.call(this, selector);

	//#region Private Methods
	// Fix: After a child dialog is closed, the parent dialog does not re-gain
	// the focus. This is a known issue with BS modals. As a work-around, focus
	// to the parent dialog must be set manually. Otherwise, ESC key to close
	// the parent dialog will not work after a child dialog is dismissed. Note
	// that, focus must be called from `OnHidden`, not `OnHide`.
	function setFocusToParentDialog() {
		parentDialog.Focus();
	}
	//#endregion Private Methods

	// Automatically apply JQuery UI's draggable feature.
	this.$.draggable({ handle: '.modal-header' });

	// Fix: If there is a parent dialog, let it re-gain focus after this dialog
	// is dismissed.
	if (parentDialog !== undefined)
		this.OnHidden(setFocusToParentDialog);
}

Element.Inherit(Dialog, Element);

// Attributes
Dialog.prototype.SetTitle = function(title) {
	this.$.find('.modal-title').text(title);
}
Dialog.prototype.GetTitle = function() {
	return this.$.find('.modal-title').text();
}
Dialog.prototype.SetText = function(text) { // override
	// Fix: `html` instead of `text` to allow markup.
	this.$.find('.modal-body').html(text);
}
Dialog.prototype.GetText = function() { // override
	return this.$.find('.modal-body').text();
}

// Operations
Dialog.prototype.Show = function() { // override
	this.$.modal('show');
}
Dialog.prototype.Hide = function() { // override
	this.$.modal('hide');
}

// Events
Dialog.prototype.OnShow = function(callback) {
	this.OnEvent('show.bs.modal', callback);
}
Dialog.prototype.OnShowOnce = function(callback) {
	this.OnEventOnce('show.bs.modal', callback);
}
Dialog.prototype.OnShown = function(callback) {
	this.OnEvent('shown.bs.modal', callback);
}
Dialog.prototype.OnShownOnce = function(callback) {
	this.OnEventOnce('shown.bs.modal', callback);
}
Dialog.prototype.OnHide = function(callback) {
	this.OnEvent('hide.bs.modal', callback);
}
Dialog.prototype.OnHideOnce = function(callback) {
	this.OnEventOnce('hide.bs.modal', callback);
}
Dialog.prototype.OnHidden = function(callback) {
	this.OnEvent('hidden.bs.modal', callback);
}
Dialog.prototype.OnHiddenOnce = function(callback) {
	this.OnEventOnce('hidden.bs.modal', callback);
}

//----------------------------------------------------------------------------
//  SuccessDialog < Dialog < Element
//----------------------------------------------------------------------------

function SuccessDialog(jq)
{
	Dialog.call(this, jq);

	//#region Private Variables
	var me = this;
	var mOKButton$ = this.$.find('.modal-footer > button');
	//#endregion Private Variables

	//#region Private Methods
	function onShown() {
		mOKButton$.focus(); // UX
	}
	//#endregion Private Methods

	//#region Public Methods
	this.Show = function(message) { // override
		me.SetText(message);
		Dialog.prototype.Show.call(this); // call base method
	}
	//#endregion Public Methods

	this.OnShown(onShown);
}

Element.Inherit(SuccessDialog, Dialog);

//#region Static Methods
SuccessDialog.New = function() {
	var jq =  $('#SuccessDialog');
	if (jq.length === 0)
		return null;
	return new SuccessDialog(jq);
}
//#endregion Static Methods

//----------------------------------------------------------------------------
//  ErrorDialog < Dialog < Element
//----------------------------------------------------------------------------

function ErrorDialog(jq)
{
	Dialog.call(this, jq);

	//#region Private Variables
	var me = this;
	var mOKButton$ = this.$.find('.modal-footer > button');
	//#endregion Private Variables

	//#region Private Methods
	function onShown() {
		mOKButton$.focus(); // UX
	}
	//#endregion Private Methods

	//#region Public Methods
	this.Show = function(message) { // override
		me.SetText(message);
		Dialog.prototype.Show.call(this); // call base method
	}
	//#endregion Public Methods

	this.OnShown(onShown);
}

Element.Inherit(ErrorDialog, Dialog);

//#region Static Methods
ErrorDialog.New = function() {
	var jq =  $('#ErrorDialog');
	if (jq.length === 0)
		return null;
	return new ErrorDialog(jq);
}
//#endregion Static Methods

//----------------------------------------------------------------------------
//  ProgressDialog < Dialog < Element
//----------------------------------------------------------------------------

function ProgressDialog()
{
	Dialog.call(this, '#ProgressDialog');

	var mBar = this.$.find('.progress-bar');

	this.SetPercentage = function(percentage) {
		mBar.css('width', percentage + '%');
	}
}

Element.Inherit(ProgressDialog, Dialog);

//----------------------------------------------------------------------------
//  WaitDialog < Dialog < Element
//----------------------------------------------------------------------------

function WaitDialog()
{
	Dialog.call(this, '#WaitDialog');
}

Element.Inherit(WaitDialog, Dialog);

//----------------------------------------------------------------------------
//  DeleteDialog < Dialog < Element
//----------------------------------------------------------------------------

function DeleteDialog()
{
	Dialog.call(this, '#DeleteDialog');

	var mConfirmButton = new Button('#DeleteDialog_ConfirmButton');

	this.Show = function(onConfirm) { // override
		// When the dialog is shown, register user defined callback function
		// to click event of `mConfirmButton`.
		mConfirmButton.OnClick(onConfirm);
		// Also, when the dialog is hidden, unregister the callback function.
		// Note that, `OnHidden` could be used at class level however
		// `onConfirm` is only available to the function scope. So, `OnHiddenOnce`
		// is used instead not to register duplicated handlers to the
		// 'hidden.bs.modal' event.
		this.OnHiddenOnce(function() { mConfirmButton.OffClick(onConfirm); });
		Dialog.prototype.Show.call(this); // call base method
	}
}

Element.Inherit(DeleteDialog, Dialog);

//----------------------------------------------------------------------------
//  Model
//----------------------------------------------------------------------------

function Model()
{
}

// Static Methods
Model.ActionURL = function(actionName, queryParameters) {
	var url = 'action.php?action=' + actionName;
	if (queryParameters) {
 		// If `queryParameters` is not a string (e.g. a plain object), serialize
		// using jQuery.param()
		if (!Helper.IsString(queryParameters))
			queryParameters = $.param(queryParameters);
		url += '&' + queryParameters;
	}
	return url;
}
Model.SuccessHandler = function(json, onSuccess) {
	// If the `Content-Type` response header is `application/json`, then `json`
	// arrives here automatically constructed to a javascript object. Otherwise
	// if the `Content-Type` is `text/html` or else, `json` is a plain text
	// which we manually parse to instantiate a javascript object.
	if (!$.isPlainObject(json))
		try {
			json = $.parseJSON(json);
		} catch (ex) {
			gController.ShowError(ex.name + ': ' + ex.message);
			return;
		}
	if (json.hasOwnProperty('error'))
		gController.ShowError(json.error.message);
	else if ($.isFunction(onSuccess)) {
		if (json.hasOwnProperty('data'))
			onSuccess(json.data);
		else
			onSuccess(json);
	}
}
Model.ErrorHandler = function(errorThrown) {
	gController.ShowError(errorThrown); // todo: `errorThrown` may be an empty string.
}
Model.CompleteHandler = function(onComplete) {
	if ($.isFunction(onComplete))
		onComplete();
}

// Operations
Model.prototype.Get = function(url, onSuccess, onComplete) {
	$.ajax({
		method: 'GET',
		url: url,
		success: function(json, textStatus, jqXHR) { Model.SuccessHandler(json, onSuccess); },
		error: function(jqXHR, textStatus, errorThrown) { Model.ErrorHandler(errorThrown); },
		complete: function(jqXHR, textStatus) { Model.CompleteHandler(onComplete); }
	});
}
Model.prototype.Post = function(url, data, onSuccess, onComplete) {
	$.ajax({
		method: 'POST',
		url: url,
		data: data,
		success: function(json, textStatus, jqXHR) { Model.SuccessHandler(json, onSuccess); },
		error: function(jqXHR, textStatus, errorThrown) { Model.ErrorHandler(errorThrown); },
		complete: function(jqXHR, textStatus) { Model.CompleteHandler(onComplete); }
	});
}

//----------------------------------------------------------------------------
//  Controller
//
//  Remarks
//    If a message dialog is not rendered, falls back to the `alert` function.
//----------------------------------------------------------------------------

function Controller()
{
	//#region Public Variables
	this.successDialog = SuccessDialog.New();
	this.errorDialog = ErrorDialog.New();
	//#endregion Public Variables
}

// Operations
Controller.prototype.ShowSuccess = function(message) {
	if (this.successDialog !== null)
		this.successDialog.Show(message);
	else
		alert(Helper.ReplaceAll(message, '<br>', '\n'));
}
Controller.prototype.ShowError = function(message) {
	if (this.errorDialog !== null)
		this.errorDialog.Show(message);
	else
		alert(Helper.ReplaceAll(message, '<br>', '\n'));
}

//----------------------------------------------------------------------------
//  Helper
//
//  todo: As of jQuery 3.3, jQuery.isFunction() has been deprecated, implement
//  an `IsFunction` (see https://jsperf.com/alternative-isfunction-implementations).
//----------------------------------------------------------------------------

var Helper =
{
	IsString: function(x) {
		return typeof x === 'string';
	},
	ReplaceAll: function(s, a, b) {
		return s.replace(new RegExp(a, 'g'), b);
	},
	FormatString: function(format) {
		// Taken from: http://www.harryonline.net/scripts/sprintf-javascript/385
		for (var i = 1, ii = arguments.length; i < ii; ++i)
			format = format.replace(/%s/, arguments[i]);
		return format;
	},
	FormatMoney: function(amount, locale, precision) {
		return amount.toLocaleString(locale, {
			minimumFractionDigits: precision,
			maximumFractionDigits: precision
		});
	},
	ConvertToInteger: function(x) {
		var y = parseInt(x, 10);
		if (isNaN(y))
			return 0;
		return y;
	},
	ConvertToDecimal: function(x) {
		var y = parseFloat(x);
		if (isNaN(y))
			return 0.0;
		return y;
	},
	RandomInteger: function(min, max) { // [min, max)
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min)) + min;
	},
	RandomIntegerInclusive: function(min, max) { // [min, max]
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min + 1)) + min;
	},
	RandomDecimal: function(min, max) { // [min, max)
		return Math.random() * (max - min) + min;
	},
	RandomString: function(length/*=32*/) {
		length = length || 32;
		var s = '';
		while (s.length < length)
			s += Math.random().toString(36).substr(2);
		return s.substr(0, length);
	},
	PadWithZeros: function (x, w) {
		var y = String(x);
		while (y.length < w)
			y = '0' + y;
		return y;
	},
	MergeObjects: function(lhs, rhs) {
		// Short-circuit if no custom settings are specified.
		if (!$.isPlainObject(rhs))
			return lhs;
		var result = {};
		// Deep-copy default settings.
		for (var key in lhs)
			result[key] = lhs[key];
		// Override/add custom settings.
		for (var key in rhs)
			result[key] = rhs[key];
		return result;
	},
	// This method returns the value of a specified URL parameter from a
	// query string, e.g. if the URL is `...?id=5` then calling
	// Helper.GetURLParameter('id') will return `5`.
	GetURLParameter: function(name) {
		// The `search` property contains the query string portion of the
		// current url. For example, http://example.org/?page=1&mode=b#foo
		// would return the query string ?page=1&mode=b.
		var parameters = window.location.search.substring(1).split('&');
		for (var i = 0, ii = parameters.length; i < ii; ++i) {
			var parameter = parameters[i].split('=');
			if (parameter[0] === name)
				// Fix: `parameter` may be an encoded uri component, such as
				// `page.php%3Fid%3D42` which must be decoded, such as to
				// `page.php?id=42`.
				return decodeURIComponent(parameter[1]);
		}
		return null;
	},
	GetMetaContent: function(name) {
		var metas = document.getElementsByTagName('META');
		for (var i = 0, ii = metas.length; i < ii; ++i) {
			var meta = metas[i];
			if (meta.name === name)
				return meta.content;
		}
		return null;
	},
	// Implementation of PHP's `htmlspecialchars_decode`.
	DecodeHtmlEntities: function(s) {
		return s.replace(/&amp;/g, '&')
		        .replace(/&quot;/g, '"')
		        .replace(/&apos;/g, "'").replace(/&#039;/g, "'")
		        .replace(/&lt;/g, '<')
		        .replace(/&gt;/g, '>');
	}
}
