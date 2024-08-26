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
</script>
