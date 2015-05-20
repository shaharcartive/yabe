<?php 

class C5AB_STYLE {
	
	function __construct() {
		
	}
	
	function generate_css_keyframe($name, $start, $end) {
		$data = '@-webkit-keyframes '.$name.' {
		  0%   { '.$start.'}
		  100% { '.$end.' }
		}
		@-moz-keyframes '.$name.' {
		  0%   { '.$start.'}
		  100% { '.$end.'}
		}
		@-o-keyframes '.$name.' {
		 0%   { '.$start.'}
		 100% { '.$end.'}
		}
		@-ms-keyframes '.$name.' {
		  0%   { '.$start.'}
		  100% { '.$end.'}
		}
		@keyframes '.$name.' {
		  0%   { '.$start.' }
		  100% { '.$end.'}
		}';
		
		return $data;
	}
	function hex2rgb($hex) {
	  $hex = str_replace("#", "", $hex);
	  if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
	
	function generate_gradient($color) {
		
		$color_dark =  $this->hexDarker($color, 5);
		$data = 'background: '.$color.'; /* Old browsers */
		background: -moz-linear-gradient(top,  '.$color.' 0%,  '.$color_dark.' 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,'.$color.'), color-stop(100%,'.$color_dark.')); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  '.$color.' 0%, '.$color_dark.' 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  '.$color.' 0% ,'.$color_dark.' 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  '.$color.' 0% ,'.$color_dark.' 100%); /* IE10+ */
		background: linear-gradient(to bottom,  '.$color.' 0% ,'.$color_dark.' 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\''.$color.'\', endColorstr=\''.$color_dark.'\',GradientType=0 ); /* IE6-9 */';
		
		return $data;
	}
	
	function border_darker($color) {
		$color_dark = $this->hexDarker($color, 10);
		$data = 'border: 1px solid ' . $color_dark.';';
		return $data;
	}
	
	function hexDarker($hex,$factor = 30)
	        {
	        $new_hex = '';
	        $hex = substr($hex,1);
	        if (strlen($hex) == 3) {
	        	$hex = $hex.$hex;
	        }
	        $base['R'] = hexdec($hex{0}.$hex{1});
	        $base['G'] = hexdec($hex{2}.$hex{3});
	        $base['B'] = hexdec($hex{4}.$hex{5});
	        
	        foreach ($base as $k => $v)
	                {
	                $amount = $v / 100;
	                $amount = round($amount * $factor);
	                $new_decimal = $v - $amount;
	        
	                $new_hex_component = dechex($new_decimal);
	                if(strlen($new_hex_component) < 2)
	                        { $new_hex_component = "0".$new_hex_component; }
	                $new_hex .= $new_hex_component;
	                }
	                
	        return '#' . $new_hex;        
	        }
	     
	  
	  function hexLighter($hex,$factor = 30) 
	      { 
	      $new_hex = ''; 
	       
	      $base['R'] = hexdec($hex{0}.$hex{1}); 
	      $base['G'] = hexdec($hex{2}.$hex{3}); 
	      $base['B'] = hexdec($hex{4}.$hex{5}); 
	       
	      foreach ($base as $k => $v) 
	          { 
	          $amount = 255 - $v; 
	          $amount = $amount / 100; 
	          $amount = round($amount * $factor); 
	          $new_decimal = $v + $amount; 
	       
	          $new_hex_component = dechex($new_decimal); 
	          if(strlen($new_hex_component) < 2) 
	              { $new_hex_component = "0".$new_hex_component; } 
	          $new_hex .= $new_hex_component; 
	          } 
	           
	      return $new_hex;     
	      }
	      
	      
	      
	      function HTMLToRGB($htmlCode)
	        {
	          if($htmlCode[0] == '#')
	            $htmlCode = substr($htmlCode, 1);
	      
	          if (strlen($htmlCode) == 3)
	          {
	            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
	          }
	      
	          $r = hexdec($htmlCode[0] . $htmlCode[1]);
	          $g = hexdec($htmlCode[2] . $htmlCode[3]);
	          $b = hexdec($htmlCode[4] . $htmlCode[5]);
	      
	          return $b + ($g << 0x8) + ($r << 0x10);
	        }
	      
	      function RGBToHSL($RGB) {
	          $r = 0xFF & ($RGB >> 0x10);
	          $g = 0xFF & ($RGB >> 0x8);
	          $b = 0xFF & $RGB;
	      
	          $r = ((float)$r) / 255.0;
	          $g = ((float)$g) / 255.0;
	          $b = ((float)$b) / 255.0;
	      
	          $maxC = max($r, $g, $b);
	          $minC = min($r, $g, $b);
	      
	          $l = ($maxC + $minC) / 2.0;
	      
	          if($maxC == $minC)
	          {
	            $s = 0;
	            $h = 0;
	          }
	          else
	          {
	            if($l < .5)
	            {
	              $s = ($maxC - $minC) / ($maxC + $minC);
	            }
	            else
	            {
	              $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
	            }
	            if($r == $maxC)
	              $h = ($g - $b) / ($maxC - $minC);
	            if($g == $maxC)
	              $h = 2.0 + ($b - $r) / ($maxC - $minC);
	            if($b == $maxC)
	              $h = 4.0 + ($r - $g) / ($maxC - $minC);
	      
	            $h = $h / 6.0; 
	          }
	      
	          $h = (int)round(255.0 * $h);
	          $s = (int)round(255.0 * $s);
	          $l = (int)round(255.0 * $l);
	      
	          return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
	        }
	
}


 ?>