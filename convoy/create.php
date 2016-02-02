<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require("assets/header.php");
	
    if(!empty($_POST)){
		$user = addslashes(strip_tags($_POST['user']));
        $server = $_POST['server'];
		$start = $_POST['start'] .", ". $_POST['place'];
		$date = $_POST['date'];
		$description = strip_tags(addslashes($_POST['description']), '<p><br />');
		$convoyID = createConvoy($user, $start, $server, $date, $description);
		if($convoyID > 0){
			header("Location: convoy.php?id=". $convoyID);
			exit;
		}
        var_dump($_POST);
        die();
    }


    $locationsArray = [];
    foreach (scandir("locations") as $file) {
        $locations = json_decode(file_get_contents("locations/" . $file), true);
        foreach((array)$locations as $loc){
            $locationsArray[] = "". $loc['city'];
        }
		sort($locationsArray);
    }

    $servers = json_decode(file_get_contents("https://api.ets2mp.com/servers/"), true);

    if(!checkUserAccess($ipRestricted)){
        echo '<section class="container"><h1>Convoy Creation</h1><p class="alert-red">You do not have permission to create a convoy.</p></section>';
        require("assets/footer.php");
        die();
    }


?>
<section class="container">
    <h1>Convoy Creation</h1>
    <p style="text-align:center;">Fill in the form below to create a convoy for <?php echo $vtcName; ?></p>
    <form action="create.php" method="POST">
        <table class="createForm">
			<tr>
                <td>Display Username</td>
                <td>
                    <input name="user" type="text" placeholder="Enter in your name or username">
                </td>
            </tr>
            <tr>
                <td>Server</td>
                <td>
                    <select name="server">
                        <?php
                            foreach($servers['response'] as $serv){
                                echo '<option>'. $serv['shortname'] .'</option>';
                            } 
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Starting City</td>
                <td>
                    <select name="start">
                        <?php foreach($locationsArray as $ar){
                            echo '<option>'. $ar .'</option>';
                        }?>
                    </select>
                </td>
            </tr>
			<tr>
                <td>Starting Location</td>
                <td>
                    <select name="place">
                        <option>Hotel</option>
						<option>Repair Station</option>
						<option>Garage</option>
						<option>Truck Dealer</option>
						<option>Bus Station</option>
						<option>Dock</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date & Time</td>
                <td>
                    <input name="date" id="datetimepicker" type="text" value="<?php echo date("Y/m/d H:i"); ?>">
                </td>
            </tr>
            <tr>
                <td>Description</td>
                <td>
                    <textarea name="description" placeholder="Enter information about your convoy, rules etc."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><button type="submit" class="submitButton">Submit</button></td>
            </tr>
        </table>

    </form>
</section>
<?php require("assets/footer.php"); ?>