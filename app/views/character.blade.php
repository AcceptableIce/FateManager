@extends('layout')
@section('title', strlen($character->name) > 0 ? $character->name : 'New Character')
@section('includes')
	<link rel='stylesheet' type='text/css' href='../css/charSheet.css' />
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

@stop
@section('script')
<script type="text/javascript">

(function (ko) {
	ko.extenders.api = function(target, path) {
		var baseUrl = "http://localhost:8888/fatemanager/public";
		path = path.replace('{id}', {{$character->id}});
		target.subscribe(function(newValue) {
			$.post(baseUrl + path, {value: newValue});
		});
		
	}
	
	ko.observable.fn.silencable = function() {
	    var self = this;
	    this.pauseNotifications = false;  
	    this.notifySubscribers = function(value, event) {
	        if (!self.pauseNotifications) {
	            ko.subscribable.fn.notifySubscribers.call(this, value, event);
	        } 
		};
       
		return this; 
    }
	
})(ko);
function FateSheetVM() {
	var self = this;
	
	self.id = ko.observable({{$character->id}}); 
	self.name = ko.observable("{{$character->name}}").extend({ 'api' : '/api/v1/character/{id}/update/name' });
	self.description = ko.observable("{{$character->description}}").extend({ 'api' : '/api/v1/character/{id}/update/description' });
	self.refresh = ko.observable("{{$character->refresh}}").extend({ 'api' : '/api/v1/character/{id}/update/refresh' });
	
	self.aspects = [];
	for(var i = 0; i < 5; i++) self.aspects.push(ko.observable(""));

	@foreach($character->aspects()->get() as $a)
		self.aspects[{{$a->position}}]("{{$a->name}}");
	@endforeach
	
	for(i = 0; i < 5; i++) self.aspects[i].extend({'api': '/api/v1/character/{id}/update/aspect/' + i});
	self.extras = ko.observable("{{$character->extras}}").extend({ 'api' : '/api/v1/character/{id}/update/extras' });
	self.stunts = ko.observable("{{$character->stunts}}").extend({ 'api' : '/api/v1/character/{id}/update/stunts' });

	self.physicalSkill = ko.observable({ id: {{$character->campaign()->physicalSkill()->id}}, name: "{{$character->campaign()->physicalSkill()->name}}" });
	self.mentalSkill = ko.observable({ id: {{$character->campaign()->mentalSkill()->id}}, name: "{{$character->campaign()->mentalSkill()->name}}" });

	self.physicalStress = [];
	var rawPhysicalStressValue = {{$character->physical_stress_taken}};
	self.physicalStress[0] = ko.observable((rawPhysicalStressValue & parseInt('0001', 2)) > 0);
	self.physicalStress[1] = ko.observable((rawPhysicalStressValue & parseInt('0010', 2)) > 0);
	self.physicalStress[2] = ko.observable((rawPhysicalStressValue & parseInt('0100', 2)) > 0);
	self.physicalStress[3] = ko.observable((rawPhysicalStressValue & parseInt('1000', 2)) > 0);
	
	self.bitwisePhysicalStress = ko.computed(function() {
		var out = '';
		for(i = 3; i >= 0; i--) out += self.physicalStress[i]() ? '1' : '0';
		return parseInt(out, 2);
	});
	
	self.bitwisePhysicalStress.extend({ 'api': '/api/v1/character/{id}/update/stress/physical' });
	
	self.mentalStress = [];
	var rawMentalStressValue = {{$character->mental_stress_taken}};
	self.mentalStress.push(ko.observable((rawMentalStressValue & parseInt('0001', 2)) > 0));
	self.mentalStress.push(ko.observable((rawMentalStressValue & parseInt('0010', 2)) > 0));
	self.mentalStress.push(ko.observable((rawMentalStressValue & parseInt('0100', 2)) > 0));
	self.mentalStress.push(ko.observable((rawMentalStressValue & parseInt('1000', 2)) > 0));
		
	self.bitwiseMentalStress = ko.computed(function() {
		var out = '';
		for(i = 3; i >= 0; i--) out += self.mentalStress[i]() ? '1' : '0';
		return parseInt(out, 2);
	});
	
	self.bitwiseMentalStress.extend({ 'api': '/api/v1/character/{id}/update/stress/mental' });

	<?php $c4 = $character->consequences()->where('severity', 4)->first();
	$c6 = $character->consequences()->where('severity', 6)->first();
	?>
	self.consequences = [ko.observableArray([]), ko.observable("{{isset($c4) ? $c4->name : ''}}").extend({ 'api' : '/api/v1/character/{id}/update/consequence/4' }), ko.observable("{{isset($c6) ? $c6->name : ''}}").extend({ 'api' : '/api/v1/character/{id}/update/consequence/6' })];
	var i = 0;
	@foreach($character->consequences()->where('severity', 2)->get() as $c)
		self.consequences[0].push(ko.observable("{{$c->name}}").extend({ 'api' : '/api/v1/character/{id}/update/consequence/2/' + i++ }));
	@endforeach
	for(; i < 2; i++) self.consequences[0].push(ko.observable("").extend({ 'api' : '/api/v1/character/{id}/update/consequence/2/' + i }));
	
	
	self.skills = [];
	for(i = 0; i < 5; i++) {
		self.skills.push([]);
		for(j = 0; j < 5; j++) {
			self.skills[i].push(ko.observable(0).silencable());
			self.skills[i][j].extend({ 'api' : '/api/v1/character/{id}/update/skill/' + (i + 1) + '/' + j })
		}
	}
	@foreach($character->skills()->get() as $s)
		var skill = self.skills[{{$s->rank - 1}}][{{$s->position}}];
		skill.pauseNotifications = true;
		skill({{$s->definition()->id}});
		skill.pauseNotifications = false;
	@endforeach
	
	self.selectedSkills = ko.computed(function() {
		var out = [];
		for(i = 0; i < 5; i++) {
			for(j = 0; j < 5; j++) {
				out.push(self.skills[i][j]());
			}
		}

		return out;
	});
	
	self.campaignSkillList = [];
	@foreach($character->campaign()->skills()->get() as $s)
	self.campaignSkillList.push({ id: {{$s->id}}, name: "{{$s->name}}" });
	@endforeach
	
	self.availableSkills = ko.computed(function(val) {
		var out = [{ id: 0, name: ""}];
		for(i = 0; i < self.campaignSkillList.length; i++) out.push(self.campaignSkillList[i]);
		return out;
	});
	
	
	self.getSkillRowName = function(row) {
		switch(row) {
			case 0: return "Average (+1)";
			case 1: return "Fair (+2)";
			case 2: return "Good (+3)";
			case 3: return "Great (+4)";
			case 4: return "Superb (+5)";
		}
	}	
	
	self.isSkillHighEnough = function(skill, rank) {
		for(var i = rank; i < 6; i++) {
			for(var j = 0; j < 5; j++) {
				if(self.skills[i - 1][j]() == skill.id) return true;
			}
		}	
		return false;
	}
	
	self.checkPhysicalStressBox = function(value) {
		if(value == 2 && !self.isSkillHighEnough(self.physicalSkill(), 1)) return;
		if(value == 3 && !self.isSkillHighEnough(self.physicalSkill(), 3)) return;
		self.physicalStress[value](!self.physicalStress[value]());
	}
	
	self.checkMentalStressBox = function(value) {
		if(value == 2 && !self.isSkillHighEnough(self.mentalSkill(), 1)) return;
		if(value == 3 && !self.isSkillHighEnough(self.mentalSkill(), 3)) return;
		self.mentalStress[value](!self.mentalStress[value]());
	}
}	

