<div class="container pt20 mobp0 detail-page">
    <div class="custom-user-list">
        <div class="list-box-custom">
            <h3>Details</h3>
            <div class="p15 fw">
                <div class="detail-box">
                    <h4>Basic Information</h4>
                    <ul>
                        <li><b>Name:</b> <span>{{details_data.first_name}} {{details_data.last_name}}</span></li>                        
                        <li><b>Designation:</b> <span>{{details_data.Designation}}</span></li>
                        <li><b>Field:</b> <span>{{details_data.Industry}}</span></li>
                        <li><b>City:</b> <span>{{details_data.City}}</span></li>
                        <li><b>DOB:</b> <span>{{details_data.DOB}}</span></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="right-add">
        <div class="custom-user-add">
            <img ng-src="<?php echo base_url('assets/n-images/add.jpg') ?>">
        </div>
    </div>
</div>