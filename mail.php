<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to validate email address (define function before using it)
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Get the username from the form
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : 'User';
//Load Composer's autoloader (created by composer, not included with PHPMailer)
require __DIR__ . '/vendor/autoload.php';

//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

// Email address to validate
$recipientEmail = 'austin.maina@strathmore.edu';

// Validate email before proceeding
if (!isValidEmail($recipientEmail)) {
    die('Invalid email address: ' . $recipientEmail);
}

// Email address to validate
$recipientEmail = 'austin.maina@strathmore.edu';

// Validate email before proceeding
if (!isValidEmail($recipientEmail)) {
    die('Invalid email address: ' . $recipientEmail);
}

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'oscar.tanui@strathmore.edu';                     //SMTP username
    $mail->Password   = 'kwyz sfjt nblq dznr';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    if (!isValidEmail('austin.maina@strathmore.edu')) {
        die('Invalid sender email address');
    }
    $mail->setFrom('oscar.tanui@strathmore.edu', 'Oscar Tanui');
    
    if (!isValidEmail($recipientEmail)) {
        die('Invalid recipient email address');
    }
    $mail->addAddress($recipientEmail, 'Austin Ndiangui');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to ICS 2.2! Account Verification';
    $mail->Body    = '
    Hello ' . $username . ',<br><br>

    You requested and Account you need on ICS 2.2.<br><br>
    In order to use this Account you need to <a href="#">click Here</a> to complete the registration process.<br><br>

    Regards,<br>
    Systems Admin<br>
    </br> ICS 2.2';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo "<div style='text-align: center; margin-top: 50px;'>
            <h2>Success!</h2>
            <p>Verification email has been sent.</p>
            <a href='index.html'>Back to Form</a>
          </div>";
} catch (Exception $e) {
    echo "<div style='text-align: center; margin-top: 50px; color: red;'>
            <h2>Error</h2>
            <p>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>
            <a href='index.html'>Try Again</a>
          </div>";
}
} else {
    // Redirect back to the form if accessed directly
    header("Location: index.html");
    exit();
}
