var dsSwissKnife = new function(){
	/************** slow queue / loop **************/
	/*
		Fournir une array, un délai
		callback: ix, arrayItem
	 */

	this.slowLoop = function(arrayToIterate, delay, callback){
		dsSwissKnife.slowLoop.ix = -1;

		dsSwissKnife.slowLoop.timer = setInterval(function(ix){
			dsSwissKnife.slowLoop.ix++;

			// Si on a fini notre boucle
			if (dsSwissKnife.slowLoop.ix == arrayToIterate.length){
				clearInterval(dsSwissKnife.slowLoop.timer);
				return;
			}

			// call
			callback(dsSwissKnife.slowLoop.ix, arrayToIterate[dsSwissKnife.slowLoop.ix]);

		}, delay);
	}

	/************** OBSOLETE NUBER FUNCTIONS SE DSVALUEFORMATTER ***************/
	this.isNumeric = function(n) {
		  return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	// Arrondi proprement une valeur numérique
	// Voir problèmes avec math.round et .toFixed
	this.round = function (value, decimals) {
		value = parseFloat(value);
		if ( isNaN(value) ) return Number.NaN;
		
		if ( decimals == undefined ) decimals = 2;
	    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
	};
	
	this.prettyPrint = function(formatName, value) {
		switch ( formatName ){
		case "money":
				if (!this.isNumeric(value)) return "";
				return this.number_format(value, 2, ",", " ") + "$";
			break;
		case "percent":
			if (!this.isNumeric(value)) return "";
			return this.number_format(value, 2, ",", " ") + "%";
			break;
		case "phone":
			return value.replace(/(\d{3})(\d{3})(\d{4})/, "($1)$2-$3");
			break;
		case "date":
			var d = value; // js date object
			function pad(n){return n<10 ? '0'+n : n}
				return d.getFullYear()+'-'
					+ pad(d.getMonth()+1)+'-'
					+ pad(d.getDate()) +' '
					+ pad(d.getHours())+':'
					+ pad(d.getMinutes())+':'
					+ pad(d.getSeconds());
				break;
		}
	};
	
	this.unPrettyPrint = function (formatName, value){
		if ( value == undefined ) value = "";
		switch ( formatName ){
		case "money":
			value = value.replace("$", "");
		case "percent":
		case "float":
			value = value.replace(" ", "");
			value = value.replace(",", ".");
			value = parseFloat(value);
			return value;
			break;
		}
	}
	
	this.number_pad = function(number, minDigits){
		var s = number+"";
		while (s.length < minDigits) s = "0" + s;
		return s;
	}

	this.number_format = function(number, decimals, dec_point, thousands_sep) {
		// phpjs.org
	    // *     example 1: number_format(1234.56);
	    // *     returns 1: '1,235'
	    // *     example 2: number_format(1234.56, 2, ',', ' ');
	    // *     returns 2: '1 234,56'
	    // *     example 3: number_format(1234.5678, 2, '.', '');
	    // *     returns 3: '1234.57'
	    // *     example 4: number_format(67, 2, ',', '.');
	    // *     returns 4: '67,00'
	    // *     example 5: number_format(1000);
	    // *     returns 5: '1,000'
	    // *     example 6: number_format(67.311, 2);
	    // *     returns 6: '67.31'
	    // *     example 7: number_format(1000.55, 1);
	    // *     returns 7: '1,000.6'
	    // *     example 8: number_format(67000, 5, ',', '.');
	    // *     returns 8: '67.000,00000'
	    // *     example 9: number_format(0.9, 0);
	    // *     returns 9: '1'
	    // *    example 10: number_format('1.20', 2);
	    // *    returns 10: '1.20'
	    // *    example 11: number_format('1.20', 4);
	    // *    returns 11: '1.2000'
	    // *    example 12: number_format('1.2000', 3);
	    // *    returns 12: '1.200'
	    var n = !isFinite(+number) ? 0 : +number, 
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        toFixedFix = function (n, prec) {
	            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	            var k = Math.pow(10, prec);
	            return Math.round(n * k) / k;
	        },
	        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
	    if (s[0].length > 3) {
	        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	        s[1] = s[1] || '';
	        s[1] += new Array(prec - s[1].length + 1).join('0');
	    }
	    return s.join(dec);
	}

}

/************************ DEFAULT BUTTON **************************/

$(document).keypress(function(event){
	var serializable;
	var defaultButton;

	if (event.keyCode != 13) return;

	// look at my parent module to find a default button
	// go higher till we find a default button
	var lookupRef = event.target;
	do{
		serializable = $(lookupRef).closest(".serializable"); // Trouve le parent immédiat de l'appelant (pour les boutons dans un module)
		if (serializable == undefined) break;
		defaultButton = $(".btn-default", serializable);
		if (defaultButton !== undefined) {
			defaultButton.click();
			break;
		}
		// seems like we'll look higher
		lookupRef = serializable;
	}while(serializable !== undefined);

  // If enter, call onclick of default button
});