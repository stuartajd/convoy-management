<?php 
    require("assets/header.php"); 
?>    
<section class="container">
    <h1>Planned VTC Events</h1>

    <table class="indexTable">
        <tr>
            <th>Server</th>
            <th>Location</th> 
            <th>Organiser</th>
            <th>Date</th>
            <th></th>
        </tr>
        <?php 
        if(sizeof($convoys) > 0){
            foreach($convoys as $cv){    
                echo '
                    <tr>
                        <td>'. $cv['server'] .'</td>
                        <td>'. $cv['location'] .'</td> 
                        <td>'. $cv['user'] .'</td>
                        <td>'. date("d/m/y - H:i", strtotime($cv['startdate'])) .'</td>
                        <td><a href="convoy.php?id='. $cv['id'] .'" class="button">Info</a></td>
                    </tr>
                ';

            }
        } else {
            echo '
                <tr>
                    <td colspan="5">No Convoys To Display</td>
                </tr>
            ';
        }?>
        
        
    </table>        
</section>
<?php 
    require("assets/footer.php");
?>