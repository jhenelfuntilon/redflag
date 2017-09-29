<div class="container">
	<div class="row">
		<div class="col">
			<form class="form-inline">
				<label class="sr-only" for="inlineFormInput">Number</label>
				<input type="text" name="number" class="form-control mb-2" id="inputNumber" placeholder="Enter a number">
				<button id="btnConvertNumber" type="button" class="btn btn-primary ml-2 mb-2 mr-2">Convert</button>
				<button id="btnAddComma" type="button" class="btn btn-primary mb-2">Add Comma</button>
			</form>
			<div class="card text-center">
				<div class="card-header">
					Conversion to Word(s)
				</div>
				<div class="card-block pt-2 pb-2" style="min-height: 54px;">
					<h4 class="card-title"><converted-number></converted-number></h4>
				</div>
			</div>
		</div>
		<div class="col">
			<form class="form-inline">
				<label class="sr-only" for="inlineFormInput">Word</label>
				<input type="text" class="form-control mb-2" id="inputWord" placeholder="Enter a word">
				<button id="btnConvertWord" type="button" class="btn btn-primary mb-2 ml-2">Convert</button>
			</form>
			<div class="card text-center">
				<div class="card-header">
					Conversion to Number
				</div>
				<div class="card-block pt-2 pb-2" style="min-height: 54px;">
					<h4 class="card-title"><converted-word></converted-word></h4>
				</div>
			</div>
		</div>
	</div>
	<div class="page-header mt-5">
		<h4>Resource</h4>
	</div>
	<div class="d-flex flex-row-reverse">
		<a href="/resources/create" class="btn btn-success mb-2">Add</a>
	</div>
	
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Number</th>
				<th>Word</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($resources as $resource) : ?>
			<tr>
				<td><?= $resource->id ?></td>
				<td><?= $resource->number ?></td>
				<td><?= $resource->word ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(() => {
		// Handles initialization of Data Table
		$('table').DataTable();

		// Handles restictions for number numeric and comma only
		$("input[name=number]").keypress( (e) =>  {
			return /\d+|,+|[/b]+|-+/i.test(e.key);
		});

		// Handles Conversion for Number to Word Event
		$('#btnConvertNumber').click((e) => {
			e.preventDefault();
			const input = $('#inputNumber');
			// Perform action
			actions.convert(input.val().split(',').join(''));
			return;
		});

		// Handles Conversion for Word to Number Event
		$('#btnConvertWord').click((e) => {
			e.preventDefault();
			const input = $('#inputWord');
			// Perform action
			actions.convert(input.val(), 'number');
			return;
		});

		// Handles event for add comma
		$('#btnAddComma').click((e) => {
			e.preventDefault();
			const num = $('#inputNumber').val().split(',').join('');
			$('#inputNumber').val(actions.addComma(num));
		})
	});

	const actions = {
		/**
		 * Convert Number to words
		 * 
		 * @param {number} num
		 * @return {void}
		 */
			
		convert(wildcard, to) {
			const type = to || 'word';
			const number = type === 'word' ? parseInt(wildcard) : wildcard;
			if ( number ) {
				let params = {
					number : wildcard
				}

				if ( type !== 'word' )  {
					params = {
						word : wildcard
					}
				}

				$.get('/resources', params, (response) => {
					let conversion = '-';
					let element = type ==='word' ? 'converted-number' : 'converted-word';
					if (_.size(response.data)) {
						conversion = type === 'word' ? response.data[0].word : response.data[0].number;
					}
					$(element).html(conversion);
				})
			}
		},

		/**
		 * Add comma to number
		 *
		 * @param {number} num
		 * @return {number} formatted
		 */
		addComma(num) {
			return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
	}
</script>