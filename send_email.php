<?php

class Email
{
  private $userContact;
  private $subject;
  private $message;
  public $report = 
  [
   'success' => true, 
   'user_feedback' =>'',
   'errors' => [],
   'old_values' => []
];

  private function validateCaptcha()
  {
     
      if(empty($_POST['recaptcha_token']))
      {
          $this->report['success'] = false;
          $this->report['errors']['recaptcha'] = 'There was a problem with the anti spam control. Make sure your browser allows using javascript and do not submit the form very quickly.';  
      }
      else
      {
         $recaptchaToken = $_POST['recaptcha_token'];
         $secretKey = "";
         $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptchaToken."&remoteip=".$_SERVER['REMOTE_ADDR']);
         
         $response = json_decode($response);

         

            if($response->success)
            {
                 if($response->score < 0.5)
                 {
                   $this->report['success'] = false;
                   $this->report['errors']['recaptcha'] = 'The spambot protection algorithm detected you as a robot.';
                 }
            }
            else
            {
               $this->report['success'] = false;
               $this->report['errors']['recaptcha'] = 'There was some unidentified problem with the anti-spam control. Please try again later.';
            }
      }

  }

  private function checkIfIsEmail($str)
  {
  	
        if(filter_var($str,FILTER_VALIDATE_EMAIL))
        {
        	$this->userContact = "Email : $str";
        	return true;
        }

        return false;
  }

  private function checkIfIsPhoneNumber($str)
  {
     $charactersToRemove = [' ', '+', '-', '.'];
     $purifiedStr = str_replace($charactersToRemove, '', $str);
     $strLength = strlen($purifiedStr);
  
          if(is_numeric($purifiedStr) and $strLength > 6 and $strLength < 16 )
          {  
            $this->userContact = "Phone number : $str";
          }
          else
          {
            $this->report['success'] = false;
            $this->report['errors']['user_contact'] = 'The contact data you have entered is neither a valid email, nor a valid phone number';
          }
     
  }

  private function validateSubject()
  {
      if(!empty($_POST['subject']))
      {
          $subject = htmlspecialchars(trim($_POST['subject'])); 
          $this->report['old_values']['subject'] = $subject;

           if(strlen($subject)> 30)
          {
      	    $this->report['success'] = false;
      	    $this->report['errors']['subject'] = "The subject exceeds 30 characters";
          }
          else
          {
            $this->subject = $subject;
          }

      }
      else
      {
        $this->subject = "No subject";
      }

      
  }

  private function validateMessage()
  {
     if(!empty($_POST['message']))
     {
        $message = htmlspecialchars(trim($_POST['message']));
        $this->report['old_values']['message'] = $message;

        if(strlen($message) > 1000)
        {
        	$this->report['success'] = false;
          $this->report['errors']['message'] = "The message exceeds 1000 characters";
        }
        else
        {
           $this->message = $message; 
        }

     }
     else
     {
       $this->report['success'] = false;
       $this->report['errors']['message'] = "The message does not exist";
     }

     
  }

  private function validateUserContact()
  {
     if(!empty($_POST['user_contact']))
     {
          $str = htmlspecialchars(trim($_POST['user_contact']));
          $this->report['old_values']['user_contact'] = $str;


          if(!$this->checkIfIsEmail($str))
          {
            $this->checkIfIsPhoneNumber($str);
          }
      
     }
     else
     {
         $this->userContact = '';
     }
  }

  public function validateInput()
  {
  	   if($_SERVER['REQUEST_METHOD'] === "POST" and isset($_POST['recaptcha_token']))
       {
          $this->validateCaptcha();
          $this->validateUserContact();
          $this->validateSubject();
          $this->validateMessage();
       }
       else
       {
         header('HTTP/1.0 403 Forbidden'); 
         die();
       }
     
  	
  }

  private function generateMessageBody()
  {
  	return $this->message.'<div>'.$this->userContact.'</div>';
  }

  public function tryToSendMessage()
  {
     if($this->report['success'] === true)
     {
       require "PHPMailer/PHPMailerAutoload.php";

	    $mail = new PHPMailer(); 
	    $mail->IsSMTP(); 
		  $mail->SMTPAuth = true; 
		  $mail->SMTPSecure = 'tls'; 
		  $mail->Host = "smtp.gmail.com";
		  $mail->Port = 587; 
		  $mail->IsHTML(true);
		  $mail->CharSet = 'UTF-8';
		  $mail->Username = "myporfoliouser@gmail.com";
		  $mail->Password = "";
		  $mail->SetFrom("myporfoliouser@gmail.com","myporfoliouser@gmail.com");
		  $mail->Subject = $this->subject;
		  $mail->Body = $this->generateMessageBody();
		  $mail->AddAddress("arturmostowiak@gmail.com");

      		if(!$mail->send())
      		{
      			 $this->report['errors']['sending'] = "The data you entered was valid however there was an unidentified problem while sending the email. Please try again later.";
            $this->report['success'] = false;
      		}

    		
	   }
  }

 
  }
 
 
    session_start();
    $email = new Email;
    $email->validateInput();
    $email->tryToSendMessage();
    $_SESSION['report'] = $email->report;
    header('Location: http://www.mostowiak.net/contact.php');
