<script type="text/javascript">
	let table = $('.dt').DataTable({
		"ajaxSource": "<?= site_url($url) ?>/datatable",
		"columnDefs": [{
			"targets": [],
			"orderable": false,
		}],
		"order": [
			[1, "desc"]
		],
	});

	function viewKTP(url) {
		// Create a new window or modal to display the photo
		var win = window.open(url, '_blank');
		win.focus();
	}

	
</script>