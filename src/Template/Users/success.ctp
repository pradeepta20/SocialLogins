
<body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
    <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0" style="margin-top: 30px;">
        <tr>
            <td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
                <table>
                    <tr>
                        <td class="table-td-wrap" align="center">
                            <table class="table-space" height="18" style="height: 18px; font-size: 0px; line-height: 0; background-color: #e4e6e9;"  bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td class="table-space-td" valign="middle" height="18" style="height: 18px; background-color: #e4e6e9;"  bgcolor="#E4E6E9" align="left">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; background-color: #ffffff;"  bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td class="table-space-td" valign="middle" height="8" style="height: 8px; background-color: #ffffff;"  bgcolor="#FFFFFF" align="left">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table-row" width="450" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; width: 680px; padding-right: 36px;"  valign="top" align="left">
                                            <table class="table-col" align="left" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                <tbody>
                                                    <tr>
                                                        <td class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
                                                            <table class="header-row" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="header-row-td" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Thank you for signing up!</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
                                                                <b>Welcome to <a style="text-decoration: none;" href="<?php echo HTTP_ROOT; ?>"><?php echo SITE_NAME; ?></a></b>

                                                                <b>Please finish your registration by clicking the validation link in the
                                                                    confirmation email, we have sent to : <a style="text-decoration: none;" href="mailto:<?= $userDetail->email; ?>"><?= $userDetail->email; ?></a></b>

                                                                <h3 style="font-size: 13px;">Please note!</strong> The email may take a few minutes to arrive.</h3>
                                                                <h3 style="font-size: 13px;">If you don't get the Email, <a  href="<?php echo HTTP_ROOT . 'users/success/' . $userDetail->id . '?resend'; ?>"><span>Click Here</span> to resend</a></h3>
                                                                <h5>IMPORTANT</h5>
                                                                <ul>
                                                                    <li>1.	If 5-10 minutes have passed after your registration and you do not see the confirmation email in your
                                                                        <strong>«inbox»</strong> folder, please check <strong>«spam/junk»</strong> folder. The email with your login details should be there.</li>
                                                                    <li>2.	To ensure that <?= SITE_NAME ?> are not filtered and do not get to your<strong>«spam/junk»</strong> folder 
                                                                        select <strong>«Add/Save to Address Book»</strong> option and add <a href="mailto:<?= $adminSetting->support_email; ?>"><?= $adminSetting->support_email; ?></a> to Address Book of your email programme.</li>
                                                                </ul>
                                                                <b style="color: #777777;">Please <a href="<?php echo HTTP_ROOT; ?>"> Click </a> here to go login page.</b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table-space" height="12" style="height: 12px;width: 100%; font-size: 0px; line-height: 0;  background-color: #ffffff;" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; background-color: #ffffff;" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                            <table class="table-space" height="12" style="height: 12px; width: 100%; font-size: 0px; line-height: 0; background-color: #ffffff;"  bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="12" style="height: 12px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
                            <table class="table-space" height="16" style="height: 16px; width: 100%; font-size: 0px; line-height: 0; background-color: #ffffff;"  bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="16" style="height: 16px;  background-color: #ffffff;"  bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="pageurl" value="<?php echo HTTP_ROOT; ?>"/>

    </table>
</body>
