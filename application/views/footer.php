<script type="text/javascript">

jQuery(document).ready(function() {
	
	jQuery.fn.dataTable.moment( 'M/D/YYYY hh:mm:ss a' );
	jQuery.fn.dataTable.ext.type.detect.unshift(
		function ( d ) {
			return d === 'Open' || d === 'In Progress' || d === 'On Hold' || d === 'Closed' ? 
				'status' :
				null;
		}
	);
	jQuery.fn.dataTable.ext.type.order['status-pre'] = function ( d ) {
		switch ( d ) {
			
			case 'Open': return 1;
			case 'In Progress': return 2;
			case 'On Hold': return 3;
			case 'Closed': return 4;
			
		}
		return 0;
	};
	jQuery(".tasks_table").DataTable({
		
		"paging": false,
		"ordering": true,
		"info": true,
		"bFilter": false,
		"order": [[ 1, "desc" ],[ 4, "desc" ]]
		
	});
	
	jQuery("span.time").timeago();
	
	jQuery("li#header_notification_bar ul.dropdown-menu-list li a").hover(function() {
		
		// do something?
		
	}, function() {
		
		var notification = jQuery(this).parent();
		jQuery.post("ajax/notificationRead", {
			
			nid: jQuery(this).data('nid')
			
		}, function(e) {
			
			notification.fadeOut();
			
		}, "html");
		
	});
	
});

</script>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
	<div class="footer-inner">
		 2015 &copy; Supplement Technologies. All Rights Reserved.
	</div>
	<div class="footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
</body>
<!-- END BODY -->
</html>