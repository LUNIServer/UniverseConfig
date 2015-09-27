<?php


$server = $_SERVER['SERVER_NAME'];

if (isset($_GET['t']) && isset($_GET['a'])){
	if ($_GET['t'] == "xml"){
		if ($_GET['a'] == "EnvironmentInfo"){

$string = <<<XML
<Environment xmlns="http://schemas.datacontract.org/2004/07/LEGO.Service.UniverseConfig.Core.Model" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"></Environment>
XML;

$xml = new SimpleXMLElement($string);

$acc = $xml->addChild('AccountInfo');
$acc->addChild("SendPasswordUrl", "http://" . $server . "/UniverseLauncher/index.php?page=sendPassword&amp;username=");
$acc->addChild("SignInUrl", "http://" . $server . "/UniverseLauncher/index.php");
$acc->addChild("SignUpUrl", "http://" . $server . "/UniverseLauncher/index.php?page=register");

$game = $xml->addChild('GameInfo');

$game->addChild("AuthenticationUrl", "http://" . $server . "/UniverseLauncher/UniverseAuthentification.php");
$game->addChild("ClientUrl", "http://" . $server . "/UniverseLauncher/Registration.php?username=");
$game->addChild("CrashLogUrl", "http://" . $server . "/UniverseLauncher/CrashLog.php");
$game->addChild("LauncherUrl", "http://" . $server . "/UniverseLauncher/launcher.php?launcher=1");
$game->addChild("LauncherUrl2", "http://" . $server . "/UniverseLauncher/launcher.php?launcher=1");

$patch = $xml->addChild("PatcherInfo");

$patch->addChild("CiderUrl", "http://" . $server . "/UniversePatcher/lu/luclient/cider/cider.txt");
$patch->addChild("ConfigUrl", "http://" . $server . "/UniversePatcher/lu/luclient/patcher.ini");
$patch->addChild("InstallUrl", "http://" . $server . "/UniversePatcher/lu/luclient/lego_universe_install.exe");

$universes = array();

if (file_exists("../config/data.php")){
	require_once("../config/data.php");
	if (NULL !== UNIVERSES && is_array(UNIVERSES)){
		$universes = UNIVERSES;
	}
}

if (file_exists("../config/db.php")){
	require_once("../config/db.php");
	
	$mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$mysql->set_charset("utf8");
	
	$sql = "SELECT name, address FROM universes ORDER BY id";
	$res = $mysql->query($sql);
	if ($res != NULL && $res->num_rows > 0){
		while($obj = $res->fetch_object()){
			$universes[] = array('name' => $obj->name, 'address' => $obj->address);
		}
	}
}

$serversNode = $xml->addChild('Servers');

foreach ($universes as $universe){
	$serverNode = $serversNode->addChild('Server');
	$serverNode->addChild("AuthenticationIP", $universe['address']);
	$cdn = $serverNode->addChild('CdnInfo');
	$cdn->addChild("CpCode", "89164");
	$cdn->addChild("PatcherDir", "UniversePatcher/lu/luclient");
	$cdn->addChild("PatcherUrl", $server);
	$cdn->addChild("Secure", "false");
	$cdn->addChild("UseDlm", "true");
	$crisp = $serverNode->addChild("CrispInfo");
	$crisp->addAttribute("i:nil", "true", "http://www.w3.org/2001/XMLSchema-instance");
	$serverNode->addChild("DataCenterId", "1");
	$serverNode->addChild("GameApiUrl");
	$serverNode->addChild("GameContentApiUrl");
	$serverNode->addChild("Language", "en_US");
	$serverNode->addChild("LogLevel", 100);
	$serverNode->addChild("MetricsDataServiceUrl");
	$serverNode->addChild("Name", $universe['name']);
	$serverNode->addChild("Online", "true");
	$serverNode->addChild("Suggested", "false");
	$serverNode->addChild("UGCControllerServicesUrl");
	$ugc = $serverNode->addChild("UgcCdnInfo");
	$ugc->addChild("CpCode", "89164");
	$ugc->addChild("PatcherDir", "UniversePatcher/lu/luclient");
	$ugc->addChild("PatcherUrl", $server);
	$ugc->addChild("Secure", "false");
	$ugc->addChild("UseDlm", "true");
	$serverNode->addChild("Use3DServices", "true");
	$serverNode->addChild("Version", "1.10.64");
	$serverNode->addChild("VersionDirType", "0");
	$serverNode->addChild("WebApiUrl");
}

Header('Content-type: text/xml');
print(explode("\n", $xml->asXML())[1]);
		}
		if ($_GET['a'] == "MasterIndex"){
$string = <<<XML
<MasterIndex xmlns="http://schemas.datacontract.org/2004/07/LEGO.Universe.ConfigServices.Static" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"></MasterIndex>
XML;
$xml = new SimpleXMLElement($string);

$xml->addChild("Config", "http://" . $server . "/UniverseConfig/UniverseConfig.svc");
$xml->addChild("Status", "http://" . $server . "/UniverseStatus/UniverseStatus.svc");

Header('Content-type: text/xml');
print(explode("\n", $xml->asXML())[1]);
		}
	}
}
?>