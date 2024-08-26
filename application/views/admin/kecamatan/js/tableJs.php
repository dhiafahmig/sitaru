<script type="text/javascript">
	// Set DataTable error mode to throw
	$.fn.dataTable.ext.errMode = 'throw';

	let table = $('.dt').DataTable({
		"ajax": "<?= site_url($url) ?>/datatable",
		"columnDefs": [{
			"targets": [0, 8],
			"orderable": false,
		}],
		"order": [
			[1, "desc"]
		],
	});
</script>