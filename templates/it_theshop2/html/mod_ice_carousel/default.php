<?php
/**
 * IceAccordion Extension for Joomla 3.0 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/iceaccordion.html
 * @Support 	http://www.icetheme.com/Forums/IceCarousel/
 *
 */
 

/* no direct access*/
defined('_JEXEC') or die;
?>
<div id="icecarousel<?php echo $module->id;?>" class="icecarousel carousel slide <?php echo $effect ;?> desc_opacity">
        <div class="carousel-inner">
			<?php
				foreach($list as $key=>$item){
					$activeclass = "";
					if($key == 0){
						$activeclass = "active";
					}
					?>
					<div class="item <?php echo $activeclass; ?>">
					
					<?php if ($params->get('link_titles') == 1) : ?>
						<a class="carousel-image" href="javascript:void(0)">  	
						<?php if($item->mainImage): ?>
							<?php echo $item->mainImage; ?>
						<?php endif; ?>
						</a>
					 <?php
						else:
								 echo $item->mainImage;
						endif;
					  ?>	
						
						<?php if($params->get("display_caption", 1)): ?>	
						
							<div class="carousel-caption">
							
							  <h4>
							  <?php if ($params->get('link_titles') == 1) : ?>
								<?php echo $item->title; ?>
							  <?php
								else:
									echo $item->title;
								endif;
							  ?>
							  </h4>
								  <div class="mod-ice-carousel-description">

										<p><?php echo $item->displayIntrotext; ?></p>

								  </div>
								
							  <?php if ($params->get('show_readmore')) :?>
								<p class="mod-articles-category-readmore">
									<a class="mod-articles-category-title" href="<?php echo $item->link; ?>">
									<?php 
											echo JText::_('MOD_CAROSUEL_READ_MORE');
									?>
								</a>
								</p>
								
							  <?php endif; ?>
							  
							</div>
							
						<?php	endif; ?>
						
					  </div>
                      
					<?php
				}
				
			?>
        </div><!-- .carousel-inner -->

<!--  Navigation Bullets -->     
<?php if($params->get("display_bullets", 1)): ?>        
<ul class="carousel-nav">        
<?php $uniqueNo= -1; $uniqtitle= -1; ?>   
<?php foreach($list as $key=>$item){ $activeclass = "";
if($key == 0){
	$activeclass = "active";
}
?>
<li><a href="#" data-to="<?php echo $uniqueNo+=1; ?>" class="<?php echo $activeclass; ?>"><span><?php echo $uniqtitle+=1; ?></span></a></li>
<?php } ?>
</ul>
<?php endif; ?>

<!--  next and previous controls here
  href values must reference the id for this carousel -->        
<?php if($params->get("display_arrows", 1)): ?>
<a class="carousel-control left" href="#icecarousel<?php echo $module->id;?>" data-slide="prev">&lsaquo;</a>
<a class="carousel-control right" href="#icecarousel<?php echo $module->id;?>" data-slide="next">&rsaquo;</a>
<?php endif; ?>

</div>
<!-- .carousel -->
<!-- end carousel -->

<?php if($params->get("display_bullets", 1)): ?>
<script type="text/javascript">
	
  jQuery(window).load(function() {
		var $carousel = jQuery('#icecarousel<?php echo $module->id;?>');
		var index = 0;
		/**
		var currentElement = null;
		$('#icecarousel<?php echo $module->id;?>').find(".carousel-caption").each(function(idx){
			$(this).hide();
			if(idx == index){
				currentElement = this;
			}
		});
		*/
		function onSliding(){
			var elements = 4; // change to the number of elements in your nav
			  var nav = jQuery('.carousel-nav');
			  var index = jQuery('#icecarousel<?php echo $module->id;?>').find('.item.active').index();
			  index = (index == elements - 1) ? 0 : index + 1;
			  var currentElement = null;
			  jQuery('#icecarousel<?php echo $module->id;?>').find(".carousel-caption").each(function(idx){
					if(idx == index){
						currentElement = this;
					}
				});
			  var item = nav.find('a').get(index);
			  nav.find('a.active').removeClass('active');
			  jQuery(item).addClass('active');
			  
			  if(currentElement){
					jQuery(currentElement).slideUp(200).delay(600).fadeIn(600);
				}
		}
		jQuery('#icecarousel<?php echo $module->id;?>').carousel(index);
		var nav = jQuery('.carousel-nav');
		var item = nav.find('a').get(index);
		nav.find('a.active').removeClass('active');
		jQuery(item).addClass('active');
		/**
		if(currentElement){
			$(currentElement).slideUp(200).delay(600).fadeIn(600);
		}
       */
		
        jQuery(".carousel-nav a").click(function(e){
			e.preventDefault();
			jQuery("#icecarousel<?php echo $module->id;?>").unbind('slide');
            var index = parseInt(jQuery(this).attr('data-to'));
			
			
			var currentElement = null;
			jQuery('#icecarousel<?php echo $module->id;?>').find(".carousel-caption").each(function(idx){
				jQuery(this).hide();
				if(idx == index){
					currentElement = this;
				}
			});
            
            jQuery('#icecarousel<?php echo $module->id;?>').carousel(index);
            var nav = jQuery('.carousel-nav');
            var item = nav.find('a').get(index);
            nav.find('a.active').removeClass('active');
            jQuery(item).addClass('active');
			
			if(currentElement){
			
				jQuery(currentElement).slideUp(200).delay(600).fadeIn(600);
				
			}
			jQuery("#icecarousel<?php echo $module->id;?>").bind('slide', function(e) {
				onSliding();
			});
        });

        jQuery("#icecarousel<?php echo $module->id;?>").bind('slide', function(e) {
			onSliding();
        });
		
  });
</script>
<?php endif; ?>
