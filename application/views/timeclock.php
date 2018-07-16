<div id="container">
	<h1><?php echo $this->lang->line('welcome_h1'); ?></h1>

	<div id="body">
		
        <code><?php echo $this->lang->line('welcome_message'); ?></code>
        
        <table border="0" width="100%">
        <tr>
        	<td align="center" width="40%">
            
            	<?php
                
				if ($clock_status == 1) {
					
					echo $this->lang->line('welcome_clocked_in_for')."
		            	<div id='stopwatch'></div>
						<input type='button' id='punch' class='button ui-button-danger ui-corner-all' value='".$this->lang->line('clock_out')."' />
						
					";
					
				} else {
					
					echo"<input type='button' id='punch' class='button ui-button-success ui-corner-all' value='".$this->lang->line('clock_in')."' />";
					
				}
				
				?>
                
                <br/><br/>
        
        		<span style="font-style:italic;"><?php echo $this->lang->line('last_punch'); ?>[ <b><?php echo $user->last_punch == 0 ? $this->lang->line('never') : date('m/d/Y g:i:sa', $last_punch->timestamp); ?></b> ]</span>
                
            </td>
            <td width="60%">
            
            	<?php echo $this->calendar->generate(date('Y'), date('m'), $calendar); ?>
            
            </td>
        </tr>
       	</table>
        
	</div>
	<p class="footer"><?php echo $this->lang->line('footer_render'); ?><strong>{elapsed_time}</strong><?php echo $this->lang->line('footer_copyright'); ?></p>
</div>

<script type="text/javascript">

<?php if ($clock_status == 1) { ?>

$(document).ready(function() {
	
	$("#stopwatch").stopwatch({startTime: <?php echo $punch_difference; ?>}).stopwatch('start');
	
});

<?php } ?>

$("#punch").click(function() {
	
	window.location = "<?php echo site_url(); ?>timeclock/punch/";
	
});

</script>