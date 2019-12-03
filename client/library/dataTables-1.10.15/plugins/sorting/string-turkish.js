jQuery.extend(jQuery.fn.dataTableExt.oSort, {
	"string-turkish-pre": function(a) {
		if (!a)
			return a;
		var magic = {
			"C": "Ca", "c": "ca", "Ç": "Cb", "ç": "cb",
			"G": "Ga", "g": "ga", "Ğ": "Gb", "ğ": "gb",
			"I": "Ia", "ı": "ia", "İ": "Ib", "i": "ib",
			"O": "Oa", "o": "oa", "Ö": "Ob", "ö": "ob",
			"S": "Sa", "s": "sa", "Ş": "Sb", "ş": "sb",
			"U": "Ua", "u": "ua", "Ü": "Ub", "ü": "ub"
			};
		for (var val in magic)
		   a = a.split(val).join(magic[val]).toLowerCase();
		return a;
	}
});
