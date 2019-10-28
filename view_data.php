<?php 
session_start();
$classes = ['user_contact' => '', 'subject' => '', 'message' => ''];
$values = ['user_contact' => '', 'subject' => '', 'message' => ''];
$userFeedback = "";

if(isset($_SESSION['report']))
{
	$report = $_SESSION['report'];
    
    if($report['success'] === false)
    {
         $userFeedback = '<div class="user-feedback error">The following errors have occured while sending the email<ul class="error-list">';

         $errors = $report['errors'];
	     $values = $report['old_values'];
         
         if(isset($errors['sending']))
         {
            $userFeedback .= "<li>".$errors['sending']."</li>";
         }
         else
         {
             foreach($classes as $inputName => $class)
              {
             
                  if(empty($errors[$inputName]))
                  { 
                         continue;
                  }

                 $classes[$inputName] = 'has-error';
                 $userFeedback .= "<li>$errors[$inputName]</li>";
             
              }

              if(isset($errors['recaptcha']))
              {
                $userFeedback .= "<li>".$errors['recaptcha']."</li>";
              }
         }
    	     

         $userFeedback .= '</ul></div>';
    }
    else
    {
        $userFeedback = '<div class="user-feedback">Message sent successfully</div>';
    }

  }
