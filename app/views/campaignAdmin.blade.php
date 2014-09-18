@extends('campaign')
@section('campaign-tab-script')
	self.admins = ko.observableArray([]);
	@foreach($campaign->administrators() as $a)
		self.admins.push({ id: {{$a->id}}, name: "{{$a->username}}" });
	@endforeach	

@stop
@section('campaign-tab')
<div class="input-section-title">Administrators</div>
<div class="input-section campaign-skill-section">
	<div data-bind="foreach: $root.admins">
		<div class="admin-name" data-bind="text: name"></div>
		<label>Add an Admin:</label><input type="text" class="admin-add-value" /><button>Add</button>
	</div>
</div>
@stop