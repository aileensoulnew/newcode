<div class="container pt15 main-dashboard">

	<div class="full-box">

		<div class="row ">
			<div class="media-tab">
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li><a href="{{user_slug}}/article" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> Article</a></li>
						<li><a href="{{user_slug}}/photos" ng-click='makeActive("dashboard")'><i class="fa fa-camera" aria-hidden="true"></i> Photo</a></li>
						<li class="active"><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
						<li><a href="{{user_slug}}/audios" ng-click='makeActive("dashboard")'><i class="fa fa-music" aria-hidden="true"></i> Audio</a></li>
						<li><a href="{{user_slug}}/pdf" ng-click='makeActive("dashboard")'><i class="fa fa-newspaper-o" aria-hidden="true"></i> PDF</a></li>
					</ul>

					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="video">
							<input type="hidden" name="page_number" class="page_number" ng-class="page_number" ng-model="post.page_number" ng-value="{{post.page_number}}">
			                <input type="hidden" name="total_record" class="total_record" ng-class="total_record" ng-model="post.total_record" ng-value="{{post.total_record}}">
			                <input type="hidden" name="perpage_record" class="perpage_record" ng-class="perpage_record" ng-model="post.perpage_record" ng-value="{{post.perpage_record}}">
							<ul class="all-tab  video-tab">
								<li ng-repeat="_videoData in videoData">
									<a href="#" ng-click="openModal('myModalVideo');currentSlide($index + 1)">
										<img ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_videoData.filename | removeLastCharacter}}png"" alt="Image-{{$index}}">
									</a>
			                    </li>
			                    <li ng-if="pagecntctData.pagedata.total_record == 0">
									<div class="custom-user-box no-data-available">
					                    <div class='art-img-nn'>
					                        <div class='art_no_post_img'>
					                            <img src="<?php echo base_url('assets/img/no-video.png'); ?>" alt="No Videos">
					                        </div>
					                        <div class='art_no_post_text'>No Videos Available. </div>
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
<div id="myModalVideo" class="modal modal2" style="display: none;">
	<button type="button" class="modal-close" data-dismiss="modal" ng-click="closeModal()">×</button>
	<div class="modal-dialog">
        <div class="modal-content">     
            <!-- <span class="close2 cursor" ng-click="closeModal()">&times;</span> -->
            <div class="mySlides mySlides2Video" ng-repeat="_videoData in allVideosData">
                <div class="numbertext">{{$index + 1}} / {{allVideosData.length}}</div>
                <div class="slider_img_p">
                   <video id="videoplayer_{{$index + 1}}" controls width="100%" preload="none">
                        <source ng-src="<?php echo USER_POST_MAIN_UPLOAD_URL ?>{{_videoData.filename}}#t=0.1" type="video/mp4">
                    </video>
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