<?php
switch ($fileView) {
    case 'reset_password':

?>

        <form class="changePassForm">
            <input type="hidden" value="<?= $_SESSION['userMode'] ?>" id="userID">
            <ul class="list-group">
                <li class="list-group-item py-0 border-0 bg-transparent text-center">
                    <div class="alertbox alertContainer text-center success-alert"><?= $_SESSION['otpstatus'] ?></div>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <div class="form-group">
                        <div class="input-group border-custom rounded">
                            <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-key"></i></span>
                            <input type="number" name="otp" class="form-control border-0" id="otp" placeholder="OTP" required />
                        </div>
                    </div>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <div class="form-group">
                        <div class="input-group border-custom rounded">
                            <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control border-0" id="password" placeholder="New Password" oninput="valPass(this)" required />
                        </div>
                        <div class="passAlert d-none bg-warning rounded px-1 mt-1 small"></div>
                    </div>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <div class="form-group">
                        <div class="input-group border-custom rounded">
                            <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            <input type="password" name="confirm_password" class="form-control border-0" id="password" placeholder="Confirm Password" required />
                        </div>
                    </div>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <table class="table table-borderless m-0 align-middle">
                        <tr>
                            <td class="p-0 text-start">
                                <label><input type="checkbox" onchange="showPassword(this)" /> Show Password</label>
                            </td>
                            <td class="p-0 text-end"><a href="<?= ROOT ?>auth/forgot_password">Resent OTP</a></td>
                        </tr>
                    </table>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <button class="form-control pg-theme px-4 rounded text-white passSubmitBtn" disabled="disabled">Save New Password</button>
                </li>
            </ul>
        </form>

    <?php
        break;
    case 'forgot_password':
    ?>

        <ul class="list-group">
            <li class="list-group-item py-0 border-0 bg-transparent text-center">
                <h6>Where do you want to receive a verification code?</h6>
                <div class="alertbox alertContainer text-center"></div>
            </li>
            <?php if (!(empty(($_SESSION['userData']->user_email) or ($_SESSION['userData']->user_phone)))) { ?>
                <?php if (!(empty(($_SESSION['userData']->user_email)))) : ?>
                    <li class="list-group-item border-0 bg-transparent">
                        <button class="btn border text-dark w-100 text-start" onclick="passReqForm('email')">
                            <h6>To my email</h6>
                            <?= hide_email($_SESSION['userData']->user_email) ?>
                        </button>
                    </li>
                <?php endif; ?>
                <?php if (!(empty(($_SESSION['userData']->user_phone)))) : ?>
                    <li class="list-group-item border-0 bg-transparent">
                        <button class="btn border text-dark w-100 text-start" onclick="passReqForm('phone')">
                            <h6>To my phone number</h6>
                            <?= hide_phone(smartPhone($_SESSION['userData']->user_phone)) ?>
                        </button>
                    </li>
                <?php endif; ?>
            <?php } else { ?>
                <li class="list-group-item border-0 bg-transparent">
                    <div class="alert alert-warning">
                        You have not added either the Email address or Phone number to receive authentication OTP for account security. <br> Kindly contact school based admin for your account setups.
                    </div>
                </li>
            <?php } ?>
        </ul>

    <?php
        break;
    case 'password':
    ?>

        <form class="authPassForm">
            <ul class="list-group">
                <li class="list-group-item py-0 border-0 bg-transparent text-center">
                    <div class="alertbox alertContainer text-center"></div>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <div class="form-group">
                        <div class="input-group border-custom rounded">
                            <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control border-0" id="password" placeholder="Password" autofocus required />
                        </div>
                    </div>
                </li>
                <li class="list-group-item py-2 border-0 bg-transparent">
                    <table class="table table-borderless m-0 align-middle">
                        <tr>
                            <td class="p-0 text-start">
                                <label><input type="checkbox" onchange="showPassword(this)" /> Show Password</label>
                            </td>
                            <td class="p-0 text-end"><a href="<?= ROOT ?>auth/forgot_password">Forgot Password?</a></td>
                        </tr>
                    </table>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <button class="form-control pg-theme px-4 rounded text-white">Login</button>
                </li>
            </ul>
        </form>

    <?php
        break;
    default:
    ?>

        <form class="authFormSubmit">
            <ul class="list-group">
                <li class="list-group-item py-0 border-0 bg-transparent text-center">
                    <div class="alertbox alertContainer text-center"></div>
                </li>

                <?php
                switch ($data['user']) {
                    default:
                        if (!($data['user'] == "student")) {
                ?>
                            <li class="list-group-item border-0 bg-transparent">
                                <div class="form-group">
                                    <div class="input-group border-custom rounded">
                                        <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
                                        <input type="text" name="username" class="form-control border-0" id="username" placeholder="Email Address or User Name" autofocus required />
                                    </div>
                                </div>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="list-group-item border-0 bg-transparent">
                                <div class="form-group">
                                    <div class="input-group border-custom rounded">
                                        <span class="input-group-text border-0 bg-transparent text-muted" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
                                        <input name="adm" type="text" class="form-control border-0" id="adm" placeholder="Registration or Admission Number" autofocus required />
                                    </div>
                                </div>
                            </li>
                <?php
                        }
                        break;
                }
                ?>

                <!-- <li class="list-group-item border-0 py-2 bg-transparent">
                    <div id="recaptchaHtml"></div>
                </li> -->
                <li class="list-group-item border-0 py-2 bg-transparent">
                    <label for="rememberMe" class="">
                        <input type="checkbox" name="" id="rememberMe"> Remember Me
                    </label>
                </li>
                <li class="list-group-item border-0 bg-transparent">
                    <button class="form-control pg-theme px-4 rounded text-white">Continue</button>
                </li>
            </ul>
        </form>

<?php
        break;
}
