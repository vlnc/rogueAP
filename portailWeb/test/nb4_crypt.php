<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Portail Captif Communautaire SFR WiFi</title>
        <script type="text/javascript" src="js/pcnb4.js"></script>
        <link rel="stylesheet" type="text/css" href="css/mode3/default-pc.css" />
	<link rel="icon" type="image/png" href="favicon.png" />
        		<!--WISPAccessGatewayParam xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="https://hotspot.sfr.fr/dashboard/WISPAccessGatewayParam.xsd">
			<AuthenticationReply>
				<MessageType>120</MessageType>
				<ResponseCode>100</ResponseCode>
				<ReplyMessage>Authentication Failure</ReplyMessage>
			</AuthenticationReply>
		</WISPAccessGatewayParam-->
	<!--SFRLoginURL_JIL=https://hotspot.wifi.sfr.fr/indexEncryptingChilli.php?res=failed-->
    </head>

    <body>
		<!--version>5.2 - PCNB4 - {28/02/2013}</version-->
        <table border="0" cellpadding="0" cellspacing="0" width="900" align="center" style="border: 1px #d1d1d1 solid;margin-top:20px">
            <tr>
                <td colspan="2">
                    <div class="headerSFR">
                        <div class="gauche"><div class="sprite-sfr-wifi"></div></div>
                        <div class="droite">vous accompagne, l&agrave; o&ugrave; vous en avez besoin.</div>
                        <div class="fleche"><div class="sprite-flecheG"></div></div>
                    </div>
                    <div style="width:100%; text-align: center">
                        <div class="ligne-rouge"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <div class="infosBloc">
                        <div class="titre"> Avec SFR WiFi, surfez en illimit&eacute; </div>
                        <ul class="liste">
                            <li><span style="color:black">4 millions de Hotspots partout en France</span></li>
                            <li><span style="color:black">Les principales gares SNCF</span></li>
                            <li><span style="color:black">H&ocirc;tels, caf&eacute;s et restaurants</span></li>
                        </ul>
                        <div class="promo">
                            <div class="bloc">
                                <h1>Client iPhone<br />& Webphone</h1>
                                <div style="margin-top:10px;margin-bottom: 2px;height:81px;">
                                    <div class="texte">Utilisez l'application<br />SFR WiFi ou Auto Connect WiFi.</div>
                                    <div class="image"><div class="sprite-mobiles"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="lien">
                                    <div class="texteL"><a href="http://www.sfr.fr/telephonie-mobile/services-options/services-smartphones/applications-sfr/sfr-wifi">Plus d'infos</a></div>
                                    <div class="imageL"><div class="sprite-fleche-rouge"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                            <div class="bloc">
                                <h1>Client Tablette & iPad</h1>
                                <div style="margin-top:26px;margin-bottom: 3px;height:80px;">
                                    <div class="texte">Utilisez l'application<br />SFR WiFi ou Auto Connect WiFi.</div>
                                    <div class="image"><div class="sprite-tablette"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="lien">
                                    <div class="texteL"><a href="http://www.sfr.fr/telephonie-mobile/services-options/services-smartphones/applications-sfr/sfr-wifi">Plus d'infos</a></div>
                                    <div class="imageL"><div class="sprite-fleche-rouge"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                            <div class="bloc">
                                <h1>Client Internet 3G+</h1>
                                <div style="margin-top:20px;margin-bottom: 20px;">
                                    <div class="texte" style="padding-top:4px">Utilisez le gestionnaire de connexion.</div>
                                    <div class="image"><div class="sprite-cle3g"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="lien">
                                    <div class="texteL"><a href="http://www.sfr.fr/vos-services/internet-partout/PC-en-mobilite/cle-internet-3g/fonctionnalites/sfr-wifi/index.jsp">Plus d'infos</a></div>
                                    <div class="imageL"><div class="sprite-fleche-rouge"></div></div>
                                    <div style="clear:both"></div>
                                </div>
                            </div>
                            <div style="clear:both;overflow:hidden;height:1px;"></div>
							<div class="blocFon">
								<img src="i/fon.jpg" alt="FON" />
								<p><strong>En exclusivit&eacute; pour les clients SFR ADSL ou Fibre</strong>, 8 millions de hotspots WiFi &agrave; l&rsquo;&eacute;tranger en rejoignant la communaut&eacute; Fon.</p>
								<!--<div style="clear:both"></div>-->
								<div class="texteL"><a href="http://assistance.sfr.fr/internet_neufbox-de-SFR/connexion/creer_identifiant-fon-et-activer-option/fc-2405-50213">Plus d'infos</a></div>
							
							</div>
                        </div>
                    </div>
                </td>
                <td width="390px">
                    <div class="authentBloc">
                        <form action="nb4_crypt.php" method="POST" name="connect" onsubmit="javascript:return validForm();">
                            <div class="titre">Vous &ecirc;tes client <span class="rouge">SFR</span> ADSL ou Fibre,<br />identifiez-vous !</div>
                            <div class="identifiant">
                                <strong><span class="rouge">E-mail</span> ou <span class="rouge">NeufID</span></strong><br />
                                <input type="text" name="username" id="login" size="30" />
                            </div>
                            <div class="motdepasse">
                                <strong>Mot de passe</strong><br />
                                <input type="password" name="password" id="password" size="30" />
                            </div>
                            <div class="cond">
                                <input type="checkbox" name="conditions" id="conditions" /> J'accepte les <strong><a href="mentions.html">termes et conditions</a></strong> du service<br />
                                <input type="checkbox" name="save" id="save" /> Se souvenir de mon identifiant
                            </div>
                            <div class="connexion">
                                <input type="text" name="challenge" value="" style="display:none;" />
                                <input type="text" name="accessType" value="" style="display:none;" />
                                <input type="text" name="lang" value="" style="display:none;" />
                                <input type="text" name="mode" value="" style="display:none;" />
                                <input type="text" name="userurl" value="" style="display:none;" />
                                <input type="text" name="uamip" value="" style="display:none;" />
                                <input type="text" name="uamport" value="" style="display:none;" />
                                <input type="text" name="channel" value="" style="display:none;" />
                                <input type="text" name="mac" value="" style="display:none;" />
                                <input type="submit" name="connexion" value="Connexion" class="boutonC sprite-connexion" /><br /><br />
                                <div class="plusInfos">
                                    <div class="sprite-puce" style="margin-left:238px"></div>
                                    <div style="float: right;"><a href="#" onclick="openPopup(700, 440, 'aideDiv', true)">Besoin d'aide ?</a></div>
                                </div>
                                <br />
                            </div>
                            <div class="infos">
                                <div class="sprite-ligne-grise"></div>
                                <div class="image">
                                    <div class="sprite-ampoule"></div>
                                </div>
                                <div class="texte">
                                    <strong>Vous &ecirc;tes client SFR, ADSL ou Fibre?</strong><br />
                                    Chez vous, utilisez votre r&eacute;seau WiFi priv&eacute; pour surfer sur internet !
                                </div>
                                <div class="plusInfos">
                                    <div class="sprite-puce" style="margin-left:200px"></div>
                                    <div style="float: right;"><a href="http://www.sfr.fr/vos-services/services-fixes-adsl/internet/wifi/" target="_blank">Plus d'infos</a></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="footerBloc">
                     <a href="mentions.html" target="_blank">Mentions l&eacute;gales</a> | <a href="http://assistance.sfr.fr/index.do" target="_blank">Assistance</a>
                </td>
            </tr>
        </table>
        <div class="voile" id="voile"> </div>
        <div class="box" id="box">
            <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
                <tr align="right" height=38" valign="middle">
                    <td><div id="fermerBox" class="fermer">
                            <div class="sprite-fermer" style="position:absolute;right:0;top:0"></div>
                            <div style="position:absolute;right:0;top:7px"><a onclick="javascript:closePopup()">FERMER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
                            <div style="clear: both"></div>
                    </div></td>
                </tr>
                <tr align="center" valign="top"><td id="contenuBox"></td></tr>
            </table>
        </div>
        <div id="erreurDiv" style="display: none">
            <div style="width:500px;height:200px;background-color:#d1d1d1;font-size:16px;line-height:30px;">
                <br /><span class="rouge" style="font-weight:bold;font-size:24px">ERREUR D'AUTHENTIFICATION !</span><br />
                <hr style="height:2px;width:400px;background-color:black;border:1px black solid" /><br />
                Assurez-vous d'avoir saisi vos <strong>identifiants</strong> neufbox de SFR.<br />
                Si vous &ecirc;tes chez vous, utilisez plut&ocirc;t votre acc&egrave;s WiFi priv&eacute;.
            </div>
        </div>
        <div id="successDiv" style="display: none">
			<div id="successPopin">
				<div class="logoPopin"></div>
                <p class="titlePopin">F&Eacute;LICITATIONS !</p>
                <p class="texteCompteur">Vous allez &ecirc;tre redirig&eacute; vers le site internet demand&eacute; dans <span class="rouge" id="theTimer">7 secondes</span>.</p>
