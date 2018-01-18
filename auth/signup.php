<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
use Illuminate\Hashing\BcryptHasher;
use Loadwave\App\Model;
use Loadwave\App\Library;

session_start();
if( Library::verifyToken() == false )
{
    header("Location: /?error=token");
    exit;
}

date_default_timezone_set("Africa/Tunis");

$pattern = "/AF|AX|AL|DZ|AS|AD|AO|AI|AQ|AG|AR|AM|AW|AU|AT|AZ|BS|BH|BD|BB|BY|BE|BZ|BJ|BM|BT|BO|BQ|BA|BW|BV|BR|IO|BN|BG|BF|BI|KH|CM|CA|CV|KY|CF|TD|CL|CN|CX|CC|CO|KM|CG|CD|CK|CR|CI|HR|CU|CW|CY|CZ|DK|DJ|DM|DO|EC|EG|SV|GQ|ER|EE|ET|FK|FO|FJ|FI|FR|GF|PF|TF|GA|GM|GE|DE|GH|GI|GR|GL|GD|GP|GU|GT|GG|GN|GW|GY|HT|HM|VA|HN|HK|HU|IS|IN|ID|IR|IQ|IE|IM|IL|IT|JM|JP|JE|JO|KZ|KE|KI|KP|KR|KW|KG|LA|LV|LB|LS|LR|LY|LI|LT|LU|MO|MK|MG|MW|MY|MV|ML|MT|MH|MQ|MR|MU|YT|MX|FM|MD|MC|MN|ME|MS|MA|MZ|MM|NA|NR|NP|NL|NC|NZ|NI|NE|NG|NU|NF|MP|NO|OM|PK|PW|PS|PA|PG|PY|PE|PH|PN|PL|PT|PR|QA|RE|RO|RU|RW|BL|SH|KN|LC|MF|PM|VC|WS|SM|ST|SA|SN|RS|SC|SL|SG|SX|SK|SI|SB|SO|ZA|GS|SS|ES|LK|SD|SR|SJ|SZ|SE|CH|SY|TW|TJ|TZ|TH|TL|TG|TK|TO|TT|TN|TR|TM|TC|TV|UG|UA|AE|GB|US|UM|UY|UZ|VU|VE|VN|VG|VI|WF|EH|YE|ZM|ZW/";

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}

if ( 	isset($_POST['email']) && preg_match("/^[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z_+])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/", $_POST['email'])
	 && isset($_POST['username']) && (strlen($_POST['username']) >= 4)
	 && isset($_POST['password']) && (strlen($_POST['password']) >= 8)
	 && isset($_POST['firstname']) && (strlen($_POST['firstname']) >= 1)
	 && isset($_POST['lastname']) && (strlen($_POST['lastname']) >= 1)
	 && isset($_POST['gender']) && ($_POST['gender'] == "male" || $_POST['gender'] == "female")
	 && isset($_POST['country']) && preg_match($pattern, $_POST['country'])
	 &&	isset($_POST['birthday']) && (strlen($_POST['birthday']) >= 1) && validateDate($_POST['birthday'])  )
{
    $message = '<div><h1>Please, confirm your registration !</h1>';
    $message .= "<br /><h3>these are your personal information:</h3>";
    $message .= '<br /><ul style="text-align: justify"><li><strong>Email: </strong>'.$_POST["email"].'</li>
                            <li><strong>Username: </strong>'.$_POST["username"].'</li><li><strong>Password: </strong>'.$_POST["password"].'</li>
                            <li><strong>First Name: </strong>'.$_POST["firstname"].'</li><li><strong>Last Name: </strong>'.$_POST["lastname"].'</li>
                            <li><strong>Gender: </strong>'.$_POST["gender"].'</li><li><strong>Country: </strong>'.$_POST["country"].'</li>
                            <li><strong>Birthday: </strong>'.$_POST["birthday"].'</li></ul>';
    $hasher = new BcryptHasher;
    $post = array("email" => $_POST["email"], "username" => $_POST["username"], "password" => $_POST["password"], "firstname" => $_POST["firstname"],
        "lastname" => $_POST["lastname"], "gender" => $_POST["gender"], "country" => $_POST["country"], "birthday" => $_POST["birthday"]);
    $post['password'] = $hasher->make($post['password']);
    $joined_at = date("Y-m-d H:i:s");
    $hash = md5(uniqid(rand()));
    $post = array_merge($post, array('likes' => 0, 'joined_at' => $joined_at, 'hash' => $hash, 'confirmed' => 1));
	$model = new Model;
	try {
        $id = $model->setUser($post);
	} catch (PDOException $e) {
        echo $e;
        exit;
		header("Location: /?error=signup");
        exit;
	}
    // $to = $_POST["email"];
    // $subject = "Email Confirmation";
    // $confirm = "?code=".$hash."&id=$id";
    // $message .= '<br /><a href="/confirm/'.$confirm.'">Click hear to confirm</a></div>';
    // $header = "From:contact@loadwave.com\r\n";
    // $header .= "MIME-Version: 1.0\r\n";
    // $header .= "Content-type: text/html\r\n";
    // mail ($to,$subject,$message,$header);
    header("Location: /?success=signup");
 }
 else
     header("Location: /?error=generic");
