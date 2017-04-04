<?php
echo form_dropdown($name, $options, $selected, array("class"=>'form-control'));
if (!empty($loadurl)) {
?>
<script >
$(document).on("change", "select[name=<?php echo $name; ?>]", function() {
	var url = ("<?php echo $loadurl; ?>"+$(this).val());
	$("select[name=<?php echo $depended; ?>]").load(encodeURI(url));
})
</script>
<?php } ?>