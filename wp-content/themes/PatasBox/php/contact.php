<?php

if(isset($_REQUEST["isvalid"])){

	$youremail = "webmaster@patasbox.es";
	$email = $_POST["useremail"];
	$mailsubject = "Bienvenido a PatasBox";
	$subject = $_POST["usersubject"];

	$message =
"Nuevo registro de email para:

$email";

	$message2 =
'<html>
<head>        
    <style type="text/css">
		body,#bodyTable,#bodyCell{
			height:100% !important;
			margin:0;
			padding:0;
			width:100% !important;
		}
		table{
			border-collapse:collapse;
		}
		img,a img{
			border:0;
			outline:none;
			text-decoration:none;
		}
		h1,h2,h3,h4,h5,h6{
			margin:0;
			padding:0;
		}
		p{
			margin:1em 0;
			padding:0;
		}
		a{
			word-wrap:break-word;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
			line-height:100%;
		}
		table,td{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		body,table,td,p,a,li,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		#bodyCell{
			padding:20px;
			border-top:0;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		body,#bodyTable{
			background-color:#F2F2F2;
		}
		#bodyCell{
			border-top:0;
		}
		#templateContainer{
			border:0;
		}
		h1{
			color:#606060 !important;
			display:block;
			font-family:Helvetica;
			font-size:40px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:-1px;
			margin:0;
			text-align:left;
		}
		h2{
			color:#404040 !important;
			display:block;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:-.75px;
			margin:0;
			text-align:left;
		}
		h3{
			color:#606060 !important;
			display:block;
			font-family:Helvetica;
			font-size:18px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:-.5px;
			margin:0;
			text-align:left;
		}
		h4{
			color:#808080 !important;
			display:block;
			font-family:Helvetica;
			font-size:16px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:normal;
			margin:0;
			text-align:left;
		}
		#templatePreheader{
			background-color:#FFFFFF;
			border-top:0;
			border-bottom:0;
		}
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			color:#606060;
			font-family:Helvetica;
			font-size:11px;
			line-height:125%;
			text-align:left;
		}
		.preheaderContainer .mcnTextContent a{
			color:#606060;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateHeader{
			background-color:#FFFFFF;
			border-top:0;
			border-bottom:0;
		}
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			color:#606060;
			font-family:Helvetica;
			font-size:15px;
			line-height:150%;
			text-align:left;
		}
		.headerContainer .mcnTextContent a{
			color:#6DC6DD;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateBody{
			background-color:#FFFFFF;
			border-top:0;
			border-bottom:0;
		}
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			color:#606060;
			font-family:Helvetica;
			font-size:15px;
			line-height:150%;
			text-align:left;
		}
		.bodyContainer .mcnTextContent a{
			color:#6DC6DD;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateFooter{
			background-color:#FFFFFF;
			border-top:0;
			border-bottom:0;
		}
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			color:#606060;
			font-family:Helvetica;
			font-size:11px;
			line-height:125%;
			text-align:left;
		}
		.footerContainer .mcnTextContent a{
			color:#606060;
			font-weight:normal;
			text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[id=bodyCell]{
			padding:10px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnBoxedTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcpreview-image-uploader]{
			width:100% !important;
			display:none !important;
		}

}	@media only screen and (max-width: 480px){
		img[class=mcnImage]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnImageGroupContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageGroupContent]{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageGroupBlockInner]{
			padding-bottom:0 !important;
			padding-top:0 !important;
		}

}	@media only screen and (max-width: 480px){
		tbody[class=mcnImageGroupBlockOuter]{
			padding-bottom:9px !important;
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
			padding-right:18px !important;
			padding-left:18px !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardBottomImageContent]{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardTopImageContent]{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
			padding-right:18px !important;
			padding-left:18px !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardBottomImageContent]{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardTopImageContent]{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnBoxedTextContentColumn]{
			padding-left:18px !important;
			padding-right:18px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnTextContent]{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
		max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		h1{
			font-size:9px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		h2{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		h3{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		h4{
			font-size:16px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		table[id=templatePreheader]{
			display:block !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
			font-size:14px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
			font-size:18px !important;
			line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
			font-size:9px !important;
			line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=footerContainer] a[class=utilityLink]{
			display:block !important;
		}

}</style></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tbody>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                        <tbody><tr>
                                            <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px; font-weight: normal; line-height: 125%; text-align: left;">
                        
                            <h1>
<br>
<span style="line-height:41.5999984741211px">¡BIENVENIDO A PATASBOX!</span></h1>

<h2 class="null"><span style="line-height:41.5999984741211px">¡Nos encanta tenerte por aquí!</span></h2>

<h4 class="null"><br>
<span style="font-size:12px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">Llevamos varios meses de arriba abajo fichando y seleccionando muchas cosas para que&nbsp;<br>
por fin tu mascota y tú descubráis algo nuevo de verdad.<br>
Ahora estamos metiendo todo en 75 cajas y nos encantaría que tú fueras uno de&nbsp;<br>
los primeros en recibirlas.&nbsp;<br>
En cuanto acabemos la última de las cajas te mandaremos otro correo para que puedas&nbsp;<br>
conseguirla antes que nadie.</span></span><br>
<br>
<span style="font-size:12px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">¡Muchas gracias!</span></span></h4>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0;">
                                
                                    
                                        <img align="left" alt="PatasBox team" src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/e03a389e-a233-4756-944c-504be500a245.png" width="28" style="max-width:56px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="padding: 5px 18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 2px;border-top-style: solid;border-top-color: #999999;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
                                        <tbody><tr>
                                            <td valign="top" class="footerContainer" style="padding-bottom:9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px; font-weight: normal; line-height: 125%;">
                        
                            <h4 class="null"><span style="color:#696969"><span style="font-size:12px">PD: si tienes alguna duda, tenemos a Jarvis The Pug siempre atento para responderlas.&nbsp;<br>
Tiene cara de listo, ¿verdad? Descubre porqué lo hemos elegido en nuestro blog.</span></span></h4>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:0px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    <a href="http://htcvr.es/sandbox/7-razones-por-las-que-hemos-contratado-a-jarvis/" title="PatasBox Blog" class="" target="_blank">
                                        <img align="center" alt="Jarvis te lleva a nuestro blog" src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/4714deb5-3fff-4560-814d-7c05e9e50335.png" width="150" style="max-width:300px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    </a>
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer">
    <tbody><tr>
        <td align="center" style="padding-left:9px;padding-right:9px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContent" style="border: 1px solid #EEEEEE;background-color: #FAFAFA;">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tbody><tr>
								<td valign="top">
			                        
			                            
			                            
			                                <table align="left" border="0" cellpadding="0" cellspacing="0">
			                                    <tbody><tr>
			                                        <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
			                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
			                                                <tbody><tr>
			                                                    <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
			                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
			                                                            <tbody><tr>
			                                                                
			                                                                    <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
			                                                                        <a href="http://www.facebook.com/patasbox" target="_blank"><img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/color-facebook-48.png" style="display:block;" height="24" width="24" class=""></a>
			                                                                    </td>
			                                                                
			                                                                
			                                                                    <td align="left" valign="middle" class="mcnFollowTextContent" style="padding-left:5px;">
			                                                                        <a href="http://www.facebook.com/patasbox" target="" style="font-family: Arial;font-size: 11px;text-decoration: underline;color: #606060;font-weight: normal;line-height: 100%;text-align: center;">Facebook</a>
			                                                                    </td>
			                                                                
			                                                            </tr>
			                                                        </tbody></table>
			                                                    </td>
			                                                </tr>
			                                            </tbody></table>
			                                        </td>
			                                    </tr>
			                                </tbody></table>			                            
			                                <table align="left" border="0" cellpadding="0" cellspacing="0">
			                                    <tbody><tr>
			                                        <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
			                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
			                                                <tbody><tr>
			                                                    <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
			                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
			                                                            <tbody><tr>
			                                                                
			                                                                    <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
			                                                                        <a href="http://www.pinterest.com/patasbox" target="_blank"><img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/color-pinterest-48.png" style="display:block;" height="24" width="24" class=""></a>
			                                                                    </td>
			                                                                
			                                                                
			                                                                    <td align="left" valign="middle" class="mcnFollowTextContent" style="padding-left:5px;">
			                                                                        <a href="http://www.pinterest.com/patasbox" target="" style="font-family: Arial;font-size: 11px;text-decoration: underline;color: #606060;font-weight: normal;line-height: 100%;text-align: center;">Pinterest</a>
			                                                                    </td>
			                                                                
			                                                            </tr>
			                                                        </tbody></table>
			                                                    </td>
			                                                </tr>
			                                            </tbody></table>
			                                        </td>
			                                    </tr>
			                                </tbody></table>
			                                <table align="left" border="0" cellpadding="0" cellspacing="0">
			                                    <tbody><tr>
			                                        <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
			                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
			                                                <tbody><tr>
			                                                    <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
			                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
			                                                            <tbody><tr>
			                                                                
			                                                                    <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
			                                                                        <a href="http://instagram.com/patasbox" target="_blank"><img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/color-instagram-48.png" style="display:block;" height="24" width="24" class=""></a>
			                                                                    </td>
			                                                                
			                                                                
			                                                                    <td align="left" valign="middle" class="mcnFollowTextContent" style="padding-left:5px;">
			                                                                        <a href="http://instagram.com/patasbox" target="" style="font-family: Arial;font-size: 11px;text-decoration: underline;color: #606060;font-weight: normal;line-height: 100%;text-align: center;">Instagram</a>
			                                                                    </td>
			                                                                
			                                                            </tr>
			                                                        </tbody></table>
			                                                    </td>
			                                                </tr>
			                                            </tbody></table>
			                                        </td>
			                                    </tr>
			                                </tbody></table>
			                                <table align="left" border="0" cellpadding="0" cellspacing="0">
			                                    <tbody><tr>
			                                        <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
			                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
			                                                <tbody><tr>
			                                                    <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
			                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
			                                                            <tbody><tr>
			                                                                
			                                                                    <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
			                                                                        <a href="http://www.htcvr.es/sandbox/blog" target="_blank"><img src="http://htcvr.es/sandbox/wp-content/themes/PatasBox/img/newsletterbienvenida/color-link-48.png" style="display:block;" height="24" width="24" class=""></a>
			                                                                    </td>
			                                                                
			                                                                
			                                                                    <td align="left" valign="middle" class="mcnFollowTextContent" style="padding-left:5px;">
			                                                                        <a href="http://www.htcvr.es/sandbox/blog" target="" style="font-family: Arial;font-size: 11px;text-decoration: underline;color: #606060;font-weight: normal;line-height: 100%;text-align: center;">Blog</a>
			                                                                    </td>
			                                                                
			                                                            </tr>
			                                                        </tbody></table>
			                                                    </td>
			                                                </tr>
			                                            </tbody></table>
			                                        </td>
			                                    </tr>
			                                </tbody></table>
								</td>
							</tr>
						</tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px; font-family: Arial, &#39;Helvetica Neue&#39;, Helvetica, sans-serif; font-size: 9px; font-weight: normal; line-height: 125%; text-align: center;">
                        
                            <p>SOUSA Y CERRATO, S.L.&nbsp;C/ San Hermenegildo 21 Tercero B 28015&nbsp;- Madrid, España</p>

<p>Su dirección e-mail forma parte de los ficheros de SOUSA Y CERRATO, S.L., pudiendo ejercer en cualquier momento sus derechos de acceso, rectificación, oposición y cancelación dirigiéndose por escrito a C/ San Hermenegildo 21 Tercero B 28015&nbsp;- Madrid, España o vía e-mail a <a href="mailto:hola@patasbox.es?subject=Baja%20lista%2075%20cajas">hola@patasbox.es</a>.<br>
Si desea ponerse en contacto con nosotros, escríbanos por favor a <a href="mailto:hola@patasbox.es?subject=Hola%20PatasBox" target="_blank">hola@patasbox.es</a>.</p>

<div>Copyright 2015, Todos los derechos reservados. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>

                        </td>
                    </tr>
                </tbody></table>
                
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </center>
</body></html>';

	$headers = 'From:' . $email . "\r\n";

	$headers2  = 'MIME-Version: 1.0' . "\r\n";
	$headers2 .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers2 .= "From: PatasBox  <webmaster@patasbox.es>\r\n";
	$headers2 .= 'Reply-to: PatasBox <webmaster@patasbox.es>' . "\r\n";
	
	mail($youremail, $mailsubject, $message, $headers);
	mail($email, $mailsubject, $message2, $headers2, "-f $youremail");

	echo "success";
} else {
	echo "failed";
}