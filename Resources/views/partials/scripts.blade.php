<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>

@if (count($activities) > 10)
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$('.data-table').dataTable({
				"order": [[0]],
				"pageLength": 100,
				"lengthMenu": [
				[10, 25, 50, 100, 500, 1000, -1],
				[10, 25, 50, 100, 500, 1000, "All"]
				],
				"paging": false,
				"lengthChange": true,
				"searching": false,
				"ordering": true,
				"info": false,
				"autoWidth": true,
				"dom": 'T<"clear">lfrtip',
				"sPaginationType": "full_numbers",
				'aoColumnDefs': [{
					'bSortable': false,
					'searchable': false,
					'aTargets': ['no-search'],
					'bTargets': ['no-sort']
				}]
			});
		});
	</script>
@endif

<script type="text/javascript">
	$(document).on('mouseenter', "div.activity-table table > tbody > tr > td ", function () {
		var $this = $(this);
		if (this.offsetWidth < this.scrollWidth && !$this.attr('title')) {
			$this.attr('title', $this.text());
		}
	});
</script>