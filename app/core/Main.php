<?php

/** defaut system time zone */
date_default_timezone_set('Africa/Nairobi');
/** page roots */
define('ROOT', $ROOT);
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . DS);
define('SERVERNAME', explode('/', $_SERVER['DOCUMENT_ROOT']));
/** Main system data */
define(
    'SHAREDCONTROLLERS',
    [
        'library',
        'download',
        'blog',
    ]
);

define(
    'SCHOOLSTATUS',
    [
        1 => ['active', ''],
        2 => ['suspended', '']
    ]
);

define('STUDREGKEYS', [
    'A' => 'stud_adm',
    'B' => 'stud_form',
    'C' => 'stud_stream',
    'D' => 'stud_lname',
    'E' => 'stud_fname',
    'F' => 'stud_oname',
    'G' => 'stud_gender',
    'H' => 'stud_cat',
    'I' => 'stud_phone',
    'J' => 'stud_kcpe_index',
    'K' => 'stud_kcpe_marks',
    'L' => 'stud_birth_date',
    'M' => 'stud_birth_cert',
    'N' => 'stud_county'
]);

define(
    'NEWSCHOOLINVOICE',
    array(
        '1' => array('Domain name registration', '1500'),
        '2' => array('System installation fees', '20000'),
        '3' => array('SMS system setup fees', '8000'),
        '4' => array('Training fees', '10000')
    )
);

define(
    'SYSRENEWALINVOICE',
    array(
        '1' => array('Domain name renewal', '2000'),
        '2' => array('system management fees', '13000')
    )
);

define('TILL', '9445767');

define(
    'PORTALS',
    array(
        // 'admin' => [7],
        'finance' => [2, 5, 7],
        'staff' => [1, 2, 3, 4, 7],
        'student' => [7]
    )
);
$PORTALKEYS = [];
foreach (PORTALS as $key => $value) {
    $PORTALKEYS[] = $key;
}
define('PORTALKEYS', $PORTALKEYS);

define(
    'STAFFTITLES',
    array(
        '1' => 'teacher',
        '2' => 'hod',
        '3' => 'finance',
        '4' => 'secretary',
        '5' => 'deputy',
        '6' => 'principal',
        '7' => 'sch_admin',
        '8' => 'main_admin'
    )
);

define(
    'STAFFSTATUS',
    array(
        '1' => 'not validated',
        '2' => 'validated',
        '3' => 'suspended'
    )
);

define(
    'COUNTIES',
    array(
        'baringo',
        'bomet',
        'bungoma',
        'busia',
        'elgeyo marakwet',
        'embu',
        'garissa',
        'homa bay',
        'isiolo',
        'kajiado',
        'kakamega',
        'kericho',
        'kiambu',
        'kilifi',
        'kirinyaga',
        'kisii',
        'kisumu',
        'kitui',
        'kwale',
        'laikipia',
        'lamu',
        'machakos',
        'makueni',
        'mandera',
        'meru',
        'migori',
        'marsabit',
        'mombasa',
        'muranga',
        'nairobi',
        'nakuru',
        'nandi',
        'narok',
        'nyamira',
        'nyandarua',
        'nyeri',
        'samburu',
        'siaya',
        'taita taveta',
        'tana river',
        'tharaka nithi',
        'trans nzoia',
        'turkana',
        'uasin gishu',
        'vihiga',
        'wajir',
        'pokot'
    )
);

define(
    'GENDER',
    array(
        'male' => 'boys',
        'female' => 'girls',
        'other' => 'other'
    )
);

define(
    'SALUTATION',
    array(
        'mr',
        'mrs',
        'miss',
        'ms'
    )
);

define(
    'TEACHERTERMS',
    array(
        'TSC',
        'BOM',
        'internship'
    )
);

define(
    'IMAGES',
    array(
        'sch_logo' => array(
            'logos',
            'school logo',
            'default.png'
        ),
        'sch_bg' => array(
            'bg',
            'school system background',
            'default.png'
        ),
        'sch_stamp' => array(
            'stamp',
            'school official stamp',
            'default.png'
        )
    )
);

