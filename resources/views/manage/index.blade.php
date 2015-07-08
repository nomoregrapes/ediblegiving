@extends('layouts.power')

@section('title')
	Management
@endsection

@section('content')
	<h1 class="cover-heading">Management index</h1>
	<p class="lead">
		<?php echo link_to('manage/login/github', 'Login with Github!'); ?><br>
		<?php echo link_to('manage/login/twitter', 'Login with Twitter!'); ?><br>
		<?php echo link_to('manage/login/facebook', 'Login with Facebook!'); ?>
	</p>
@endsection
