    <!-- Alert Boxes Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="alert-box d-none p-0" id="alertnobox">
                <div class="alert alert-danger d-flex flex-column align-items-center me-2 mt-2 alerttab" role="alert">
                    <div class="d-flex align-items-center point-none">
                        <div class="bi bi-exclamation-triangle">&nbsp;&nbsp;</div>
                        <div id="alertnoline">Someting went Wrong !</div>
                    </div>
                    <div>
                        <a class="btn mt-2 d-none" id="alertnobtn">Error</a>
                    </div>
                </div>
                <i onclick="alertDangerclose();" class="bi bi-x text-danger alert-close"></i>
            </div>
            <div class="alert-box d-none p-0" id="alertokbox">
                <div class="alert alert-success d-flex flex-column align-items-center me-2 mt-2 alerttab" role="alert">
                    <div class="d-flex align-items-center point-none">
                        <div class="bi bi-check2-all">&nbsp;&nbsp;</div>
                        <div id="alertokline">Something Happend !</div>
                    </div>
                    <div>
                        <a class="btn mt-2 d-none" id="alertokbtn">Success</a>
                    </div>
                </div>
                <i onclick="alertSuccessclose();" class="bi bi-x text-success alert-close"></i>
            </div>
        </div>
    </div>
    <!-- Alert Boxes End -->
