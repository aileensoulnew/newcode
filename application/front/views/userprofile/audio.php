<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li><a href="{{user_slug}}/article" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li><a href="{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li><a href="{{user_slug}}/videos" ng-click='makeActive("dashboard")'><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li class="active"><a href="#"><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li><a href="{{user_slug}}/pdf" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="video">
							<input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_number}}">
			                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.total_record}}">
			                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.perpage_record}}">
							<ul class="all-tab audio-tab">
								<li ng-repeat="_audioData in audioData">
									<div class="li-audio">
										<audio controls width = "100%" height = "100%">
											<source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_audioData.filename}}" type="audio/mp3">
											Your browser does not support the audio tag.
										</audio>
									</div>
									<label dd-text-collapse dd-text-collapse-max-length="60" dd-text-collapse-text="{{_audioData.description}}" dd-text-collapse-cond="false" class="audio-title" ng-if="_audioData.post_for == 'simple'">{{_audioData.description}}</label>
									<label dd-text-collapse dd-text-collapse-max-length="60" dd-text-collapse-text="{{_audioData.opportunity}}" dd-text-collapse-cond="false" class="audio-title" ng-if="_audioData.post_for == 'opportunity'">{{_audioData.opportunity}}</label>
								</li>
								<li ng-if="pagecntctData.pagedata.total_record == 0">
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-audio.png'); ?>" alt="No Audio">
					                        </div>
					                        <div class='art_no_post_text'>No Audio Available. </div>
					                    </div>
					                </div>
								</li>
							</ul>
			                <div class="fw post_loader" style="text-align:center; display: none;"><img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" /></div>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>