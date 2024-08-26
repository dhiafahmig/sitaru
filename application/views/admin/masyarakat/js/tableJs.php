<script type="text/javascript">
	let table = $('.dt').DataTable({
		"ajaxSource": "<?= site_url($url) ?>/datatable",
		 "columnDefs": [{
			"orderable": false,
		}],
		"order": [
			[1, "desc"]
		],
	});

	function viewKTP(url) {
		var win = window.open(url, '_blank');
		win.focus();
	}
</script>