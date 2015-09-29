@extends('layouts.manage')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management Area</h1>
	<p>
		If you have not logged into Edible Giving before, your account will <strong>need to be authorised</strong> by an organisation or Edible Giving, authorisation is a manual process and may take a few days.
		Edible Giving uses this process to ensure data is curated by the organisations running the locations and by trusted people who keep all information accurate.
	</p>
	<p>Select the service you will use to login to Edible Giving
		<ul class="login-providers">
			<li><a href="/manage/login/facebook">
				Login using Facebook
				<div class="img-container">
					<img src="/images/manage/login-facebook.png" class="standard">
					<img src="/images/manage/login-facebook-active.png" class="active">
				</div>
				Login using Facebook
			</a></li>
			<li><a href="/manage/login/twitter">
				Login using Twitter
				<div class="img-container">
					<img src="/images/manage/login-twitter.png" class="standard">
					<img src="/images/manage/login-twitter-active.png" class="active">
				</div>
				Login using Twitter
			</a></li>
			<li><a href="/manage/login/github">
				Login using Github
				<div class="img-container">
					<img src="/images/manage/login-github.png" class="standard">
					<img src="/images/manage/login-github-active.png" class="active">
				</div>
				Login using Github
			</a></li>
		</ul>
	</p>
@endsection
