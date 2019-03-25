<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title><?php echo $title ?></title>

<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-datepicker3.min.css" />

<!-- page specific plugin styles -->

<!-- text fonts -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" />

<!-- ace styles -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

<!--[if lte IE 9]>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
<![endif]-->
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-skins.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />

<!--[if lte IE 9]>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-ie.min.css" />
<![endif]-->

<!-- inline styles related to this page -->

<!-- ace settings handler -->
<script src="<?php echo base_url()?>assets/js/ace-extra.min.js"></script>

<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

<!--[if lte IE 8]>
<script src="<?php echo base_url()?>assets/js/html5shiv.min.js"></script>
<script src="<?php echo base_url()?>assets/js/respond.min.js"></script>
<![endif]-->

 <script type="text/javascript">
            function ask_for_delete() {
                var chk = confirm('Are You Sure For Delete?');
                if (chk) {
                    return true;
                } else {
                    return false;
                }

            }
        </script>


</head>

<body class="skin-2">
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
<div class="navbar-container ace-save-state" id="navbar-container">
<div class="navbar-header pull-left">
<a href="<?php echo base_url()?>Ael_panel" class="navbar-brand">
<small>
<img class="nav-user-photo" src="<?php echo base_url()?>assets/inc/ael.png"  style="
    height: 50px;
    width: 120px;
"/>
 ADMIN PANEL
</small>
</a>

<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<img src="<?php echo base_url()?>assets/images/avatars/user.jpg"  />
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>


</div>

<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
<ul class="nav ace-nav">


<li class="light-blue dropdown-modal user-min">
<a data-toggle="dropdown" href="" class="dropdown-toggle">
<img class="nav-user-photo" src="<?php echo base_url()?>assets/inc/ael.png" />
<span class="user-info">
<small>AEL</small>
Admin
</span>

<i class="ace-icon fa fa-caret-down"></i>
</a>

<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
<li>
<a href="<?php echo base_url()?>change_password/<?php echo $admin_id?>">
<i class="ace-icon fa fa-cog"></i>
Password Change
</a>
</li>

<li>
<a href="<?php echo base_url()?>profile">
<i class="ace-icon fa fa-user"></i>
Profile
</a>
</li>

<li class="divider"></li>

<li>
<a href="<?php echo base_url()?>logout">
<i class="ace-icon fa fa-power-off"></i>
Logout
</a>
</li>
</ul>
</li>
</ul>
</div>


</div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container">
<script type="text/javascript">
try{ace.settings.loadState('main-container')}catch(e){}
</script>

<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse ace-save-state">
<script type="text/javascript">
try{ace.settings.loadState('sidebar')}catch(e){}
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">


<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
<span class="btn btn-success"></span>

<span class="btn btn-info"></span>

<span class="btn btn-warning"></span>

<span class="btn btn-danger"></span>
</div>
</div><!-- /.sidebar-shortcuts -->

<ul class="nav nav-list">


<li class="active open  hover">
<a href="<?php echo base_url()?>Ael_panel">
<i class="menu-icon fa fa-tachometer"></i>
<span class="menu-text"> Dashboard </span>
</a>

<b class="arrow"></b>
</li>


<li class="hover">
<a href="#" class="dropdown-toggle">
<i class="menu-icon fa fa-map-marker"></i>
<span class="menu-text">
Zone
</span>

<b class="arrow fa fa-angle-down"></b>
</a>

<b class="arrow"></b>

<ul class="submenu">


<li class="hover">
<a href="<?php echo base_url()?>add_zone">
<i class="menu-icon fa fa-caret-right"></i>
Add New 
</a>

<b class="arrow"></b>
</li>

<li class="hover">
<a href="<?php echo base_url()?>view_zone">
<i class="menu-icon fa fa-caret-right"></i>
View All
</a>

<b class="arrow"></b>
</li>


</ul>
</li>


<li class="hover">
<a href="#" class="dropdown-toggle">
<i class="menu-icon fa fa-desktop"></i>
<span class="menu-text">
Distributor
</span>

<b class="arrow fa fa-angle-down"></b>
</a>

<b class="arrow"></b>

<ul class="submenu">


<li class="hover">
<a href="<?php echo base_url()?>new_distributor">
<i class="menu-icon fa fa-caret-right"></i>
Add New 
</a>

<b class="arrow"></b>
</li>

<li class="hover">
<a href="<?php echo base_url()?>view_distributor">
<i class="menu-icon fa fa-caret-right"></i>
View All
</a>

<b class="arrow"></b>
</li>


</ul>
</li>









<li class="hover">
<a href="#" class="dropdown-toggle">
<i class="menu-icon fa fa-bullseye"></i>
<span class="menu-text">
Product
</span>

<b class="arrow fa fa-angle-down"></b>
</a>

