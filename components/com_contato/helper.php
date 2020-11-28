<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
    
    function _sendEmail($data, $contact, $copy_email_activated)
	{
			$app = JFactory::getApplication();

			if ($contact->email_to == '' && $contact->user_id != 0)
			{
				$contact_user      = JUser::getInstance($contact->user_id);
				$contact->email_to = $contact_user->get('email');
			}

			$mailfrom = $app->get('mailfrom');
			$fromname = $app->get('fromname');
			$sitename = $app->get('sitename');

			$name    = $data['contact_name'];
			$email   = JStringPunycode::emailToPunycode($data['contact_email']);
			$subject = $data['contact_subject'];
			$body    = $data['contact_message'];

			// Prepare email body
			$prefix = JText::sprintf('APAC - ', JUri::base());
			$body   = $prefix . "\n" . $name . ' <' . $email . '>' . "\r\n\r\n" . stripslashes($body);

			/*$mail = JFactory::getMailer();
			$mail->addRecipient($contact->email_to);
			$mail->addReplyTo($email, $name);
			$mail->setSender(array($mailfrom, $fromname));
			$mail->setSubject($sitename . ': ' . $subject);
			$mail->setBody($body);
			$sent = $mail->Send();*/

			// If we are supposed to copy the sender, do so.

			// Check whether email copy function activated
			//if ($copy_email_activated == true && !empty($data['contact_email_copy']))
			//{
				$copytext    = JText::sprintf('Mensagem', $contact->name, $sitename);
				$copytext    .= "\r\n\r\n" . $body;
				$copysubject = JText::sprintf('Assunto', $subject);

				$mail = JFactory::getMailer();
				$mail->addRecipient($email);
				$mail->addReplyTo($email, $name);
				$mail->setSender(array($mailfrom, $fromname));
				$mail->setSubject($copysubject);
				$mail->setBody($copytext);
				$sent = $mail->Send();
			//}

			return $sent;
	}