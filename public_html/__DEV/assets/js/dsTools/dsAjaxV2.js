var dsAjaxV2 = {
	ajaxing: false,

	init: function(){
		dsAjaxV2.resetDefaults();
	},
	resetDefaults: function(){
		dsAjaxV2.url = window.location.href,
		dsAjaxV2.async = true,
		dsAjaxV2.headers = {
			"DS-AJAX-VERSION":"2"
		}
	},

	send: function(params, ACKFunc, ERRFunc){

	dsAjaxV2._showDelayedWaitCursor(1000);

	// tell everyone we're ajaxing (want to disable controls or something ?)
	dsAjaxV2.ajaxing = true;
	$(document).trigger("evtAjaxing", ["before"]);

	// Are we debugging ?
	if ( getQueryStringParts(window.location.href, "debug") !== null) parts['debug'] = true;
	if ( getQueryStringParts(window.location.href, "debugSQL") !== null) parts['debugSQL'] = true;

	//@@todo next version: change dsajaxV2 defaults to params properties like this
	if (params.url == undefined) params.url = dsAjaxV2.url;

	// go!
	$.ajax({
		url: params.url,
		type: "POST",
		async: dsAjaxV2.async,
		headers: dsAjaxV2.headers,
		data:params,
		success: function(data) {
			if (ACKFunc === undefined | ACKFunc === null){
				// replace the content of dsAjax div
				// might have other stuff output by php... like errors...
				$("#ajax").html(data);
				dsAjaxV2.readCommands();
				// load the commands in old format
				communicatorReadCommands();
			}
			else {
				ACKFunc(data);
			}
			$("body").removeClass("wait");
		},
		error: function (err) {
			if (ERRFunc === undefined | ERRFunc === null){
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert("Erreur! Impossible de communiquer avec le serveur.");
			}else{
				// Got some error handling? Like saving locally.
				ERRFunc(params);
			}
			$("body").removeClass("wait");

		},
		complete: function(){
			// tell everyone we're done ajaxing
			$(document).trigger("evtAjaxing", ["after"]);
			dsAjaxV2._showDelayedWaitCursor(0);
			dsAjaxV2.ajaxing = false;
			dsAjaxV2.resetDefaults();
		}
	});

	},

	commands:{
		setHTML:function (cmdData){
			var myHTML = cmdData.data;
			//document.getElementById(cmdData.tagID).innerHTML = myHTML;  does not include scripts... :(

			// backward compatibility with tagID
			if (cmdData.tagID !== undefined) {
				$("#" + cmdData.tagID).html(myHTML);
			}
			{
				$(cmdData.jSelector).html(myHTML);
			}

		},

		replaceHTML: function(cmdData){
			var myHTML = cmdData.data;
			$(cmdData.jSelector).replaceWith(myHTML);
		},

		appendHTML: function(cmdData){
			var myHTML = cmdData.data;
			$( "#" + cmdData.tagID ).append(myHTML);
		},

		scrollHere: function(cmdData){
			scrollHere(cmdData);
		},

		setFieldValue: function(cmdData){
			var el = getElementFromAddressString(cmdData.address);
			if (el == undefined) console.warn("Impossible d'appliquer une valeur à " + cmdData.address + "");
			$(el).val(cmdData.value);
		},

		CSSAddClass: function(cmdData){
			$(cmdData.jSelector).addClass(cmdData.class);
		},

		CSSRemoveClass: function(cmdData){
			$(cmdData.jSelector).removeClass(cmdData.class);
		},

		/*
		 ajoute la classe isInvalid au champ spécifié
		 paramètres:
		 address: adresse sous forme de string
		 */
		setFieldAsInvalid: function(cmdData){
			var el = getElementFromAddressString(cmdData.address);
			if (el == undefined) console.warn("Impossible de marquer " + cmdData.address + "comme invalide");
			$(el).addClass("isInvalid");
		},

		clearInvalidFieldClass:function(cmdData){
			$(".isInvalid").removeClass("isInvalid");
		},

		downloadFile: function(cmdData){
			window.open(cmdData.URL);
		},

		openFileInNewWindow: function(cmdData){
			window.open(cmdData.URL, '_blank');
		},

		retVal: function(cmdData){
			return cmdData;
		},

		alert: function(cmdData){
			alert(cmdData);
		},

		redirect: function(cmdData){
			window.location.href = cmdData;
		},

		reload: function(){
			window.location.reload();
		},

		clearisInvalidClass: function (cmdData) {
			$(".input").removeClass("isInvalid");
		},

		setModuleValue: function(cmdData){
			window[cmdData.moduleName][cmdData.propertyName] = cmdData.value;
		},
		callModuleFunction: function(cmdData){
			var mod = window[cmdData.moduleName];
			mod[cmdData.functionName].apply(mod, cmdData.args);
		}

	},

	/* Load les commandes du tag <script> */
	readCommands: function(){
		$("#ajax script.dsAjaxV2").each(function(){
			var myJSON = this.textContent; // keep only the wanted received content
			dsAjaxV2._decodeMultipleAnswers(myJSON);
			$(this).remove();
		});
	},
	_decodeMultipleAnswers: function(data){

		var myData;
		try{
			myData = JSON.parse(data);
		}
		catch(e){
			//alert(data);

			// try to decode anyway
			n = data.lastIndexOf("]\r\n");
			jsonData = data.substring(0, n+1);
			errormsg = data.substring(n+1);
			var JSONrepaired = false;

			try{
				myData = JSON.parse(jsonData);
				var w = window.open();
				var od = dumpObjectIndented(myData);
				var humanReadableMyData = od;
				$(w.document.body).html(humanReadableMyData + "<pre>" + errormsg + "</pre>");
				JSONrepaired = true;
			}
			catch(e){
				// Really undecodable
				var w = window.open();
				$(w.document.body).html("Error:"+e+ "\r\n" + data);
			}

			// @@ use console for production mode...
			if (JSONrepaired === undefined) return;
		}

		var cmdData;
		var cmdIx;
		// Loop les différentes commandes
		for (cmdIx = 0; cmdIx < myData.length; ++cmdIx){
			// trouve la commande et agit
			for (var cmd in myData[cmdIx]) {
				if (dsAjaxV2.commands[cmd] !== undefined) {
					dsAjaxV2.commands[cmd](myData[cmdIx][cmd]);
				}
			}
		}
	},

	showWaitAnimation: function(){
		dsAjaxV2._showDelayedWaitCursor(1);
	},
	_showDelayedWaitCursor: function(delayOrZeroForCancel){
		if (delayOrZeroForCancel == 0){
			if (dsAjaxV2._showDelayedWaitCursor.myTimeout !== undefined){
				clearTimeout(dsAjaxV2._showDelayedWaitCursor.myTimeout);
				$("body").removeClass("wait");
			}
		}
		else{
			if (dsAjaxV2._showDelayedWaitCursor.myTimeout !== undefined) return; // Already timing out
			dsAjaxV2._showDelayedWaitCursor.myTimeout = setTimeout(function(){
				$("body").addClass("wait");
				delete dsAjaxV2._showDelayedWaitCursor.myTimeout;
			}, delayOrZeroForCancel);
		}
	},

	serializeControl: function(el){
		// Sérialise le contrôle //

		// Cherche un serializer approprié
		controlSerializer = $(el).data("serializer");
		if (controlSerializer == undefined) controlSerializer = "default";

		// sérialise
		var out = dsAjaxV2.serializers[controlSerializer](el);
		out.name = $(el).attr("name");
		return out;
	},

	/* Sérialiseurs d'éléments
	 * Ajoutez votre sérialiseur custom ici! */
	serializers:{
		default: function(el){

			var tagName = el.tagName.toLowerCase();
			var theValue = el.value;

			switch(tagName){
				case "div":
				case "label":
				case "span":
					theValue = el.textContent;
					break;
				case "a":
					theValue = el.getAttribute("href");
					break;
			}

			return {
				type: "input",
				value: theValue
			};
		},
		checkbox: function(el){
			return {
				type: "checkbox",
				value: (el.checked) ? 1: 0
			};
		},
		checkboxlist: function(el){
			var values = [];
			$("input", el).each(function(){
				if (this.checked) values.push($(this).attr("name"));
			});
			return {
				type: "checkboxlist",
				value: values
			};
		}
	},

	/*
	 * Sérialisation de la page, ses modules et ses champs
	 */
	getSerializablesAsJSON: function(relativeToThisElement, userOptions){
		var out = {
			children: {},
			firstChild: undefined
		};
		var parents = [], parent, parentName, child, elName, elementAddress;
		var i;

	// options
		options = {serializeAttributes: false};

		// merge les options fournies avec les options par défaut
		if (userOptions !== undefined){
			jQuery.extend(options, userOptions);
		}

	// Trouve le premier parent
		if (relativeToThisElement == undefined) {
			el = $(document).find(".serializable:first");  // Trouve le plus parent
		}
		else {
			el = $(relativeToThisElement).closest(".serializable"); // Trouve le parent immédiat de l'appelant (pour les boutons dans un module)
		}

	// attribute serialization
		var attrSerialize = function(el){
			var out = {};
			for (var att, i = 0, atts = el.attributes, n = atts.length; i < n; i++) {
				att = atts[i];
				out[att.nodeName] = att.nodeValue;
			}
			return out;
		}

	// get the input fields
		var elParent = el.parent(".serializable");
		var controlSerializer = undefined;
		var serializedControl = {};

		$(el).find(".input").each(function(){
			elementAddress = [];

			parents = $(this).parentsUntil(elParent, ".serializable");
			parent = out;

			for (i = parents.length - 1; i >= 0; i--) {
				parentName = parents[i].getAttribute("name");
				elementAddress.push(parentName);

				child = {
					type: "container",
					name: parentName,
					children: {},
					fields: {}
				};
				if (options.serializeAttributes) child.attributes = attrSerialize(parents[i]);

				if (parent.children[parentName] == undefined) parent.children[parentName] = child;

				parent = parent.children[parentName];
				if (out.firstChild == undefined) out.firstChild = parentName;

			}

			// sérialise
			serializedControl = dsAjaxV2.serializeControl(this);

			// ajoute le nom du contrôle à son adresse
			elementAddress.push(this.getAttribute("name"));
			serializedControl.address = elementAddress;

			// Sérialise les attributs si demandé
			if (options.serializeAttributes) serializedControl.attributes = attrSerialize(this);

			parent.fields[serializedControl.name] = serializedControl;

		});

		// le node racine sera le premier parent et non un node vide.
		return JSON.stringify(out.children[out.firstChild]);
	},
	eventCommitContainer: function(event, eventName){
		this.event(event.target, eventName, "", {serializeMode:"container"});
	},
	eventCommitContainerWattributes: function(event, eventName){
		this.event(event.target, eventName, "", {serializeMode:"containerWattributes"});
	},
	eventTiny: function(event, optionalPayloadDefaultIsElementValue, optionalSerializeMode){
		var payload = optionalPayloadDefaultIsElementValue;

		// sérialise
		serializedControl = dsAjaxV2.serializeControl(event.target);

		if (payload == undefined) payload = serializedControl.value;

		eventName = serializedControl.name + "_" + event.type;

		paramObj = {};
		if (optionalSerializeMode !== undefined) paramObj.serializeMode = optionalSerializeMode;
		dsAjaxV2.event(event.target, eventName, payload, paramObj);
	},
	event: function (element, eventName, payload, paramObj){
		if ( typeof paramObj === "string" ) paramObj = JSON.parse(paramObj);

		var	callParams = {
			destinationAddress: undefined,
			ACKFunc: undefined,
			ERRFunc: undefined,
			serializeMode: "none"
		};

		// Merge with caller supplied params
		if ( paramObj != undefined ) jQuery.extend(callParams, paramObj);

		// find the element
		var elAddress = dsAjaxV2.getElementAddress(element);

		// Convert destination address

		if ( callParams.destinationAddress == undefined ) {
			// utilise l'adresse de l'élément mais vu que les événements sont
			// gérés par le container, on enlève le nom de l'élément
			var trimmedAddress = elAddress.slice(0, elAddress.length - 1);
			callParams.destinationAddress = trimmedAddress;
		}else{
			if (!Array.isArray(callParams.destinationAddress)) {
				callParams.destinationAddress = callParams.destinationAddress.split(".");
			}
		}

		// Get the formsData
		switch (callParams.serializeMode){
			case "all":
				formsData = dsAjaxV2.getSerializablesAsJSON();
				break;
			case "container":
				formsData = dsAjaxV2.getSerializablesAsJSON(element);
				break;
			case "containerWattributes":
				formsData = dsAjaxV2.getSerializablesAsJSON(element, {serializeAttributes:true});
				break;
			case "none":
				formsData = {};
				break;
		}

		params = {
			event:{
				version: 1,
				element:{	name:element.name,
							address:elAddress
						},
				destinationAddress: callParams.destinationAddress,
				eventName: eventName,
				formsData: formsData,
				payload: payload
			}
		}

		dsAjaxV2.send(params, callParams.ACKFunc, callParams.ERRFunc);
	},



	/*
		---------------------------------------- TOOLS ----------------------------------------
	 */

	getElementAddress: function(element){
		var out = [];
		var name = "";
		var el = element;
		while(el.parentElement){
			el = el.parentElement;
			name = el.getAttribute("name");
			if ( name !== null ) out.unshift(name);
		}
		out.push(element.getAttribute("name"));
		return out;
	},

	getElementFromAddress: function(addressAsArray){
		var stAddress = addressAsArray;

		var arrayLength = stAddress.length;
		var query = "";
		for (var i = 0; i < arrayLength; i++) {
			query = query + " [name=" + stAddress[i] + "]";
		}

		var address = addressAsArray.join(".");
		var results = $(query);
		arrayLength = results.length;
		for (i = 0; i < arrayLength; i++){
			if ( dsAjaxV2.getElementAddressAsString(results[i]) == address ) return results[i];
		}
	},

	getElementAddressAsString: function(element){
		return dsAjaxV2.getElementAddress(element).join(".");
	},

	getElementFromAddressString: function(address){
		var stAddress = address.split(".");

		var arrayLength = stAddress.length;
		var query = "";
		for (var i = 0; i < arrayLength; i++) {
			query = query + " [name=" + stAddress[i] + "]";
		}

		var results = $(query);
		arrayLength = results.length;
		for (i = 0; i < arrayLength; i++){
			if ( dsAjaxV2.getElementAddressAsString(results[i]) == address ) return results[i];
		}
	},

	getQueryStringParts: function(specificUrl, specificParam){

		if (specificUrl == undefined) specificUrl = window.location.href;

		var vars = {}, hash;
		var hashes = specificUrl.slice(specificUrl.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			//vars.push(hash[0]);
			vars[hash[0]] = hash[1];

			if (specificParam !== undefined && specificParam == hash[0] ){
				return hash[1];
			}

		}

		if (specificParam !== undefined ) return null;

		return vars;
	}



};


$(document).ready(function(){

	// initialise le communicateur
	dsAjaxV2.init();

	// A-t-on des messages de cachés dans le code HTML ?
	// truc: ajouter un document ready dans document ready de sorte que
	// la fonction est ajoutée à la readyList seulement quand tous les autres
	// readys ont été ajoutés, donc obligatoirement a la fin.
	// cela permet d'être certain que tous les objets / modules /pages sont initialisés
	// avant de les appeler.
	$(document).ready(function(){
		$('#ajax script.dsAjaxV2').each(function(){
			msg = this.textContent;
			dsAjaxV2._decodeMultipleAnswers(msg);
		});
	});
});



/**
 *
 */


/* OBSOLETE !!! confirmation pour delete, save, whatever */
function confirmation(message, urlOrFunc){
	ret = confirm(message);
	if ( ret == true ){
		if (typeof urlOrFunc === 'function') {
			urlOrFunc();
		}
		else{
			window.location.href = urlOrFunc;
		}
	}
}






