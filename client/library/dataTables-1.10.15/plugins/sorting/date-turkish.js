jQuery.extend(jQuery.fn.dataTableExt.oSort, {
	"date-turkish-pre": function(a) {
		if (!a)
			return 0;
		a = a.split('.'); // e.g. '14.08.2017'
		return (a[2] + a[1] + a[0]) * 1;
	}
});
