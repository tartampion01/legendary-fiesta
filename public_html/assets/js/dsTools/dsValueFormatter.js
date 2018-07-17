function dsValueFormatter(value){
	this.value = value;
	this.isInvalid = false;

	this.clone = function(){
		return new dsValueFormatter(this.value);
	}

	this.isNumeric = function(){
		return !isNaN(parseFloat(this.value)) && isFinite(this.value);
	}

	// Arrondi proprement une valeur numérique
	// Voir problèmes avec math.round et .toFixed
	this.round = function (decimals) {
		value = parseFloat(this.value);
		if ( isNaN(value) ) {this.value = Number.NaN; return this;}

		if ( decimals == undefined ) decimals = 2;
		this.value = Number(Math.round(value+'e'+decimals)+'e-'+decimals);
		return this;
	}

	this.toBool = function(){
		if (this.value == true || this.value == "true" || this.value == 1 || this.value == "1"){
			this.value = true;
		} else{
			this.value = false;
		}
		return this;
	}

	this.toFloat = function(){
		if (this.value == undefined) return this;

		value = this.value;
		value = value.replace("$", "");
		value = value.replace("%", "");
		value = value.replace(" ", "");
		value = value.replace(",", ".");
		this.value = parseFloat(value);
		if (isNaN(this.value)) {
			this.isInvalid = true;
			this.value = 0;
		}
		return this;
	}

	this.fromMoney = function(){
		return this.toFloat();
	}
	this.toMoney = function(){
		if (!this.isNumeric(this.value)){
			this.value = "";
		}else{
			this.toNumberFormat(2, ",", " ");
			this.value += "$";
		}
		return this;
	}

	this.fromDate = function(){
		var d = this.value; // js date object
		function pad(n){return n<10 ? '0'+n : n}
		this.value = d.getFullYear()+'-'
					+ pad(d.getMonth()+1)+'-'
					+ pad(d.getDate()) +' '
					+ pad(d.getHours())+':'
					+ pad(d.getMinutes())+':'
					+ pad(d.getSeconds());
		return this;
	}

	this.toPercent = function(decimals){
		if (!this.isNumeric(this.value)){
			this.value = "";
		}else{
			if (decimals == undefined) decimals = 2;
			this.toNumberFormat(decimals, ",", " ");
			this.value += "%";
		}
		return this;
	}

	this.toPhone = function(){
		this.value = this.value.replace(/(\d{3})(\d{3})(\d{4})/, "($1)$2-$3");
		return this;
	}

	this.numberPad = function(minDigits){
		var s = this.value + ""; // Force as string
		while (s.length < minDigits) s = "0" + s;
		this.value = s;
		return this;
	}

	this.toNumberFormat = function(decimals, dec_point, thousands_sep) {
			var number = this.value;
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
			this.value = s.join(dec);
			return this;
		}



	return this;
}

