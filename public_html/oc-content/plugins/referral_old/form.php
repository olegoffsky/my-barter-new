<?php
$ref  = '';
if(Params::getParam('ref') != ''){
$ref = Params::getParam('ref');
}
?>
<input type="hidden" name="ref" value="<?php echo $ref ?>" />