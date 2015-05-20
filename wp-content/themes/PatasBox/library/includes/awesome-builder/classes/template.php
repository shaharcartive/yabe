<?php 

class C5PB_TEMPLATE extends C5PB_BASE{

	public $post_id;

	function __construct() {
		$this->hook();
	}
	function hook() {
		
		
	}
	
	
	
	
	
	
	function layout_css() {
		
		?>
		<style>
		.c5ab-ruler-single{
			width: <?php echo 100/C5BP_col_count; ?>%;
		}
		<?php
		
		for ($i = 1; $i <= C5BP_col_count; $i++) {
			?>
			.c5ab-grid-<?php echo $i?>{
				left: <?php echo ($i*100)/C5BP_col_count ?>%;
			}
			
			.c5ab_col_<?php echo $i?> { width: <?php echo ($i*100)/C5BP_col_count ?>%; }
			<?php
			
			/*for ($sub_i = 1; $sub_i <= C5BP_col_count; $sub_i++) {
				$value = round($sub_i*$i/C5BP_col_count);
				if($value == 0){
					$value =1;
				}
				?>.c5ab_col_<?php echo $i?>  .c5ab_col_<?php echo $sub_i?> { width: <?php echo ($value*100)/$i ?>%; }
				<?php
			}*/
		}
		?>
		</style>
		<?php 
	}
	
	function presets() {
		$presets= array(
			array(
				'class'=>'12',
				'icon'=> 'c5abf-full',
				'title'=> '1/1'
			),
			array(
				'class'=>'6_6',
				'icon'=> 'c5abf-half',
				'title'=> '1/2 - 1/2'
			),
			array(
				'class'=>'4_4_4',
				'icon'=> 'c5abf-third',
				'title'=> '1/3 - 1/3 - 1/3'
			),
			array(
				'class'=>'3_3_3_3',
				'icon'=> 'c5abf-quarter',
				'title'=> '1/4 - 1/4 - 1/4 - 1/4'
			),
			
			
			array(
				'class'=>'4_8',
				'icon'=> 'c5abf-1o3-2o3---copy',
				'title'=> '1/3 - 2/3'
			),
			array(
				'class'=>'8_4',
				'icon'=> 'c5abf-2o3-1o3',
				'title'=> '2/3 - 1/3'
			),
			array(
				'class'=>'3_9',
				'icon'=> 'c5abf-1o4-3o4',
				'title'=> '1/4 - 3/4'
			),
			array(
				'class'=>'9_3',
				'icon'=> 'c5abf-3o4-1o4',
				'title'=> '3/4 - 1/4'
			),
			
			
			array(
				'class'=>'3_6_3',
				'icon'=> 'c5abf-1o4-1o2-1o4',
				'title'=> '1/4 - 1/2 - 1/4'
			),
			
			array(
				'class'=>'3_3_6',
				'icon'=> 'c5abf-1o4-1o4-1o2',
				'title'=> '1/4 - 1/4 - 1/2'
			),
			
			array(
				'class'=>'6_3_3',
				'icon'=> 'c5abf-1o2-1o4-1o4',
				'title'=> '1/2 - 1/4 - 1/4'
			),
			
			array(
				'class'=>'2_2_2_2_2_2',
				'icon'=> 'c5abf-1o6',
				'title'=> '1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6'
			)
		);
		
		foreach ($presets as $preset) {
			$classes = explode('_' , $preset['class']);
			$new_classes = array();
			$bool = true;
			foreach ($classes as $value) {
				$value_new = $value/12*C5BP_col_count;
				$whole = floor($value_new);      // 1
				$fraction = $value_new - $whole;
				$new_classes[] = $value_new;
				
				if($fraction != 0){
					$bool= false;
					break;
				}
			}
			if($bool){
				echo '<span class="c5ab_preset_'.$preset['class'].' '.$preset['icon'].' c5ab-full-i" title="'.$preset['title'].'" data-columns="'.implode('_', $new_classes).'"></span>';
			}
		}		
	}
	
	function ruler() {
		
		?>
		<div class="c5ab-ruler-wrap">
			<?php 
			for ($i = 1; $i <= C5BP_col_count; $i++) {
				$number = $i;
				if($i<10){
					$number = '0' . $i;
				}
				$span = '<span class="number">'. $number .'</span>';
				
				?>
				<div class="c5ab-ruler-<?php echo $i ?> c5ab-ruler-single"><div class="c5ab-ruler-inner" ><?php echo $span ?></div></div>
				<?php
			}
			 ?>
		</div>
		<?php
	}
	function grid() {
	
	?>
		<div class="c5ab-bg-wrap c5ab-grid">
			<div class="c5ab-grid-row">
				<?php 
				for ($i = 0; $i <= C5BP_col_count; $i++) {
					?>
					<div class="c5ab-grid-<?php echo $i ?> c5ab-grid-single"></div>
					<?php
				}
				 ?>
			
			</div>
		</div>
	<?php
		
	}
	
	

}
 ?>