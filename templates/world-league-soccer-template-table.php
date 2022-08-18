<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>

<div class="flexcontainer">
    <div class="item laliga-jornadas extra">
        <?php _e ('Sesion','world-league-soccer'); ?> <span style="font-size:28px; font-weight:bold" class="success"><?php echo esc_attr($currentSesion)?></span>
    </div>
    <div class="item laliga-jornadas">
        <select class="form-control select select_partidos" onchange="#">
            <?php 
                for ($z=1; $z <= $maxSesion; $z++) { 
                    if ($z != $currentSesion) {
                        echo '<option value="'.esc_attr($z). '">Jornada ' . $z . '</option>';
                    } else {
                        echo '<option value="'.esc_attr($z). '" style=" font-weight:bold">Cambiar</option>';
                    }                    
                }
            ?>
        </select>
    </div>  	
</div>