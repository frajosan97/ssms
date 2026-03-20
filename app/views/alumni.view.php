<div class="container py-4">
    <div class="row clearfix">

        <?php if (!(in_array($fileView, ['login', 'register']))): ?>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm rounded-0">
                    <div class="card-body p-1">
                        <ul class="list-group text-capitalize">
                            <li class="list-group-item rounded-0 pg-theme">News & Socail Groups</li>
                            <?php if (isset($_SESSION['ALUMNI'])) { ?>
                                <li class="list-group-item rounded-0"><a href="<?= ROOT ?>alumni/account"><i
                                            class="fas fa-angle-right"></i> account</a></li>
                                <li class="list-group-item rounded-0"><a href="<?= ROOT ?>alumni/create"><i
                                            class="fas fa-angle-right"></i> Add alumni page</a></li>
                            <?php } else { ?>
                                <li class="list-group-item rounded-0"><a href="<?= ROOT ?>alumni/login"><i
                                            class="fas fa-angle-right"></i> login</a></li>
                            <?php } ?>
                            <?php if (DPAGES): ?>
                                <?php foreach (DPAGES as $key => $value) { ?>
                                    <li class="list-group-item rounded-0"><a href="<?= ROOT ?>alumni/<?= $value->page_key ?>"><i
                                                class="fas fa-angle-right"></i> <?= $value->page_sub_title ?></a></li>
                                <?php } ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php switch ($fileView) {
            case "create":
                ?>

                <div class="col-md-9 mb-3">
                    <form class="dynamicPageForm">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <input type="hidden" name="main_page" value="alumni">
                                <div class="form-group mb-2">
                                    <label for="">Page sub title</label>
                                    <input type="text" name="page_sub_title" placeholder="Page sub title" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <textarea name="page_article" class="form-control" id="editor"></textarea>
                                </div>
                            </div>
                            <div class="card-footer border-0 bg-transparent mb-2">
                                <button type="reset" class="btn btn-outline-danger float-start"><i class="fas fa-undo"></i>
                                    Reset</button>
                                <button class="btn btn-outline-custom float-end"><i class="fas fa-user-plus"></i> Create
                                    Page</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                break;
            case "account":
                ?>

                <div class="col-md-9 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <?php foreach ($_SESSION['ALUMNI'] as $key => $value) { ?>
                                <?php if (!(in_array($key, ['id', 'sch_token', 'al_key', 'al_email', 'al_password', 'date']))): ?>
                                    <div class="form-group mb-2">
                                        <label for="<?= $key ?>"><?= str_replace("al_", "", $key) ?></label>
                                        <input type="text" id="<?= $key ?>" value="<?= $value ?>" class="form-control">
                                    </div>
                                <?php endif; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php
                break;
            case "login":
                ?>

                <div class="col-md-9 mx-auto my-5 py-5">
                    <div class="card border-0 rounded-0 shadow bg-img">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col">
                                    <div class="card border-0 rounded-0 shadow-none">
                                        <div class="card-body py-5">
                                            <form class="alumniLoginForm">
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <h5>Sign in</h5>
                                                        <hr class="dividerDiv1">
                                                    </li>
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <div class="form-group">
                                                            <div class="input-group border-custom rounded">
                                                                <span
                                                                    class="input-group-text border-0 bg-transparent text-muted"
                                                                    id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                                                <input type="text" name="email" class="form-control border-0"
                                                                    id="email" placeholder="Email Address" autofocus required />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <div class="form-group">
                                                            <div class="input-group border-custom rounded">
                                                                <span
                                                                    class="input-group-text border-0 bg-transparent text-muted"
                                                                    id="basic-addon1"><i class="fas fa-lock"></i></span>
                                                                <input type="password" name="password"
                                                                    class="form-control border-0" id="password"
                                                                    placeholder="Password" autofocus required />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-2 border-0 bg-transparent">
                                                        <table class="table table-borderless m-0 align-middle">
                                                            <tr>
                                                                <td class="p-0 text-start">
                                                                    <label><input type="checkbox"
                                                                            onchange="showPassword(this)" /> Show
                                                                        Password</label>
                                                                </td>
                                                                <td class="p-0 text-end"><a
                                                                        href="<?= ROOT ?>auth/forgot_password">Forgot
                                                                        Password?</a></td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <button
                                                            class="form-control pg-theme px-4 rounded text-white">Login</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center d-none d-sm-grid text-white">
                                    <p class="text-center">
                                        Not a member yet? <br><br>
                                        <a href="https://wa.me/<?= smartPhone(APPINFO->sch_phone) ?>/?text=Hello, i am an alumni of *<?= strtoupper(cleanHtml(APPINFO->sch_name)) ?>* and i hereby enquire for membership. Kindly guide me on the way forward."
                                            class="btn btn-outline-light">Request for membership now</a> <br><br>
                                        <a href="" class="text-white"><u>Membership procedures</u></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                break;
            case "register":
                ?>

                <div class="col-md-9 mb-3 mx-auto">
                    <div class="card border-0 shadow-sm bg-img">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col">
                                    <div class="card border-0 rounded-0 rounded-start shadow-none">
                                        <div class="card-body">
                                            <form class="alumniSignUpForm">
                                                <ul class="list-group">
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <h6>Sign Up</h6>
                                                        <hr class="dividerDiv1">
                                                    </li>
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <input type="hidden" name="al_key" value="<?= $data['al_key'] ?>">
                                                        <div class="form-group">
                                                            <div class="input-group border-custom rounded">
                                                                <span
                                                                    class="input-group-text border-0 bg-transparent text-muted"
                                                                    id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                                                <input type="text" name="email" class="form-control border-0"
                                                                    id="email" placeholder="Email Address" autofocus required />
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item border-0 bg-transparent">
                                                        <button class="form-control pg-theme px-4 rounded text-white">Sign
                                                            up</button>
                                                    </li>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center d-none d-sm-grid text-white">
                                    <p class="text-center">
                                        Already a registered member? <br><br>
                                        <a href="<?= ROOT ?>alumni/login" class="btn btn-outline-light">Login to your
                                            account</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                break;
            default:
                ?>

                <div class="col-md-9 mb-3">
                    <div class="card border-0 rounded-0 shadow-sm">
                        <div class="card-body">
                            <?php if (isset($data['page'])) { ?>
                                <?= $data['page']->page_article ?>
                            <?php } else { ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-md-9 mb-3">
                    <div class="card border-0 rounded-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 rounded-0 maincolor h4">
                            <?= strtoupper(APPINFO->sch_name . " alumni association") ?>
                            <hr class="dividerDiv1 my-2">
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h5 class="maincolor text-center">OUR PROMINENT ALUMNI</h5>
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm rounded-0 h-100">
                                <img src="" class="card-img-top" alt="">
                                <div class="card-body">
                                    <h6>Francis Kioko Kilonzo</h6>
                                    Software developer - KATHEKA BOYS
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <?php
                break;
        } ?>

    </div>
</div>