<?php         
    if(file_exists("install")){
        die('<h1>Installer</h1>The installer for CMS (Convoy Management System) is still uploaded. Please either run the installer on <a href="install">/install</a> or delete this directory. <br /><br />If you were redirected here from the installer, it was successfully installed.');  
    }
	if(!file_exists("connection.php")){
		die('<h1>Installation Error</h1>The database connection for CMS (Convoy Management System) could not complete as the database information is missing. Please upload and run the installer on <a href="install">/install</a>.');
	}
    $config_ini = parse_ini_file("settings.ini", true);
    $vtcName = $config_ini['VTC']['displayName'];
    $vtcLink = $config_ini['VTC']['vtcLink'];
    $headerImage = $config_ini['DISPLAY']['headerImage'];
    $ipRestricted = $config_ini['SETTINGS']['ipOnly'];  

    require("connection.php");
    $convoys = getAllFutureConvoys();
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $vtcName; ?> - ETS2 Convoy Management System</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="create.php">Create Convoy</a></li>
                    <li><a href="<?php echo $vtcLink; ?>" target="_blank">VTC Homepage</a></li>
                </ul>
            </nav>
        </header>
        <section class="header">
            <section class="imageHeader">&nbsp;</section>
            <section class="headerText"><?php echo $vtcName; ?> - Convoy Management</section>
        </section>