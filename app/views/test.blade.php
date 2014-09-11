@extends('layout')
@section('title', 'FATE Manager')
@section('includes')
	<link rel='stylesheet' type='text/css' href='../css/charSheet.css' />
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

@stop
@section('script')
<script type="text/javascript">
function FateSheetVM() {
	var self = this;
	self.name = ko.observable("{{$character->name}}");
	self.description = ko.observable("{{$character->description}}");
	self.refresh = ko.observable("{{$character->refresh}}");
	self.aspects = ko.observableArray([]);
	@foreach($character->aspects()->get() as $a)
	self.aspects.push("{{$a->name}}");
	@endforeach
	
	self.aspectList = ko.computed(function() {
		var out = [];
		for(var i = 0; i < 5; i++) {
			if(self.aspects()[i]) {
				out.push(self.aspects()[i]);
			} else {
				out.push("");
			}
		}
		return out;
	});
}	

ko.applyBindings(new FateSheetVM());

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
			<!-- ko foreach: $root.aspectList -->
			<div class="sheet-input-box sheet-input-aspect"><input class="sheet-editable" data-bind="value: $data, attr: {'placeholder': $index() == 0 ? 'High Concept' : $index() == 1 ? 'Trouble' : ''}" /></div>
			<!-- /ko -->

		</div>
		<div id="sheet-skill-set">
			<div class="sheet-header" id="sheet-header-skills">Skills</div>
			<div class="sheet-skill-row">
				<div class="sheet-skill-row-descriptor">Superb (+5)</div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
			</div>
			<div class="sheet-skill-row">
				<div class="sheet-skill-row-descriptor">Great (+4)</div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
			</div>
			<div class="sheet-skill-row">
				<div class="sheet-skill-row-descriptor">Good (+3)</div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
			</div>
			<div class="sheet-skill-row">
				<div class="sheet-skill-row-descriptor">Fair (+2)</div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box muted"></div>
				<div class="sheet-skill-row-box muted"></div>
			</div>
			<div class="sheet-skill-row">
				<div class="sheet-skill-row-descriptor">Average (+1)</div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box"></div>
				<div class="sheet-skill-row-box muted"></div>
			</div>						
 		</div>	
	</div>
	<div id="sheet-row-3">
		<div id="sheet-extras-set">
			<div class="sheet-header" id="sheet-header-extras">Extras</div>
			<div class="sheet-input-box" id="sheet-input-extras"></div>
		</div>
		<div id="sheet-stunts-set">
			<div class="sheet-header" id="sheet-header-stunts">Stunts</div>
			<div class="sheet-input-box" id="sheet-input-stunts"></div>
		</div>	
	</div>
	<div id="sheet-row-4">
		<div id="sheet-stress-set">
			<div class="sheet-header" id="sheet-header-physical-stress">Physical Stress <span class="sheet-header-subtext">(Physique)</span></div>
			<div class="sheet-stress-row">
				<div class="sheet-stress-box sheet-stress-1"></div>
				<div class="sheet-stress-box sheet-stress-2"></div>
				<div class="sheet-stress-box sheet-stress-3 muted"></div>
				<div class="sheet-stress-box sheet-stress-4 muted"></div>

			</div>
			<div class="sheet-header" id="sheet-header-mental-stress">Mental Stress <span class="sheet-header-subtext">(Will)</span></div>
			<div class="sheet-stress-row">
				<div class="sheet-stress-box sheet-stress-1"></div>
				<div class="sheet-stress-box sheet-stress-2"></div>
				<div class="sheet-stress-box sheet-stress-3 muted"></div>
				<div class="sheet-stress-box sheet-stress-4 muted"></div>
			</div>
		</div>
		<div id="sheet-consequences-set">
			<div class="sheet-header" id="sheet-header-consequences">Consequences</div>
			<div class="sheet-consequences-row">
				<div class="sheet-input-box sheet-consequence-box sheet-consequence-2">Mild</div>
				<div class="sheet-input-box sheet-consequence-box sheet-consequence-2 muted">Mild</div>
			</div>
			<div class="sheet-input-box sheet-consequence-box sheet-consequence-4">Moderate</div>
			<div class="sheet-input-box sheet-consequence-box sheet-consequence-6">Severe</div>

		</div>
	</div>
	
</div>

@stop