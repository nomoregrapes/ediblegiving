@extends('layouts.manage')

@section('title')
	About Edible Giving
@endsection

@section('content')

	<div class="page-header">
		<h1>@yield('title')</h1>
	</div>
	
	<p class="lead">Edible Giving helps you find organisations that you can donate food or your time to. Where you can donate or receive food is shown boldly on the map, and clicking a marker will bring up specific information about that place.</p>


	<p>The information is managed by people within the organisations that are making use of donated food, this keeps it up-to-date and accurate. In some cases, locations have been added by Edible Giving volunteers, so that they are not missed from the website.
	If you are responsible for an organisation that is missing from Edible Giving, please get in touch so we can help you use the website.</p>

	<div class="newsletter-signup" style="width:550px; margin-left:10px; float: right;">
		<!-- Begin MailChimp Signup Form -->
		<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
			/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
		<form action="//ediblegiving.us11.list-manage.com/subscribe/post?u=33716e8393222fbfbaeea95de&amp;id=12f62dd244" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		    <div id="mc_embed_signup_scroll">
			<h2>Receive Edible Giving e-mail updates!</h2>
		<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
		<div class="mc-field-group">
			<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
		</label>
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
		</div>
		<div class="mc-field-group">
			<label for="mce-FNAME">First Name </label>
			<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
		</div>
		<div class="mc-field-group">
			<label for="mce-LNAME">Last Name </label>
			<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
		</div>
		<div class="mc-field-group input-group">
		    <strong>Select the areas of interest for you. Updates are about once a month. </strong>
		<ul>
			<li><input type="checkbox" value="4" name="group[9129][4]" id="mce-group[9129]-9129-2"><label for="mce-group[9129]-9129-2"> News about meeting community food needs</label></li>
			<li><input type="checkbox" value="2" name="group[9129][2]" id="mce-group[9129]-9129-1"><label for="mce-group[9129]-9129-1"> Edible Giving: news and updates</label></li>
			<li><input type="checkbox" value="1" name="group[9129][1]" id="mce-group[9129]-9129-0"><label for="mce-group[9129]-9129-0"> Edible Giving: updating locations &amp; info</label></li>
			<li><input type="checkbox" value="8" name="group[9129][8]" id="mce-group[9129]-9129-3"><label for="mce-group[9129]-9129-3"> Edible Giving: using the data (technical)</label></li>
		</ul>
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <div style="position: absolute; left: -5000px;"><input type="text" name="b_33716e8393222fbfbaeea95de_12f62dd244" tabindex="-1" value=""></div>
		    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		    </div>
		</form>
		</div>
		<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
		<!--End mc_embed_signup-->
	</div>
	<h2>Contact</h2>
	<p>If you want to stay informed about improvements, follow <a href="https://twitter.com/ediblegiving">@EdibleGiving</a> for updates on twitter.</p>
	<p>Enter your details on the right-hand side to be e-mailed updates about Edible Giving.</p>
	<p>If you have questions, or wish to get in touch then e-mail <em>info</em><em>@ediblegiving</em><em>.org</em>.</p>

	<h2>The History and Vision</h2>
	<p>I like food, it is yummy. I am privileged and sometimes I have food left over or can add an extra item to my shopping trolley without any qualms.</p>
	<p>Can that food go to local people who need it, where and when can I donate the food? I know a few local charities, but if I'm away from home where do I give the food, and what if local details change? I wanted to solve this by creating a UK-wide or international map, and I wanted different organisations to be able to use their own systems to keep the shared map updated. Finally in March 2015 I made a start to this and created Edible Giving, we shall see where it goes.
	The website was created by Gregory Marler.</p>
	<p></p>
	<!--
	I want to write about: Github, 
	features planned?, 
	reusing the data (public domain but nice to attribute?),
	created by me, who?
	-->


@endsection
