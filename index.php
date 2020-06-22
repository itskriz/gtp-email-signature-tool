<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>GTP Email Signature Builder and Copy Tool</title>
    <style type="text/css">
    	#tels .form-group label:before {
    		content: attr(data-tel);
    	}
      #tels .tel:nth-child(even) {
        background-color: #f7f7f7;
      }
      #nojs,
      #nochrome {
        color: red;
        font-weight: bold!imporant;
        text-align: center;
        width: 100%;
        font-family: sans-serif !important;
      }
    </style>
  </head>
  <body>
    <?php
      $get_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $get_cwd = explode('?', $get_url);
      $logoURL = $get_cwd[0] . 'gtp_email-logo';
      $logoEXT = '.gif';
      if (isset($_GET) && !empty($_GET)) {
        $name = ucwords(filter_var($_GET['name'], FILTER_SANITIZE_STRING));
        $title = ucwords(filter_var($_GET['title'], FILTER_SANITIZE_STRING));
        $tels = array();
        $maxTel = 0;

        if ('animated' == $_GET['logotype']) {
          $logoEXT = '.gif';
        } else if ('static' == $_GET['logotype']) {
          $logoEXT = '.png';
        }
        $logoURL .= $logoEXT;

        $widthFix = array(
          ' width: 45%; max-width: 45%;',
          ' width="45%"'
        );

        //$widthFix = array('', '');
        for ($i = 0; $i < 10; $i++) {
          if (isset($_GET['tel_'.$i.'_value']) && $_GET['tel_'.$i.'_region']) {
            $thisTelValue = filter_var($_GET['tel_'.$i.'_value'], FILTER_SANITIZE_STRING);
            $thisTelRegion = filter_var($_GET['tel_'.$i.'_region'], FILTER_SANITIZE_STRING);
            if (strlen($thisTelValue) > $maxTel) {
              $maxTel = strlen($thisTelValue);
            }
            $thisTel = array(
              'label'   => $thisTelValue,
              'region'  => $thisTelRegion,
              'href'    => '+' . preg_replace('/[^0-9]/', '', $thisTelValue)
            );
            if (preg_match('/[a-z]/i', $thisTelValue)) {
              $thisTel['href'] = '#';
              $thisTel['label'] = $thisTelValue;
              $thisTel['refion'] = $thisTelRegion;
            }
            array_push($tels, $thisTel);
          }
        }
        if (17 > $maxTel) {
          $widthFix = array(
            ' width: 40%; max-width: 40%;',
            ' width="40%"'
          );
        }
        $disclaimerTel = array(
          'label' => '+1 918 628 3316',
          'href'  => 'tel:+19186283316',
        );
        if (is_array($tels) && !empty($tels)) {
          $disclaimerTel = array(
            'label' => $tels[0]['label'],
            'href'  => $tels[0]['href'],
          );
        }

        $html = '<div id="signature" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif !important;max-width:640px;font-size:14px;"><div style="background-color:transparent;font-weight:bold;"><span style="color:#000000;font-size:20px;font-weight:bold!imporant;line-height:20px;">'.$name.'</span></div><div style="background-color:transparent;"><span style="color:#000000;font-size:14px;line-height:14px;">'.$title.'</span></div><!--[if (mso)|(IE)]><br/><![endif]--><div style="background-color:transparent;padding-top:10px;padding-bottom:15px;"><a href="https://gtpprepaid.com/" title="https://gtpprepaid.com/" style="border:none!important;"><img src="'.$logoURL.'" alt="Logo for GTP" width="175" height="76" style="width:175px;height:76px;max-width:175px;display:block;border:none!important;"></a></div>';

        if (!empty($tels) && is_array($tels)) {
          $html .= '<!--[if (mso)|(IE)]><br/><![endif]--><div style="background-color:transparent;"><table bgcolor="transparent" cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto 0 0; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: transparent; width: 320px;" valign="top" width="320"><tbody><tr style="vertical-align: top;" valign="top"><tbody>';
          for ($i = 0; $i < count($tels); $i++) {
            $tel = $tels[$i];
            if ('#' === $tel['href']) {
              $html .= '<tr style="vertical-align: top;" valign="top"><td align="left" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif !important; text-align: left; word-break: break-word; vertical-align: top;;font-size:14px;line-height:14px;'.$widthFix[0].'" valign="top"'.$widthFix[0].'><span style="font-size:14px;color:#000000!important;text-decoration:none!important">'.$tel['label'].'</span></td><td align="left" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif !important; text-align: left; font-size: 14px; line-height: 1.3; word-break: break-word; mso-line-height-alt: 18px; margin: 0;"><span style="font-size:14px;">'.$tel['region'].'</span></td></tr>';
            } else {
              $html .= '<tr style="vertical-align: top;" valign="top"><td align="left" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif !important; text-align: left; word-break: break-word; vertical-align: top;;font-size:14px;line-height:14px;'.$widthFix[0].'" valign="top"'.$widthFix[0].'><a href="tel:'.$tel['href'].'" title="tel:'.$tel['href'].'" style="color:000000;important;text-decoration:none!important"> <span style="font-size:14px;color:#000000!important;text-decoration:none!important">'.$tel['label'].'</span></a></td><td align="left" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif !important; text-align: left; font-size: 14px; line-height: 1.3; word-break: break-word; mso-line-height-alt: 18px; margin: 0;"><span style="font-size:14px;">'.$tel['region'].'</span></td></tr>';
            }
          }
          $html .= '</tbody></table></div><!--[if (mso)|(IE)]><br/><![endif]-->';
        }
        $html .= '<div style="background-color:transparent;padding-top:10px;padding-bottom:5px;"> <a href="https://gtpprepaid.com/" title="https://gtpprepaid.com/" target="_blank" style="font-size:14px;line-height:14px;color:#1350a3!important;text-decoration:none!important"> <span style="font-size:14px;color:#1350a3!important;text-decoration:none!important">GTPprepaid.com</span> </a> </div><!--[if (mso)|(IE)]><br/><![endif]--><div style="background-color:transparent;padding-top:10px;padding-bottom:10px;"> <span>View our Corporate Video in <a href="https://vimeo.com/322308746" target="_blank" style="font-size:14px;line-height:14px;color:#1350a3!important;text-decoration:none!important">English</a> / <a href="https://vimeo.com/322315904" target="_blank" style="font-size:14px;line-height:14px;color:#1350a3!important;text-decoration:none!important">French</a></span></div><!--[if (mso)|(IE)]><br/><![endif]--><div style="background-color:transparent;padding-top:5px;padding-bottom:5px;max-width:640px;font-size:10px;line-height:11px;text-align:justify;"> <span style="color:#000000;font-size:10px;text-align:justify;">This email and all documents accompanying this transmission contain information from Global Technology Partners LLC (“GTP”) and affiliates which is confidential and/or privileged. The information is intended for the exclusive use of the individual(s) or entity(ies) named on this email. If you have received this email in error, please delete the email and notify us by telephone immediately at <a href="'.$disclaimerTel['href'].'" title="'.$disclaimerTel['href'].'" style="color:#000000!important;font-size:10px;text-decoration:none!important;">'.$disclaimerTel['label'].'</a> so that we can direct it to the proper recipient. Addressees should be aware of internet scams that involve email messages falsely claiming to be from GTP. Never click on a link or upload an attachment unless you are confident this email was sent by an authorized GTP representative. Any passcodes, card numbers or other confidential cardholder data must be masked in any text, screenshots or attachments sent in reply to this email.</span></div></div>';

        $myFile = "filename.htm"; // or .php
        $myFile = 'signatures/signature_' . strtolower(str_replace(' ', '-', $name)) . '.htm';
        $fh = fopen($myFile, 'w'); // or die("error");    
        fwrite($fh, $html);
        fclose($fh);
      }

    ?>
    <div id="wrapper">
      <header id="header" class="container py-4" style="max-width: 720px;">
        <h1>GTP Signature Builder and Copying Tool</h1>
        <hr>
      </header>
      <div class="container" style="max-width: 720px">
        <form id="form" method="GET" action="#signature">
          <div class="form-group">
            <h2>Signature Generator</h2>
            <p>Enter your information below to generate your signature.</p>
            <p>To add phone numbers and usernames, click the <strong class="text-info">"Add Phone / Username"</strong> button. You may use the sort up "<i class="fa fa-arrow-up text-success" aria-hidden="true"></i>" and sort down "<i class="fa fa-arrow-down text-danger" aria-hidden="true"></i>" buttons on the left side of each telePhone / Username input to reorder telePhone / Usernames. You may use the removal "<i class="fa fa-times text-danger" aria-hidden="true"></i>" button on the right side of each telephone input to remove it.</p>
          </div>
          <hr>
          <div class="form-row">
            <div class="col-6 mb-3">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp"<?php if (isset($_GET['name'])) { echo ' value="'.$_GET['name'].'"'; } ?> placeholder="ex: John Doe" required>
              <small id="nameHelp" class="form-text text-muted">Please input your name as you prefer it.</small>
            </div>
            <div class="col-6 mb-3">
              <label for="title">Position / Title</label>
              <input type="text" name="title" class="form-control" id="title" aria-describedby="titleHelp"<?php if (isset($_GET['name'])) { echo ' value="'.$_GET['title'].'"'; } ?> placeholder="ex: Demo Person" required>
              <small id="nameHelp" class="form-text text-muted">Please enter your title or position</small>
            </div>
          </div>

          <div id="tels">
            <?php
              for ($i = 0; $i < 10; $i++) {
                if (isset($_GET['tel_'.$i.'_value']) && isset($_GET['tel_'.$i.'_region'])) {
                  ?>
            <div id="tel_<?php echo $i; ?>" class="tel py-2" data-tel="<?php echo $i; ?>">
              <div class="form-row">
                <div class="col-1" style="display: flex; flex-flow: column wrap; justify-content: center; align-items: center;">
                  <button class="btn btn-sm text-success" data-control="sort-up" title="Move up">
                    <span class="sr-only">Up</span>
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                  </button>
                  <button class="btn btn-sm text-danger" data-control="sort-down" title="Move down">
                    <span class="sr-only">Down</span>
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="col-6 tel-number">
                  <label for="tel_<?php echo $i; ?>_value">Phone / Username <?php echo $i + 1; ?></label>
                  <input type="tel" name="tel_<?php echo $i; ?>_value" class="form-control" id="tel_<?php echo $i; ?>_value" aria-describedby="tel_<?php echo $i; ?>_valueHelp"<?php echo ' value="'.$_GET['tel_'.$i.'_value'].'"';?> placeholder="Ex: +1 555 123 4567" required>
                  <small class="text-muted form-text" id="tel_<?php echo $i; ?>_valueHelp">Please include your formatted phone number with country code. <strong>ex: +1 123 456 7890</strong></small>
                </div>
                <div class="col-4 tel-region">
                  <label for="tel_<?php echo $i; ?>_region">Country / Label</label>
                    <input type="text" class="form-control" id="tel_<?php echo $i; ?>_region" name="tel_<?php echo $i; ?>_region" aria-describedby="tel_<?php echo $i; ?>_regionHelp"<?php echo ' value="'.$_GET['tel_'.$i.'_region'].'"'; ?> placholder="ex: Office" required>
                    <small class="text-muted form-text" id="tel_<?php echo $i; ?>_regionHelp"></small>
                </div>
                <div class="col-1" style="display: flex; align-items: center;">
                  <button class="btn btn-sm text-danger" data-control="remove" title="Remove">
                    <span class="sr-only">Remove</span>
                    <i class="fa fa-times" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
           </div>
                  <?php
                }
              }
            ?>
          </div>
          <div class="form-row pt-2">
            <div class="col">
              <p class="form-text">
                Logo Style
              </p>
              <div class="form-check form-check-inline">
                <input type="radio" name="logotype" class="form-check-input" value="animated"<?php if ('animated' == $_GET['logotype'] || !isset($_GET['logotype'])) { echo ' checked'; } ?> required>
                <label class="form-check-label" for="logotype">Animated Logo</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" name="logotype" class="form-check-input" value="static"<?php if ('static' == $_GET['logotype'] || !isset($_GET['logotype'])) { echo ' checked'; } ?> required>
                <label class="form-check-label" for="logotype">Static Logo</label>
              </div>
            </div>
            <div class="col text-right">
              <button id="addTel" class="btn btn-info">
                <span>Add Phone / Username</span>
                <i class="fa fa-plus" aria-hidden="true"></i>
              </button>
            </div>
          </div>
          <hr>
          <button type="submit" class="btn btn-primary">Generate Signature</button>
        </form>
      </div>   
  <?php
  if (!empty($_GET)) {
  ?>
      <div class="container my-4" style="max-width: 720px;">
        <h2>Signature Preview</h2>
        <p>Use the <strong class="text-primary">"Copy Signature to Clipboard"</strong> button below to copy the signature to your clipboard and paste into the signature area of your preferred email client. You may also edit the fields above and click the <strong class="text-primary">"Generate Signature"</strong> button again.</p>
        <p>
          <strong>Signature installation tutorials:</strong><br>
          <a href="https://support.google.com/mail/answer/8395?co=GENIE.Platform%3DDesktop&amp;hl=en" target="_blank" rel="nofollow noopener"><i class="fa fa-fw fa-google" aria-hidden="true"></i> GMail</a> &nbsp;
          <a href="https://support.office.com/en-us/article/change-an-email-signature-86597769-e4df-4320-b219-39d6e1a9e87b" target="_blank"><i class="fa fa-fw fa-windows" aria-hidden="true"></i> Outlook</a> &nbsp;
          <a href="https://support.apple.com/guide/mail/create-and-use-email-signatures-mail11943/mac" target="_blank" rel="nofollow noopener"><i class="fa fa-fw fa-apple" aria-hidden="true"></i> Apple Mail</a>
        </p>
        <p>
          <strong>Outlook 2016 Users:</strong> <br>
          To install for Outlook 2016, click the <strong class="text-info">"Download .htm file"</strong> to download your signature and follow these steps below:
        </p>
        <ol>
          <li>Go to Outlook Options > Mail and click "Signatures"</li>
          <li>Create a new signature. Name it somethin simple like "My GTP Signature" and save your changes (it will be empty)</li>
          <li>Again, at the Outlook Options > Mail page, click "Signatures" again, this time pressing and holding the Control key as you do so. This should open a new window</li>
          <li>In this new window, find and delete the <strong>.htm</strong> file named after the signature you just created (ie: My GTP Signature.htm)</li>
          <li>Copy the <strong>.htm</strong> file you download to the new window. Once complete, rename the file exactly as you named your signature (ie: My STP Signature.htm)</li>
          <li>Back in Outlook, you signature may look strange in the signature settings. That's okay. Just draft a new email and test your signature to ensure it looks correct.</li>
        </ol>
        <p>You may also follow along with <a href="https://www.youtube.com/watch?v=uu0hBvBSoJ8" target="_blank" rel="nofollow noopener">this YouTube video</a> to help you with the above steps.</p>
        <p>
          <strong>Generator Link</strong><br>
          If you are generating this signature for someone else, you may use the below link to send a premade signature to someone. Click the copy button "<i class="fa fa-clipboard text-info" aria-hidden="true" title="Copy to clipboard"></i>" below to copy it to your clipboard and send that to the person of your choice.
        </p>
        <!-- Target -->
        <div class="form-inline">
          <input id="signatureLink" style="width: calc(100% - 42px);" class="bg-light form-control small px-3 py-2" value="<?php echo $get_url . '#signature'; ?>">
          <!-- Trigger -->
          <button class="btn btn-info copy-btn" data-clipboard-target="#signatureLink">
              <i class="fa fa-clipboard" aria-hidden="true" title="Copy to clipboard"></i>
          </button>
          <p class="text-success text-right pt-1 mb-0 pb-0" style="opacity: 0;">URL copied!</p>
        </div>
        <hr>
<!-- BEGIN SIG -->

        <?php echo $html; ?>

<!-- END SIG -->
        <div style="background-color:transparent;">
          <hr>
          <button class="btn btn-primary copy-btn" id="getSignature" data-clipboard-target="#signature">Copy Signature to Clipboard</button>
          <a href="<?php echo $myFile; ?>" class="btn btn-info" id="downloadSignature" download>Download .htm file</a>
          <p class="text-success mt-3" style="opacity: 0;">Signature copied!</p>
        </div>
  <?php
  } // end if get
  ?>
      </div>
    </div>
    <noscript>
      <p id="nojs" style="margin-top: 30px">
        JavaScript is required to use this tool. <br>Please enable JavaScript in your browser.
      </p>
      <style>#wrapper{display:none;}</style>
    </noscript>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
    <script type="text/javascript">
      var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
      if (!isChrome) {
        $("#wrapper *").remove();
        $('<p id="nochrome" class="pt-4 mt-4">Please use this tool using Google Chrome.</p>').appendTo('#wrapper');
      }
      $(function() {
        new Clipboard('.copy-btn');
      });
      $('.copy-btn').click(function() {
        var notice = $(this).parent().find('p');
        notice.css({opacity: 1});
        setTimeout(function() {
          $(notice).animate({opacity: 0}, 1000);
        }, 3000);
      });

      function telOrder() {
        var tels = $('#tels').find('.tel');
        var telsCount = tels.length;
        for (var i = 0; i < telsCount; i++) {
          var thisTel = tels.eq(i);
          thisTel.attr({
            'id': 'tel_' + i,
            'data-tel': i
          });
          thisTel.find('.tel-number label').attr({
            'for': 'tel_'+i+'_value'
          }).text('Phone / Username ' + (i+ 1));
          thisTel.find('.tel-number input').attr({
            'name': 'tel_'+i+'_value',
            'id': 'tel_'+i+'_value',
            'aria-describedby': '#tel_'+i+'_valueHelp'
          });
          thisTel.find('.tel-number small').attr('id', 'tel_'+i+'_valueHelp');
          thisTel.find('.tel-region label').attr({
            'for': 'tel_'+i+'_region'
          });
          thisTel.find('.tel-region input').attr({
            'name': 'tel_'+i+'_region',
            'id': 'tel_'+i+'_region',
            'aria-describedby': '#tel_'+i+'_regionHelp'
          });
          thisTel.find('.tel-region small').attr('id', 'tel_'+i+'_regionHelp');
        }
      }
      $('#tels').on('click', 'button', function(e) {
        e.preventDefault();
        let control = $(this).attr('data-control');
        if (control == 'remove') {
          $(this).parents('.tel').remove();
        }
        var thisTel = $(this).parents('.tel');
        if (control == 'sort-up') {
          thisTel.insertBefore(thisTel.prev());
        }
        if (control == 'sort-down') {
          thisTel.insertAfter(thisTel.next());
        }
        telOrder();
      });
      $('#addTel').click(function(e) {
      	e.preventDefault();
        var telCount = $('#tels').find('.tel').length;
        if (telCount >= 9) {
        	$(this).prop('disabled', 'disabled');
        }
        var data = '<div id="tel_'+telCount+'" class="tel py-2" data-tel="'+telCount+'"> <div class="form-row"> <div class="col-1" style="display: flex; flex-flow: column wrap; justify-content: center; align-items: center;"> <button class="btn btn-sm text-success" data-control="sort-up" title="Move up"> <span class="sr-only">Up</span> <i class="fa fa-arrow-up" aria-hidden="true"></i> </button> <button class="btn btn-sm text-danger" data-control="sort-down" title="Move down"> <span class="sr-only">Down</span> <i class="fa fa-arrow-down" aria-hidden="true"></i> </button> </div><div class="col-6 tel-number"> <label for="tel_'+telCount+'_value">Phone / Username '+(telCount+1)+'</label> <input type="tel" name="tel_'+telCount+'_value" class="form-control" id="tel_'+telCount+'_value" aria-describedby="tel_'+telCount+'_valueHelp" placeholder="ex: +1 555 123 4567" required> <small class="text-muted form-text" id="tel_'+telCount+'_valueHelp">Please include your formatted phone number with country code. <strong>Ex: +1 123 456 7890</strong></small> </div><div class="col-4 tel-region"> <label for="tel_'+telCount+'_region">Country / Label</label> <input type="text" class="form-control" id="tel_'+telCount+'_region" name="tel_'+telCount+'_region" aria-describedby="tel_'+telCount+'_regionHelp" placeholder="ex: Office" required> <small class="text-muted form-text" id="tel_'+telCount+'_regionHelp"></small> </div><div class="col-1" style="display: flex; align-items: center;"> <button class="btn btn-sm text-danger" data-control="remove" title="Remove"> <span class="sr-only">Remove</span> <i class="fa fa-times" aria-hidden="true"></i> </button> </div></div></div>';
        $('#tels').append(data);
      });
    </script>
    <footer id="footer" class="container text-center pt-4 pb-3">
      <p class="small text-muted">Created by <a href="http://kwilliams.me" target="_blank">K. Williams</a> for exclusive use by <a href="http://gtpprepaid.com/" rel="noopener nofollow">GTP</a>. Do not duplicate.</p>
    </footer>
  </body>
</html>