<?php echo $head_profile_reg; ?>  
<body ng-app="SelectModule">
<section ng-app ng-controller="Controller">
    	<h2 class="page-title">Model</h2>

    <div class="row-fluid">
        <div class="span4">
            <label for="cboGroup">Countries</label>
            <select data-ng-model="currentCountry" data-ng-options="country.name for country in Countries.items">
                <option value="">Please select a country</option>
            </select>
        </div>
        <div class="span4">
            <label for="cboItem">States</label>
            <select data-ng-model="currentItem" data-ng-options="item.id as item.name for item in States.StateGroups[currentCountry.StateGroupID].items">
                <option value="">Please select a state</option>
            </select>
            
        </div>
        <BR>
        <div class="well">what I am trying to archive is that the items are changing each time the group changes.</div>
        <BR>
        <div>Countries : {{Countries.items | json}}</div>
        <div>States : {{urrentStates.items | json}}</div>
    </div>
</section>
 <script type="text/javascript" src="<?php echo base_url('assets/js/angular-validate.min.js?ver=' . time()) ?>"></script>
<script>
angular.module("SelectModule", [])
    .controller("Controller", function selectController($scope) {
   
    var Countries = {
        "id": "field10",
            "items": [{
            "id": "10",
                "StateGroupID": 0,
                "name": "United State"
        }, {
            "id": "2",
                "StateGroupID": 1,
                "name": "Canada"
        }]
    };

    $scope.States = {
        "id": "field20",
            "StateGroups": [{
            "items": [{
                "id": "1",
                    "name": "Alabama"
            }, {
                "id": "2",
                    "name": "Alaska"
            }, {
                "id": "3",
                    "name": "Arizona"
            }, {
                "id": "4",
                    "name": "California"
            }]
        }, {
            "items": [{
                "id": "201",
                    "name": "Alberta"
            }, {
                "id": "202",
                    "name": "British Columbia"
            }, {
                "id": "303",
                    "name": "Manitoba"
            }, {
                "id": "304",
                    "name": "Ontario"
            }]
        }]
    };
    $scope.Countries = Countries;
});

</script>