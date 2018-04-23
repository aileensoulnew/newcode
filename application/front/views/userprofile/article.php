<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#" ><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li><a href="{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li><a href="{{user_slug}}/videos" ng-click='makeActive("dashboard")'><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li><a href="{{user_slug}}/audios" ng-click='makeActive("dashboard")'><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li><a href="{{user_slug}}/pdf" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="article">							
							<ul class="all-tab article-tab">
								<li>
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-article.png'); ?>" alt="No Article">
					                        </div>
					                        <div class='art_no_post_text'>No Article Available. </div>
					                    </div>
					                </div>									
								</li>								
							</ul>			                
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>