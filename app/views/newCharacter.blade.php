@extends('layout')
@section('title', 'New Character')
@section('includes')
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

@stop
@section('script')
<script type="text/javascript">
function NewCharacterVM() {
	
}	

var viewModel = new NewCharacterVM();
ko.applyBindings(viewModel);
</script>
@stop
@section('content')

<form class="offset-main-content" method=POST action="/fatemanager/public/character/new">
	<h1>Create a New Character</h1>
	<div class="input-section-title">Information</div>
	<div class="input-section">
		<div class="input-block">
			<label>Character Name</label>
			<input type="text" name="name" class="form-input-text" />
			<p class="help-text">You can always change this later.</p>
		</div>
		<div class="input-block">
			<label>Campaign</label>
			<input type="text" name="campaign" class="form-input-text" />
		</div>
	</div>
	
	<div class="input-section-title">Settings</div>
	<div class="input-section"  id="new-character-settings-block">
		<div class="input-block">
			<label>Hidden</label>
			<input type="checkbox" name="hidden" class="form-input-checkbox" />
			<p class="help-text">Do not display this character in the campaign's active roster.</p>

		</div>
	</div>
	<input type="submit" class="form-input-submit" value="Submit" />
</form>
@stop