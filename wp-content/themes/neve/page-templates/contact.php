<?php /* Template Name: Contacts */ ?>

<?php get_header(); ?>

<?php
if ( have_posts() ) {
?>

    <!-- User definition -->
<?php
    $ctc_account_id = wp_get_current_user()->ID;
    
    $sql = "SELECT MAX(CTC_ID) FROM CONTACT";
    $userID = $wpdb->get_var($sql) + 1;
    $userID = 'u' . str_pad($userID, 7 , '0' , STR_PAD_LEFT);
    $password = wp_generate_password ( $length = 12, $special_chars = true, $extra_special_chars = false );

    $sql = "SELECT COUNT(CTC_TYPE) FROM CONTACT WHERE CTC_TYPE = 'GUARDIAN'";
    $result = $wpdb->get_var($sql);
    $guardian_popup = $result < 4 ? 'we need at least 3 to make the service work.' : '' ;

    $sql = "SELECT COUNT(CTC_TYPE) FROM CONTACT WHERE CTC_TYPE = 'RECIPIENT'";
    $rep_count = $wpdb->get_var($sql);
    $recipient_popup = $rep_count == 0 ? 'At present, there are not recipient.' : '' ;

    $sql = "SELECT PLN_NB_RECIP FROM PLAN, ACCOUNT WHERE ACT_ID = '" . $ctc_account_id . "' AND ACT_PLAN = 'PLN_CODE'";
    $result = $wpdb->get_var($sql);
    $recipient_max_popup =  $result > $rep_count? 'The count of recipient is exceeded.' : '';

    $sql = "SELECT ACT_PLAN FROM ACCOUNT WHERE ACT_ID = '" . $ctc_account_id . "'";
    $plan = $wpdb->get_var($sql);

?>    
    <div class="other_elements">
		<input type="hidden" value="<?php bloginfo('template_directory');?>" id="theme_url" />
        <input type="hidden" value="<?=home_url();?>" id="site_url"/>
    </div>
    
    <div class="container mt-5 p-3">

        <h2 class="p-2 mx-3"><strong>My Contacts</strong></h2>
        <div class='form-field p-5'>
            <div class="m-4" style="max-height: 200px; overflow: auto;">
                <div class="table-responsive-sm">
                    <table class="table table-bordered" style="margin-bottom: 0; margin-top: 0; " id='contactTable'>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-around m-3">
                <button type="button" onclick='add_fill()'>Add</button>
                <button type="button"  data-toggle="modal" data-target="#deleteModal">Delete</button>
                <a href='<?=home_url();?>'><button type="button">Close</button></a>
            </div>

            <div class='form-field p-5 mt-5 invisible'>
                <form action="contact_form_action.php" method="POST" id="contact" name='contact' class="needs-validation" novalidate>
                    <input type = 'hidden' name='accountId' value=<?php echo $ctc_account_id; ?> id='accountId' />
                    <input type='hidden' id='ctc_id' name='ctc_id' />

                    <div class='mx-5 p-2'><h4 class='mx-5'>Contact Information</h4></div>

                    <div class="row m-3 p-2">
                        <div class="col-12 col-md-4">
                            <div class="form-group mx-3">
                                <label for="firstName">First Name (*)</label>
                                <input type="text" class="form-control input-lg" id="firstName" placeholder="Enter your first name" name="firstName" required />
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mx-3">
                                <label for="lastName">Last Name (*)</label>
                                <input type="text" class="form-control input-lg" id="lastName" placeholder="Enter your last name" name="lastName" required />
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mx-3">
                                <label for="emailAdress">Email Address (*)</label>
                                <input type="email" class="form-control input-lg" id="emailAddress" placeholder="Enter your email address" name="emailAddress" required />
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="m-3 p-2 row">
                        <div class=' form-group mx-3 col-12 col-md-6'>
                            <label for="phone">Your mobile number(*)</label><br>
                            <input type='hidden' name='mobileNumber' />

                            <input id="phone" name="phone" type="tel" class="form-control input-lg" required>
                            <span id="valid-msg" class="invisible"> Valid</span>
                            <span id="error-msg" class="invisible"></span>

                        </div>
                    </div>

                    <div class="m-3 p-2 row">
                        <div class=' form-group mx-3 col-12 col-md-6'>
                            <label for="country">Country of residence (*)</label>
                            <select class="form-control input-lg country" id="country" name='country' style='font-size: 14px;' required></select>
                            <div class="valid-feedback" >Valid.</div>
                            <div class="invalid-feedback" >Please select one country at least.</div>
                        </div>
                    </div>

                    <div class="form-check mx-5 my-3 ">
                        <input type="checkbox" name="addressCheck" required> I certify I live in the country mentioned above
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Check this checkbox to continue.</div>
                    </div>

                    <div class="m-3 p-2 mt-5">
                        <div class="card m-4 p-2" style="position: relative;">
                            <div class="row mt-3 mx-2">
                                <div class="col-12 col-lg-2">
                                    <div class="radio">
                                        <label><input type="radio" name="typeOfContact" value='GUARDIAN' checked> Guardian</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="radio">
                                        <label><input type="radio" name="typeOfContact" value='INSIDER'> Insider</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="radio">
                                        <label><input type="radio" name="typeOfContact" value='RECIPIENT'> Recipient</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="radio">
                                        <label><input type="radio" name="typeOfContact" value='INSIDER_RECIP'> Insider & Recipient</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="radio">
                                        <label><input type="radio" name="typeOfContact" value='GUARDIAN_RECIP'> Guardian & Recipient</label>
                                    </div>
                                </div>
                            </div>
                            <div style="position: absolute; left: 30px; top: -15px; background-color: white;" class="px-2">
                                <p style="font-size: larger;"><strong> Type of contact </strong></p>
                            </div>
                            <div class='my-2 p-2 bg-warning invisible text-center' id='type_alert'></div>
                        </div>
                    </div>
                    <div class="m-3 p-2 mt-5">
                        <div class="card m-4 p-2" style="position: relative;">
                            <div class="row mt-3 mx-2">
                                <div class="col 12 col-md-6">
                                    <label for="userID">User</label>
                                    <input type="text" class="form-control" id="userID" name="userID" readonly value='<?php echo $userID; ?>'>
                                </div>
                                <div class="col 12 col-md-6">
                                    <label for="userID">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" readonly value='<?php echo $password; ?>'>
                                </div>
                            </div>
                            <p class="mt-2 invisible" id='checkInsider'><small>Please take note of the user id and password as you will have to communicate it to this contact</small></p>
                            <div style="position: absolute; left: 30px; top: -15px; background-color: white;" class="px-2">
                                <p style="font-size: larger;"><strong> Contact Credentials </strong></p>
                            </div>
                        </div>

                        <div class="mx-4">
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" rows="5" id="message" name='message'></textarea>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="d-flex justify-content-around m-3">
                    <button type="button" onclick='save()'>Save</button>
                    <button type="button" data-toggle="modal" data-target="#cancelModal" >Cancel</button>
                </div>
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
                    <div class="modal-body save-modal-body">
                        Your contact information has been inserted/updated correctly.
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
                        <a href="<?=home_url();?>"><button type="button" class='modal_button'>Confirm</button></a>
                        <button type="button" data-dismiss="modal" class='modal_button'>Go back</button>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please confirm you want to delete this contact.</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        Do you confirm deleting?
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class='modal_button' onclick='delete_row()' data-dismiss="modal">Confirm</button>
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
        var ctc_ids, stop;

        getCountryName();
        refresh_table(); 

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

        var rad = document.contact.typeOfContact;
        for(let i = 0; i < rad.length; i++) {
            rad[i].addEventListener('change', function() {
                var checkInsider = document.querySelector("#checkInsider");
                if(i == 1) {
                    checkInsider.classList.remove("invisible");
                }
                else checkInsider.classList.add("invisible");
            });
        }

       function save() {
            
            stop = 'N';
            validate();
            if(stop == 'Y') return;

            const plan = '<?php echo $plan; ?>';
            if($('input[name=typeOfContact]').val() == 'INSIDER' && plan == 'FREE'){
                $('#type_alert').removeClass('invisible');
                $('#type_alert').html('<h6>You can not add a insider</h6>');
                return;
            }
            var currentUrl = $('#theme_url').val() + '/page-templates/account_management/contact/contact_form_action.php';
            $.ajax({
                url : currentUrl || window.location.pathname,
                type: "POST",
                data: {
                    firstName: $('input[name=firstName]').val(),
                    lastName: $('input[name=lastName]').val(),
                    emailAddress: $('input[name=emailAddress]').val(),
                    mobileNumber: $('input[name=mobileNumber]').val(),
                    country: $("select.country").children("option:selected").val(),
                    typeOfContact: $('input[name=typeOfContact]').val(),
                    password: $('input[name=password]').val(),
                    message: $.trim($("#message").val()),
                    accountId: $('input[name=accountId]').val()
                },
                success: function (data) {
                    console.log(data);
                    $('.save-modal-body').html('Your contact information has been ' + data + ' correctly.');
                    $('#saveModal').modal('show');
                    refresh_table();
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


        function row_click(row) {
            $('table > tr').css('background-color', '#f0f0f0');
            $(row).css('background-color', 'lightgrey');
            var string_ctcids = ctc_ids.split(" ");
            $('input[name=ctc_id]').val(string_ctcids[row.rowIndex]);
            $('.form-field').removeClass('invisible');
        }
        
        function delete_row() {
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/contact/delete_row.php',
                data: { ctc_id: $('input[name=ctc_id]').val()}, 
                success:function(data){
                    refresh_table();
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
        function add_fill() {
            $('.form-field').removeClass('invisible');
            if($('input[name=ctc_id]').val() == '') return;
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/contact/add_fill.php',
                data: { ctc_id: $('input[name=ctc_id]').val()}, 
                success:function(data){
                    var dat = JSON.parse(data);
                    
                    $('input[name=firstName').val(dat.CTC_FIRST_NAME);
                    $('input[name=lastName').val(dat.CTC_LAST_NAME);
                    $('input[name=emailAddress').val(dat.CTC_EMAIL);
                    $('input[name=phone').val(dat.CTC_PHONE);
                    $('input[name=userID').val($('input[name=ctc_id]').val());
                    $('input[name=country').val(dat.CTC_COUNTRY);
                    $('input[name=password').val(dat.CTC_PASSWORD);
                    $("textarea#message").val(dat.CTC_MESSAGE);

                    const radios = document.forms.contact.elements.typeOfContact;
                    for(var i = 0; i < radios.length; i ++) {
                        if(radios[i].value == dat.CTC_TYPE) {
                            radios[i].checked = true;
                            break;
                        }
                    }
                    
                    
                    //$('input[name=typeOfContact][value=dat.CTC_TYPE]').checked = true;
                    //refresh_table();
                },
                error: function (jXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

        }
        function refresh_table() {            
            $.ajax({
                type: "POST",
                url: $('#theme_url').val() + '/page-templates/account_management/contact/refresh_table.php',
                data: { accountId: $('input[name=accountId]').val()}, 
                success:function(data){
                    ctc_ids = data.split("###")[0];
                    var tableContent = data.split("###")[1];
                    $('#contactTable').html(tableContent);
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
