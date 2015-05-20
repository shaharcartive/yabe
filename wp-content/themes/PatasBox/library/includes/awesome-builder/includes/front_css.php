
<style>
	.c5ab-col-base{
		display: block;
		<?php if(is_rtl()){ ?>
		float: right;
		<?php }else { ?>
		float: left;	
		<?php } ?>
		
		box-sizing: border-box;
		min-height:1px;
	}
	/*[c5ab-animation-data]{
		opacity: 0;
		visibility: hidden;
	}*/
	.wow{
		visibility: hidden;
	}
	.showme{
		opacity: 1;
		visibility: visible;
	}
	.c5ab-dark-mode {
		color: white;
	}
	.c5ab-align-center{
		text-align:center;
	}
	.c5ab-align-center iframe,
	.c5ab-align-center img,
	.c5ab-align-center .wp-video{
		margin: auto;
	}
	
	.c5ab-section-common{
		position: relative;
		display: block;
	}
	.c5ab-have-videobackground{
		overflow: hidden;
	}
	.c5ab-have-videobackground > .c5ab-row,
	.c5ab-have-videobackground > .entry-content{
		position: relative;
		z-index: 1;
	}
	.c5ab-center-content{
		display: block;
		margin: auto;
		position: relative;
	}
	img{
		max-width:100%;
		height: auto;
	}
	<?php
	for ($i = 1; $i <= C5BP_col_count; $i++) {
		?>.c5ab-col-lg-<?php echo $i?> { width: <?php echo ($i*100)/C5BP_col_count ?>%; }
		<?php
		
		
	}
	?>
	
	<?php if(c5ab_get_option('tablet') != 'off'){ ?>
	@media (max-width:<?php echo c5ab_get_option('tablet_width'); ?>px){
	
	.c5ab-tablet-FALSE, .c5ab-tablet-off{
		display: none !important; 	
	}
	<?php
	for ($i = 1; $i <= C5BP_col_count; $i++) {
		?>.c5ab-col-md-<?php echo $i?> { width: <?php echo ($i*100)/C5BP_col_count ?>%; }
		<?php
		
	}
	?>
	}
	<?php } ?>
	
	<?php if(c5ab_get_option('mobile') != 'off'){ ?>
	
	@media (max-width:<?php echo c5ab_get_option('mobile_width'); ?>px){
	.c5ab-tablet-FALSE, .c5ab-mobile-FALSE, .c5ab-tablet-off, .c5ab-mobile-off{
		display: none !important;	
	}
	.c5ab-mobile-TRUE,  .c5ab-mobile-on{
		display: block !important;	
	}
		
		<?php
		for ($i = 1; $i <= C5BP_col_count; $i++) {
			?>.c5ab-col-sm-<?php echo $i?> { width: <?php echo ($i*100)/C5BP_col_count ?>%; }
			<?php
			
			
		}
		?>
	}
	<?php } ?>
	
	<?php echo c5ab_get_option('custom_css'); ?>
	
</style>