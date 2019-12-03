jQuery.extend(jQuery.fn.dataTableExt.oSort, {
	"datetime-turkish-pre": function(a) {
		if (!a)
			return 0;
		a = a.split(' '); // e.g. '14.08.2017 14:00:00'
		var d = a[0].split('.');
		var t = a[1].split(':');
		return (d[2] + d[1] + d[0] + t[0] + t[1] + t[2]) * 1;
	}
});
