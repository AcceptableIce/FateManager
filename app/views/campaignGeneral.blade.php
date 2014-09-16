@extends('campaign')
@section('campaign-tab-script')

	self.requests = ko.observableArray([]);
	
	@foreach($campaign->requests()->get() as $r)
	<?php $definition = $r->definition(); ?>
	self.requests.push({ id: {{$r->id}}, name: "{{$definition["name"]}}", desc: "{{addslashes($definition["desc"])}}", date: "{{HomeController::convertDateToHumanReadable($r->created_at, time())}}" })
	@endforeach;
	
	self.acceptRequest = function(data) {
		$.getJSON(baseUrl + "/api/v1/campaign/{{$campaign->id}}/request/" + data.id + "/accept", function(returnData) {
			self.requests.remove(data);
		});
	}
	
	self.rejectRequest = function(data) {
		$.getJSON(baseUrl + "/api/v1/campaign/{{$campaign->id}}/request/" + data.id + "/reject", function(returnData) {
			self.requests.remove(data);
		});
	}
@stop
@section('campaign-tab')
<div class="input-section-title">Requests</div>
<div class="input-section campaign-request-section">
	<!-- ko if: $root.requests().length === 0 -->
		There are no requests.
	<!-- /ko -->
	<div data-bind="foreach: $root.requests">
		<div class="campaign-request">
			<div class="campaign-request-name" data-bind="text: name"></div>
			<div class="campaign-request-description" data-bind="html: desc"></div>
			<div class="campaign-request-date" data-bind="text: date + ' ago'"></div>
			<div class="campaign-request-accept" data-bind="click: $root.acceptRequest">Accept</div>
			<div class="campaign-request-reject" data-bind="click: $root.rejectRequest">Reject</div>
		</div>
	</div>
</div>
@stop