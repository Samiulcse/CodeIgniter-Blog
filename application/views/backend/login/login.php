<div class="container">

    <section>
        <div id="container_demo">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form">
                    <form id="loginForm" autocomplete="on">
                        <h1>Log in</h1>
                        <p class="text-denger text-center" id="login_error"></p>
                        <p>
                            <label for="lusername" class="uname" data-icon="u"> Your email or username </label>
                            <input id="lusername" name="username" required="required" type="text"
                                   placeholder="myusername or mymail@mail.com"/>
                            <span class="error text-danger" id="lusername_error"></span>
                        </p>
                        <p>
                            <label for="lpassword" class="youpasswd" data-icon="p"> Your password </label>
                            <input id="lpassword" name="password" required="required" type="password"
                                   placeholder="eg. X8df!90EO"/>
                            <span class="error text-danger" id="lpassword_error"></span>
                        </p>
                        <p class="login button">
                            <input type="button" id="loginBtn" value="Login"/>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {


        // login user

        $('#loginBtn').on('click', function () {

            var user_name = $('#lusername').val();
            var user_pass = $('#lpassword').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('login/login_validation') ?>",
                dataType: "JSON",
                data: {user_name: user_name, user_pass: user_pass},
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        $("#lusername_error").html("");
                        $("#lpassword_error").html("");

                        window.location.href = data.redirect;

                    } else {
                        $("#lusername_error").html(data.error.user_name);
                        $("#lpassword_error").html(data.error.user_pass);
                        $("#login_error").html(data.error.login_error);

                        console.log(data.error);
                    }
                }
            });
            return false;
        });

    });
</script>
<style>
    .text-danger {
        color: red;
        font-size: 12px;
        position: relative;
        left: 8%;
        top: 3px;
    }

    .text-center {
        text-align: center;
        left: 0 !important;
    }
</style>