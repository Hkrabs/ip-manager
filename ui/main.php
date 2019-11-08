
			<div class="col-md-9" id="page">
				<div id="content">
					<h3>Son Eklenenler</h3>
					<div class="blacklist-preview">
                        <ul></ul>
                    </div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript">
		
		$(function() {
			$.getJSON('blacklist-json.php?by_ttl&except_whitelist&limit=5', function(item) {
				$.each(item, function(i) {
					$('.blacklist-preview ul')
					.prepend('<li>' + item[i].ip_address + '</li>');
				});
			});

		});

	</script>