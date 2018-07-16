<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
<?php echo $this->lang->line('welcome_h1'); ?>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('welcome'); ?>">Dashboard</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php echo site_url('tasks'); ?>">Task System</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php echo site_url('tasks/view/'.$this->uri->segment(3)); ?>"><?php echo $task['title']; ?></a>
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
                    <i class="icon-check"></i> <?php echo $task['title']; ?>
                </div>
            </div>
            <div class="portlet-body">
            
            	<div class="row">
                
                	<div class="col-md-12">
                	<table class="table table-bordered table-striped">
                    <tbody>
                    
                    <tr>
                    	<td style="width:15%;">Task Title</td>
                        <td>
                        	<a href="#" id="title" class="editable editable-click"><?php echo $task['title']; ?></a>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td style="width:15%;">Task Status</td>
                        <td>
                        	<a href="#" id="status" class="editable editable-click"><?php echo $task['status']; ?></a>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td style="width:15%;">Task Due Date</td>
                        <td>
                        	<a href="#" id="due" class="editable editable-click"><?php echo date('m/d/Y', $task['due']); ?></a>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td style="width:15%;">Task Assigned To</td>
                        <td>
                        	<a href="#" id="assign" class="editable editable-click"><?php echo implode("<br/>", $task['assign']); ?></a>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td style="width:15%;">Task Content</td>
                        <td>
                        	<textarea class="form-control wysihtml5" id="task_content" style="height:400px;"><?php echo $task['content']; ?></textarea><br/>
                            <div class="text-right"><button id="update_content" class="btn btn-info" type="button">Update Content</button></div>
                        </td>
                    </tr>
                    
                    </tbody>
                    </table>
                    </div>
                
                </div>
            
            </div>
        </div>
    </div>
</div>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/tasks.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {

	$('#title').editable({
		url: '/ajax/taskTitle',
		type: 'text',
		pk: <?php echo $task['tid']; ?>,
		name: 'title',
		title: 'Enter task title'
	});
	
	$('#status').editable({
		url: '/ajax/taskStatus',
		type: 'select',
		value: <?php echo $task['tsid']; ?>,
		source: '/ajax/taskStatuses',
		pk: <?php echo $task['tid']; ?>,
		name: 'status',
		title: 'Choose task status'
	});
	
	$("#due").editable({
		url: '/ajax/taskDue',
		type: 'date',
		format: 'mm/dd/yyyy',
		pk: <?php echo $task['tid']; ?>,
		name: 'due',
		title: 'Select due date'
	});
	
	$("#assign").editable({
		
		url: '/ajax/taskAssign',
		type: 'checklist',
		pk: <?php echo $task['tid']; ?>,
		name: 'assign',
		title: 'Select employees to assign',
		value: '<?php echo implode(",",$task['assignid']); ?>',
		source: [
			<?php
			
			foreach ($employees AS $employee) {
				echo"{ value: ".$employee['eid'].", text: '".$employee['name_first']." ".$employee['name_last']."' },";
			}
			
			?>
		]
		
	});
	
	$(".wysihtml5").wysihtml5({
		"stylesheets": ["<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
	});
	
	$("#update_content").click(function() {
		
		$.post("/ajax/taskContent", {
			
			"tid": <?php echo $task['tid']; ?>,
			"value": $("#task_content").val()
			
		});
		
	});

});
</script>
<!-- END JAVASCRIPTS -->