<b class="arrow"></b>

<ul class="submenu">

<!-- 
<li class="hover">
<a href="<?php echo base_url()?>add_category">
<i class="menu-icon fa fa-caret-right"></i>
Add Category
</a>

<b class="arrow"></b>
</li>

<li class="hover">
<a href="<?php echo base_url()?>view_category">
<i class="menu-icon fa fa-caret-right"></i>
View Category
</a>

<b class="arrow"></b>
</li>

<hr> -->



<li class="hover">
<a href="<?php echo base_url()?>Ael_panel/add_product">
<i class="menu-icon fa fa-caret-right"></i>
Add Product 
</a>

<b class="arrow"></b>
</li>






<li class="hover">
<a href="<?php echo base_url()?>Ael_panel/view_product">
<i class="menu-icon fa fa-caret-right"></i>
Product All
</a>

<b class="arrow"></b>
</li>







</ul>
</li>













<li class="hover">
<a href="#" class="dropdown-toggle">
<i class="menu-icon fa fa-cubes"></i>
<span class="menu-text">
 Distributors Report
</span>

<b class="arrow fa fa-angle-down"></b>
</a>

<b class="arrow"></b>

<ul class="submenu">


<!-- <li class="hover">
<a href="<?php echo base_url()?>distributor_form">
<i class="menu-icon fa fa-caret-right"></i>
Distributor
</a>

<b class="arrow"></b>
</li> -->

<li class="hover">
<a href="<?php echo base_url()?>purchase_forms">
<i class="menu-icon fa fa-caret-right"></i>
Purchase
</a>

<b class="arrow"></b>
</li>




<li class="hover">
<a href="<?php echo base_url()?>stock_forms">
<i class="menu-icon fa fa-caret-right"></i>
Stock
</a>

<b class="arrow"></b>

</li>

<li class="hover">
<a href="<?php echo base_url()?>dist_sales">
<i class="menu-icon fa fa-caret-right"></i>
Sales
</a>

<b class="arrow"></b>
</li>

<li class="hover">
<a href="<?php echo base_url()?>most_saleable_product">
<i class="menu-icon fa fa-caret-right"></i>
Most Saleable Product
</a>

<b class="arrow"></b>
</li>











</ul>
</li>

<li class="hover">
<a href="<?php echo base_url()?>Admin_account">
<i class="menu-icon fa fa-building"></i>
<span class="menu-text">
Accounting Module
</span>

</a>
</li>



</ul>



</ul><!-- /.nav-list -->
</div>








<?php echo $admin_master ?>



















<div class="footer">
<div class="footer-inner">
<div class="footer-content">
<span class="bigger-120">
<span class="blue bolder">AEL</span>
 &copy; 2017
</span>

&nbsp; &nbsp;
<span class="action-buttons">
<a href="#">
<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
</a>

<a href="#">
<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
</a>

<a href="#">
<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
</a>
</span>
</div>
</div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>


<!-- basic scripts -->

<!--[if !IE]> -->
<script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="<?php echo base_url()?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!-- ace scripts -->
<script src="<?php echo base_url()?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url()?>assets/js/ace.min.js"></script>
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>

<!-- Bootstrap WYSIHTML5 -->


<!-- inline scripts related to this page -->


<!--Table Page specific plugin scripts -->
		<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/buttons.flash.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/buttons.print.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/dataTables.select.min.js"></script>




<script type="text/javascript">
jQuery(function($) {
$('#sidebar2').insertBefore('.page-content');
$('#navbar').addClass('h-navbar');
$('.footer').insertAfter('.page-content');

$('.page-content').addClass('main-content');

$('.menu-toggler[data-target="#sidebar2"]').insertBefore('.navbar-brand');


$(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
if(event_name == 'sidebar_fixed') {
if( $('#sidebar').hasClass('sidebar-fixed') ) $('#sidebar2').addClass('sidebar-fixed')
else $('#sidebar2').removeClass('sidebar-fixed')
}
}).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);

$('#sidebar2[data-sidebar-hover=true]').ace_sidebar_hover('reset');
$('#sidebar2[data-sidebar-scroll=true]').ace_sidebar_scroll('reset', true);
})
</script>



<!-- Form Page Script -->

<script>
            CKEDITOR.replace( 'editor1' );
        </script>

		<!-- End Form Page Script -->





		<!-- Table page inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				/***************/
				
				
				
				
				
				/**
				//add horizontal scrollbars to a simple table
				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
				  {
					horizontal: true,
					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
					size: 2000,
					mouseWheelLock: true
				  }
				).css('padding-top', '12px');
				*/
			
			
			})
		</script>



<script src="<?php echo base_url()?>assets/js/daterangepicker.min.js"></script>

<script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">

	$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});






</script>




</body>
</html>
