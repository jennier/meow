<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Meow - @yield('title')</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/formValidation.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/base.css') }}">
</head>

    <body>
	@if(Auth::user())
      <div class="hook" id="hook"></div>
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{!! route('dashboard') !!}"> <img alt="Meow" src="http://www.cutcatscourier.com/meow/images/meow-logo.png"></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Members<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('members.committees') !!}">Committee Contacts</a></li>
                  <li><a href="{{ route('members.index') }}">Member Schedule</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ballots<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('ballots.create') !!}">Create a Ballot</a></li>
                  <li><a href="{!! route('ballots.index') !!}">View Ballots</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Surveys<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('surveys.index') !!}">View Surveys</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">CR<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('cr.reports.index') !!}">View Reports</a></li>
                  <li><a href="{!! route('cr.reports.create') !!}">Submit Report</a></li>
                </ul>
              </li>
             
              @if(Entrust::hasRole('admin'))
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                 <ul class="dropdown-menu" role="menu">
                      <li><a href="{{ url('/role_permission') }}">Overview</a></li>
                      <li><a href="{{ URL::route('roles.index') }}">Roles</a></li>
                      <li><a href="{{ URL::route('permissions.index') }}">Permissions</a></li>
                       <li><a href="{{ URL::route('members.index') }}">Manage Users</a></li>
                      <li><a href="{{ URL::route('members.create') }}">Create User</a></li>
                 </ul>
              </li>
              @endif
              
              <!--/
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">HR<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Submit a Report</a></li>
                  <li><a href="#">View all Write Ups</a></li>
                  <li><a href="#">View your Write Ups</a></li>
                </ul>
              </li>
              -->
            </ul>
            @if(Auth::user())
            <ul class="nav navbar-nav navbar-right">
            	<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Oh hay there {{ Auth::user()->name }}<span class="caret"></span></a>
                 <ul class="dropdown-menu" role="menu">
                 	<li><a href="{!! route('dashboard') !!}">Dashboard</a></li>
              		<li><a href="{!! route('logout') !!}">Logout</a></li>
                  </ul>
               </li>
            </ul>
            @endif
         </div>
        </div><!--/.nav-collapse -->
       </div>
      </nav>
    @endif
    
    <div class="container">
    	<div class="breadcrumbs">
        	<!-- @yield('breadcrumbs') -->
        </div>
   		<div class="page-header">
  			<h1>@yield('title')</h1>
 		</div>
        
        @if (Session::has('message'))
            <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('message') }}
            </div>
		@endif
        
        @yield('content')
 
  	</div> <!-- /container -->

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>


<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="{{ asset('js/formValidation.min.js') }}"></script>
<script src="{{ asset('js/framework/bootstrap.min.js') }}"></script>

@yield('jquery')
    </body>
</html>