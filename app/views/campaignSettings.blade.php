@extends('campaign')
@section('campaign-tab-script')
	self.skills = ko.observableArray([]);
	@foreach($campaign->skills()->get() as $s)
		self.skills.push({id: {{$s->id}}, name: "{{$s->name}}", desc: "{{addslashes($s->description)}}", isPhysical: {{$s->isPhysical}}, isMental: {{$s->isMental}} });
	@endforeach
@stop
@section('campaign-tab')
<div class="input-section-title">Skills</div>
<div class="input-section campaign-skill-section">
	<div class="skill-list" data-bind="foreach: $root.skills">
		<div class"skill-item">
			<div class="skill-remove"><i class="fa fa-close"></i></div>
			<input class="skill-name" data-bind="value: name" />
			<div class="skill-options">
				<div class="skill-check">
					 <input type="checkbox" data-bind="value: self.skills[$index()].isPhysical" />
					 <label class="skill-label">Physical Skill</label>
				</div>
				<div class="skill-check">
					<input type="checkbox" data-bind="value: self.skills[$index()].isMental" />
					<label class="skill-label">Mental Skill</label>
				</div>
			</div>
		</div>
	</div>
</div>
@stop