import Vue from 'vue'

Vue.filter('rupiah', function (value) {
	if (value) {
		var rupiah = ''
		var rupiahReverse = value.toString().split('').reverse().join('');
		for(var i = 0; i < rupiahReverse.length; i++) {
			if(i % 3 == 0) {
				rupiah += rupiahReverse.substr(i,3) + '.'
			}
		}
		return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('')
	} else {
		return 'Rp. ' + 0;
	}
	
	// return number_format($number, 0, ',', '.');
	// return value == null ? 0 : `Rp. ${value}`
})

Vue.filter('rupiahDash', function (value) {
	if (value) {
		var rupiah = ''
		var rupiahReverse = value.toString().split('').reverse().join('');
		for(var i = 0; i < rupiahReverse.length; i++) {
			if(i % 3 == 0) {
				rupiah += rupiahReverse.substr(i,3) + '.'
			}
		}
		return rupiah.split('', rupiah.length - 1).reverse().join('')
	} else {
		return 0;
	}
})

Vue.filter('tanggal', function(value) {
	if (value) {
		var month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
		var date = value.split('-')
		if (date.length == 3) { // jika tanggal lengkap, misal 2017-05-25
			return date[2] + ' ' + month[date[1] - 1] + ' ' + date[0]
		} else {
			return month[date[1] - 1] + ' ' + date[0]
		}
	} else {
		return '-'
	}
})

Vue.filter('toFixed', function(value) {
	return value == 0 ? 0 : parseFloat(value).toFixed(2)
})

Vue.filter('thousandSuffix', function (value) {
	var SI_POSTFIXES = ["", "k", "M", "G", "T", "P", "E"];

    // what tier? (determines SI prefix)
    var tier = Math.log10(Math.abs(value)) / 3 | 0;

    // if zero, we don't need a prefix
    if(tier == 0) return value;

    // get postfix and determine scale
    var postfix = SI_POSTFIXES[tier];
    var scale = Math.pow(10, tier * 3);

    // scale the value
    var scaled = value / scale;

    // format value and add postfix as suffix
    var formatted = scaled.toFixed(1) + '';
    
    // remove '.0' case
    if (/\.0$/.test(formatted))
    	formatted = formatted.substr(0, formatted.length - 2);
    
    return formatted + postfix;
})

Vue.filter('isEmpty', function(value) {
	return value == '' || value == null ? '-' : value
})
