<?php
// © IceTheme 2013
// GNU General Public License


defined('_JEXEC') or die;

// A code to show the offline.php page for the demo
if (JRequest::getCmd("tmpl", "index") == "offline") {
    if (is_file(JPATH_ROOT . "/templates/" . $this->template . "/offline.php")) {
        require_once(JPATH_ROOT . "/templates/" . $this->template . "/offline.php");
    } else {
        if (is_file(JPATH_ROOT . "/templates/system/offline.php")) {
            require_once(JPATH_ROOT . "/templates/system/offline.php");
        }
    }
} else {
	
// Include Variables
include_once(JPATH_ROOT . "/templates/" . $this->template . '/icetools/vars.php');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<?php if ($this->params->get('responsive_template')) { ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php } ?>
	
    <jdoc:include type="head" />

		<?php
        // Include CSS and JS variables 
        include_once(JPATH_ROOT . "/templates/" . $this->template . '/icetools/css.php');
        ?>

</head>

<body class="<?php echo $pageclass->get('pageclass_sfx'); ?>">


<?php if ($this->params->get('styleswitcher')) { ?>
<ul id="ice-switcher">  
    <li class= "style1"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style1"><span>Style 1</span></a></li>  
    <li class= "style2"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style2"><span>Style 2</span></a></li> 
    <li class= "style3"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style3"><span>Style 3</span></a></li> 
    <li class= "style4"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style4"><span>Style 4</span></a></li> 
    <li class= "style5"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style5"><span>Style 5</span></a></li>  
    <li class= "style6"><a href="templates/<?php echo $this->template;?>/css/styles/style-switcher.php?templatestyle=style6"><span>Style 6</span></a></li>  
</ul> 
<?php } ?>

<!-- header -->
<header id="header">

	<div id="topbar">
        
		<div class="container">
            
            <div id="logo">	
            <p><a href="<?php echo $this->baseurl ?>"><?php echo $logo; ?></a></p>	
            </div>
            
			<?php if ($this->countModules('language')) { ?>
            <div id="language">  
                 <jdoc:include type="modules" name="language" />
            </div>
            <?php } ?>            
            
            <jdoc:include type="modules" name="cart" />
          
            <jdoc:include type="modules" name="mainmenu" />
            
        </div>
    
    </div>

	<?php if ($this->countModules('showcase')) { ?>
    <div id="showcase">
    
        <div class="container">
        
              <jdoc:include type="modules" style="general" name="showcase" />
        
        </div>
    
    </div>
    <?php } ?>

	<?php if ($this->countModules('icecarousel')) { ?>
    <div class="container">
    
        <div id="icecarousel" class="clearfix"> 
        
             <jdoc:include type="modules" name="icecarousel" />
            
        </div>
    
    </div>   
    <?php } ?>

    </div>
    
</header><!-- /header -->   

    <?php if ($this->countModules('search')) { ?>
    <!-- search --> 
    <div id="search">
    
        <div class="container">
        
            <jdoc:include type="modules" name="search" />
                    
        </div>
    
    </div><!-- /search --> 
    <?php } ?>
    

<!-- content -->
<section id="content">
	
    <div class="container">
    
		<?php if ($this->countModules('categories')) { ?>
            <div id="categories">
                  <jdoc:include type="modules" style="block" name="categories" />
            </div>
        <?php } ?>  
        
		<!-- columns -->
		<div id="columns" class="clearfix">
        
			<?php if ($this->countModules('sidebar')) { ?>      
            <!-- sidebar -->
            <aside id="sidebar">
            
            <div class="inside">
                <jdoc:include type="modules" name="sidebar" style="sidebar" />
			</div>
            
            </aside>
            <!-- sidebar -->
            <?php } ?>
          
            <div id="content_inner">
            
				<?php if ($this->countModules('breadcrumbs')) { ?>
                <div id="breadcrumbs" class="clearfix">
                    <jdoc:include type="modules" name="breadcrumbs" />
                </div>
                <?php } ?>            
                
                <div id="middlecol">
                
                    <div class="inside">
                        
                        <jdoc:include type="message" />
                        <jdoc:include type="component" />

                    </div>
                 
                </div>
            
            </div>

        </div><!-- /columns -->
        
        <?php if ($this->countModules('banner')) { ?>
        <!-- Banner --> 
        <section id="banner">
        
            <div class="container">
    
                    <jdoc:include type="modules" name="banner" />
 
            </div>
        
        </section><!-- /Banner --> 
        <?php } ?>

    </div>
    
</section><!-- /content -->


<!-- promo --> 
<?php if ($this->countModules('promo1 + promo2 + promo3 + promo4 + slider')) { ?>
<section id="promo">
	
    <div class="container">
    		
		<?php if ($this->countModules('slider')) { ?>
        <div id="slider"> 
            <jdoc:include type="modules" name="slider" style="slider" />
        </div>   
        <?php } ?>
    
   		<?php if ($this->countModules('promo1 + promo2 + promo3 + promo4')) { ?>
    	<div class="row">
            
			<?php if ($this->countModules('promo1')) { ?>
            <div class="<?php echo $promospan;?>">	
                <jdoc:include type="modules" name="promo1" style="block" />
            </div> 
            <?php } ?>
            
            <?php if ($this->countModules('promo2')) { ?>
            <div class="<?php echo $promospan;?>">	
                <jdoc:include type="modules" name="promo2" style="block" />
            </div> 
            <?php } ?>
            
            <?php if ($this->countModules('promo3')) { ?>
            <div class="<?php echo $promospan;?>">	
                <jdoc:include type="modules" name="promo3" style="block" />
            </div> 
            <?php } ?>
            
            <?php if ($this->countModules('promo4')) { ?>
            <div class="<?php echo $promospan;?>">	
                <jdoc:include type="modules" name="promo4" style="block" />
            </div> 
            <?php } ?>
            
        </div>
        <?php } ?>
        
	</div>
   
</section>
 <?php } ?>
<!-- /promo --> 



	<?php if ($this->countModules('testimonials')) { ?>
    <!-- testimonials --> 
    <div id="testimonials">
    
        <div class="container">
        
      		  <jdoc:include type="modules" name="testimonials" />
       
        </div>
        
    </div><!-- /testimonials --> 
    <?php } ?>


	


<!-- footer -->
<footer id="footer">
    
	<div class="container">
    
		<?php if ($this->countModules('footer1 + footer2 + footer3 + footer4')) { ?>
		<div id="footermods" class="row">
       	
        	<?php if ($this->countModules('footer1')) { ?>
            <div class="<?php echo $footerspan;?>">	
                <jdoc:include type="modules" name="footer1" style="block" />
            </div> 
            <?php } ?> 
            
            <?php if ($this->countModules('footer2')) { ?>
            <div class="<?php echo $footerspan;?>">	
                <jdoc:include type="modules" name="footer2" style="block" />
            </div> 
            <?php } ?> 
            
            <?php if ($this->countModules('footer3')) { ?>
            <div class="<?php echo $footerspan;?>">	
                <jdoc:include type="modules" name="footer3" style="block" />
            </div> 
            <?php } ?> 
            
            <?php if ($this->countModules('footer4')) { ?>
            <div class="<?php echo $footerspan;?>">	
                <jdoc:include type="modules" name="footer4" style="block" />
            </div>
            <?php } ?>  
            
        </div>
        <?php } ?> 
        
         <!-- copyright -->    
        <div id="copyright_area" class="clearfix">
        
           	<?php if 
            ($this->params->get('social_icon_fb') or  
             $this->params->get('social_icon_tw') or
			 $this->params->get('social_icon_yt')) 
            { ?>
            <div id="social_icons">
               <ul>
                
                  <?php if($this->params->get('social_icon_fb')) { ?>
                  <li class="social_facebook">
                  <a target="_blank" rel="tooltip" data-placement="top" title="Like <?php echo $social_fb_user; ?> on Facebook" href="http://www.facebook.com/<?php echo $social_fb_user; ?>"><span>Facebook</span></a>			                     
                  </li>				
                  <?php } ?>	
                  
                  <?php if($this->params->get('social_icon_tw')) { ?>
                  <li class="social_twitter">
                  <a target="_blank" rel="tooltip" data-placement="top" title="Follow us on Twitter" href="http://www.twitter.com/<?php echo $social_tw_user; ?>" ><span>Twitter</span></a>
                  </li>
                  <?php } ?>
                 
                 <?php if($this->params->get('social_icon_yt')) { ?>
                  <li class="social_youtube">
                  <a target="_blank" rel="tooltip" data-placement="top" title="Subscribe on YouTube" href="http://www.youtube.com/<?php echo $social_yt_user; ?>"><span>Youtube</span></a>			                     
                  </li>				
                  <?php } ?>
                 
                 
                </ul>

            </div>
            <?php } ?>
            
            <p id="copyright">&copy; <?php echo date('Y');?> <?php echo $sitename; ?> </p>
            
			<?php if ($this->countModules('copyrightmenu')) { ?>
            <div id="copyrightmenu">
                <jdoc:include type="modules" name="copyrightmenu" />
            </div>
            <?php } ?> 
            
            <?php if ($this->params->get('go2top')) { ?>
            <a href="#" class="scrollup"><?php echo JText::_('TPL_TPL_FIELD_SCROLL'); ?></a>
            <?php } ?>


        
        </div><!-- copyright --> 
    
             
	</div>
       
    
</footer><!-- footer -->  

<?php if ($this->params->get('styleswitcher')) { ?> 
<script type="text/javascript">  

jQuery.fn.styleSwitcher = function(){
	jQuery(this).click(function(){
		loadStyleSheet(this);
		return false;
	});
	function loadStyleSheet(obj) {
		jQuery('body').append('<div id="overlay" />');
		jQuery('body').css({height:'100%'});
		jQuery('#overlay')
			.fadeIn(500,function(){
				jQuery.get( obj.href+'&js',function(data){
					jQuery('#stylesheet').attr('href','<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/css/styles/' + data + '.css');
					cssDummy.check(function(){
						jQuery('#overlay').fadeOut(1000,function(){
							jQuery(this).remove();
						});	
					});
				});
			});
	}
	var cssDummy = {
		init: function(){
			jQuery('<div id="dummy-element" style="display:none" />').appendTo('body');
		},
		check: function(callback) {
			if (jQuery('#dummy-element').width()==2) callback();
			else setTimeout(function(){cssDummy.check(callback)}, 200);
		}
	}
	

	cssDummy.init();
}


	jQuery('.ice-template-style a').styleSwitcher(); 
	jQuery('#ice-switcher a').styleSwitcher(); 
	

</script>  
<?php } ?>


<?php if ($this->params->get('google_analytics')) { ?>
<!-- Google Analytics -->  
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $this->params->get('analytics_code');; ?>']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
<!-- Google Analytics -->  
<?php } ?>


<?php if ($this->countModules('testimonials')) {
$document->addScript('templates/' . $this->template . '/js/jquery.flexslider-min.js');
$document->addStyleSheet('templates/' . $app->getTemplate(). '/css/flexslider.css');
?>
	<script type="text/javascript">
    // Can also be used with $(document).ready()
    jQuery(window).load(function() {
        jQuery('.icetestimonials').flexslider({
		selector: ".slides > div",
        animation: "slide",
        slideshow: false,
        animationLoop: true,
        directionNav: true,  
        controlNav: true, 
        direction: "horizontal",
		randomize: false
    });
    });
    </script>
<?php } ?>


<?php if ($this->params->get('equal_column')) { ?>
<script type="text/javascript">
/* Start Equal Columns Function */
var myLeftColumn = document.getElementById("sidebar"); /* Column Name*/
var myRightColumn = document.getElementById("content_inner"); /* Column Name*/
</script>   
<?php } ?>


</body>
</html>
<?php } ?>