var viewModel = new FateSheetVM();
ko.applyBindings(viewModel);


</script>
@stop
@section('content')
<div id="character-sheet">
	<div id="sheet-row-1">
		<div class="sheet-header" id="sheet-header-id">ID</div>
		<div id="sheet-id-set-1">
			<div class="sheet-input-box" id="sheet-input-name"><input class="sheet-editable" placeholder="Name" data-bind="value: $root.name" /></div>
			<div class="sheet-input-box" id="sheet-input-desc"><textarea class="sheet-editable" placeholder="Description" id="sheet-description-edit" data-bind="value: $root.description"></textarea></div>
		</div>
		<div class="sheet-input-box" id="sheet-input-refresh">Refresh<input class="sheet-editable" data-bind="value: $root.refresh" id="sheet-refresh-input" /></div>
		<div id="sheet-logo"></div>
	</div>
	<div id="sheet-row-2">
		<div id="sheet-aspect-set">
			<div class="sheet-header" id="sheet-header-aspects">Aspects</div>
			<!-- ko foreach: $root.aspects -->
			<div class="sheet-input-box sheet-input-aspect"><input class="sheet-editable" data-bind="value: $root.aspects[$index()], attr: {'placeholder': $index() == 0 ? 'High Concept' : $index() == 1 ? 'Trouble' : ''}" /></div>
			<!-- /ko -->

		</div>
		<div id="sheet-skill-set">
			<div class="sheet-header" id="sheet-header-skills">Skills</div>
			<!-- ko foreach: [4, 3, 2, 1, 0] -->
				<div class="sheet-skill-row">
					<div class="sheet-skill-row-descriptor" data-bind="text: $root.getSkillRowName($data)"></div>
					<!-- ko foreach: $root.skills[$data] -->
						<div class="sheet-skill-row-box" data-bind="css: {'muted': !$data }"><select class="sheet-editable" data-bind="options: $root.availableSkills, value: $root.skills[$parent][$index()], optionsText: 'name', optionsValue: 'id'"></select></div>
					<!-- /ko-->
				</div>
			<!-- /ko-->					
 		</div>	
	</div>
	<div id="sheet-row-3">
		<div id="sheet-extras-set">
			<div class="sheet-header" id="sheet-header-extras">Extras</div>
			<div class="sheet-input-box" id="sheet-input-extras"><textarea class="sheet-editable" data-bind="value: $root.extras"></textarea></div>
		</div>
		<div id="sheet-stunts-set">
			<div class="sheet-header" id="sheet-header-stunts">Stunts</div>
			<div class="sheet-input-box" id="sheet-input-stunts"><textarea class="sheet-editable" data-bind="value: $root.stunts"></textarea></div>
		</div>	
	</div>
	<div id="sheet-row-4">
		<div id="sheet-stress-set">
			<div class="sheet-header" id="sheet-header-physical-stress">Physical Stress <span class="sheet-header-subtext" data-bind="text: '(' + $root.physicalSkill().name + ')'"></span></div>
			<div class="sheet-stress-row">
				<div class="sheet-stress-box sheet-stress-1" data-bind="click: function() { checkPhysicalStressBox(0) }, css: { 'checked': $root.physicalStress[0] }"></div>
				<div class="sheet-stress-box sheet-stress-2" data-bind="click: function() { checkPhysicalStressBox(1) }, css: { 'checked': $root.physicalStress[1] }"></div>
				<div class="sheet-stress-box sheet-stress-3" data-bind="click: function() { checkPhysicalStressBox(2) }, css: {'muted': !$root.isSkillHighEnough($root.physicalSkill(), 1), 'checked': $root.physicalStress[2] }"></div>
				<div class="sheet-stress-box sheet-stress-4" data-bind="click: function() { checkPhysicalStressBox(3) }, css: {'muted': !$root.isSkillHighEnough($root.physicalSkill(), 3), 'checked': $root.physicalStress[3] }"></div>

			</div>
			<div class="sheet-header" id="sheet-header-mental-stress">Mental Stress <span class="sheet-header-subtext" data-bind="text: '(' + $root.mentalSkill().name + ')'"></span></div>
			<div class="sheet-stress-row">
				<div class="sheet-stress-box sheet-stress-1" data-bind="click: function() { checkMentalStressBox(0) }, css: {'checked': $root.mentalStress[0] }"></div>
				<div class="sheet-stress-box sheet-stress-2" data-bind="click: function() { checkMentalStressBox(1) }, css: {'checked': $root.mentalStress[1] }"></div>
				<div class="sheet-stress-box sheet-stress-3" data-bind="click: function() { checkMentalStressBox(2) }, css: {'muted': !$root.isSkillHighEnough($root.mentalSkill(), 1), 'checked': $root.mentalStress[2] }"></div>
				<div class="sheet-stress-box sheet-stress-4" data-bind="click: function() { checkMentalStressBox(3) }, css: {'muted': !$root.isSkillHighEnough($root.mentalSkill(), 3), 'checked': $root.mentalStress[3] }"></div>
			</div>
		</div>
		<div id="sheet-consequences-set">
			<div class="sheet-header" id="sheet-header-consequences">Consequences</div>
			<div class="sheet-consequences-row">
				<div class="sheet-input-box sheet-consequence-box sheet-consequence-2"><input class="sheet-editable" placeholder="Mild" data-bind="value: $root.consequences[0]()[0]" /></div>
				<div class="sheet-input-box sheet-consequence-box sheet-consequence-2" data-bind="css: {'muted': !$root.isSkillHighEnough($root.physicalSkill(), 5) }"><input class="sheet-editable" placeholder="Mild" data-bind="value: $root.consequences[0]()[1]" /></div>
			</div>
			<div class="sheet-input-box sheet-consequence-box sheet-consequence-4"><input class="sheet-editable" placeholder="Moderate" data-bind="value: $root.consequences[1]" /></div>
			<div class="sheet-input-box sheet-consequence-box sheet-consequence-6"><input class="sheet-editable" placeholder="Severe" data-bind="value: $root.consequences[2]" /></div>

		</div>
	</div>
	
</div>

@stop