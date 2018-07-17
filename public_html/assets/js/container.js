var Container = function(moduleName, obj){

    // Créé un objet qui hérite de moi
    // et copie les propriétés de l'objet fourni
    var o = Object.create(Container.prototype);
    for (var prop in obj){
        if (obj.hasOwnProperty(prop)) o[prop] = obj[prop];
    }

    o.instanceName = "";
    o.instanceElement = undefined;
    o.moduleName = moduleName;
    o.isDirty = false;
    o.init();

    $(document).ready(function(){
        o.documentReady();
        o.bindEvents();

        // Dirtyness detector
        $(document.body).on("change", "." + o.moduleName + " .input", null, function(){
            o.isDirty = true;
        });
    });

    $(window).on("unload",o, o.beforeUnload);

    return o;
}

Container.prototype = {
    init: function(){},
    documentReady: function(){ var a = 1;/* do stuff in child class */},
    events: {}, /* child class will store events in there */
    beforeUnload: function(event){
        // You may override me //
        var o = event.data;
        if (!o.isDirty) return;
        var myDiv = $("." + o.moduleName);
       // if (! myDiv.hasClass("base_page")) return;

        var ret = confirm("Attention, vous avez des données non sauvegardées. Désirez-vous quitter cette page?");
        if (!ret) return false;
    },

    bindEvents: function(){  // you should not override this or use it, it's internal/private stuff.
        var callback;
        for (var fieldName in this.events){
            for (var evtName in this.events[fieldName]){

                var fwdData = { container: this,
                                fieldName: fieldName,
                                evtName: evtName};

                $(document.body).on(evtName, "." + this.moduleName + " [name=" + fieldName + "]", fwdData, function(event){

                    // don't trigger for child module field with same name.
                    if ($(event.target).is("." + event.data.container.moduleName + " .base_module [name=" + event.data.fieldName + "]")){
                        return;
                    }

                    var cntnr = event.data.container;
                    cntnr.instanceElement = cntnr.getElementParentContainerElement(this);
                    cntnr.instanceName = cntnr.instanceElement.attr("name");
                    cntnr.events[event.data.fieldName][event.data.evtName].call(cntnr, event, this);
                });
            }
        }

        /* BIND EVENTS THAT ARE NOT MINE */
	    for (var fieldAddress in this.notmyevents){
		    for (var evtName in this.notmyevents[fieldAddress]){

		        var stAddr = fieldAddress.split('.');
				jSelector = "";
		        // if address starts with a . then it's a relative path
			    if (stAddr[0] == ""){
			        jSelector = "." + this.moduleName;
			        stAddr.shift();
			    }

			    fieldName = stAddr.pop();
			    stAddr.forEach(function(s){
			    	jSelector += ' [name="' + s + '"]';
			    });

			    var fwdData = { container: this,
				                fieldAddress: fieldAddress,
							    fieldName: fieldName,
							    evtName: evtName};

			    $(document.body).on(evtName, jSelector + ' [name="' + fieldName + '"]' , fwdData, function(event){

				    // don't trigger for child module field with same name.
				    if ($(event.target).is(jSelector + " .base_module [name=" + event.data.fieldName + "]")){
					    return;
				    }

				    var cntnr = event.data.container;
				    cntnr.instanceElement = cntnr.getElementParentContainerElement(this);
				    cntnr.instanceName = cntnr.instanceElement.attr("name");

				    cntnr.notmyevents[event.data.fieldAddress][event.data.evtName].call(cntnr, event, this);
			    });
		    }
	    }


    },

    bindDirtyMonitor: function(){

    },

    getElementParentContainerElement: function(el){
        return $(el).closest(".base_page, .base_module." + this.moduleName);
    },
    field: function(fieldName){
        var instanceNameSelector = "";
        if (this.instanceName != "") instanceNameSelector = "[name=" + this.instanceName + "]";
        return $(instanceNameSelector + "." + this.moduleName + " [name=" + fieldName + "]");
    },
    fieldValue: function(fieldName){
        return new dsValueFormatter(this.field(fieldName).val());
    },
    foreachInstance: function(callback, params){
        var cntnr = this;
        $("." + this.moduleName).each(function(){
            cntnr.instanceElement = this;
            cntnr.instanceName = $(this).attr("name");
            callback.apply(cntnr, params);
        });
    }
}

/*
var module_DS_popupPunchItemEdit = new Container("module_DS_popupPunchItemEdit",{
    init: function(){

    },
    punchIn: function(){
        this.field("punchIn").val(this.getTime());
    },

    getTime: function(){
        var now = new Date();
        return now.getHours() + ":" + dsSwissKnife.number_pad( now.getMinutes(), 2) ;
    },

    events:{
        tempsFacture:{
            click: function(event){
                // alert("dude");
                test.field("tempsFacture").val("ahahah");
            }
        }
    }
});
*/