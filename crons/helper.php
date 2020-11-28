<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
    
    function _sendEmail($data, $contact, $copy_email_activated)
	{
        $config = JFactory::getConfig();
        
        if ($contact->email_to == '' && $contact->user_id != 0)
        {
            $contact->email_to = 'alexandre.ama@apac.pe.gov.br';
        }

        $mailfrom = $config->get('mailfrom');
        $fromname = $config->get('fromname');
        $sitename = $config->get('sitename');

        $name    = $data['contact_name'];
        $email   = JStringPunycode::emailToPunycode($data['contact_email']);
        $subject = $data['contact_subject'];
        $body    = $data['contact_message'];

        $copytext = $body;
        $copysubject = $subject;
       
        $mail = JFactory::getMailer();
        $mail->isHtml(true);
        $mail->Encoding = 'base64';
        $mail->addRecipient($email);
        $mail->addReplyTo($email, $name);
        $mail->setSender(array($mailfrom, $fromname));
        $mail->setSubject($copysubject);
        $mail->setBody($copytext);
        
        $sent = $mail->Send();


        return $sent;
	}