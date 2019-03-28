<?php
$characteristic_displayfields = $this->characteristic_displayfields;
$characteristic_fields = $this->characteristic_fields;
$characteristic_fieldvalues = $this->characteristic_fieldvalues;
$groupname = "";
?>
<?php print $this->tmp_ext_search_html_characteristic_start;?>
<?php if (is_array($characteristic_displayfields) && count($characteristic_displayfields)){?>
    <div class="filter_characteristic">
    <?php foreach($characteristic_displayfields as $ch_id){?>
        <?php if ($characteristic_fields[$ch_id]->groupname!=$groupname){ $groupname = $characteristic_fields[$ch_id]->groupname;?>
            <div class="characteristic_group"><?php print $groupname;?></div>
        <?php }?>
        <div class="characteristic_name"><?php print $characteristic_fields[$ch_id]->name;?></div>
        <?php if ($characteristic_fields[$ch_id]->type==0){?>
            <input type="hidden" name="extra_fields[<?php print $ch_id?>][]" value="0" />
            <?php if (is_array($characteristic_fieldvalues[$ch_id])){?>
                <?php foreach($characteristic_fieldvalues[$ch_id] as $val_id=>$val_name){?>
                    <div class="characteristic_val"><input type="checkbox" name="extra_fields[<?php print $ch_id?>][]" value="<?php print $val_id;?>" <?php if (is_array($extra_fields_active[$ch_id]) && in_array($val_id, $extra_fields_active[$ch_id])) print "checked";?> /> <?php print $val_name;?></div>
                <?php }?>
            <?php }?>
        <?php }else{?>
            <div class="characteristic_val"><input type="text" name="extra_fields[<?php print $ch_id?>]" class="inputbox" /></div>
        <?php }?>
    <?php }?>
    </div>
<?php } ?>
<?php print $this->tmp_ext_search_html_characteristic_end;?>