@extends('layout')
@section('title', $campaign->name)
@section('includes')
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

@stop
@section('script')
<script type="text/javascript">
function CampaignVM() {
	var self = this;
	
	var baseUrl = "http://localhost:8888/fatemanager/public";

	self.description = ko.observable("{{$campaign->description}}");
	
	self.toggleDescription = function() {
		$(".campaign-description-text").hide();
		$(".campaign-description-field").show().focus().on('blur', function() {
			$(".campaign-description-text").show();
			$(this).hide();
		});
	}
	@yield('campaign-tab-script');

}	

var viewModel = new CampaignVM();
ko.applyBindings(viewModel);
</script>
@stop
@section('content')
<div class="offset-main-content">
	<h1>{{$campaign->name}}</h1>
	<div class="campaign-description">
		<span class="campaign-description-edit" data-bind="click: $root.toggleDescription"><i class="fa fa-pencil"></i></span>
		<div class="campaign-description-text" data-bind="text: $root.description"></div>
		<input class="campaign-description-field" style="display: none" type="text" data-bind="value: $root.description" />
	</div>
	<div class="campaign-content-main">
		@yield('campaign-tab')
	</div>
	<div class="campaign-content-sidebar">
		<div class="campaign-sidebar-tab {{$page == 'general' ? 'active' : ''}}">General</div>
		<div class="campaign-sidebar-tab {{$page == 'roster' ? 'active' : ''}}">Roster</div>
		<div class="campaign-sidebar-tab {{$page == 'settings' ? 'active' : ''}}">Settings	</div>
		<div class="campaign-sidebar-tab {{$page == 'admin' ? 'active' : ''}}">Administration</div>

	</div>
</div>
@stop