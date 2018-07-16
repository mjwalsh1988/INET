<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
<?php echo $this->lang->line('welcome_h1'); ?>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php site_url('welcome'); ?>">Dashboard</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php site_url('tasks'); ?>">Task System</a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->
<div class="row">

    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-check"></i> View Active Tasks
                </div>
            </div>
            <div class="portlet-body">
            
            	<?php echo form_open('tasks'); ?>
            	<div class="text-left" style="float: left; margin-right: 10px;">
                
                <?php
                    
                    echo form_label($this->lang->line('filter_employee'), 'employee').": ";
                    echo form_dropdown('employee', $employees, $this->input->post('employee'), 'class="form-control"');
					
				?>
                
                </div>
                <div class="text-left" style="float: left; margin-right: 10px;">
                
                <?php
                    
                    echo form_label($this->lang->line('filter_status'), 'status').": ";
                    echo form_dropdown('status', $statuses, $this->input->post('status'), 'class="form-control"');
					
				?>
                
                </div>
                <div class="text-left" style="float: left;">
                
                <?php
                    
                    echo form_submit('submit', $this->lang->line('filter_submit'), 'class="btn btn-primary" style="margin-top:24px;"');
					
				?>
                
                </div>
                
                <?php echo form_close(); ?>
                
                <div class="text-right"><?php echo anchor('tasks/add', $this->lang->line('add_task'), 'class="btn btn-primary" style="float:right;"'); ?></div>
                <div class="clearfix"></div>
                <br/>
                <table class="tasks_table table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('tasks_table_title'); ?></th>
                    <th><?php echo $this->lang->line('tasks_table_status'); ?></th>
                    <th><?php echo $this->lang->line('tasks_table_assigned_to'); ?></th>
                    <th><?php echo $this->lang->line('tasks_table_author'); ?></th>
                    <th><?php echo $this->lang->line('tasks_table_timestamp'); ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                
                <?php
                
                foreach ($tasks AS $task) {
                    
                    if ($task['status'] == "Closed" && $this->input->post('status') != "4" && $this->input->post('status') != "all") continue;
                    
                    switch ($task['status']) {
                        
                        case "On Hold": $class = "label-danger"; break;
                        case "In Progress": $class = "label-success"; break;
                        case "Open": $class = "label-info"; break;
                        case "Closed": $class = "label-default"; break;
                        
                    }
                    
                    echo"
                    
                    <tr title='".substr(htmlspecialchars(strip_tags($task['content'])), 0, 50).(strlen($task['content']) > 50 ? " [...]" : "")."'>
                    
                    <td><a href='".site_url('tasks/view/'.$task['tid'])."'>".$task['title']."</a></td>
                    <td><span class='label label-sm ".$class."'>".$task['status']."</span></td>
                    <td>".implode(", ", $task['assign'])."</td>
                    <td>".$task['author']."</td>
                    <td>".date('m/d/Y h:i:sa', $task['timestamp'])."</td>
					<td width='1%' data-tid='".$task['tid']."'>
						<a class='btn btn-danger delete'>
						 <i class='fa fa-minus'></i>
						</a>
					</td>
                    
                    </tr>
                    
                    ";
                    
                }
                
                ?>
                
                </tbody>
                </table>
                
            </div>
        </div>
        <!-- END PORTLET-->
    </div>

</div>
                            
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {
	App.init(); // initlayout and core plugins
	jQuery('.delete').click(function() {
		
		var task = jQuery(this).parent();
		jQuery.post("ajax/taskDelete", {
			
			tid: task.data('tid')
			
		}, function(e) {
			
			task.parent().fadeOut();
			
		});
	   
   });
   
});
</script>
<!-- END JAVASCRIPTS -->