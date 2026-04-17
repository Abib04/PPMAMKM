<?php
                $query = "SELECT * FROM pengumuman order by id desc limit 0,2";
                $faqs = db_read($query);
                foreach($faqs as $key => $value){?>
                <?php } ?>
            <?php 
								echo "<h2>".$value['judul']."</h2>";
		    ?>
