<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       MailController.php
        function:   handles api mail
 
        Last revision: 15-01-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    public function index( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
        // debug info
        $this->debug( 'MailController index' );

        // get contact vars
        $contactVars = $request->all();
        
        // debug info
        $this->debug( 'contact vars: ' . json_encode( $contactVars ) );
        
        // create result
        $mailResult = '';
        
        // get request action
        $action = $request->route()->getAction();
       
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode'] : false;
        
        // create body
        $body = "Iemand heeft het contact formulier van de website: " . env( 'APP_HOME' ) . ' ingevuld.' . '<br>' . '<br>';
        
        // loop over fields
        foreach ( $contactVars as $index => $contactVar  ) {
            
            // index ! proces id
            if( $index != 'procesId' ){
                
                // add index
                $body .= $contactVar['label'] . ': ';

                // add value
                $body .= str_replace( "\n", '<br>', $contactVar['value'] ) . '<br>';

            }
            // index ! proces id
            
        }
        // loop over fields
        
        // use wordwrap() if lines are longer than 70 characters
        $body = wordwrap( $body, 70 );

        // create result
        $mailResult = 'Send started.';
        
        $mail = new PHPMailer( true );  

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
//            $mail->isSMTP();                                      // Set mailer to use SMTP
//            $mail->Host = '37.34.58.234';                         // Specify main and backup SMTP servers
//            $mail->SMTPAuth = true;                               // Enable SMTP authentication
//            $mail->Username = 'id237';             // SMTP username
//            $mail->Password = '3ytgh4yt7yF56TRHR';       // SMTP password
//            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//           $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom( env( 'SITE_ANIMATOR_EMAIL' ), 'Website' );
            $mail->addAddress( 'borchef@gmail.com', 'Roberto' );     // Add a recipient


            // content
            $mail->isHTML( false );                               // Set email format to text
            $mail->Subject = 'Mail from the siteanimator website';
            $mail->Body    = $body;
            $mail->AltBody = $body;

            // debug info
            $this->debug( 'MailController sending' );

            $mail->send();
            
            // set result
            $mailResult = 'ok';
            
        } 
        catch (Exception $e ) {
                        // set result
            $mailResult = 'error';
        }
       
        // return result
        return array( 'result' => $mailResult, 'procesId' => $request->input('procesId') );
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        
    }
}