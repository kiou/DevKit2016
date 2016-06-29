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
                <html><body style="margin:0px; padding:0px;">

                    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="3a3f52">
                        <tr>
                            <td>

                                <table cellspacing="0" cellpadding="0" height="80" width="600" align="center">
                                    <tr>
                                        <td width="600" height="80" colspan="2">
                                            <p style="color:#ffffff">'.$titre.'</p>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>

                    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="ffffff">

                        <tr>
                            <td>

                                <table cellspacing="0" cellpadding="0" width="600" align="center">
                                    <tr>
                                        <td width="600" height="25">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="600" colspan="2">
                                            <p style="color:#3a3f52; font-size:15px;">'.$contenu.'</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="600" height="25">&nbsp;</td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>

                </body></html>';

            /* Contenu de l'email */
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
