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
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php site_url('tasks/add'); ?>">Add New Task</a>
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
                    <i class="icon-plus"></i> Add New Task
                </div>
            </div>
            <div class="portlet-body form">
		
        		<div class="form-body">
                
					<?php
                    
                    if ($this->input->post()) {
                        
                        echo"
                        
                            <div class='note note-".($result['type'] == "success" ? "success" : "danger")."'>
                               ".$result['message']."
                            </div>
                        
                        ";
                        
                    }
					
					?>
                    
                    <?php echo form_open('tasks/add', 'class="form-horizontal"'); ?>
                        
                    <div class="form-group">
						<?php
                        
                            /* INPUT GROUP */
                            echo form_label($this->lang->line('form_title'), "title", array("class"=>"control-label col-md-3"));
                            
                        ?>
                        <div class="col-md-6">
                            <?php
                            $input = array(
                                'name'			=> 'title',
                                'id'			=> 'title',
                                'class'			=> 'form-control',
                                'placeholder'	=> $this->lang->line('form_title'),
                                'value'			=> $this->input->post('title')
                            );
                            echo form_input($input);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                    
						<?php
                        
                        /* INPUT GROUP */
                        echo form_label($this->lang->line('form_status'), "status", array("class"=>"control-label col-md-3"));
						
						?>
                        
                        <div class="col-md-6">
                        <?php echo form_dropdown('status', $statuses, $this->input->post('status'), 'class="form-control"'); ?>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        
						<?php
                            
                            /* INPUT GROUP */
                            echo form_label($this->lang->line('form_due'), "due", array("class"=>"control-label col-md-3"));
							
						?>
                        <div class="col-md-6">
                        <?php
                            $input = array(
                                'name'			=> 'due',
                                'id'			=> 'due',
                                'class'			=> 'form-control date-picker',
                                'placeholder'	=> '00/00/0000',
                                'value'			=> (strlen($this->input->post('due')) ? date('m/d/Y', $this->input->post('due')) : "")
                            );
                            echo form_input($input);
                        ?>
                        </div>
                            
                    </div>
                    <div class="form-group">
                    
						<?php
                        
                        /* INPUT GROUP */
                        echo form_label($this->lang->line('form_assign'), "assign[]", array("class"=>"control-label col-md-3"));
						?>
                        <div class="col-md-6">
                        
                        	<?php
                    		$input = "id='assign' class='multi-select'";
                    		echo form_multiselect('assign[]', $employees, $this->input->post('assign[]'), $input);
							?>
                            
                        </div>
                        
                   </div>
                   <div class="form-group">
					   <?php
                        
                        /* INPUT GROUP */
                        echo form_label($this->lang->line('form_content'), "content", array("class"=>"control-label col-md-3"));
                        ?>
                        <div class="col-md-6">
                        
                        <?php
                        $input = array(
                            'name'			=> 'content',
                            'id'			=> 'content',
                            'class'			=> 'form-control wysihtml5',
                            'placeholder'	=> $this->lang->line('form_content'),
                            'value'			=> $this->input->post('content')
                        );
                        echo form_textarea($input);
                        
                        ?>
                        </div>
                    </div>
                
                </div>
                <div class="form-actions right">
                
                	<button type="submit" class="btn btn-info">
                    	<i class="fa fa-check"></i>
                        <?php echo $this->lang->line('form_submit_add'); ?>
                    </button>
                
                	<?php echo form_close(); ?>
                
                </div>
		
        	</div>
        </div>
        <!-- END PORTLET-->
    </div>

</div>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/tasks.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-components.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   App.init(); // initlayout and core plugins
   FormComponents.init();
});
</script>
<!-- END JAVASCRIPTS -->