define(
    'LIBRARY',
    array(
        'notes' => 'notes',
        'past_papers' => 'past papers',
        'assignments' => 'assignments',
        'exams' => 'exams',
        'video_lessons' => 'video lessons'
    )
);

define(
    'SCHCATEGORIES',
    array(
        'day',
        'boarding',
        'day-boarding'
    )
);

define(
    'SCHTYPE',
    array(
        'boys' => 'boys school',
        'girls' => 'girls school',
        'mixed' => 'mixed school'
    )
);

define(
    'DEFAULTGRADES',
    array(
        'A' => array('min' => 81, 'max' => 100, 'point' => 12, 'rem' => 'excellent', 'lugha' => 'vizuri sana'),
        'A-' => array('min' => 75, 'max' => 80, 'point' => 11, 'rem' => 'very good', 'lugha' => 'vizuri sana'),
        'B+' => array('min' => 70, 'max' => 73, 'point' => 10, 'rem' => 'good', 'lugha' => 'kazi nzuri'),
        'B' => array('min' => 65, 'max' => 69, 'point' => 9, 'rem' => 'good', 'lugha' => 'kazi nzuri'),
        'B-' => array('min' => 60, 'max' => 64, 'point' => 8, 'rem' => 'good', 'lugha' => 'kazi nzuri'),
        'C+' => array('min' => 55, 'max' => 59, 'point' => 7, 'rem' => 'aim higher', 'lugha' => 'jitahidi'),
        'C' => array('min' => 50, 'max' => 54, 'point' => 6, 'rem' => 'aim higher', 'lugha' => 'jitahidi'),
        'C-' => array('min' => 45, 'max' => 49, 'point' => 5, 'rem' => 'aim higher', 'lugha' => 'jitahidi'),
        'D+' => array('min' => 40, 'max' => 44, 'point' => 4, 'rem' => 'work hard', 'lugha' => 'tia bidii'),
        'D' => array('min' => 30, 'max' => 39, 'point' => 3, 'rem' => 'work hard', 'lugha' => 'tia bidii'),
        'D-' => array('min' => 20, 'max' => 29, 'point' => 2, 'rem' => 'work hard', 'lugha' => 'tia bidii'),
        'E' => array('min' => 1, 'max' => 19, 'point' => 1, 'rem' => 'work hard', 'lugha' => 'tia bidii'),
        'X' => array('min' => 0, 'max' => 0, 'point' => 0, 'rem' => 'not done', 'lugha' => 'hajafanya')
    )
);

define(
    'DATAHEADERS',
    array(
        '' => 'class',
        'marks' => 'total',
        'mean' => 'mean',
        'avg pnt' => 'points',
        'grade' => 'grade',
        'position' => 'position'
    )
);

define(
    'TERMS',
    array(
        '1' => 'term 1',
        '2' => 'term 2',
        '3' => 'term 3'
    )
);

define(
    'PAYMODES',
    array(
        'cash' => array('Cash', 'Enter Student Admission number followed by the student Full name'),
        'mpesa' => array('M-Pesa', 'Enter M-Pesa transaction code'),
        'cheque' => array('Cheque', 'Enter Cheque Number'),
        'bursary' => array('Bursary', 'Enter grant organization name and cheque number')
    )
);

define(
    'STUDEXPORTDATA',
    array(
        'stud_adm',
        'stud_cat',
        'stud_gender',
        'stud_lname',
        'stud_fname',
        'stud_oname',
        'stud_form',
        'stud_stream',
        'stud_phone'
    )
);

define(
    'DELETESTUDTABLES',
    array(
        'sch_stud' => array('StudentModel', 'stud_key'),
        'sch_results' => array('ResultModel', 're_studK')
    )
);

define(
    'SCHSMSMODE',
    array(
        '1' => 'Offline System',
        '2' => 'Online Server - School SMS API'
    )
);

define(
    'MESSVAR',
    array(
        '_STUDNAME_' => 'student name',
        '_STUDGENDER_' => 'student gender',
        '_STUDADM_' => 'student adm',
        '_STUDCLASS_' => 'student class',
        '_FEESBALANCE_' => 'fees balance',
    )
);

