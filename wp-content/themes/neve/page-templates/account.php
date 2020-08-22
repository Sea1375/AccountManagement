<?php /* Template Name: Account */ ?>

<?php get_header(); ?>
<?php
if ( have_posts() ) {
?>
<?php

    $account_id = wp_get_current_user()->ID;

    $sql = "SELECT ACT_FIRST_NAME, ACT_PLAN, ACT_ADDRESS_LINE1, ACT_EMAIL, ACT_PHONE,
      ACT_NOTIF_EMAIL, ACT_NOTIF_SMS, ACT_LAST_NAME, ACT_COUNTRY,
      ACT_AUTO_PULSE_CHECK, ACT_PULSE_CHECK_FREQ, ACT_ADDRESS_LINE2, ACT_CITY, ACT_STATE_PROVINCE,
       ACT_POSTAL_CODE, ACT_BIRTH_YEAR FROM ACCOUNT WHERE ACT_ID = '" . $account_id ."'";
    $results = $wpdb->get_results($sql);

    $act_firstName = $results[0]->ACT_FIRST_NAME;
    $act_plan = $results[0]->ACT_PLAN;
    $act_streetLine1 = $results[0]->ACT_ADDRESS_LINE1;
    $act_emailAddress = $results[0]->ACT_EMAIL;
    $act_phone = $results[0]->ACT_PHONE;

    if($results[0]->ACT_NOTIF_SMS == 'Y') {
        $act_noticeSMS = 'checked';
        $act_noticeEmail = '';
    } else {
        $act_noticeEmail = 'checked';
        $act_noticeSMS = '';
    }

    $act_lastName = $results[0]->ACT_LAST_NAME;
    $act_country = $results[0]->ACT_COUNTRY;
    $act_pulseRadio = $results[0]->ACT_AUTO_PULSE_CHECK == 'Y' ? '' : 'checked';
    $act_auto = $act_pulseRadio == '' ? 'checked' : '';

    $act_frequency = $results[0]->ACT_PULSE_CHECK_FREQ;
    $act_streetLine2 = $results[0]->ACT_ADDRESS_LINE2;
    $act_city = $results[0]->ACT_CITY;
    $act_stateProvince = $results[0]->ACT_STATE_PROVINCE;
    $act_postalCode = $results[0]->ACT_POSTAL_CODE;
    $act_birthYear = $results[0]->ACT_BIRTH_YEAR;

    $readonly = '';

    if($act_plan == 'FREE') {
        $readonly = 'readonly';
        $act_frequency = '4';
    } else if($act_plan == 'STANDARD') {
        $readonly = 'readonly';
        $act_frequency = '2';
    }

?>
    <!-- User definition -->

    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
		<input type="hidden" value="<?=home_url();?>" id="site_url" />
	</div>

    <div class="container mt-5 p-3">

        <h2 class="p-2 mx-3"><strong>My Account</strong></h2>

        <div class='form-field p-5'>
            <form action="account_form_action.php" method="POST" id="account" class="needs-validation" novalidate>
                
                <input type="hidden" value="<?php echo $account_id; ?>" name="accountId" />
                <input type='hidden' value='N' name='actAuto' />

                <div class='mx-5 p-2'><h4 class='mx-5'>Update Your Account Details</h4></div>
                
                <div class="row m-3 p-2">
                    <div class="col-12 col-md-6">
                        <div class="form-group mx-3">
                            <label for="firstName">First Name (*)</label>
                            <input type="text" class="form-control input-lg" id="firstName" placeholder="Enter your first name" name="firstName" value='<?php echo $act_firstName; ?>' required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mx-3">
                            <label for="lastName">Last Name (*)</label>
                            <input type="text" class="form-control input-lg" id="lastName" placeholder="Enter your last name" name="lastName" value='<?php echo $act_lastName; ?>'  required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                </div>
                
                <div class='m-3 p-2'>
                    <div class="card m-3" style="position: relative;">
                        <div class="card-body m-3">
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="streetLine1">Street Line 1 (*)</label>
                                        <input type="text" class="form-control input-lg" id="streetLine1" placeholder="Enter your street line 1" name="streetLine1" value='<?php echo $act_streetLine1; ?>' required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="streetLine2">Street Line 2</label>
                                        <input type="text" class="form-control input-lg" id="streetLine2" placeholder="Enter your street line 2" name="streetLine2" value='<?php echo $act_streetLine2; ?>' >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="city">City (*)</label>
                                        <input type="text" class="form-control input-lg" id="city" placeholder="Enter your city" name="city" value='<?php echo $act_city; ?>' required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="stateProvince">State/Province</label>
                                        <input type="text" class="form-control input-lg" id="stateProvince" placeholder="Enter your state/province" name="stateProvince" value='<?php echo $act_stateProvince; ?>'>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="postalCode">Postal Code (*)</label>
                                        <input type="text" class="form-control input-lg" id="postalCode" placeholder="Enter your postal code" name="postalCode" value='<?php echo $act_postalCode; ?>' required>
                                        <div class="valid-feedback">Valid.</div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mx-3 my-3">
                                        <label for="country">Country (*)</label>
                                        <select class="form-control input-lg country" id="country" name='country' style='font-size: 14px;' required></select>
                                        <div class="valid-feedback" >Valid.</div>
                                        <div class="invalid-feedback" >Please select one country at least.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mx-4 my-3 ">
                                <input type="checkbox" name="addressCheck" required> I certify I live in the country mentioned above
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Check this checkbox to continue.</div>
                            </div>    
                        </div>
                        <div style="position: absolute; left: 30px; top: -15px; background-color: white;" class="px-2">
                            <p style="font-size: larger;"><strong>Address where you live </strong>(for sales tax and data privacy purposes)</p>
                        </div>
                    </div>
                </div>
                
                <div class="row m-3 p-2">
                    <div class="col-12 col-md-6">
                        <div class="form-group mx-3">
                            <label for="emailAddress">Email Address (*)</label>
                            <input type="email" class="form-control input-lg" id="emailAddress" placeholder="Enter your email address" name="emailAddress" value='<?php echo $act_emailAddress; ?>' required readonly>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group mx-3">
                            <label for="country">Birth Year (*)</label>
                            <input type="number" class="form-control input-lg" id="birthYear" placeholder="Enter your birth year" name="birthYear" value='<?php echo $act_birthYear; ?>' required>
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback birthyear_score">Please fill out this field with correct value.</div>
                        </div>
                    </div>
                </div>
                <div class="m-3 p-2 row">
                    <div class=' form-group mx-3 col-12 col-md-6'>
                        <label for="phone">Your mobile number(*)</label><br>
                        <input type='hidden' name='mobileNumber' />
                        
                        <input id="phone" name="phone" type="tel" class="form-control input-lg" value='<?php echo $act_phone; ?>' required>
                        <span id="valid-msg" class="invisible"> Valid</span>
                        <span id="error-msg" class="invisible"></span>
                        
                    </div>
                </div>
                
                <div class="m-3 p-2 form-check">
                    <label class='mx-5'>Please select your notification preference</label>
                    <div class="row m-2">
                        <div class="col-12 col-md-3 mx-3">
                            <div class='form-group'>
                                <input type="checkbox" name = 'noticeEmail' id = 'noticeEmail' <?php echo $act_noticeEmail; ?>  > Email
                                <div class="valid-feedback" >Valid.</div>
                                <div class="invalid-feedback" >Please check out one field at least.</div>
                            </div>  
                        </div>
                        <div class="col-12 col-md-3 mx-3">
                            <label class="checkbox-inline form-check-label">
                                <input type="checkbox" name = 'noticeSMS' id = 'noticeSMS' <?php echo $act_noticeSMS; ?>> SMS
                            </label>
                        </div>
                        
                    </div>
                </div>

                <div class="m-3 p-2 my-5">
                    <label class='mx-5'>Please select your pulse check frequency preference:</label>
                    <div class='mx-5'>
                        <div class="radio">
                            <label>
                            <input type="radio" name="pulseRadio" value = 'every' <?php echo $act_pulseRadio; ?> style='top: 8px;'> Every 
                            <input type="number" id="frequency" placeholder="" name="frequency" value='<?php echo $act_frequency; ?>' min='1' max='8' <?php echo $readonly; ?> > weeks
                            </label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="pulseRadio" value='automatic' <?php echo $act_auto; ?> > Automatic</label>
                        </div>
                    </div>
                </div>
                <div>
                <div class="m-5 p-2">
                    <div class='mx-3 form-group'>
                        <input type="checkbox" value="" required> I have read and agree with the Need2Tellyou<sup>TM</sup> <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                        <div class="valid-feedback" >Valid.</div>
                        <div class="invalid-feedback" >Please check out one field at least.</div>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-around m-3">
                <button type="button" onclick='save()'>Save</button>
                <button type="button" data-toggle="modal" data-target="#cancelModal" >Cancel</button>
            </div>
        </div>

        <div class="modal fade" id="saveModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Success</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Your account information has been updated correctly.
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class='modal_button'>OK</button>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="cancelModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please confirm you want to leave this page</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Confirming will bring you to the home page
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a href='#'><button type="button" class='modal_button'>Confirm</button></a>
                        <button type="button" data-dismiss="modal" class='modal_button'>Go back</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        
        var iti = window.intlTelInput(input, {
            nationalMode: true,
            allowDropdown: true,
            autoHideDialCode: false,
            separateDialCode: true,
            utilsScript: "build/js/utils.js",
        });
        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("invisible");
            validMsg.classList.add("invisible");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
            reset();
            if (input.value.trim()) {
                if (iti.isValidNumber()) {
                    $('input[name=mobileNumber]').val(iti.getNumber());
                    validMsg.classList.remove("invisible");
                } else {
                    input.classList.add("error");
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("invisible");
                }
            }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script>

    <script>
        var stop;
        getCountryName();
        function getCountryName() {
            var request_url = $('#theme_url').val() + '/page-templates/account_management/get_countryName.php';
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("country").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET",request_url,true);
            xmlhttp.send();
        }

        function save() {
            var index = $("input[name=pulseRadio]")[0].checked ? 0 : 1;
            if(index == 1) $("input[name=actAuto]").val('Y');
            
            get_max_birthyear();
            
            stop = 'N';
            validate();
            if(stop == 'Y') return;

            const currentUrl = $('#theme_url').val() + '/page-templates/account_management/account/account_form_action.php';

            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: {
                    accountId: $('input[name=accountId]').val(),
                    addressCheck: $('input[name=addressCheck]').val(),
                    noticeSMS: $('input[name=noticeSMS]').val(),
                    noticeEmail: $('input[name=noticeEmail]').val(),
                    actAuto: $('input[name=actAuto]').val(),
                    frequency: $('input[name=frequency]').val(),
                    firstName: $('input[name=firstName]').val(),
                    lastName: $('input[name=lastName]').val(),
                    streetLine1: $('input[name=streetLine1]').val(),
                    streetLine2: $('input[name=streetLine2]').val(),
                    city: $('input[name=city]').val(),
                    stateProvince: $('input[name=stateProvince]').val(),
                    postalCode: $('input[name=postalCode]').val(),
                    country: $("select.country").children("option:selected").val(),
                    emailAddress: $('input[name=emailAddress]').val(),
                    birthYear: $('input[name=birthYear]').val(),
                    mobileNumber: $('input[name=mobileNumber]').val()
                },
                success: function (data) {
                    $('#saveModal').modal('show');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        function validate() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
            
                if (form.checkValidity() === false) {
                    stop = 'Y';            
                }
                form.classList.add('was-validated');
            
            });
        }
        $('input[name=noticeSMS]').change(function(){
            if(!$(this).is(':checked')) {
                document.getElementById("noticeEmail").required = true;
            } else {
                document.getElementById("noticeEmail").required = false;
            }
        });
    
        
        function get_max_birthyear() {   
            console.log('country', $("select.country").children("option:selected").val());
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/account/account_birthday.php',
                data: { country: $("select.country").children("option:selected").val()},
                success:function(data){
                    console.log('max', data);
                    $("input[name=birthYear]").attr({
                        "max" : data,
                        "min" : 1880          
                    });
                    $('.birthyear_score').html('This field must be between 1880 and ' + data + '.');
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

    </script>


<?php
}
?>
<?php get_footer(); ?>