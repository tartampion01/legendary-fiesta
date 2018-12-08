<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<body>
    <div name='menu' class='layout_normal base_layout base_page serializable'>
        <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
        <div id="entete" class="row">
            <div id="menu" class="col-xs-3 col-sm-2">
                <a href="default.php" class="home-link">
                    <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
                </a>
            </div>
            <div id="titre" class="col-xs-6 col-sm-8">Test signature</div>
            <div id="user" class="col-xs-3 col-sm-2">
                <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
                <a href="#" class="offline_hide">
                    <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
                </a>
            </div>
        </div>
        <div id="contenu">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea type="text" id="test-signature" name="test-signature" rows="6" style="width: 100%;"></textarea><br /><br />
                            <button id="btn-action" name="btn-action">Tester signature</button>
                            <br /><br /><br /><br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div name='mod_signature' class='module_signature base_module serializable' >
                                <div id="signature_mod_signature" class="signPad">
                                    <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1em !important; margin-bottom:1em !important;">
                                    </div>
                                    <div id="jSignatureTest" style="margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none;" class="jSignatureTest disabled" width="600" height="150"></div>
                                    <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1.5em !important; margin-bottom:1.5em !important; position: relative;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer id="pied">
            <div class="bottomBanner">
                <div class="copyright"></div>
            </div>
        </footer>
    </div>
    <div id="showLoading">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
        <!--img src="wait.png"-->
    </div>
    <div id="ajax" style="display:none;">
        <script type="text/json" class="communicator">[{"nop":""}]</script>
        <script type="text/json" class="dsAjaxV2">[{"nop":""}]</script>
    </div>
    
    <script>
        $(document).ready(function() {
            
            var $sigdiv = $('.jSignatureTest');
            if($sigdiv.length > 0) {
                $sigdiv.jSignature();
                //$sigdiv.jSignature('disable');
            }

            $('#btn-action').on('click', function() {
                var signatureInput = $('#test-signature').val();
                
                if(signatureInput != '') {
                    
                    $('.jSignatureTest').removeClass('disabled');
                    
                    try {
                        $sigdiv.jSignature("importData", signatureInput);
                    }
                    catch(error) {
                        swal({
                            type: 'error',
                            title: 'Attention!',
                            html: 'Il y a une erreur dans le format de la string!',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.value) {
                                return false;
                            }
                        });
                    }
                }
                else {
                    swal({
                        type: 'warning',
                        title: 'Attention!',
                        html: 'Vous devez entrer une signature en base30!',
                        allowEscapeKey: false,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.value) {
                            return false;
                        }
                    });
                }
            });
            
        });
    </script>
</body>
</html>
