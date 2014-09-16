@extends('campaign')
@section('campaign-tab-script')
	self.skills = ko.observableArray([]);
		
	self.listSkill = function(id, name, physical, mental) {
		var newSkill = {};
		newSkill.id = id;
		newSkill.name = ko.observable(name);
		newSkill.isPhysical = ko.observable(physical);
		newSkill.isMental = ko.observable(mental);
		
		newSkill.name.subscribe(function(newVal) {
			$.post(baseUrl + "/api/v1/campaign/" + {{$campaign->id}} + "/skill/" + id + "/update/name", { value: newVal });
		});
		
		newSkill.isPhysical.subscribe(function(newVal) {
			if(newVal) {
				for(i = 0; i < self.skills().length; i++) self.skills()[i].isPhysical(false);
				$.post(baseUrl + "/api/v1/campaign/" + {{$campaign->id}} + "/skill/" + id + "/update/physical");
			}
		});

		newSkill.isMental.subscribe(function(newVal) {
			if(newVal) {
				for(i = 0; i < self.skills().length; i++) self.skills()[i].isMental(false);
				$.post(baseUrl + "/api/v1/campaign/" + {{$campaign->id}} + "/skill/" + id + "/update/mental");
			}
		});
				
		self.skills.push(newSkill);
	}
	@foreach($campaign->skills()->get() as $s)
		self.listSkill({{$s->id}}, "{{$s->name}}", {{$s->isPhysical}}, {{$s->isMental}});
	@endforeach
	
	self.addNewSkill = function() {
		$.getJSON(baseUrl + "/api/v1/campaign/" + {{$campaign->id}} + "/skill/add", function(data) {
			self.listSkill(data.id, "New Skill", false, false);
		});
	}
	
	self.deleteSkill = function(skill) {
		$.post(baseUrl + "/api/v1/campaign/" + {{$campaign->id}} + "/skill/delete", { skill: skill.id }, function(data) {
			self.skills.remove(skill);
		});
	}

@stop
@section('campaign-tab')
<div class="input-section-title">Skills</div>
<div class="input-section campaign-skill-section">
	<div class="skill-list" data-bind="foreach: $root.skills">
		<div class"skill-item">
			<div class="skill-remove" data-bind="click: $root.deleteSkill"><i class="fa fa-close"></i></div>
			<input class="skill-name" data-bind="value: name" />
			<div class="skill-options">
				<div class="skill-check">
					 <input type="checkbox" data-bind="checked: $root.skills()[$index()].isPhysical" />
					 <label class="skill-label">Physical Skill</label>
				</div>
				<div class="skill-check">
					<input type="checkbox" data-bind="checked: $root.skills()[$index()].isMental" />
					<label class="skill-label">Mental Skill</label>
				</div>
			</div>
		</div>
	</div>
	<div class="add-skill" data-bind="click: addNewSkill"><i class="fa fa-plus"></i></div>
</div>
@stop