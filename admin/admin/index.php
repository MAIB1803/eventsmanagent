<?php include("header.php");
include("./class/config.php");
include("./class/helperFunction.php");
$no = noOfPost(config::getConn(), "event");

?>

<div class="sidebody-contents">
    <div method="POST" enctype="multipart/form-data" class="form" id="showForm">
        <!-- <h5> Add Event</h5>

        <input type="text" id="title" placeholder="Event Title" class="input mt-20">
        <input type="text" id="location" placeholder="Location" class="input mt-20">
        <input type="text" id="city" placeholder="City" class="input mt-20">
        <h6 class="mt-20">Add Description </h6>
        <br>
        <input type="text" id="desc" name="desc" placeholder="Event Description" class="input ">
        <h6 class="mt-10">Select Image </h6>
        <input type="file" id="fileCompanylogo" class="input mt-10">
        <h6 class="mt-10">Start Date</h6>
        <input type="date" id="start_date" placeholder="Start date" class="input mt-10">
        <h6 class="mt-10">End Date</h6>
        <input type="date" id="end_date" placeholder="End date" class="input mt-10">
        <h6 class="mt-20" id="result"></h6>

        <button type="submit" name="submit" class="btn-submit mt-20 color-w ">
            <h6 class="fw-400 ls-1" onclick="takePostData(this)">SUBMIT</h6>
        </button> -->

    </div>
    <div class="">
        <div class="number-cards p-20">
            <h4 class="color-w "> <?= $no; ?></h4>
            <h6 class="color-w mt-30">POST</h6>
        </div>

    </div>
</div>
<div class="sidebody-contents1">
    <div>
        <input type="text" id="findLocation" placeholder="Event Location" class="input mt-20">
        <input type="text" id="findCity" placeholder="Event City" class="input mt-20">
        <button type="submit" name="submit" class="btn-submit mt-20 color-w ">
            <h6 class="fw-400 ls-1" onclick="find(this)">Search</h6>
        </button>
    </div>
    <table class="table" id="showALL">
    </table>
</div>
</div>
</section>
<script src="js/app.js"></script>
<script src="js/model.js"></script>
</body>

</html>