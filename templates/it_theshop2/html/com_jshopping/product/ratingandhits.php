<?php if ($this->allow_review || $this->config->show_hits){?>
<div style="height:22px;">
<table align="right">
<tr>
    <?php if ($this->config->show_hits){?>
    <td><?php print _JSHOP_HITS?>: </td>
    <td><?php print $this->product->hits;?></td>
    <?php } ?>
    
    <?php if ($this->allow_review && $this->config->show_hits){?>
    <td> | </td>
    <?php } ?>
    
    <?php if ($this->allow_review){?>
    <td><?php print _JSHOP_RATING?>: </td>
    <td>
    <?php print showMarkStar($this->product->average_rating);?>                    
    </td>
    <?php } ?>
</tr>
</table>
</div>
<?php } ?>