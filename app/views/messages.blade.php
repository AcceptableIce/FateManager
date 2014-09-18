@extends('layout')
@section('title', "Messages")
@section('includes')
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

@stop
@section('script')
<script type="text/javascript">
function CampaignVM() {
	var self = this;
	
	var baseUrl = "http://localhost:8888/fatemanager/public";

	self.messages = ko.observableArray([]);

}	

var viewModel = new CampaignVM();
ko.applyBindings(viewModel);
</script>
@stop
@section('content')
<div class="offset-main-content">
	<h1>Messages</h1>
	<h3 data-bind="visible: self.messages().length == 0">You don't seem to have any messages :(</h3>
</div>
@stop