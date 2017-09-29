<div class="page-header">
	<h3>Add Resource</h3>
	<hr />
</div>
<div class="container">
	<div class="row">
		<div class="col col-md-6">
			<div class="alert alert-success" role="alert">
  				<strong>Well done!</strong> You successfully added new resource.
			</div>

			<div class="alert alert-danger" role="alert">
  				<strong>Oh snap!</strong> Change a few things up and try submitting again.
			</div>
			<form>
				<div class="form-group">
					<label for="number"><code>*</code>Number</label>
					<input type="number" name="number" class="form-control" placeholder="Enter a number">
				</div>

				<div class="form-group">
					<label for="number"><code>*</code>Word</label>
					<input type="text" name="word" class="form-control" placeholder="Enter a word">
				</div>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(() => {
		// Hides alerts
		$('.alert').hide();

		// Handles number only key event
		$("input[name=number]").keypress( (e) =>  {
			return /^\d+$/i.test(e.key);
		});

		// Handles Submit Form
		$('button[type=submit]').click((e) => {
			e.preventDefault();

			let payLoad = $('form').serialize();

			$.post('/resources/insert', payLoad, (response) => {})
				.done((response) => {
					if (_.size(response.data)) {
						$('.alert-success').show();
					}
					$('input').val('');
				})
				.fail((error) => {
					$('.alert-danger').html(`<strong>Oh Snap!</strong> ${error.responseJSON.message}`);
					$('.alert-danger').show();
				})
				.always(() => {
					setTimeout(() => {
						$('.alert').fadeOut();
					}, 4000);
				});
		})
	})
</script>