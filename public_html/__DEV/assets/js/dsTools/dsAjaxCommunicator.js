/**
 * @ obsolete, use dsAjaxV2
 */

	var ajaxRequests = [];
 	var ajaxSequentialRequests = false;
	var ajaxing = false;
	
	function ajaxExecuteSequentialRequests(finalFunc){
		
		ajaxSequentialRequests = false;
		nextRequest = ajaxRequests.shift();
		
		if (nextRequest !== undefined){
			
			ACKFunc = function(data){
				if (nextRequest.ACKFunc instanceof Function) nextRequest.ACKFunc(data);
				ajaxExecuteSequentialRequests(finalFunc);
			}
		
			ajaxRequest(nextRequest.params, ACKFunc, nextRequest.async);
		}
		else{
			if (finalFunc instanceof Function) finalFunc();
		}

	}
		
	function ajaxRequest(url, params, ACKFunc, async){
		
		showDelayedWaitCursor(1000);
		
		// Gestion des requêtes séquentielles
		if (ajaxSequentialRequests == true){
			var zReq = {params: params,
					ACKFunc: ACKFunc,
					async: async
					};
			ajaxRequests.push(zReq);
			return;
		}
		
		// Keep the sessionID to ourselves
		// @@ update: sessionID can be passed as POST instead of COOKIE :)
		//sessionID = sessionStorage.getItem("sessionID");
		//Cookies.set('sessionID', sessionID);
				
		// tell everyone we're ajaxing (want to disable controls or something ?)
		 ajaxing = true;
		 $(document).trigger("evtAjaxing", ["before"]);

	// default url
		 if ( url == null ) url = window.location.href;
		 
	// append ajax to url
		var parts = getQueryStringParts(url);
		parts['ajax'] = "true";
		
		// Are we debugging ?
		if ( getQueryStringParts(window.location.href, "debug") !== null) parts['debug'] = true;
		if ( getQueryStringParts(window.location.href, "debugSQL") !== null) parts['debugSQL'] = true;

		url = url.split("?")[0] + "?" + $.param(parts);
		
	// go!
		if (async === undefined) {async = true;}
		$.ajax({
			url:url,
			type:"POST",
			async: async,
			data:params,
			success: function(data) {
				if (ACKFunc === undefined | ACKFunc === null){
					// replace the content of dsAjax div
					// might have other stuff output by php... like errors...
					$("#ajax").html(data);
					communicatorReadCommands();
					if (dsAjaxV2) dsAjaxV2.readCommands();
				}
				else {
					ACKFunc(data);
				}
				$("body").removeClass("wait");
			},
			error: function (err) {
		        console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
		        $("body").removeClass("wait");
			},
			complete: function(){
				// tell everyone we're done ajaxing
				 $(document).trigger("evtAjaxing", ["after"]);
				 showDelayedWaitCursor(0);
				 ajaxing = false;
			}
		});
	
	}

	
	var decodeMultipleAnswersCommands = {
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
			if (el == undefined) console.warn("Impossible de marquer " + cmdData.address + "comme invalide");
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

	    login:function(cmdData){
	        window.location.href = "login.php";
	    },

	    redirect: function(cmdData){
	        window.location.href = cmdData;
	    },

		reload: function(){
			window.location.reload();
		},

	    clearisInvalidClass: function (cmdData) {
	        $(".input").removeClass("isInvalid");
	    }
	};

	/* read commands from the <script> tag */
	function communicatorReadCommands(){
		$("#ajax script.communicator").each(function(){
			var myJSON = this.textContent; // keep only the wanted received content
			decodeMultipleAnswers(myJSON);
			$(this).remove();
		});
	}

	function decodeMultipleAnswers(data){
	
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
		        if (decodeMultipleAnswersCommands[cmd] !== undefined) {
		            decodeMultipleAnswersCommands[cmd](myData[cmdIx][cmd]);
		        }
			}			
		}
		 
		// RE-MAP some stuff after the document changed
		
	
	}

/* OBSOLETE !!!!!!!!!!! ****/
	function postFormsAsJSON(postBackURL){
		
		var formsData = getFormAsJSON();
		
		var params = {
			formsData: formsData
		}
		
		ajaxRequest(postBackURL, params, null);		
	
	}
	
