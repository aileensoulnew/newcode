 <?php 
 $userid = $this->session->userdata('aileenuser');
        
        /*code for business profile link start */

        $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
        $business_profile_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->business_profile_link = base_url("business-profile/");
        if(isset($business_profile_count) && !empty($business_profile_count) && isset($business_profile_count[0]['business_count']) && $business_profile_count[0]['business_count']==1){
            $this->business_profile_link = base_url("business-profile/home");
        }
        /*Code for business profile link end*/

        /*code for Artis profile link start */
            $contition_array = array('user_id' => $userid);
            $artist_profile_count = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for artist profile link ends*/ 

        /*code for Job profile link start */
            $contition_array = array('user_id' => $userid);
            $job_profile_count = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for Job profile link ends*/
        /*code for recruiter profile link start */
            $contition_array = array('user_id' => $userid);
            $recruiter_profile_count = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for recuiter profile link ends*/

        /*code for freelance hire link start */
            $contition_array = array('user_id' => $userid,'is_delete' => '0', 'status' => '1');
            $freelancer_hire_profile_count = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for freelance hire profile link ends*/

        /*code for freelace apply link start */
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata1 = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        /*Code for freelance aply link ends*/

            $this->business_profile_link = base_url("business-profile/");
            $this->artist_profile_link = base_url("artist/");
            $this->job_profile_link = base_url("job/");
            $this->recruiter_profile_link = base_url("recruiter/");
            $this->freelance_hire_profile_link = base_url("freelance/");
            $this->freelance_apply_profile_link = base_url("freelance/");
            $this->business_profile_set = 0;
            $this->artist_profile_set = 0;
            $this->job_profile_set = 0;
            $this->recruiter_profile_set = 0;
            $this->freelance_hire_profile_set = 0;
            $this->freelance_apply_profile_set = 0;

            if(!empty($business_profile_count) &&  $business_profile_count[0]['business_step']==4){
                $this->business_profile_link = base_url("business-profile/home");
                 $this->business_profile_set = 1;
            }
            if(!empty($artist_profile_count) &&  count($artist_profile_count)>1){
                $this->artist_profile_link = base_url("artist/home");
                $this->artist_profile_set = 1;
            }
            if(!empty($job_profile_count) &&  count($job_profile_count)>0){
                $this->job_profile_link = base_url("job/home");
                $this->job_profile_set = 1;
            }
            if(!empty($recruiter_profile_count) &&  count($recruiter_profile_count)>0){
                $this->recruiter_profile_link = base_url("recruiter/home");
                $this->recruiter_profile_set = 1;
            }
            if(!empty($freelancer_hire_profile_count) &&  count($freelancer_hire_profile_count)>0){
                $this->freelance_hire_profile_link = base_url("freelance-hire/home");
                $this->freelance_hire_profile_set = 1;
            }
             if(!empty($freelancer_apply_profile_count) &&  count($freelancer_apply_profile_count)>0){
                $this->freelance_apply_profile_link = base_url("freelance-work/home");
                $this->freelance_apply_profile_set = 1;
            }
        /*Code for business profile link end*/
         $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="javascript:void(0)" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="'. $this->artist_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->business_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->job_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.$this->recruiter_profile_link.'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.$this->freelance_hire_profile_link.'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
         ?>