<form action="http://cartewifi.sfr.fr/" method="post" id="iluvhs">
<input type="hidden" name="nasID" value="">
				<div id="colHotspot">
					<div class="colLeft">
						<a href="javascript:void(1);" onclick="document.getElementById('iluvhs').submit();"/><img src="i/sfrWifi.png" alt="SFR" /></a>
					</div>
					<div class="colRight texteL">
						<a href="javascript:void(1);" onclick="document.getElementById('iluvhs').submit();"/>Cliquez ici pour d&eacute;couvrir SFR WiFi et rejoindre la communaut&eacute; des hotspotters.</a>
					</div>
				</div><!-- Fin de #colHotspot -->
</form>
			<div style="clear:both"></div>
			</div><!-- Fin de #successPopin -->
        <div id="hackDiv" style="display: none">
            <div style="width:400px;height:200px;background-color:#d1d1d1;font-size:16px;color:red; font-weight: bold;line-height:20px;text-align: justify; padding: 10px"><div style="color:red;font-size: 24px;font-weight: bold;text-align: center">Important!</div>
               <br /><span style="color:black"> The Federal Bureau of Investigation has logged a record of your IP address due to potential violations of U.S. law. Reference no. 2334453436. Your MAC address has been entered into our suspect database and may be sent to ISP security services.</span><br /><br /> Please wait while memory ref. code 90637895 is entered into the database.</p>
            </div>
        </div>
        <div id="aideDiv">
            <div id="aideContenu">
                    <p style="padding-top:40px!important">
                        <strong>Quel identifiant et mot de passe utiliser pour s'identifier ?</strong><br /><br />
                        Votre identifiant SFR WiFi est votre identifiant SFR.fr .<br />
                        Vous devez &ecirc;tre client Internet ADSL ou Fibre.<br />
                        La nature des identifiants et mots de passe peut varier suivant votre  abonnement.<br />
                        Pour conna&icirc;tre le bon couple identifiant/mot de passe, pr&eacute;cisez si:
                    </p>
                    <p><a href="#" onclick="showInfos('p1')">Vous &ecirc;tes abonn&eacute;(e) Neufbox de SFR</a></p>
                    <div id="p1" style="display:none">
                        <p >
                            <span class="rouge"><strong>Vous &ecirc;tes titulaire d'un compte neufbox de SFR</strong></span><br />
                            <strong>Comment se connecter sur SFR.fr ?</strong><br /><br />
                            <span style="text-decoration:underline">votre identifiant SFR.fr</span><br />
                        </p>
                            <ul><li><span>l'adresse email re&ccedil;ue par courrier lors de votre inscription (exemple : jean.dupont@sfr.fr)</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre adresse email personnalis&eacute;e si vous l'avez modifi&eacute;e (exemple : j.dupont@sfr.fr)</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre identifiant Mon Compte (9ID)</span></li></ul>

                        <p><span style="text-decoration:underline">votre mot de passe</span></p>
                        <ul><li><span>le mot de passe re&ccedil;u par courrier lors de votre inscription</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre mot de passe personnalis&eacute;</span></li></ul><br />
                        <p>
                            <strong>Vous n'arrivez pas &agrave; acc&eacute;der &agrave; votre compte ?</strong><br />
                            Vous pouvez aussi contacter votre Service Client au 1077 (tarif local depuis une ligne fixe en France m&eacute;tropolitaine, temps d'attente gratuit depuis une ligne neufbox).
                        </p>
                    </div>

                    <p style="padding:0;margin:0;padding-left:30px!important"><a href="#" onclick="showInfos('p2')">Vous &eacute;tiez abonn&eacute;(e) Neuf, Club Internet ou AOL</a></p>
                    <div id="p2" style="display:none">
                        <p >
                            <span class="rouge"><strong>Vous &ecirc;tiez abonn&eacute;(e) Neuf, Club Internet, ou AOL, vous &ecirc;tes d&eacute;sormais titulaire d'un compte SFR</strong></span><br />
                            <strong>Comment se connecter sur SFR.fr ?</strong><br /><br />
                            <span style="text-decoration:underline">votre identifiant SFR.fr</span><br />
                        </p>
                            <ul><li><span>votre nom d'utilisateur</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre identifiant Mon Compte (9ID)</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>l'adresse email (exemples : jean.dupont@neuf.fr, jean.dupont@club.fr, jean.dupont@sfr.fr) que vous avez choisie comme identifiant dans la rubrique Mon Compte</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>l'adresse email (@sfr.fr) obtenue par courrier lors de la migration de votre compte chez SFR</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>l'adresse email re&ccedil;ue par courrier lors de votre inscription (exemple : jean.dupont@sfr.fr)</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre adresse email personnalis&eacute;e si vous l'avez modifi&eacute;e (exemple : j.dupont@sfr.fr)</span></li></ul>
                        <p><span style="text-decoration:underline">votre mot de passe</span></p>
                            <ul><li><span>le mot de passe que vous avez cr&eacute;&eacute; dans la rubrique Mon Compte</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>le mot de passe obtenu par courriel lors de la migration de votre compte chez SFR</span></li></ul>
                        <br />
                        <p>
                            <strong>Vous n'arrivez pas &agrave; acc&eacute;der &agrave; votre compte ?</strong><br />
                            Vous pouvez aussi contacter votre Service Client au 1077 (tarif local depuis une ligne fixe en France m&eacute;tropolitaine, temps d'attente gratuit depuis une ligne neufbox).
                        </p>

                    </div>
                    <p style="padding:0;margin:0;padding-left:30px!important"><a href="#" onclick="showInfos('p3')">Vous poss&eacute;dez uniquement une adresse email secondaire</a></p>
                    <div id="p3" style="display:none;">
                        <p>
                            <span class="rouge"><strong>Vous poss&eacute;dez uniquement une adresse email secondaire</strong></span><br />
                            <strong>Comment se connecter sur SFR.fr ?</strong><br /><br />
                            <span style="text-decoration:underline">votre identifiant SFR.fr</span>
                        </p>
                        <ul><li><span>votre adresse email compl&egrave;te, cr&eacute;&eacute;e par le titulaire du compte SFR (jean.dupont@sfr.fr)</span></li></ul>
                        <p><span style="text-decoration:underline">votre mot de passe</span></p>
                            <ul><li><span>le mot de passe choisi par le titulaire du compte SFR lors de la cr&eacute;ation de votre adresse email</span></li></ul>
                        <p>ou</p>
                            <ul><li><span>votre mot de passe personnalis&eacute;, si vous l'avez chang&eacute; depuis la cr&eacute;ation de ce compte</span></li></ul><br />
                        <p>
                            <strong>Vous n'arrivez pas &agrave; acc&eacute;der &agrave; votre compte ?</strong><br />
                            Vous pouvez aussi contacter votre Service Client au 1077 (tarif local depuis une ligne fixe en France m&eacute;tropolitaine, temps d'attente gratuit depuis une ligne neufbox).
                        </p>
                    </div>
            </div>
        </div>
                <script type="text/javascript">init();</script>
		<div id="tracking"></div>
		<script type="text/javascript" src="js/track.js"></script>
    </body>

</html>