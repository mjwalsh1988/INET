<!-- BEGIN PAGE HEADER-->
<h3 class="page-title"><?php echo $this->lang->line('welcome_h1'); ?></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php site_url('welcome'); ?>">Dashboard</a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<!-- BEGIN PORTLET-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bar-chart"></i>Recent Clocked Hours
							</div>
                            <div class="tools">
                            	<?php echo $latest_hours_total." total hours"; ?>
                            </div>
						</div>
						<div class="portlet-body">
							<div id="site_statistics_loading">
								<img src="assets/img/loading.gif" alt="loading"/>
							</div>
							<div id="site_statistics_content" class="display-none">
								<div id="site_statistics" class="chart">
								</div>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-clock"></i>Timeclock Quick Actions
							</div>
                            <div class="tools">
                            	<?php
								
								if ($last_punch->action == "In") {
									
									echo"<i>Clocked in for.. &nbsp; </i><div id='stopwatch'></div>";
									
								}
								
								?>
                            </div>
						</div>
						<div class="portlet-body">
							
                            <div class="text-center">
                            <?php
							
							if ($last_punch->action == "Out" || $last_punch->action == NULL) {
								
								echo"
								
								<a href='".site_url('timeclock/punch')."' class='btn btn-success'>Punch In</a>
								
								";
								
							} else if ($last_punch->action == "In") {
								
								echo"
								
								<a href='".site_url('timeclock/punch')."' class='btn btn-danger'>Punch Out</a>
								
								";
								
							}
							
							?>
                            </div>
                            
                            <br/>
                            
                            <div class="table-responsive">
                            
                            	<table class="table table-striped table-bordered table-hover">
                                
                                <thead>
                                	<tr>
                                    	<th>#</th>
                                    	<th>Punch Timestamp</th>
                                        <th>Punch Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    	<?php
										
										$i = 1;
										foreach ($latest_punches AS $punch) {
											
											echo"
											
											<tr>
												<td>".$i."</td>
												<td>".date('m/d/Y g:i:sa', $punch['timestamp'])."</td>
												<td>".$punch['action']."</td>
											</tr>
											
											";
											
											$i++;
											
										}
										
										?>
                                </tbody>
                                
                                </table>
                            
                            </div>
                            
						</div>
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-4">
					<!-- BEGIN PORTLET-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-signal"></i>Dailies Checklist Statistics
							</div>
						</div>
						<div class="portlet-body">
							<div id="dailies" class="chart"></div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
                <div class="col-md-4">
					<!-- BEGIN PORTLET-->
					<div class="portlet tasks-widget">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-check-square"></i>Dailies Checklist
							</div>
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height:300px;">
                            
                            	<ul class="task-list">
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
                                                <span class="label label-sm label-success">
												Company </span>&nbsp;
												Present 2013 Year IPO Statistics at Board Meeting </span>
												<span class="task-bell">
												<i class="fa fa-bell-o"></i>
												</span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
                                                <span class="label label-sm label-danger">
												Marketing </span>&nbsp;
												Hold An Interview for Marketing Manager Position </span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												AirAsia Intranet System Project Internal Meeting </span>
												<span class="label label-sm label-success">
												AirAsia </span>
												<span class="task-bell">
												<i class="fa fa-bell-o"></i>
												</span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												Technical Management Meeting </span>
												<span class="label label-sm label-warning">
												Company </span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												Kick-off Company CRM Mobile App Development </span>
												<span class="label label-sm label-info">
												Internal Products </span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												Prepare Commercial Offer For SmartVision Website Rewamp </span>
												<span class="label label-sm label-danger">
												Vision </span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												Sign-Off The Comercial Agreement With AutoSmart </span>
												<span class="label label-sm label-default">
												AutoSmart </span>
												<span class="task-bell">
												<i class="fa fa-bell-o"></i>
												</span>
											</div>
										</li>
										<li>
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												Company Staff Meeting </span>
												<span class="label label-sm label-success">
												Cruise </span>
												<span class="task-bell">
												<i class="fa fa-bell-o"></i>
												</span>
											</div>
										</li>
										<li class="last-line">
											<div class="task-checkbox">
												<div class="checker"><span><input type="checkbox" class="liChild" value=""></span></div>
											</div>
											<div class="task-title">
												<span class="task-title-sp">
												KeenThemes Investment Discussion </span>
												<span class="label label-sm label-warning">
												KeenThemes </span>
											</div>
										</li>
									</ul>
                            
                            </div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
                <div class="col-md-4">
					<div class="portlet tasks-widget">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-check"></i>Assigned Tasks
							</div>
						</div>
						<div class="portlet-body">
							<div class="task-content">
								<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible1="1">
									<!-- START TASK LIST -->
									<ul class="task-list">
										<li>
											<div class="task-title">
												<span class="task-title-sp">
												Company Staff Meeting </span>
												<span class="label label-sm label-success">
												In Progress </span>
												<span class="task-bell">
												<i class="fa fa-bell-o"></i>
												</span>
											</div>
										</li>
										<li class="last-line">
											<div class="task-title">
												<span class="task-title-sp">
												Example Task Title</span>
												<span class="label label-sm label-danger">
												On Hold </span>
											</div>
										</li>
									</ul>
									<!-- END START TASK LIST -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
           
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.pie.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
	App.init(); // initlayout and core plugins
	Index.init();
	Index.initCalendar(); // init index page's custom scripts
	Index.initCharts(); // init index page's custom scripts
	Index.initPeityElements();
	Index.initKnowElements();
   
   <?php if ($last_punch->action == "In") { ?>
	
	$("#stopwatch").stopwatch({startTime: <?php echo $punch_difference; ?>}).stopwatch('start');

	<?php } ?>
	
	var hours = [
		<?php
		
		$hours_end = date('Y-m-d');
		$hours_start = date('Y-m-d', strtotime('-4 days'));
		
		for ($i = 1; $i <= 5; $i++) {
			
			if (!isset($hours_current)) {
				
				$hours_current = $hours_start;
				
			}
			
			$hours = $latest_hours[$hours_current]['total'];
			
			echo"[(new Date('".date('F d, Y', strtotime($hours_current))."')).getTime(), ".($hours > 0 ? $hours : 0)."],";
			
			$hours_current = date('Y-m-d', strtotime("+1 day", strtotime($hours_current)));
			
		}
		
		?>
	];
	
	if ($('#site_statistics').size() != 0) {
	
		$('#site_statistics_loading').hide();
		$('#site_statistics_content').show();
	
		var plot_statistics = $.plot($("#site_statistics"), [{
				data: hours,
				label: "Recent Clocked Hours"
			}
		], {
			series: {
				lines: {
					show: true,
					lineWidth: 2,
					fill: true,
					fillColor: {
						colors: [{
								opacity: 0.05
							}, {
								opacity: 0.01
							}
						]
					}
				},
				points: {
					show: true
				},
				shadowSize: 2
			},
			grid: {
				hoverable: true,
				clickable: true,
				tickColor: "#eee",
				borderWidth: 0
			},
			colors: ["#d12610", "#37b7f3", "#52e136"],
			xaxis: {
				ticks: 5,
				tickDecimals: 0,
				mode: "time"
			},
			yaxis: {
				ticks: 6,
				tickDecimals: 0
			}
		});
	}  
   
});
</script>
<!-- END JAVASCRIPTS -->