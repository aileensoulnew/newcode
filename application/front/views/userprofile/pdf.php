<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li><a href="{{user_slug}}/article" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li><a href="{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li><a href="{{user_slug}}/videos" ng-click='makeActive("dashboard")'><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li><a href="{{user_slug}}/audios" ng-click='makeActive("dashboard")'><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li class="active"><a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="pdf">
							<input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_number}}">
			                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.total_record}}">
			                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.perpage_record}}">
							<ul class="all-tab pdf-tab">
								<li ng-repeat="_pdfData in pdfData">
									<a href="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_pdfData.filename}}" target="_blank">
										<img ng-src="<?php echo base_url('assets/images/PDF.jpg?ver=' . time()) ?>">
										<label dd-text-collapse dd-text-collapse-max-length="40" dd-text-collapse-text="{{_pdfData.description}}" dd-text-collapse-cond="false" class="pdf-title" ng-if="_pdfData.post_for == 'simple'">{{_pdfData.description}}</label>
										<label dd-text-collapse dd-text-collapse-max-length="40" dd-text-collapse-text="{{_pdfData.opportunity}}" dd-text-collapse-cond="false" class="pdf-title" ng-if="_pdfData.post_for == 'opportunity'">{{_pdfData.opportunity}}</label>
									</a>
								</li>
								<li ng-if="pagecntctData.pagedata.total_record == 0">
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-pdf.png'); ?>" alt="No PDF">
					                        </div>
					                        <div class='art_no_post_text'>No PDF Available. </div>
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