<?php
echo $error;
?>
<script>
if(typeof RAR === 'undefined'){
	alert('sorry you not authorized');
}
else{
	RAR.Msg.show({
		title:d.lang.about,
		buttons: Ext.MessageBox.OK,
		msg:'<?php echo $error;?>'
	});
}
</script>