/* OBSOLETE !!!!!!!!!!! ****/
	function getFormAsJSON(){
		// Si on utilise TinyMCE, trigger un save.
		if (typeof tinyMCE !== 'undefined'){
			tinyMCE.triggerSave();
		}
		
		formsData = {};
		$("form").each(function(index, value){
			formsData[this.getAttribute("name")] = JSON.stringify($(this).serializeArray());
		});
		
		return formsData;
	}
	
	
	/*
	 * Sérialisation de la page, ses modules et ses champs
	 */
	function getSerializablesAsJSON(relativeToThisElement){
	    var out = {
	        children: {},
	        firstChild: undefined
	    };
		var parents = [], parent, parentName, child, elName, elementAddress;
		var i;
		
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
			        fields: {},
			        attributes: attrSerialize(parents[i])
			    };

				if (parent.children[parentName] == undefined)
				{
				    parent.children[parentName] = child;
				};

				parent = parent.children[parentName];
				if (out.firstChild == undefined) out.firstChild = parentName;

			}

			// Si c'est un checkbox, set la valeur à checked //
			if ($(this).is(":checkbox")){
				if (this.checked) {this.value = 1;} else {this.value = 0;};
			}

			// Sérialise le contrôle //
			var theValue = this.value;
			if ( this.tagName.toLowerCase() == "div" ) theValue = this.textContent;
			if ( this.tagName.toLowerCase() == "label" ) theValue = this.textContent;
			if ( this.tagName.toLowerCase() == "span" ) theValue = this.textContent;
			if ( this.tagName.toLowerCase() == "a" ) theValue = this.getAttribute("href");
			elName = this.getAttribute("name");
			elementAddress.push(elName);
			parent.fields[elName] = {
			                            type: "input",
                                        address: elementAddress,
                                        value: theValue,
                                        attributes: attrSerialize(this)
			                        };
			
		});

	    // le node racine sera le premier parent et non un node vide.

		return JSON.stringify(out.children[out.firstChild]);
	}


	function ajaxEventV2(element, eventName, payload, paramObj){
		if ( typeof paramObj === "string" ) paramObj = JSON.parse(paramObj);

		var	callParams = {
				postURL:window.location.href,
				eventDestinationAddress: undefined,
				ACKFunc: undefined,
				showWaitNow:false,
				serializeAll: false
			};

		// Merge with caller supplied params
		if ( paramObj != undefined ) jQuery.extend(callParams, paramObj);

		if ( callParams.showWaitNow == true ) showDelayedWaitCursor(1); // Gets closed when ajax is done

		var bogusChar = "?";
		if (callParams.postURL.search("\\?") >= 0) bogusChar = "&"; // Regex
		callParams.postURL = callParams.postURL + bogusChar + "action=event";  // @@ please get a real URL editor :(

		// find the element
		var elAddress = getElementAddress(element);

		// Convert destination address
		if ( callParams.eventDestinationAddress !== undefined ){
			callParams.eventDestinationAddress = callParams.eventDestinationAddress.split(".");
		}

		// Get the formsData
		switch (callParams.serializeAll){
			case true:
				formsData = getSerializablesAsJSON();
				break;
			case false:
				formsData = getSerializablesAsJSON(element);
				break;
			case "none":
				formsData = {};
				break;
		}

		params = {
			event:{	element:{	name:element.name,
								address:elAddress
							},
					eventDestinationAddress: callParams.eventDestinationAddress,
					eventName: eventName,
					formsData: formsData,
					payload: payload
			}
		}


		ajaxRequest(callParams.postURL, params, callParams.ACKFunc);
	}

	/* OBSOLETE */
	function ajaxEvent(postURL, element, eventName, payload, callbackFunc){
		if ( postURL == "" ) postURL = window.location.href;
		return ajaxEventV2(element, eventName, payload, {postURL:postURL, ACKFunc:callbackFunc});
	}
	
	function getElementAddress(element){
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
		
	}
	function getElementAddressAsString(element){
		return getElementAddress(element).join(".");
	}
	
	function getElementFromAddressString(address){
		var stAddress = address.split(".");

		var arrayLength = stAddress.length;
		var query = "";
		for (var i = 0; i < arrayLength; i++) {
			query = query + " [name=" + stAddress[i] + "]";
		}

		var results = $(query);
		arrayLength = results.length;
		for (i = 0; i < arrayLength; i++){
			if ( getElementAddressAsString(results[i]) == address ) return results[i];
		}
	}

	function showDelayedWaitCursor(delayOrZeroForCancel){
		if (delayOrZeroForCancel == 0){
			if (showDelayedWaitCursor.myTimeout !== undefined){
				clearTimeout(showDelayedWaitCursor.myTimeout);
				$("body").removeClass("wait");
			}
		}
		else{
			if (showDelayedWaitCursor.myTimeout !== undefined) return; // Already timing out
			showDelayedWaitCursor.myTimeout = setTimeout(function(){
				$("body").addClass("wait");
				delete showDelayedWaitCursor.myTimeout;
			}, delayOrZeroForCancel);			
		}
	}
	
	function getQueryStringParts(specificUrl, specificParam){
		
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
	

	/* confirmation pour delete, save, whatever */
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
	
	/* confirmation pour delete, save, whatever */
	function confirmationPOST(message, url){
		ret = confirm(message);
		if ( ret == true ){
			postFormsAsJSON(url);
		}
	}





$(document).ready(function(){
	// A-t-on des messages de cachés dans le code HTML ?
	$('script.communicator').each(function(){
		communicatorReadCommands();
	});
});