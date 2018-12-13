<?php require_once(dirname(__DIR__) . '/_includes/header/_header.php');?>
<!--<script type="application/javascript" src="assets/js/livraison.js"></script>-->
<body>
    <div name='livraison' class='page_livraison layout_normal base_layout base_page serializable'>
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">
    <div id="entete" class="row" style="margin-top: 0px;">
        <div id="menu" class="col-xs-3 col-sm-2">
            <a href="default.php" class="home-link">
                <img src="assets/images/ico-reseau-dynamique-maison-orange70x70.png" alt="">
            </a>
        </div>
        <div id="titre" class="col-xs-6 col-sm-8">LIVRAISON</div>
        <div id="user" class="col-xs-3 col-sm-2">
            <div><?php echo IL_Session::r(IL_SessionVariables::USERNAME); ?></div>
            <a href="#" class="offline_hide">
                <div id="logout" class="hyperlien" onclick="window.location.href='logout.php'">Déconnexion</div>
            </a>
        </div>
    </div>
    
    <div id="contenu">
        <div name='mod_livraison' class='module_livraison base_module awesomplete col-lg-offset-2 col-lg-8 serializable' >
            <section>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class=col-xs-12>Date de livraison</div>
                            <div class="col-xs-12">
                                <input type="text" name="tbDate" id="tbDate" value="<?php echo $date; ?>" readonly="" maxlength="200"  class="input "></input>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12 label">
                                Employé
                            </div>
                            <div class="col-xs-12">
                                <input type="text" name="tbEmploye" id="tbEmploye" value="" maxlength="10"  class="input "></input>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section name="factures" class="cloneDestination serializable">
                <div name="row1" class="row clonable serializable">
                    <div class="col-xs-5">
                        <div class="row">
                            <div class="col-xs-12 label">
                                Facture
                            </div>
                            <div class="col-xs-12">
                                <input type="text" name="tbNoFacture[]" id="tbNoFacture1" value="" maxlength="20"  class="input"></input><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="row">
                            <div class="col-xs-12 label">
                                Colis
                            </div>
                            <div class="col-xs-12">
                                <input type="text" name="tbNoColis[]" id="tbNoColis1" value="" maxlength="20"  class="input"></input><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 center">
                        <div class="row">
                            <div class="col-xs-12 label">
                                &nbsp;
                            </div>
                            <div class="col-xs-12">
                                <i name="moins" class="removeItem buttonStyle fas fa-minus" style="display: none;"></i>
                                <i name="plus" class="addItem firstItemRow buttonStyle fas fa-plus" data-item-row="1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="row">
                    <div class="col-md-12">
                        <span class="label">Destinataire </span>
                        <div class="awesomplete">
                            <input name="tbDestinataire" id="tbDestinataire" value="" list="listeClients" maxlength="20" class="input awesomplete" autocomplete="off" aria-autocomplete="list" type="text">
                        </div>
                        <datalist id="listeClients"><?php echo IL_Utils::getDistinctDestinataires() ?></datalist>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <span class="label">Nom du signataire </span>
                        <input type="text" name="tbNomSignataire" id="tbNomSignataire" value="" maxlength="200"  class="input "></input>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div style="display: none;"><input type="text" name="signature" value="" maxlength="1024"  class="input "></input>
                    </div>
                    <div class="col-md-12">
                        <div name='mod_signature' class='module_signature base_module serializable' >
                            <div id="signature_mod_signature" class="signPad">
                                <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1em !important; margin-bottom:1em !important;">
                                </div>
                                <div id="jSignature" style="margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none;" class="jSignature disabled" width="600" height="150"></div>
                                <div style="padding:0 !important; margin:0 !important;width: 100% !important; height: 0 !important; -ms-touch-action: none; touch-action: none;margin-top:-1.5em !important; margin-bottom:1.5em !important; position: relative;">
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row buttons">
                    <div class="col-xs-offset-1 col-xs-5 col-md-offset-1 col-md-5">
                        <button name="btnSign" class="btnSign" data-action="doSignature" onclick="return false;"><i class="fas fa-edit"></i> Faire signer le client</button>
                    </div>
                    <div class="col-xs-5 col-md-5">
                        <button name="btnClear" class="btnClear"><i class="far fa-trash-alt"></i> Effacer la signature</button>
                    </div>
                </div>
            </section>
            <section>
                <div class="row">
                    <div class="col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6">
                        <button type="submit" name="btnSave" class="btnSave"><i class="far fa-save"></i> Sauvegarder</button>
                        <input type="hidden" name="succursale" id="succursale" value="<?php echo $user->succursale; ?>" maxlength="25"></input>
                    </div>
                </div>
            </section>
            
            <div class="dumpSignature" style="display: none; margin: 0px; padding: 0px; border: medium none; height: 150px; width: 100%; touch-action: none; background-color: transparent;">
                
                
                
            </div>
            
            <!--<datalist id="listeClients"><option>Penske</option><option>Boutin</option><option>Charest victo</option><option>Ryder boucherville </option><option>Mljc</option><option>Pickup</option><option>Loyal express frigo</option><option>Beaudoin Drummondvil</option><option>Globocam rive sud</option><option>Gologist</option><option>Danaca</option><option>Transpec</option><option>Isuzu mal ouest </option><option> Boutin 723704</option><option>Ges</option><option>13704</option><option>Target</option><option>11226</option><option>Smtr</option><option>19066</option><option>Boutin 723723</option><option>Ascenseur viau</option><option>20173</option><option>20527</option><option>20533</option><option>Penske boucherville </option><option>Ferry dzinzio</option><option>Beaudoin St hyac</option><option>Ccb</option><option>20572</option><option>15131</option><option>20267</option><option>20520</option><option>19036</option><option>10943</option><option>Xtl</option><option>Rain ville automobil</option><option>Boutin 723704</option><option>Matrec</option><option>14870</option><option>19866</option><option>15678</option><option>20579</option><option>Ferry dzindzio </option><option>19030</option><option>Transport sn</option><option>Yfk</option><option>20352</option><option>1304</option><option>11207</option><option>15980</option><option>16132</option><option>19272</option><option>Purolator</option><option>20535</option><option>13074</option><option>12301</option><option>16337</option><option>Boutin 10943</option><option>P1</option><option>15735</option><option>11377</option><option>20526</option><option>17338</option><option>14240</option><option>19633</option><option>Letram</option><option>436</option><option>Gerry dzindzio </option><option>17055</option><option>20484</option><option>Mobile LAFORTUNE </option><option>20263</option><option>20416</option><option>Ls</option><option>Va</option><option>14414</option><option>20158</option><option>12848</option><option>20023</option><option>17961</option><option>Cynafr</option><option>Lague</option><option>20498</option><option>723909</option><option>14980</option><option>2oo21</option><option>11113</option><option>11716</option><option>10923</option><option>Ttransportsn</option><option>Demark </option><option>Jaf</option><option>12045</option><option>Sainte marie</option><option>Cia</option><option>13169</option><option>19828</option><option>18959marc</option><option>11396</option><option>16019</option><option>1498o</option><option>Transport Alain gog2</option><option>Va inc</option><option>20560</option><option>16875</option><option>Cil</option><option>20451</option><option>1</option><option>20424</option><option>10325</option><option>Hino</option><option>Technic</option><option>20537</option><option>14983</option><option>10988</option><option>20236</option><option>18923</option><option>18338</option><option>Remorques  martel </option><option>20021</option><option>Cynar logistique </option><option>Andy</option><option>17206</option><option>20234</option><option>11150</option><option>18358</option><option>20549</option><option>Ressort rive sud</option><option>175784 Canada Inc.  </option><option>Bricon</option><option>20472</option><option>12282</option><option>Herard diesel</option><option>19820</option><option>20554</option><option>12029</option><option>10280</option><option>18362</option><option>20273 </option><option>20369</option><option>11830</option><option>14433</option><option>La 60</option><option>Garage carrey</option><option>20268</option><option>Transport orion</option><option>Hydro St bruneau</option><option>11660</option><option>Coutu</option><option>Rainville automobile</option><option>10475</option><option>20544</option><option>14225</option><option>514</option><option>17999</option><option>14339</option><option>20129</option><option>14622</option><option>20480</option><option>20570</option><option>13207</option><option>Mecanique Vezina</option><option>11040</option><option>19925</option><option>16470</option><option>20564</option><option>19904</option><option>Pavages ceka</option><option>Pavage ceka</option><option>Groupe desjardins</option><option>11320</option><option>Remorquage longueuil</option><option>15735c</option><option>14356</option><option>Ville de brossard</option><option>somac</option><option>J. R. P.</option><option>Boulerice</option><option>Hydro chateauguay</option><option>À Giroux</option><option>20507</option><option>Isuzu mtl ouest</option><option>benny</option><option>Xtl costco</option><option>Rothsay</option><option>l60</option><option>Cardinal</option><option>excavation bisaillon</option><option>15302</option><option>La joie </option><option>Samuel </option><option>Noiseux</option><option>15737</option><option>Eric</option><option>20323</option><option>Remorque Longueuil </option><option>18969</option><option>16469</option><option>20486</option><option>15640</option><option>18244</option><option>20249</option><option>Orion</option><option>20029</option><option>20576</option><option>Entrepot victo</option><option>10320</option><option>91258285</option><option>16338</option><option>20257</option><option>Saq20348</option><option>18369</option><option>Trim plus</option><option>Andre</option><option>1903688</option><option>11400</option><option>20233</option><option>20522</option><option>16546</option><option>20028</option><option>13792</option><option>Groupe jean coutu</option><option>20052</option><option>20469</option><option>11906</option><option>Lague carignan</option><option>20390</option><option>19269</option><option>Toiture Jean</option><option>14350</option><option>-15980</option><option>Agd</option><option>Ville de st lambert</option><option>Location Brossard </option><option>Transport Alain giro</option><option>Herve lemieux</option><option>trs bourassa</option><option>Expro</option><option>1848</option><option>PenskeO</option><option>20380</option><option>watson</option><option>20316</option><option>18108</option><option>20542</option><option>20235</option><option>20550</option><option>R40850</option><option>20496</option><option>20237</option><option>20525</option><option>15439</option><option>Brunac inc.mkl i0</option><option>Mecaniques Lapierre</option><option>Les camions C & W</option><option>20184</option><option>Dumas trans</option><option>14724</option><option>725501</option><option>Mec mobile R Bouleri</option><option>20529</option><option>15303</option><option>P1 Rene Choquette</option><option>Lanaudierrre</option><option>30338</option><option>11735</option><option>20040</option><option>18498</option><option>20302</option><option>20014</option><option>18505</option><option>Dallaire</option><option>Technifab</option><option>15848</option><option>16482</option><option>157335</option><option>14873</option><option>20100</option><option>19565</option><option>10963</option><option>Ste marie auto</option><option>Nrj</option><option>20094</option><option>J j</option><option>Toromont</option><option>Merci </option><option>Rolex</option><option>Pro action</option><option>16050</option><option>11023</option><option>Herard</option><option>Laccaille</option><option>Rot6</option><option>Dery</option><option>Cummins</option><option>20592</option><option>Que Mont</option><option>Cadel</option><option>Service de trasmissi</option><option>T W</option><option>1799o</option><option>1tr39</option><option>1433o</option><option>St marie auto</option><option>Ste marie</option><option>Dsd</option><option>20519</option><option>Pavage axion</option><option>20125</option><option>Paul skulski</option><option>Rollex</option><option>agd vercheres</option><option>Ville longueuil</option><option>20432</option><option>17489</option><option>20494</option><option>20201</option><option>Luc</option><option>202667</option><option>20280</option><option>20332</option><option>Rive nord</option><option>Robert thibert</option><option>11848</option><option>10378</option><option>20430</option><option>smtr jaclin</option><option>R49490</option><option>Jj</option><option>202267</option><option>15315</option><option>20006</option><option>14358</option><option>Lolo</option><option>Conventa</option><option>Wajax</option><option>Guilbault</option><option>Gsrp</option><option>18041</option><option>20426</option><option>20510</option><option>20521</option><option>2028r</option><option>11714 livre dpgh</option><option>20322</option><option>20598</option><option>20212</option><option>18345</option><option>20536</option><option>20541</option><option>Courrier a1</option><option>Groupe van velzen</option><option>J labelle transport</option><option>727080</option><option>20465</option><option>20354</option><option>18501</option><option>Garage chrest et fre</option><option>Pro diesel inc</option><option>Acema</option><option>National hino</option><option>11007</option><option>14e358</option><option>Entrprise alain labr</option><option>Maer inc</option><option>Pompage nord sud</option><option>18098</option><option>20308</option><option>Transport jocelyn bo</option><option>Anjou</option><option>Chri-dan</option><option>Soudure susp st brun</option><option>Andy transport</option><option>20597</option><option>Ced</option><option>Bendix</option><option>646105-646106</option><option>Demers</option><option>Inter west island</option><option>Hercules</option><option>021-51432</option><option>Camion interanjou</option><option>R50128</option><option>P1 lussier</option><option>11027</option><option>Sstb</option><option>119272</option><option>727773</option><option>Savaria</option><option>Tech mobile</option><option>Metaux sur site</option><option>Tsb</option><option>Jrp</option><option>20138 </option><option>20378</option><option>20295</option><option>20269</option><option>15618</option><option>Mtech</option><option>021-52129</option><option>7279633</option><option>Jp vrack</option><option>Plc</option><option>Jaf 2000 inc</option><option>P jacques</option><option>Va transport</option><option>David gouin</option><option>Technique</option><option>20240</option><option>14935</option><option>20405</option><option>Les distributions ca</option><option>1439</option><option>20421</option><option>728366</option><option>202221</option><option>Techno neige</option><option>20425</option><option>15767</option><option>Nord sud exc</option><option>Excellance peterbuil</option><option>Garage perreault</option><option>19923</option><option>19036z</option><option>1015364440</option><option>Tw</option><option>20602</option><option>20499</option><option>11773</option><option>Dddistribution</option><option>20538</option><option>Kenworth hr </option><option>20326</option><option>La hebert</option><option>20495</option><option>183362</option><option>Emballage carouselle</option><option>Distribution carl be</option><option>Pl diesel</option><option>20199</option><option>728883</option><option>20511</option><option>Transoort guirand</option><option>Godette</option><option>Morneau</option><option>20342+20346</option><option>728601</option><option>20389</option><option>Mrs magoo remorquage</option><option>Kc diesel</option><option>19055</option><option>Aketan canada</option><option>20444</option><option>20569</option><option>729618</option><option>729921</option><option>20583</option><option>Stephane</option><option>730006</option><option>Manac</option><option>729166</option><option>15170</option><option>20582</option><option>183622</option><option>20073</option><option>728428</option><option>20534</option><option>Alain limoge</option><option>Skelton</option><option>Berniere</option><option>Entreprise alain lab</option><option>Jd excavation</option><option>20313</option><option>14624</option><option>C&W</option><option>Coop</option><option>L 60</option><option>Denis noiseux</option><option>ISN Canada</option><option>Auto kool</option><option>Fleet brake</option><option>M driveshaft</option><option>Drive product</option><option>Ste</option><option>Globocam pointe clai</option><option>14050</option><option>14982  </option><option>20491</option><option>15131(</option><option>17999-</option><option>14870, </option><option>Tria</option><option>17357</option><option>20575</option><option>20548</option><option>R48550</option><option>Tjb inc</option><option>20206</option><option>Recyclage roto</option><option>17454</option><option>Remorquage hd</option><option>3a</option><option>20610</option><option>20393</option><option>20420</option><option>19020</option><option>19235</option><option>11359</option><option>1862</option><option>730146</option><option>dpgh</option><option>20604</option><option>20512</option><option>1139</option><option>10325q</option><option>1000388</option><option>Inter lanaudiere</option><option>Lanaudiere</option><option>14354</option><option>20559</option><option>Steden</option><option>Emondage viliard</option><option>Alain labrecqu</option><option>Tpt rcc</option><option>Pb performance</option><option>Remorque rp</option><option>20255</option><option>Cam ste hyacinthe</option><option>C14</option><option>Skolski</option><option>15603</option><option>Camion jj</option><option>13472</option><option>11858</option><option>18779</option><option>16460</option><option>N20184</option><option>Gmf</option><option>20007</option><option>Wilfrid lussier</option><option>Ttransport sn</option><option>Slapp</option><option>inter-elite</option><option>853469 673336</option><option>G Gaudette</option><option>173381</option><option>Transport j j </option><option>17099</option><option>20169</option><option>20105</option><option>20317</option><option>Jvm jess</option><option>Beaulac</option><option>20002</option><option>Trans eqipement</option><option>10002</option><option>Derochers</option><option>Centre du camion bou</option><option>731348</option><option>20437</option><option>Maconnerie rainville</option><option>731387</option><option>Mirco</option><option>20577</option><option>20381</option><option>9152</option><option>Raynald roy</option><option>731515</option><option>20229</option><option>Ville boucherville</option><option>20566</option><option>Oclaire</option><option>Mobile mayer</option><option>Pinnard</option><option>19633 via marco lepa</option><option>Sr mecanique</option><option>4refuel</option><option>14424</option><option>Ryder</option><option>20346</option><option>19905</option><option>205371</option><option>20485</option><option>C1a</option><option>204996</option><option>10006</option><option>Advence performance</option><option>Mini exc belouil</option><option>13705</option><option>9008-6158</option><option>Cash</option><option>13580</option><option>19639</option><option>Penske mtl</option><option>1841</option><option>16640</option><option>11245</option><option>Transport tosa mobek</option><option>Garcia</option><option>Garage robert</option><option>Trabsport laurentien</option><option>20325</option><option>Gaudette trs</option><option>732532</option><option>Embrayage techniplus</option><option>Lague boucherville</option><option>Expro transit</option><option>18924</option><option>20194   </option><option>20449</option><option>1573</option><option>20266</option><option>19829</option><option>20081</option><option>Louis pouliot</option><option>Montreal kenworth</option><option>Trp louis pouliot</option><option>82303780 82303095</option><option>Cummins pour brinks </option><option>Tr louis pouliot</option><option>Brinks canada </option><option>Fleet spec</option><option>camion st jean</option><option>Lemaire</option><option>Transport louis poul</option><option>Daviault</option><option>732755</option><option>Canvec</option><option>Isolam</option><option>Marcan</option><option>732958</option><option>20377</option><option>30317</option><option>Trans louis pouliot</option><option>Construction Gianni</option><option>Hydro st hya</option><option>733060</option><option>Transp louis pouliot</option><option>11842 </option><option>Chapiteaux Montreal</option><option>733366</option><option>733373</option><option>Bergeron</option><option>P h richelieu</option><option>10465</option><option>20618</option><option>Meca mobile</option><option>Piece de camion st j</option><option>20458</option><option>20*021</option><option>Ci</option><option>V.a.</option><option>Y.boutin</option><option>Levasse</option><option>11286</option><option>Paul</option><option>1609</option><option>20168</option><option>Jule kone</option><option>20563</option><option>18363</option><option>P1 francisco bonds</option><option>Inter rive nord</option><option>20382</option><option>Bricom</option><option>18838</option><option>11375</option><option>11227</option><option>20623</option><option>20552</option><option>Lecompte diesel</option><option>13050</option><option>Franclaire</option><option>Groupe guy</option><option>Air product</option><option>Poly</option><option>18632</option><option>20606</option><option>9205-9674</option><option>11236</option><option>18376</option><option>Ecycle</option><option>Roger jeannotte</option><option>20334</option><option>734071</option><option>Va transort</option><option>Lafarge Canada</option><option>Monsieur livre tout</option><option>Ret-tw</option><option>20364</option><option>Pavages Ultra</option><option>20613</option><option>Hydraulique rnp</option><option>16042</option><option>23262</option><option>Sonar 20255</option><option>20221</option><option>Andre lacroix</option><option>H. Turner</option><option>2057</option><option>Garage St Philipe</option><option>20528</option><option>11114</option><option>20946</option><option>T oclair</option><option>Hugo Lussier</option><option>20616</option><option>13704 rollex</option><option>Transport rcc inc</option><option>Ups</option><option>Ressort mtl nord</option><option>Tms</option><option>Maska</option><option>735021</option><option>Tony deprovence</option><option>Pi</option><option>Landry</option><option>20315</option><option>J r p</option><option>Erb</option><option>Foraction</option><option>Ville de st bruno</option><option>20621</option><option>13704eb</option><option>11201</option><option>10532</option><option>183656 ford boisvert</option><option>20394</option><option>20365</option><option>Magnacharge</option><option>Maxi</option><option>Trans f air</option><option>Transport lemaire</option><option>14101</option><option>R1050860</option><option>11400t6</option><option>13704rt </option><option>Broker robert</option><option>Visuel motion</option><option>20170</option><option>P1 ascenseurs viau</option><option>20614</option><option>Ville st bruno</option><option>Mecanique henri bour</option><option>Toiture yves ferland</option><option>Ml</option><option>Visual motion</option><option>Coolair</option><option>13735</option><option>Denis lussier</option><option>Reparation rp</option><option>Renove asphalte</option><option>Gerry</option><option>736227</option><option>Mec mobile leclaire</option><option>Holland qc</option><option>D angelo</option><option>Transpalco</option><option>20632</option><option>736351</option><option>Jean 18376</option><option>Distr aras</option><option>Lubrimatic</option><option>Camion amiante</option><option>Remorquage martel</option><option>735545</option><option>Inter boucherville</option><option>Apb maconnerie</option><option>19629</option><option>Truck master</option><option>Bl</option><option>Charette</option><option>14969</option><option>198362</option><option>Babi</option><option>735815</option><option>Equipement amos</option><option>736512</option><option>R41740</option><option>20113</option><option>15356</option><option>15999</option><option>Smtr boucherville</option><option>20628</option><option>1513</option><option>Livre chez Gfs</option><option> 13704</option><option>20066</option><option>Pce camion st jean</option><option>14100</option><option>Gestion E Lapierre</option><option>Hino rive sud</option><option>Bdl bordure et toitu</option><option>Trp o claire</option><option>13999</option><option>42025</option><option>Ascenseurs Viau</option><option>20263c</option><option>520234</option><option>18289</option><option>Su5260</option><option>19036737158</option><option>20324</option><option>Rem carron</option><option>Eclipson</option><option>Michel sarban</option><option>Michel</option><option>Maconnerie aa</option><option>P.jacques</option><option>Real chenail</option><option>Warren lapoint</option><option>12284</option><option>Les greniers de jose</option><option>Tpt johnson</option><option>Rm electro</option><option>Ville de bouchervill</option><option>L.s.</option><option>20061</option><option>Loyal express frigos</option><option>Pdl</option><option>Leang 13705</option><option>P1 hunault custom</option><option>Small wheel</option><option>14189</option><option>Ced client</option><option>Gg fruit et legume</option><option>Paysagiste d lussier</option><option>Excavation ms</option><option>20584</option><option>15455</option><option>20635</option><option>Vitex</option><option>20619</option><option>2 0302</option><option>Cummin</option><option>Y a d</option><option>Trp lemaire</option><option>Frein 3 A</option><option>Horton</option><option>Thauvette</option><option>Denlo</option><option>20558</option><option>Pavage nick</option><option>Piece camion St jean</option><option>L. 60</option><option>R184618</option><option>20451 canvec</option><option>Esm 20512</option><option>737826</option><option>Panneton</option><option>George pelletier</option><option>Martin leblanc</option><option>17151</option><option>Mini excavation belo</option><option>Jean guy daviault</option><option>P1 centre estetique</option><option>P1 vanwinden</option><option>Kenworth haut richel</option><option>S.n.</option><option>738068</option><option>15461</option><option>P1 Boulerice</option><option>Mecanique R Bouleric</option><option>Mob</option><option>20222</option><option>20605</option><option>Trp alain giroux </option><option>Nv kuujjuaq</option><option>Lubrimaric</option><option>20370</option><option>R41747 Globocam</option><option>Mec Boulerice</option><option>20448</option><option>Cc st jean</option><option>Mms</option><option>Trs Lemaire </option><option>15735m</option><option>20451a1</option><option>19280</option><option>Commission scolair</option><option>Rsr</option><option>Jp cote</option><option>Nelson 26</option><option>Saq</option><option>16870</option><option>A1 alex</option><option>20478</option><option>15961</option><option>10948</option><option>Ciq</option><option>Denis </option><option>20595</option><option>Pi vitro plus</option><option>Meca mobile Bouliric</option><option>15697</option><option>13169n</option><option>P1 holland quebec</option><option>739530</option><option>20238</option><option>18338am</option><option>P.e boisvert auto</option><option>Mec r Boulerice</option><option>16130</option><option>739897</option><option>15141</option><option>Sani terre</option><option>17753</option><option>20231</option><option>Mercier diesel</option><option>Ressort boucherville</option><option>Mecanique M D</option><option>P1g</option><option>Les camions beaudoin</option><option>Dmc</option><option>P.l. diesel</option><option>Garage lague</option><option>A1 anjou</option><option>Kavalier</option><option>Isuzu mtl ouest canv</option><option>Cia a1</option><option>Brique et pierre</option><option>20343</option><option>20474</option><option>12207</option><option>20251</option><option>20265</option><option>9182 7105</option><option>20398</option><option>Rodrigue</option><option>18368</option><option>Mecanique dm</option><option>Tpt magela</option><option>20124</option><option>Sanitaire environeme</option><option>20545</option><option>Carrosserie PA</option><option>20561</option><option>Grues bellerive</option><option>Beloeil transit</option><option>Marick diesel</option><option>Yad</option><option>Metchro</option><option>20644</option><option>20330</option><option>20454</option><option>Service mec jm</option><option>Patate gemme</option><option>9324 7542</option><option>Autobus grise</option><option>740934</option><option>13980</option><option>20020</option><option>Claude dallaire</option><option>Pjp mecanique</option><option>Le Relais chevrolet</option><option>Gestion exclusif</option><option>111150</option><option>19635</option><option>20502</option><option>20245</option><option>17961 zzaaaàà</option><option>15131qq</option><option>11326</option><option>Exide</option><option>Garage cadieux</option><option>Hydro beauharnois</option><option>9118 3103</option><option>Hydro granby</option><option>742002</option><option>Boulay</option><option>20622</option><option>Maxime lacoste</option><option>Pi rapid gaz</option><option>20647</option><option>14240@</option><option>Brasseur trp</option><option>Mecanique st jean</option><option>160019</option><option>20645</option><option>Tpt richard charest </option><option>Huneault custom</option><option>Inter estrie</option><option>19150</option><option>19848</option><option>Cg mecanique</option><option>11226 climato</option><option>Sanibert</option><option>32600</option><option>Pi payette transport</option><option>18244n</option><option>742551</option><option>20250</option><option>Andre lemay</option><option>14376</option><option>14436</option><option>Excellance peterbilt</option><option>12i48</option><option>20055</option><option>Grue nrick</option><option>Inter</option><option>Remorquage St HUBERT</option><option>Excellence peterbilt</option><option>20630</option><option>Herve lemieux verche</option><option>742969</option><option>Sebastien</option><option>Martel excavation</option><option>Zecca</option><option>Giguer</option><option>Recochem</option><option>Toromont candiac</option><option>Cummins candiac</option><option>137044</option><option>20612</option><option>Inter anjou</option><option>Laidlaw</option><option>Scellant sg</option><option>Camion lussier</option><option>Sylvio thauvette</option><option>Globo anjou</option><option>Camion bl</option><option>20434</option><option>Ricbard savard trans</option><option>Ceec</option><option>743739</option><option>20366</option><option>1986</option><option>20236....20237</option><option>St marie st remi</option><option>Inrer st hyacinte</option><option>Ac service</option><option>Fontaine</option><option>Rsr 17753</option><option>270</option><option>Michaudville</option><option>D.D.DISTRIBUTION LUB</option><option>196e3</option><option>14569</option><option>29549</option><option>Intrer rive nord</option><option>M. Driveshaft inc.</option><option>B st hyacinthe</option><option>Smv</option><option>190364</option><option>CW</option><option>20383</option><option>20183</option><option>Lanaudierre</option><option>Intre anjou</option><option>P1 traction</option><option>Courier a1</option><option>Vitex 326</option><option>Inter drum</option><option>74421r</option><option>Geno</option><option>Charet international</option><option>10880</option><option>202345</option><option>Sgr</option><option>Bti</option><option>Carques pieces auto</option><option>786187</option><option>Transport lemieux</option><option>Ienter anjou</option><option>13201</option><option>Ville st jean</option><option>20639</option><option>19063</option><option>20505</option><option>Alain la breque</option><option>205y9</option><option>Labranche transport</option><option>Le roux</option><option>P1 grpit</option><option>10378943</option><option>P1 tpt prevost</option><option>Menanique dm</option><option>745481</option><option>Nv kuujju</option><option>Acier leroux</option><option>Ferme du soleil</option><option>20162</option><option>11380</option><option>Nord construction</option><option>Ryder boucherviller</option><option>Gamache</option><option>Camion isuzu</option><option>746017</option><option>20165</option><option>Gestion dgl</option><option>20418</option><option>Meca mobile Bouleric</option><option>20234...20235..20236</option></datalist>-->
        </div>
    </div>

    <footer id="pied">
        <div class="bottomBanner">
            <div class="copyright">
                <div>
                    <input type="button" id="checkLocalForageSync" class="btn-check-localforage-sync large green button" value="Synchroniser les données" />
                </div>
            </div>
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
        var e = document.getElementById('tbDate');
        // Si vide on met la date, sinon PHP récupère la date postée et la remet dans le textbox
        if( e.value.localeCompare("") == 0 )
            tbDate.value = dsSwissKnife.prettyPrint('date',new Date());
    </script>

    <!-- Start : Javascript template -->
    <script id="itemTemplate" type="text/x-jquery-tmpl">
        <div class="row clonable cloned serializable itemRow${counter}">
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbNoFacture[]" id="tbNoColis${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="tbNoColis[]" id="tbNoColis${counter}" value="" maxlength="20"  class="input"></input><br>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 center">
                <div class="row">
                    <div class="col-xs-12">
                        <i name="moins" class="removeItem buttonStyle fas fa-minus" data-item-row="${counter}"></i>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <!-- End : Javascript template -->
</body>
</html>