/** App Data */
define('APPINFO', $app->appInfo());
define('SCHOOLS', $app->sys_schools());
if (APPINFO) {
    define('CURRENTYEAR', date('Y', time()));
    define('MANAGEMENT', $app->automation());
    define('SCH_RENEWAL', $app->sch_inv_generator());
    define('VIEWFOLDER', $app->thisController());
    define('BILLCHECK', $app->sch_clearance(APPINFO->sch_token));
    define('VAT', 0.16);
    define('SESSIONS', $app->activeUser());
    define('CURRENTUSER', $app->currentUserInfo(VIEWFOLDER)['fullName']);
    define('CURRENTUSERNAME', $app->currentUserInfo(VIEWFOLDER)['userName']);
    define('CURRENTUSERKEY', $app->currentUserInfo(VIEWFOLDER)['userKey']);
    define('STREAMS', $app->sch_streams());
    define('ALLTERMS', $app->sch_term());
    define('DPAGES', $app->sch_dynamic_pages());
    define('SYSTEMSUBCAT', $app->sys_subcat());
    define('SCHSUBJECTS', $app->sch_subjects());
    define('ACCOUNTS', $app->sch_fin_accounts());
    define('CURRENTTERM', $app->activeTerm());
    define('CURRENTEXAM', $app->activeExam());
    define('RECENTTERM', $app->recentTerm());
    define('RGBA', colorRgb(APPINFO->sch_sec_theme));
    define('ARREASKEY', smartKey(APPINFO->sch_token . '_' . esc('arreas')));
    define('VOTEHEADS', $app->sch_fin_votes());
    define('LATEST_ADM', $app->latest_adm());
    // Iportant info
    // define('SYSTEM_HOST', domainInfo(SCH_CHECK_DOMAIN));
    define('SYSTEM_HOST', ['owner' => 'Hencan Group limited']);
    if (SYSTEM_HOST) {
        if (SYSTEM_HOST['owner'] == 'Hencan Group limited') {
            define('C_LOGO', 'hencan.png');
            define(
                'BILLING_ADDRESS',
                [
                    'cname' => 'Hencan Enterprises Limited',
                    'caddress' => 'P.O BOX 43-0100 Nairobi',
                    'tel' => smartPhone('0721270985') . '/' . smartPhone('0796594366'),
                    'email' => 'info.hencan@gmail.com / info@hencangroup.co.ke',
                    'website' => 'www.hencangroup.co.ke'
                ]
            );
            define(
                'PAYMENT_METHOD',
                [
                    'method' => 'Bank Name: Equity Bank',
                    'account' => 'Acc Number: 0150263180425',
                    'accname' => 'Acc Name: Hencan Enterprises Limited',
                ]
            );
            define('COPYRIGHT', '<a href="https://www.hencangroup.co.ke">Copyright &copy ' . date("Y") . ' ' . ucwords(APPINFO->sch_name) . '. &nbsp | &nbsp Powered by: <u>Hencan Group Technologies.</u></a>');
        } else {
            define('C_LOGO', 'frajosan.png');
            define(
                'BILLING_ADDRESS',
                [
                    'cname' => 'Frajosan IT Consultancies LTD',
                    'caddress' => 'P.O BOX 222-90200 Kitui',
                    'tel' => smartPhone('0796594366'),
                    'email' => 'info@frajosantech.co.ke',
                    'website' => 'www.frajosantech.co.ke'
                ]
            );
            define(
                'PAYMENT_METHOD',
                [
                    'method' => 'M-PESA',
                    'account' => 'Till Number: 9445767',
                    'accname' => 'Acc Name: Francis Kioko Kilonzo',
                ]
            );
            define('COPYRIGHT', '<a href="https://www.frajosantech.co.ke">Copyright &copy ' . date('Y') . ' ' . ucwords(APPINFO->sch_name) . '. &nbsp | &nbsp Powered by: <u>Frajosan IT Consultancies ltd.</u></a>');
        }
    } else {
        define('C_LOGO', 'default.png');
        define('BILLING_ADDRESS', ['cname' => '', 'caddress' => '', 'tel' => '', 'email' => '', 'website' => '']);
        define('PAYMENT_METHOD', ['method' => '', 'account' => '', 'accname' => '']);
        define('COPYRIGHT', '');
    }
}
