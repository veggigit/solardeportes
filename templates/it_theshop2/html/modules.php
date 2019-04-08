<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the submenu style, you would use the following include:
 * <jdoc:include type="module" name="test" style="submenu" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */


/*
 * "general" module
 */

function modChrome_general($module, &$params, &$attribs)
{
	if ($module->content) {
		
		echo "<div class=\"general_module general_module_" . htmlspecialchars($params->get('moduleclass_sfx')). " \">";
		
		if ($module->showtitle)
		{
			echo "<h3 class=\"general_module_heading\"><span>" . $module->title . "</span></h3>";
		}
		echo $module->content;
		echo "</div>";
	}
}


function modChrome_block($module, &$params, &$attribs)
{
	if(strpos($module->title,"|") !== false){
		$titleArray = explode("|",$module->title);		
		$module->title = "";
		for($i=0;$i<count($titleArray);$i++){
			if($i){
				$module->title .= "<span>".$titleArray[$i]."</span>";
			}else{
				$module->title .= $titleArray[$i];
			}
		}		
	}
	if (!empty ($module->content)) : ?>
         
       <div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
        
			<?php if ($module->showtitle) : ?>
				<h3 class="mod-title"><?php echo $module->title; ?></h3>
			<?php endif; ?>
        	
             <div class="moduletable_content clearfix">
			 <?php echo $module->content; ?>
             </div>
                
		</div>
	<?php endif;
}


/*
 * "left" position
 */

function modChrome_sidebar($module, &$params, &$attribs)
{
	if ($module->content) {
		//echo "<div class=\"sidebar_module sidebar_module_" . htmlspecialchars($params->get('moduleclass_sfx')). " \">";
		if (empty($params->get("moduleclass_sfx"))) {
			echo "<div class=\"sidebar_module sidebar_module_ \" id = 'idmenucategorias'>";
		} else {
			echo "<div class=\"sidebar_module sidebar_module_" . htmlspecialchars($params->get('moduleclass_sfx')). " \">";
		}
		
		if ($module->showtitle)
		{
			echo "<h3 class=\"sidebar_module_heading\">" . $module->title . "</h3>";
		}
		
		echo "<div class=\"sidebar_module_content\">" . $module->content . "</div>";
		
		echo "</div>";
	}
}



/*
 * "sidebar" position
 */

function modChrome_left($module, &$params, &$attribs)
{
	if ($module->content) {
		
		echo "<div class=\"leftcol_module left_module_" . htmlspecialchars($params->get('moduleclass_sfx')). " \">";
		
		if ($module->showtitle)
		{
			echo "<h3 class=\"leftcol_module_heading\">" . $module->title . "</h3>";
		}
		echo $module->content;
		echo "</div>";
	}
}



/*
 * "iceslider" position
 */


function modChrome_slider($module, &$params, &$attribs)
{
	if ($module->content) {
		
		echo "";
		
		if ($module->showtitle)
		{
			echo "<div class=\"slider_heading\"><h3><span>" . $module->title . "</span></h3></div>";
		}
		echo $module->content;
		echo "";
	}
}




?>
