<!DOCTYPE html>
<?php
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    // $date = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
    header("HTTP/1.1 304 Not Modified");
    exit();
}

$format = 'D, d M Y H:i:s \G\M\T';
$now = time();

$date = gmdate($format, $now);
header('Date: ' . $date);
header('Last-Modified: ' . $date);

$date = gmdate($format, $now + 30);
header('Expires: ' . $date);

header('Cache-Control: public, max-age=30');
?>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/images/favicon.png?ver=' . time()); ?>">
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8">
        <?php
        if ($_SERVER['HTTP_HOST'] != "localhost") {
            ?>

            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-91486853-1', 'auto');
                ga('send', 'pageview');

            </script>
            <meta name="msvalidate.01" content="41CAD663DA32C530223EE3B5338EC79E" />
            <?php
        }
        ?>
        <meta name="google-site-verification" content="BKzvAcFYwru8LXadU4sFBBoqd0Z_zEVPOtF0dSxVyQ4" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <?php
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <link rel="canonical" href="<?php echo $actual_link ?>" />
        <?php
        if (IS_OUTSIDE_CSS_MINIFY == '0') {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/blog.css?ver=' . time()); ?>">
            <?php
        } else {
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/common-style.css?ver=' . time()); ?>">
            <link rel="stylesheet" href="<?php echo base_url('assets/css_min/style-main.css?ver=' . time()); ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css_min/blog.css?ver=' . time()); ?>">
        <?php } ?>

    </head>
    <body class="custom-tp turmcon-cust outer-page">
        <div class="main-inner">
            <header class="terms-con bg-none">
                <div class="overlaay">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-3">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-name-footer.png?ver=' . time()) ?>" alt="logo"></a>
                            </div>
                            <div class="col-md-8 col-sm-9">
                                <div class="btn-right pull-right">
                                    <?php if (!$this->session->userdata('aileenuser')) { ?>
                                        <a href="<?php echo base_url('login'); ?>" class="btn2">Login</a>
                                        <a href="<?php echo base_url('registration'); ?>" class="btn3">Create an account</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="terms-con-cus">
                <div class="container">
                    <div class="cus-about" >
                        <section class="">
                            <div class="main-comtai">
                                <!-- <h1>Terms and Conditions</h1> -->
                                <h2 class="about-h2">Terms and Conditions</h2>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <section class="middle-main bg_white">


                <div class="container">
                    <div class="term_desc">
                        <span class="revision_0">
                            Last Revision : 20.12.2017</span>
                        <p style="text-transform: uppercase;">Please read this Terms of Services Agreement carefully. By using this website you agree to be bound by all of the Terms and Conditions of this agreement.</p>

                        <p> This Terms of Service Agreement governs your use of this website: <a href="https://www.aileensoul.com"><b>Aileensoul.com</b></a>. This Agreement includes, and incorporates by this reference, the policies and guidelines referenced below. Aileensoul Private Limited reserves the right to change or revise the terms and conditions of this Agreement at any time by posting any changes or a revised Agreement on this Website. Aileensoul.com will alert you that changes or revisions have been made by indicating on the top of this Agreement the date it was last revised. The changed or revised Agreement will be effective immediately after it is posted on this Website. Your use of the Website following the posting any such changes or of a revised Agreement will constitute your acceptance of any such changes or revisions. Aileensoul.com encourages you to review this Agreement whenever you visit the Website to make sure that you understand the terms and conditions governing use of the Website. If you do not agree to this Agreement (including any referenced policies or guidelines), please immediately terminate your use of the Website. If you would like to print this Agreement, please click the print button on your browser toolbar.</p>

                        <div class="second_paret_ts">
                            <h3>1. Proprietary Rights </h3>
                            <p>Aileensoul Private Limited has proprietary rights you may not copy, reproduce, resell or redistribute anything related to Aileensoul.com. Aileensoul.com also has rights to all trademarks and trade dress and specific layouts of this webpage, including calls to action, text placement, images and other information.</p>

                            <h3>2. Website</h3>
                            <ol class="upper_alpha">
                                <li>Content </li>
                                <li>Intellectual Property</li>
                                <li>Third Party Links</li>
                            </ol>
                            <p>
                                In addition to providing various services, this Website also offers information and marketing materials. This Website also offers information, both directly and through indirect links to third-party websites. Aileensoul.com does not always create the information offered on this Website; instead the information is often gathered from other sources. To the extent that aileensoul.com does create the content on this Website, such content is protected by intellectual property laws of the Republic of India, foreign nations, and international bodies. Unauthorized use of the material may violate copyright, trademark, and/or other laws. You acknowledge that your use of the content on this Website is for personal, noncommercial use. Any links to third-party websites are provided solely as a convenience to you. Aileensoul.com does not endorse the contents on any such third-party websites. Aileensoul.com is not responsible for the content of or any damage that may result from your access to or reliance on these third-party websites. If you link to third-party websites, you do so at your own risk. 
                            </p>
                            <ol>
                                <li>    <h4>Use of Website</h4>

                                    <p>
                                        Aileensoul.com is not responsible for any damages resulting from use of this website by anyone. You will not use the Website for illegal purposes. 
                                        <br>
                                        You will:
                                    <ul><li>
                                            Abide by all applicable local, state, national, and international laws and regulations in your use of the Website         (including laws regarding intellectual property)
                                        </li>
                                        <li>
                                            Not interfere with or disrupt the use and enjoyment of the Website by other users
                                        </li>
                                        <li>
                                            Not resell material on the Website
                                        </li>
                                        <li>
                                            Not engage, directly or indirectly, in transmission of "spam", chain letters, junk mail or any other type of unsolicited      communication, and 
                                        </li>
                                        <li>
                                            Not defame, harass, abuse, or disrupt other users of the Website
                                        </li>

                                    </ul>

                                    </p></li>
                                <li>   <h4>License</h4>
                                    <p>
                                        By using this Website, you are granted a limited, non-exclusive, non-transferable right to use the content and materials on the Website in connection with your normal, noncommercial, use of the Website. You may not copy, reproduce, transmit, distribute, or create derivative works of such content or information without express written authorization from aileensoul.com or the applicable third party (if third party content is at issue).
                                    </p></li>
                                <li>
                                    <h4>Posting</h4>
                                    <p>
                                        By posting, storing, or transmitting any content on the Website, you hereby grant aileensoul.com a perpetual, worldwide, non-exclusive, royalty-free, assignable, right and license to use, copy, display, perform, create derivative works from, distribute, have distributed, transmit and assign such content in any form, in all media now known or hereinafter created, anywhere in the world. Aileensoul.com does not have the ability to control the nature of the user-generated content offered through the Website. You are solely responsible for your interactions with other users of the Website and any content you post. Aileensoul.com is not liable for any damage or harm resulting from any posts by or interactions between users. Aileensoul.com reserves the right, but has no obligation, to monitor interactions between and among users of the Website and to remove any content Aileensoul.com deems objectionable.
                                    </p>
                                </li>
                            </ol>
                        </div>
                        <div class="third_ts user-gen">

                            <h3>3. USER-GENERATED CONTENT</h3>
                            <ol>
                                <li>
                                    <h4>General:</h4>
                                    <p>Aileensoul provides users with access to commenting and Posting. The Site, therefore, contains user-generated content (“UGC�?) which we do not pre-screen and which contains views that are the opinions of those users. These views do not represent Aileensoul’s views, opinions, beliefs, morals or values and so, whilst we will do our best to monitor, edit or remove such UGC where we consider it appropriate or necessary to do so, we cannot promise that the content in or on the Site (or any of it) is accurate, complete or up-to-date, that it will not offend or upset or that it does not infringe the intellectual property of other third parties.</p>
                                    <p>Further, some users may post content or advice, medical or otherwise, in the form of comments or posts on the Site. Such content and/or advice shall be for informational purposes only and any reliance placed on such content and/or advice by the users shall solely be at their own risk. The posts and comments posted by such users are their sole creation and responsibility. We do not endorse or guarantee the completeness, truthfulness, accuracy, or reliability of any posts or comments  posted by such users, nor do we endorse any opinions they express. It is further clarified that Aileensoul shall not be liable for any consequence arising from or in connection with such content and/or advice.The user represents and warrants that, (i) where the UGC posted by a relevant user which does not belong to such user, the user has procured the right or the necessary permission or license to use the said UGC; and, (ii) the user shall not post or publish any UGC which is in contravention of any Indian and English laws, that which has not been created by the user, or that which violates the rights, title and interest of another person. Further, the user agrees and acknowledges that UGC posted or published on the Site by such user is non-confidential and that the user submits such information at their own risk.</p>

                                </li>
                                <li>
                                    <h4>Registration :</h4>
                                    <p>To post any comments, messages, files, photos or images on our website, you will need to register an account with us.</p>
                                    <p>To register an account with us, you will need to provide us with your name, email address and a password. You must be 18 years or older to register an account with Aileensoul. By registering an account with us, you represent and warrant that you are at least 18 years old, that all information you submit is true, accurate and complete and you shall comply with these Terms. You must keep your account details up-to-date at all times including through provision of a valid and working email address, and you must keep the password which you use to access your account on the Site confidential and must not disclose it to or share it with anyone. You will be responsible for all activities that occur under your password. You may not sell or otherwise transfer your Aileensoul account to another person or entity.</p>
                                    <p>Aileensoul.com reserves the right to refuse to offer access to or use of the Site to any person or entity at Aileensoul.com’s sole discretion including by changing its eligibility criteria at any time.</p>
                                </li>
                                <li>
                                    <h4>Prohibited User-Generated Content :</h4>
                                    <p>You are solely responsible for the UGC that you post on the Site. Please therefore choose carefully the information that you post on the Site. You shall not host, display, upload, modify, publish, transmit, update or share any information (in any media or form), whether in the form of an article, comment, query, response or otherwise, that:</p>
                                    <ul>
                                        <li>violates these Terms or any applicable law for the time being in force including, but not limited to, those governing false advertising, consumer protection and safety, discrimination, terror and hate speech;</li>
                                        <li>is grossly harmful, blasphemous, obscene, pornographic, paedophilic or harmful to minors in anyway, hateful, or racially and ethnically objectionable, disparaging, relating or encouraging money laundering or gambling, false, malicious, inaccurate or misleading, fraudulent in nature or involving the sale of counterfeit or stolen items or items which are otherwise illegal or otherwise unlawful in any manner whatsoever ;</li>
                                        <li>links directly or indirectly, reference or describe goods or services that are prohibited under these Terms or applicable law;</li>
                                        <li>belongs to another person and upon which you do not have any right; which infringes upon any third party’s intellectual property rights or other proprietary rights including but not limited to copyright, patent, trade mark, database rights and trade secrets;</li>
                                        <li>infringes upon any third party’s rights of privacy, personality or endorsement;</li>
                                        <li>is defamatory, libellous, seditious, harassing, threatening, invasive of another’s privacy, impersonates or intimidates any person (including aileensoul.com, its personnel or users), or falsely states, impersonates and/or otherwise misrepresents an affiliation with any person or entity, through for example, the use of similar email address, account names, nicknames, or the creation of false accounts, deceives or misleads the addressee about the origin of such messages or communicates any information which is grossly offensive or menacing in nature ;</li>
                                        <li>advertises or promotes anything including personal or commercial websites;</li>
                                        <li>causes aileensoul.com to violate any applicable law, statute, ordinance or regulation including through taking a fee for a sale you make;</li>
                                        <li>contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer resource or otherwise interfere with any person or entity’s use or enjoyment of the Site; and</li>
                                        <li>threatens the unity, integrity, defense, security or sovereignty of India, friendly relations with foreign states, or public order, or causes incitement to the commission of any cognizable offence or prevents investigation of any offence or is insulting any other nation.</li>

                                    </ul>
                                </li>
                            </ol>
                            <p>This is a non-exhaustive list which should be used as a guide on what you must not post on the Site or transmit to other users.</p>
                            <p>You agree not to hold aileensoul.com responsible or liable for any material posted on the Site by you or other users. If you become aware of misuse of the Site or wish to report any grievance as a result of your access or usage of the Site, please contact  at <a href="mailto:inquiry@aileensoul.com"> inquiry@aileensoul.com</a> or <a href="mailto:aileensoulinquiry@gmail.com">aileensoulinquiry@gmail.com</a>. We shall, subject to the Terms set out herein and applicable laws, redress such grievance within 1 month from the date of receipt of grievance by us.
                                aileensoul.com reserves the right to reject, refuse to post and/or delete any UGC for any reason whatsoever, including, but not limited to, UGC being, in the sole opinion of aileensoul.com, in violation of these Terms or being considered to be offensive, illegal or in violation of the rights of any person or entity, or being harmful or threatening the safety of others.
                            </p>
                            <p></p>
                        </div>
                        <div class="third_ts">

                            <h3>4. Indemnification</h3>
                            <p>You will release, indemnify, defend and hold harmless Aileensoul.com and any of its contractors, agents, employees, officers, directors, shareholders, affiliates and assigns from all liabilities, claims, damages, costs and expenses, including reasonable attorneys' fees and expenses, of third parties relating to or arising out of:
                            <ul><li>
                                    The Website content or your use of the Website content</li><li>
                                    The services or your use of the service </li><li>

                                    Any intellectual property or other proprietary right of any person or entity</li><li>

                                    Your violation of any provision of this Agreement; or </li><li>

                                    Any information or data you supplied to Aileensoul.com.</li></ul>

                            When Aileensoul.com is threatened with suit or sued by a third party, Aileensoul.com may seek written assurances from you concerning your promise to indemnify Aileensoul.com; your failure to provide such assurances may be considered by Aileensoul.com to be a material breach of this Agreement. Aileensoul.com will have the right to participate in any defense by you of a third-party claim related to your use of any of the Website content or Products, with counsel of our choice at its expense. Aileensoul.com will reasonably cooperate in any defense by you of a third-party claim at your request and expense. You will have sole responsibility to defend Aileensoul.com against any claim, but you must receive Aileensoul.coms’ prior written consent regarding any related settlement. The terms of this provision will survive any termination or cancellation of this Agreement or your use of the Website or Products.
                            </p>



                        </div>
                        <div class="fourth_ts">
                            <h3>5. Privacy</h3>
                            <p>Aileensoul.com believes strongly in protecting user privacy. Privacy policy, incorporated by reference hereby is posted on the Website.</p>

                        </div>
                        <div class="fifth_ts">
                            <h3>6. Agreement To Bound</h3>
                            <p>By using this Website, you acknowledge that you have read and agree to be bound by this Agreement and all terms and conditions on this Website. </p>
                        </div>
                        <div class="sixth_ts">
                            <h3>7. General</h3>

                            <ol>
                                <li>
                                    <h4> Force  Majeure</h4>
                                    <p>Aileensoul.com will not be deemed in default hereunder or held responsible for any cessation, interruption or delay in the performance of its obligations hereunder due to earthquake, flood, fire, storm, natural disaster, act of God, war, terrorism, armed conflict, labor strike, lockout, or boycott.</p>
                                </li>
                                <li>
                                    <h4> Cessation of Operation</h4>
                                    <p>Aileensoul.com may at any time, in its sole discretion and without advance notice to you, cease operation of the Website and distribution of the Products.</p>
                                </li><li>
                                    <h4>Entire Agreement  </h4>
                                    <p>This Agreement comprises the entire agreement between you and Aileensoul.com and supersedes any prior agreements pertaining to the subject matter contained herein.</p>
                                </li><li>
                                    <h4>Effect of Waiver </h4>
                                    <p>The failure of Aileensoul.com to exercise or enforce any right or provision of this Agreement will not constitute a waiver of such right or provision. If any provision of this Agreement is found by a court of competent jurisdiction to be invalid, the parties nevertheless agree that the court should endeavor to give effect to the parties' intentions as reflected in the provision, and the other provisions of this Agreement remain in full force and effect.</p>
                                </li><li>
                                    <h4> Governing Law & Jurisdiction</h4>
                                    <p>This Website originates from the Ahmedabad, Gujarat. This Agreement will be governed by the laws of the State of Gujarat without regard to its conflict of law principles to the contrary. Neither you nor Aileensoul.com will commence or prosecute any suit, proceeding or claim to enforce the provisions of this Agreement, to recover damages for breach of or default of this Agreement, or otherwise arising under or by reason of this Agreement, other than in courts located in State of Gujarat. By using this Website, you consent to the jurisdiction and venue of such courts in connection with any action, suit, proceeding or claim arising under or by reason of this Agreement. You hereby waive any right to trial by jury arising out of this Agreement and any related documents.</p>
                                </li><li>
                                    <h4>Statute of Limitation </h4>
                                    <p>You agree that regardless of any statute or law to the contrary, any claim or cause of action arising out of or related to use of the Website or Products or this Agreement must be filed within one (1)  year after such claim or cause of action arose or be forever barred.</p>
                                </li><li>
                                    <h4> Waiver of Class Action Rights</h4>
                                    <p style="text-transform: uppercase;">By entering into this agreement, you hereby irrevocably waive any right you may have to join claims with those of other in the form of a class action or similar procedural device. Any claims arising out of, relating to or connection with this agreement must be asserted individually.</p>
                                </li>
                                <li>
                                    <h4>Termination</h4>
                                    <p>Aileensoul.com reserves the right to terminate your access to the Website if it reasonably believes, in its sole discretion, that you have breached any of the terms and conditions of this Agreement. Following termination, you will not be permitted to use the Website. If your access to the Website is terminated, Aileensoul.com reserves the right to exercise whatever means it deems necessary to prevent unauthorized access of the Website. This Agreement will survive indefinitely unless and until Aileensoul.com chooses, in its sole discretion and without advance to you, to terminate it.</p>
                                </li>
                            </ol>
                        </div>
                        <div class="sevent_part">
                            <p style="text-transform: uppercase;">By using this website you agree to be bound by all of the Terms and Conditions of this agreement.</p>
                        </div>

                    </div>

                </div>


            </section>
            <?php
            echo $login_footer
            ?>
        </div>
    </body>
</html>