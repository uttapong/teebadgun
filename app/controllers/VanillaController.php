<?php

class VanillaController extends BaseController {

	public function index()
	{
		

		$clientID = "812583585";
		$secret = "26ab1cb40c6b113065a5a9f3d2e745ff";

		// 2. Grab the current user from your session management system or database here.
		$signedIn = Auth::user()==null?false:true; // this is just a placeholder

		// YOUR CODE HERE.

		// 3. Fill in the user information in a way that Vanilla can understand.
		//$user = array();
		$user=Auth::user();
		if ($signedIn) {
		   // CHANGE THESE FOUR LINES.
		   $userjs['uniqueid'] = $user->id;
		   $userjs['name'] = $user->username;
		   $userjs['email'] =  $user->email;
		   $userjs['photourl'] =  $user->picture;
		}
		else{
		   $userjs['name'] = "";
		   $userjs['photourl'] =  "";
		}

		// 4. Generate the jsConnect string.

		// This should be true unless you are testing. 
		// You can also use a hash name like md5, sha1 etc which must be the name as the connection settings in Vanilla.
		$secure = false; 
		$data['jsconnect']="";
		if ($signedIn) {
			$data['jsconnect']= $this::WriteJsConnect((array)$userjs, $_GET, $clientID, $secret, $secure);
		}
		//$data['jsconnect']="";
		return View::make('jsconnect',$data);
	}
	
	public  function WriteJsConnect($User, $Request, $ClientID, $Secret, $Secure = TRUE) {
   $User = array_change_key_case($User);
   
   // Error checking.
   if ($Secure) {
      // Check the client.
      if (!isset($Request['client_id']))
         $Error = array('error' => 'invalid_request', 'message' => 'The client_id parameter is missing.');
      elseif ($Request['client_id'] != $ClientID)
         $Error = array('error' => 'invalid_client', 'message' => "Unknown client {$Request['client_id']}.");
      elseif (!isset($Request['timestamp']) && !isset($Request['signature'])) {
         if (is_array($User) && count($User) > 0) {
            // This isn't really an error, but we are just going to return public information when no signature is sent.
            $Error = array('name' => $User['name'], 'photourl' => @$User['photourl']);
         } else {
            $Error = array('name' => '', 'photourl' => '');
         }
      } elseif (!isset($Request['timestamp']) || !is_numeric($Request['timestamp']))
         $Error = array('error' => 'invalid_request', 'message' => 'The timestamp parameter is missing or invalid.');
      elseif (!isset($Request['signature']))
         $Error = array('error' => 'invalid_request', 'message' => 'Missing  signature parameter.');
      elseif (($Diff = abs($Request['timestamp'] - JsTimestamp())) > JS_TIMEOUT)
         $Error = array('error' => 'invalid_request', 'message' => 'The timestamp is invalid.');
      else {
         // Make sure the timestamp hasn't timed out.
         $Signature = JsHash($Request['timestamp'].$Secret, $Secure);
         if ($Signature != $Request['signature'])
            $Error = array('error' => 'access_denied', 'message' => 'Signature invalid.');
      }
   }
   
   if (isset($Error))
      $Result = $Error;
   elseif (is_array($User) && count($User) > 0) {
      if ($Secure === NULL) {
         $Result = $User;
      } else {
         $Result = $this::SignJsConnect($User, $ClientID, $Secret, $Secure, TRUE);
      }
   } else
      $Result = array('name' => '', 'photourl' => '');
   
   $Json = json_encode($Result);
   
   if (isset($Request['callback']))
      return "{$Request['callback']}($Json)";
   else
      return $Json;
}

public  function SignJsConnect($Data, $ClientID, $Secret, $HashType, $ReturnData = FALSE) {
   $Data = array_change_key_case($Data);
   ksort($Data);

   foreach ($Data as $Key => $Value) {
      if ($Value === NULL)
         $Data[$Key] = '';
   }
   
   $String = http_build_query($Data, NULL, '&');
//   echo "$String\n";
   $Signature = $this::JsHash($String.$Secret, $HashType);
   if ($ReturnData) {
      $Data['client_id'] = $ClientID;
      $Data['signature'] = $Signature;
//      $Data['string'] = $String;
      return $Data;
   } else {
      return $Signature;
   }
}

/**
 * Return the hash of a string.
 * @param string $String The string to hash.
 * @param string|bool $Secure The hash algorithm to use. TRUE means md5.
 * @return string 
 * @since 1.1b
 */
public  function JsHash($String, $Secure = TRUE) {
   if ($Secure === TRUE)
      $Secure = 'md5';
   
   switch ($Secure) {
      case 'sha1':
         return sha1($String);
         break;
      case 'md5':
      case FALSE:
         return md5($String);
      default:
         return hash($Secure, $String);
   }
}

public  function JsTimestamp() {
   return time();
}

/**
 * Generate an SSO string suitible for passing in the url for embedded SSO.
 * 
 * @param array $User The user to sso.
 * @param string $ClientID Your client ID.
 * @param string $Secret Your secret.
 * @return string
 */
public  function JsSSOString($User, $ClientID, $Secret) {
   if (!isset($User['client_id']))
      $User['client_id'] = $ClientID;
   
   $String = base64_encode(json_encode($User));
   $Timestamp = time();
   $Hash = hash_hmac('sha1', "$String $Timestamp", $Secret);
   
   $Result = "$String $Hash $Timestamp hmacsha1";
   return $Result;
}


}

?>