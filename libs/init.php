<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(is_file("libs/config.php")){
	include 'libs/config.php';	
}else{
	include 'yourscannersux.txt';	
}
class yourscannersux{
	private function GenerateCustomForm(){
		return '
			<form method="post">
			<input type="text" hidden="hidden" name="'.$_SESSION['yourscannersux_formid'].'_id" value="'.rand(1,999).'"/>
			<input type="submit" hidden="hidden" name="'.$_SESSION['yourscannersux_formid'].'" value="submit" />
			</form>';
	}
	public function CreateForm(){
		return $this->GenerateCustomForm();
	}
	private function Taguser($vulntype){
		$_SESSION['yourscannersux_usertag'] = $_SESSION['yourscannersux_usertag'] +1;
	}
	private function Formpost($inputtext){
		$data = urldecode(strtolower($inputtext));
		$vuln = 0;
		if(strstr($data, "'") || strstr($data, "or") || strstr($data, "select") || strstr($data, "*") || strstr($data, "--")){
			$vuln=1;		
		}
		if(strstr($data, "\"") || strstr($data, "<") || strstr($data, ">")  || strstr($data, "(")){
			$vuln=2;		
		}
		if(strstr($data, "/..") || strstr($data, "/.")  || strstr($data, "passwd")){
			$vuln=3;		
		}
		if($vuln != 0){
			$this->Taguser($vuln);
		}
	}
	public function CheckIfFormPost(){
		if(isset($_POST[$_SESSION['yourscannersux_formid']])){
			$this->Formpost($_POST[$_SESSION['yourscannersux_formid']."_id"]);
		}
	}
	private function CheckUser(){
		$level = 0;
		global $risk_low;
		global $risk_medium;
		global $risk_high;
		global $warning_risk;
		global $lockout_risk;
		global $write_log;
		global $lockout_message;
		if($_SESSION['yourscannersux_usertag'] > $risk_low) $level=1;
		if($_SESSION['yourscannersux_usertag'] >= $risk_medium) $level=2;
		if($_SESSION['yourscannersux_usertag'] >= $risk_high) $level=3;
		if($warning_risk == $level && $level != 0) header("YourScannerSux: You have being tagged");
		if($lockout_risk == $level && $level != 0){
			 if($write_log) $this->logging();
			 header(' ', true, 400);
			 header("YourScannerSux: You have being blocked");
			 die($lockout_message);
		}	
	}
	private function logging(){
		global $log_directory;
		global $allow_public_log_access;
		if(!is_dir($log_directory)){
			echo $log_directory;
			mkdir($log_directory);
			if(!$allow_public_log_access) file_put_contents($log_directory."\.htaccess", "deny from all");
		}
		file_put_contents($log_directory."\\".date("y-m-d-h.i.s"). " ".$_SERVER['REMOTE_ADDR'].".txt", print_r($_SERVER, TRUE));
	}
	public function Initialise(){
		if(isset($_SESSION['yourscannersux_userid'])){
			
		}else{
			$_SESSION['yourscannersux_userid'] = md5(rand(1,999999999));
		}
		if(isset($_SESSION['yourscannersux_formid'])){
			
		}else{
			$_SESSION['yourscannersux_formid'] = md5(rand(1,999999999));
		}
		if(isset($_SESSION['yourscannersux_usertag'])){
			
		}else{
			$_SESSION['yourscannersux_usertag'] = 0;
		}
		$this->CheckIfFormPost();
		$this->CheckUser();
	}
}
?>