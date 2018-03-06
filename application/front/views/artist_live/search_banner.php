<div class="search-banner" ng-controller="searchArtistController">
    <div class="container">
        <div class="text-right pt20">
            <a class="btn5" href="<?php echo $artist_profile_link ?>">Create Artist Profile</a>
        </div>
        <div class="search-bnr-text">
            <h1>Find The Artist That Fits Your Life</h1>
        </div>
        <div class="search-box">
            <form ng-submit="searchSubmit()">
                <div class="search-input">
                    <input type="text" ng-model="keyword" id="q" name="q" placeholder="Company, Cat, Products" autocomplete="off">
                    <input type="text" ng-model="city" id="l" name="l" placeholder="Location" autocomplete="off">
                    <input type="submit" class="btn1" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>