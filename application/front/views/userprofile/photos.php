<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li><a href="{{user_slug}}/article" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li class="active"><a href="#"><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li><a href="{{user_slug}}/videos" ng-click='makeActive("dashboard")'><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li><a href="{{user_slug}}/audios" ng-click='makeActive("dashboard")'><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li><a href="{{user_slug}}/pdf" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="photo">
							<input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_number}}">
			                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.total_record}}">
			                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.perpage_record}}">
							<ul class="all-tab">
								<li ng-repeat="_photoData in photoData">									
									<img ng-if="_photoData.filetype == 'profile_picture'" ng-src="<?php echo USER_THUMB_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image" ng-click="openModal();currentSlide($index + 1)">
				                    <img ng-if="_photoData.filetype == 'cover_picture'" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image" ng-click="openModal();currentSlide($index + 1)">
				                    <img ng-if="_photoData.filetype == 'image'" ng-src="<?php echo USER_POST_THUMB_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image" ng-click="openModal();currentSlide($index + 1)">
								</li>
								<li ng-if="pagecntctData.pagedata.total_record == 0">
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-photo.png'); ?>" alt="No Photos">
					                        </div>
					                        <div class='art_no_post_text'>No Photos Available. </div>
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
<div id="myModalPhotos" class="modal modal2" style="display: none;">
	<button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal()">×</button>
	<div class="modal-dialog">
        <div class="modal-content">
        	<div id="all_image_loader" class="fw post_loader all_image_loader" style="text-align: center;display: none;position: absolute;top: 50%;z-index: 9;">
        		<img ng-src="<?php echo base_url('assets/images/loader.gif?ver=' . time()) . '?ver=' . time() ?>" alt="Loader" />
            </div>
	 		<div class="mySlides" ng-repeat="_photoData in allPhotosData">
	 			<div class="numbertext"></div>
	 			<div class="slider_img_p">	 				
	 				<img ng-if="_photoData.filetype == 'profile_picture'" ng-src="<?php echo USER_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                    <img ng-if="_photoData.filetype == 'cover_picture'" ng-src="<?php echo USER_BG_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
                    <img ng-if="_photoData.filetype == 'image'" ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_photoData.filename}}" alt="Image-{{$index}}" id="element_load_{{$index + 1}}">
	 			</div>
	 		</div>	 		
	 	</div>
	 	<div class="caption-container">
	 		<p id="caption"></p>
	 	</div>
	</div> 
 	<a class="prev" style="left:0px;" ng-click="plusSlides(-1)">&#10094;</a>
	<a class="next" ng-click="plusSlides(1)">&#10095;</a>
</div>