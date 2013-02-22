@extends('admin.layout')

@section('sidebar')
    @parent
	
    <p>Wie wär's mit ein paar Filteroptionen?</p>
@stop

@section('content')
    <p>Hier kann man bald Nutzer anlegen, bearbeiten, sperren und was man sonst noch so machen will...</p>
	<ul>
	@foreach ($users as $user)
		<li><a href="javascript:loadUser({{ $user->id }})">{{ $user->lastName }} {{ $user->firstName }} {{ $user->email }}</a></li>
	@endforeach
		<li><a href="javascript:loadUser(2)">Bla test</a></li>
	</ul>
	
	<div class="tabs" id="user-tabs" style="display: none;">
		<ul>
			<li><a href="#" id="user-info-link">Informationen</a></li>
			<li><a href="#" id="user-groups-link">Gruppen</a></li>
			<li><a href="#" id="user-permissions-link">Rechte</a></li>
		</ul>
	</div>
@stop