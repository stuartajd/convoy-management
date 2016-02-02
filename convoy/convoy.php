<?php 
    require("assets/header.php"); 

	if(isset($_GET['id'])){
		$id = intval($_GET['id']);
		if(checkConvoyExists($id)){
			$user = getConvoyInfo($id, "user");
			$server = getConvoyInfo($id, "server");
			$start = getConvoyInfo($id, "location");
			$date = getConvoyInfo($id, "startdate");
			$description = stripslashes(getConvoyInfo($id, "description"));
		} else {
			header("Location: index.php");
			exit;
		}
	} else {
		header("Location: index.php");
		exit;
	}
	
?>    
<section class="container">
    <h1>Convoy</h1>
	<div style="max-width: 500px; width: auto; margin: 0 auto; text-align: justify;">
		<p><b>Convoy Creator</b> - <?php echo $user; ?></p>
		<p><b>Convoy Server</b> - <?php echo $server; ?></p>
		<p><b>Starting Location</b> - <?php echo $start; ?></p>
		<p><b>Convoy Date</b> - <?php echo $date; ?></p>
        
        <hr>
        
        <p><b>Convoy Information</b></p>
		<div id="textarea" readonly="readonly"><?php echo stripslashes($description); ?></div>
	</div>
</section>
<?php 
    require("assets/footer.php");
?>