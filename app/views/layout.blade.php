<!DOCTYPE html>
<? $user = Auth::user(); ?>

<html>
	<head>
		<meta charset="UTF-8">
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="/fatemanager/public/css/main.css" rel="stylesheet" type="text/css">
		@yield('includes')
		<title>@yield('title') - FATE Manager</title>
	</head>
	<body>
		@if(isset($user))
			<div id="sidebar">
				<h3>My Characters <a href="/fatemanager/public/character/new" class="new-character-button">New Character</a></h3>					
				
				@foreach($user->characters()->get() as $c)
					<a href="/fatemanager/public/character/{{$c->id}}"><div class="character-block">
						<div class="character-{{$c->active  ? '' : 'in'}}active"></div>
						<div class="character-name">{{strlen($c->name) > 0 ? $c->name : 'New Character'}}</div>
						<div class="character-last-edited">Last edited {{HomeController::convertDateToHumanReadable($c->updated_at, time())}} ago</div>
					</div></a>
				@endforeach
				<h3 class="campaign-header">My Campaigns<a class="new-campaign-button">New Campaign</a></h3>
				@foreach($user->campaigns() as $c)
					<a href="/fatemanager/public/campaign/{{$c->id}}"><div class="campaign-block">
						<div class="character-name">{{$c->name}}</div>
						<? $ct = count($c->characters()->get()); ?>
						<div class="character-last-edited">{{$ct}} active character{{$ct == 1 ? '': 's'}}</div>
					</div></a>
				@endforeach
			</div>
		@endif
		<div id="main-content">
		@yield('content')
		</div>
		<script src="/fatemanager/public/js/jquery-2.1.0.js"></script>
		<script src="/fatemanager/public/js/knockout.js"></script>
		@yield('script')
	</body>
</html>
