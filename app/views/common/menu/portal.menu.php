<?php

switch (VIEWFOLDER) {
    case 'staff':
        ?>
        <?php if ($_SESSION[VIEWFOLDER]->user_role > 1): ?>
            <!-- start Staff -->
            <li class="nav-item has-treeview">
                <a class="cursor-pointer2 nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>staff<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview treeviewcustom">
                    <li class="nav-item">
                        <a href="<?= ROOT . VIEWFOLDER ?>/staff" class="cursor-pointer2 nav-link">
                            <i class="nav-icon fas fa-arrow-circle-right"></i>
                            <p>manage staff</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= ROOT . VIEWFOLDER ?>/staff/create" class="cursor-pointer2 nav-link">
                            <i class="nav-icon fas fa-arrow-circle-right"></i>
                            <p>register staff</p>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / end Staff -->
        <?php endif; ?>
        <!-- start student -->
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>students<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/student/search" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/student/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>register students</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / end student -->
        <?php if ($_SESSION[VIEWFOLDER]->user_role > 1): ?>
            <!-- start classes -->
            <li class="nav-item">
                <a href="<?= ROOT . VIEWFOLDER ?>/classes" class="cursor-pointer2 nav-link">
                    <i class="nav-icon fas fa-university"></i>
                    <p>classes <i class="right fas fa-angle-down"></i></p>
                </a>
            </li>
            <!-- / end classes -->
        <?php endif; ?>
        <!-- start exam -->
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-folder"></i>
                <p>exams<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <?php if ($_SESSION[VIEWFOLDER]->user_role > 1): ?>
                    <li class="nav-item">
                        <a href="<?= ROOT . VIEWFOLDER ?>/system/exam" class="cursor-pointer2 nav-link">
                            <i class="nav-icon fas fa-arrow-circle-right"></i>
                            <p>manage exams</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= ROOT . VIEWFOLDER ?>/grading" class="cursor-pointer2 nav-link">
                            <i class="nav-icon fas fa-arrow-circle-right"></i>
                            <p>grading system</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= ROOT . VIEWFOLDER ?>/exam/create" class="cursor-pointer2 nav-link">
                            <i class="nav-icon fas fa-arrow-circle-right"></i>
                            <p>create marks entry</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/exam/entry" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>Marks Entry</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/result" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>Students Results</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / end exam -->
        <!-- start library -->
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>library<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/library" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage resources</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/library/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>create resource</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-download"></i>
                <p>downloads<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/download" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/download/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>add download</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>blog<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/blog" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/blog/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>add blog</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / end library -->
        <?php if ($_SESSION[VIEWFOLDER]->user_role > 1): ?>
            <!-- <li class="nav-item">
                <a href="<?= ROOT . VIEWFOLDER ?>/Invoice" class="cursor-pointer2 nav-link">
                    <i class="nav-icon fas fa-wallet"></i>
                    <p>Invoices <i class="right fas fa-angle-down"></i></p>
                </a>
            </li> -->
        <?php endif; ?>

        <?php
        break;
    case "finance":
        ?>

        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>students<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/student/search" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage student</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/student/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>register student</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Income<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/cashier/collection" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage payment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/cashier" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>receive payment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/income" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>other income</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>expenses<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/expense" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>manage expense</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/expense/create" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>add expense</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-university"></i>
                <p>acounts<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/account" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>school accounts</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>reports<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/finance_report/cash_book" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>Cash Book</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/finance_report/ledger" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>Ledger</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/finance_report/trial_balance" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>trial balance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/finance_report/balance_sheet" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>balance sheet</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/finance_report/financial_statement" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>financial statement</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-sms"></i>
                <p>messages<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/message/send/feeBalance" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>send fees balance</p>
                    </a>
                </li>
            </ul>
        </li>

        <?php
        break;
    case "secretary":

        break;
    case "admin":

        break;
    default:
        ?>

        <!-- start library -->
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>library<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/library" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>available resources</p>
                    </a>
                </li>
            </ul>
        </li>

        <?php
        break;
}
?>

<?php if (!(VIEWFOLDER == "student")): ?>
    <?php if ($_SESSION[VIEWFOLDER]->user_role > 1): ?>
        <!-- start management -->
        <li class="nav-item has-treeview">
            <a class="cursor-pointer2 nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>settings<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview treeviewcustom">
                <?php
                switch (VIEWFOLDER) {
                    case 'staff':
                        ?>
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>/system/term" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                <p>terms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>/system/subject" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                <p>subjects</p>
                            </a>
                        </li>
                        <?php
                        break;
                    case 'finance':
                        ?>
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>/system/term" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                <p>terms</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>/system/vote_head" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                <p>vote head</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= ROOT . VIEWFOLDER ?>/system/fees_structure" class="cursor-pointer2 nav-link">
                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                <p>fees structure</p>
                            </a>
                        </li>
                        <?php
                        break;
                    default:
                        break;
                }
                ?>

                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/profile" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/about" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>about page</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/contact" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>contacts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/theme" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>themes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/image" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>images</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT . VIEWFOLDER ?>/system/other" class="cursor-pointer2 nav-link">
                        <i class="nav-icon fas fa-arrow-circle-right"></i>
                        <p>other settings</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- / end management -->
    <?php endif; ?>
<?php endif; ?>