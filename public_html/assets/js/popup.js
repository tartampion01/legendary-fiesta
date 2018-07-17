module_popup = {
    popupStack: [],   /* tagID des popups ouverts */
    nextZOrder: 100,

    request: function (event, el, popupName, popupPayload) {
       // if ($.inArray(popupName, module_popup.popupStack) !== -1) return;  // Si le popup est déjà affiché

        var payload = {
            mousePageX: event.pageX,
            mousePageY: event.pageY,
            serializables: getSerializablesAsJSON(el),
            popupPayload: popupPayload
        };

        ajaxEvent("", el, popupName, payload);
    },

    /*
    popupData:
    parentModuleElement: élément DOM du module parent pour créer le popup à l'intérieur du module parent. Lors d'appels ajax, le router saura où diriger les événements
     */
    show: function (popupData) {
        var classes = ["module_popup_wrapper"];
        if (popupData.blackBG == true) classes.push("blackBG"); else classes.push("noBlackBG");
        if (popupData.modal == true) classes.push("modal");

        var myID = "popup_" + popupData.instanceName;
        var popEl = undefined;

    // CONTENU //
        // Si popup existant, remplace le html
        var currentPopUpEl = $("#" + myID);
        if (currentPopUpEl.length == 0) {

            newEl = document.createElement("div");
            newEl.setAttribute("id", myID);
            newEl.setAttribute("class", classes.join(" "));
            newEl.innerHTML = popupData.html;
            module_popup.popupStack.push(popupData.instanceName);

            // ajoute l'élément au document ou a son module parent
            if ( popupData.parentInstanceName == "" ) {
                document.body.appendChild(newEl);
            }
            else{
                // Cherche le module ou la page parente
                var parentModule = $('[name="' + popupData.parentInstanceName + '"].base_page, [name="' + popupData.parentInstanceName + '"].base_module')[0];
                if ( parentModule == undefined ) return;

                parentModule.appendChild(newEl);
            }
            popEl = newEl;
        }
        else {
            currentPopUpEl[0].innerHTML = popupData.html;
            popEl = currentPopUpEl[0];
        }


    // position du contenant et du contenu
        var wrapperStyle = "";
        var contentStyle = "";
        if (popupData.positionX !== null) {
            wrapperStyle = "position: absolute; left:" + popupData.positionX + "px; top:" + popupData.positionY + "px;";
        }
        else{
            // wrapper CENTRÉ si pas de blackBG //
            if ( popupData.blackBG == false ){
                wrapperStyle = '\
                position: fixed; \
                top: 50%; \
                left: 50%; \
                margin-top: -50px; \
                margin-left: -100px; \
            ';
            }

            contentStyle = '\
                position: fixed; \
                top: 50%; \
                left: 50%; \
                transform: translate(-50%, -50%);\
                -webkit-transform: translate(-50%, -50%);\
                -moz-transform: translate(-50%, -50%);\
                -ms-transform: translate(-50%, -50%);\
                -o-transform: translate(-50%, -50%);\
            ';

        }

        popEl.setAttribute("style", wrapperStyle);
        popEl.firstElementChild.setAttribute("style", contentStyle);


        // BOUTON CLOSE //
        if (popupData.showCloseButton == true){
            var closeButtonEL = document.createElement("button");
            closeButtonEL.setAttribute("class", "closeButton");
            closeButtonEL.textContent = 'X';
            popEl.firstElementChild.appendChild(closeButtonEL);
        }

        $(".input", currentPopUpEl).focus();

        
    },


    /* fournir instanceName */
    close:function(instanceName, thenCallThis){
        var popModule = $('.module_popup[name="' + instanceName + '"]')[0];
        if ( popModule == undefined ) return;
        var popDiv = popModule.parentNode;
        module_popup.popupStack.splice($.inArray(instanceName, module_popup.popupStack), 1);
        popDiv.parentNode.removeChild(popDiv);

        //@@TODO bogus...!
        if (thenCallThis != undefined) thenCallThis();
    }

};

// Register an ajax answer
decodeMultipleAnswersCommands.showPopup = module_popup.show;
decodeMultipleAnswersCommands.closePopup = module_popup.close;

dsAjaxV2.commands.popupShow = module_popup.show;
dsAjaxV2.commands.popupClose = module_popup.close;

