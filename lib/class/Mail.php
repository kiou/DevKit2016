<?php

    namespace Lib;

    /**
    * Class Mail
    */
    class Mail{

        /**
        * Envoyer un email simple en html
        * @param string le sujet de l'email
        * @param array la liste des expéditeurs
        * @param array la liste des destinataires
        * @param string le titre du mail
        * @param string le mail au format HTML
        */
        public static function sendSimpletHtml($sujet, array $from, array $to, $titre, $contenu){

            /* Fonction mail */
            $transport = \Swift_MailTransport::newInstance();

            /* Configuration du transport */
            $mailer = \Swift_Mailer::newInstance($transport);

            /* Mail contenu */
            $html = '
                <style type="text/css">
                    body{
                        width: 100%;
                        background-color: #f4f4f4;
                        margin:0px;
                        padding:0px;
                        -webkit-font-smoothing: antialiased;
                        mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px;
                    }
            
                    html{
                        width: 100%;
                    }
            
                    p,h1,h2,h3,h4,a{
                        margin-top:0;
                        margin-bottom:0;
                        padding-top:0;
                        padding-bottom:0;
                        font-family: Arial, Helvetica, sans-serif;
                    }
            
                    table{
                        border: 0;
                    }
                </style>';

                /* Header */
                $html .= '<html><body style="margin:0px; padding:0px;">
            
                    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="f4f4f4">
                        <tr><td width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                        
                        <tr>
                            <td>
                            
                                <table cellspacing="0" bgcolor="3a3f52" cellpadding="0" width="560" align="center">
                                    <tr><td colspan="3" width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                                
                                    <tr>
                                        <td width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                        <td width="560">
                                            <p style="font-size:20px; font-weight:bold; color:#ffffff">'.$titre.'</p>
                                        </td>
                                        <td width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                    </tr>
                                    
                                    <tr><td colspan="3" width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                                </table>
                                
                            </td>
                        </tr>
                        
                    </table>';

                /* Contenu */
                $html .= '<table cellspacing="0" cellpadding="0" width="100%" bgcolor="f4f4f4">
                            
                            <tr>
                                <td>
                                
                                    <table cellspacing="0" bgcolor="ffffff" cellpadding="0" width="560" align="center">
                                        <tr><td colspan="3" width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                                    
                                        <tr>
                                            <td width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                            <td width="560">
                                                <p style="font-size:13px; color:#3a3f52;">'.$contenu.'</p>
                                            </td>
                                            <td width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                        </tr>
                                        
                                        <tr><td colspan="3" width="20" height="20" style="font-size:20px; line-height:20px;">&nbsp;</td></tr>
                                    </table>
                                    
                                </td>
                            </tr>
                                
                        </table>';


            $html.='</body></html>';

            /* Envoyer l'email */
            $message = \Swift_Message::newInstance($sujet)
                ->setFrom($from)
                ->setTo($to)
                ->setBody(
                    $html,
                    'text/html'
                )
            ;

            $mailer->send($message);

        }

    }

?>
