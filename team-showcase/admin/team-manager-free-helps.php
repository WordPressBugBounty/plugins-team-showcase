<?php 
	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	/*
	* @Author 		Themepoints
	* Copyright: 	2016 Themepoints
	* Version : 3.0.0
	*/
?>

<div class="wraper doc-suport">
	<div class="doc-support-header">
		<h1><?php _e( 'Team Showcase', 'team-manager-free' ); ?></h1>
		<p><?php _e( 'Do you have any questions or need assistance? We\'re here to help!', 'team-manager-free' ); ?></p>
	</div>
	<div class="video-header">
	    <div class="video-content">
	        <div class="responsive-video-area">
	            <div class="responsive-video">
	                <iframe src="https://www.youtube.com/embed/S9mgBm14n0I" title="Team Showcase WordPress Plugin Installation Tutorial &amp; Demonstration | ThemePoints.com" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
	            </div>
	        </div>
	        <div class="responsive-video-items">
	            <ul>
					<li class="list-item">
						<h3><?php _e( 'Check Documentation', 'team-manager-free' ); ?></h3>
						<p>We developed plugins by maintaining WordPress standards. our docs will help you to understand the basic & advanced usage.</p>
						<div class="tps-btn"><a target="_blank" href="https://themepoints.com/teamshowcase/docs/team-showcase/overview/"><?php _e( 'Documentation', 'team-manager-free' ); ?></a></div>
					</li>
					<li class="list-item">
						<h3><?php _e( 'Get Customer Support', 'team-manager-free' ); ?></h3>
						<p>We're delighted to assist you with any questions or issues you may have regarding our plugin. We eagerly anticipate the opportunity to help you.</p>
						<div class="tps-btn"><a target="_blank" href="https://www.themepoints.com/questions-answer/"><?php _e( 'Get Support', 'team-manager-free' ); ?></a></div>
					</li>
	            </ul>
	        </div>
	    </div>
	</div>
	<div class="doc-support-content">
		<ul class="items-area">
			<li class="list-item">
				<h3><?php _e( 'Show Your Love', 'team-manager-free' ); ?></h3>
				<p>We would greatly appreciate it if you could spare a moment to rate and review our plugin. Your feedback is invaluable to us as it helps us enhance and deliver the best possible experience for our customers.</p>
				<div class="tps-btn"><a target="_blank" href="https://wordpress.org/support/plugin/team-showcase/reviews/"><?php _e( 'Rate Us Now', 'team-manager-free' ); ?></a></div>
			</li>
			<li class="list-item">
				<h3><?php _e( 'Buy Us A Coffee', 'team-manager-free' ); ?></h3>
				<p>We hope you're enjoying our plugin! We put a lot of effort into providing the best experience possible. If you're feeling generous and would like to show your appreciation, we'd be thrilled if you could consider buying us a coffee as a way of saying thank you.</p>
				<div class="tps-btn"><a target="_blank" href="https://www.themepoints.com"><?php _e( 'Donate Now', 'team-manager-free' ); ?></a></div>
			</li>
		</ul>
	</div>
</div>

<style>
.wraper.doc-suport {
	margin:10px 20px 0 2px;
	background-color: #fff;
	padding: 30px;
	border-radius: 10px;
	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
	max-width: 1140px;
}
.doc-support-header {
    background-image: linear-gradient(to right, #495aff 0%, #0acffe 100%);
    padding: 50px;
    margin-bottom: 50px;
    border-radius: 20px;
}
.wraper.doc-suport h1{
	color: #fff;
	font-size: 30px;
	font-weight: 700;
	line-height: 1.2;
	margin: 0;
	padding: 0;
}
.doc-support-header p {
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    text-transform: capitalize;
    margin-bottom: 0;
}
ul.items-area {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-justify-content: space-around;
    justify-content: center;
    margin-left: -15px;
    margin-right: -15px;
}
.doc-support-content {
	border-radius: 10px;
    column-count: 2;
    column-gap: 20px;
    margin-top: 5px;
}
.doc-support-content .items-area {
	list-style-type: none;
	padding: 0;
	margin: 0;
}
.doc-support-content .list-item {
    margin-bottom: 20px;
    border:1px solid #ddd;
    background: #fff;
    color: #fff;
    padding: 30px;
    border-radius: 10px;
	min-height: 175px;
	display: flex;
	flex-direction: column;
	justify-content: center;
}
.doc-support-content .list-item h3 {
  	font-size: 20px;
  	color: #333;
  	margin-top: 0;
  	margin-bottom: 5px;
}
.doc-support-content .list-item p {
	color:#333;
	font-size:15px;
}
.tps-btn a {
    display: inline-flex;
    font-size: 15px;
    font-weight: 400;
    margin-top: 0000;
    padding: 7px 15px;
    box-shadow: none;
    background: #0acffe ;
    color: #fff;
    text-decoration: none;
    outline: none;
    border-radius: 7px;
}
.video-header {
    max-width: 1200px;
    margin: 0 auto;
}
.video-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-start;
}
.responsive-video-area {
    flex: 1;
    min-width: 300px;
}
.responsive-video {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    max-width: 100%;
    background: #000;
}
.responsive-video iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.responsive-video-items {
    flex: 1;
    min-width: 300px;
}
.responsive-video-items ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.responsive-video-items .list-item {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.responsive-video-items .list-item p {
    margin-top: 5px;
}
.list-item h3 {
    font-size: 18px;
    margin-bottom: 5px;
    margin:0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .video-content {
        flex-direction: column;
    }
	.responsive-video-area {
	    min-width: 100%;
	}
}
/* Media query for small devices */
@media screen and (max-width: 767px) {
	.doc-support-header {
		padding:40px;
	}
	.doc-support-content {
		column-count: 1; /* Change to a single column layout */
	}
	.doc-support-content .list-item {
		width: 100%; /* Make each item take up 100% width */
	}
	.responsive-video-area {
	    min-width: 100%;
	}
}
</style>