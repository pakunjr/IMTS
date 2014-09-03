 <?php

class view_accounts {

    public function renderForm ($personId, $datas) {
        $d = $datas;

        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $c_accounts = new controller_accounts();

        $actionLink = $d != null
            ? URL_BASE.'accounts/update_account/save/'.$personId
            : URL_BASE.'accounts/create_account/save/'.$personId;

        $cancelButton = $d != null
            ? '<a href="'.URL_BASE.'accounts/read_account/'.$d['account_id'].'/"><input class="btn-red" type="button" value="Cancel" /></a>'
            : '';
        if ($d != null
                && isset($_SESSION['user'])
                && ($_SESSION['user']['accessLevel'] == 'Administrator'
                    || $_SESSION['user']['accessLevel'] == 'Admin')) {
            $deactivateButton = $d['account_deactivated'] == 0
                ? '<a href="'.URL_BASE.'accounts/deactivate_account/'.$d['account_id'].'/"><input class="btn-red" type="button" value="Deactivate Account" /></a>'
                : '<a href="'.URL_BASE.'accounts/activate_account/'.$d['account_id'].'/"><input class="btn-green" type="button" value="Activate Account" /></a>';
        } else $deactivateButton = '';

        $passwordBlock = $d != null
            ? ''
            : '<br />'.$f->password(array('id'=>'account-password', 'label'=>'Password'))
                .$f->password(array('id'=>'account-password-confirm', 'label'=>'Confirm Password'));

        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>$actionLink, 'enctype'=>'multipart/form-data'))

            .$f->hidden(array('id'=>'account-owner', 'value'=>$personId))
            .$f->hidden(array('id'=>'account-id', 'value'=>$d != null ? $d['account_id'] : '0'))

            .$f->openFieldset(array('legend'=>'Account Information'))
            .'<span class="column">'
            .$f->text(array('id'=>'account-username', 'label'=>'Username', 'value'=>$d != null ? $d['account_username'] : ''))
            .$c_accounts->displayAccessLevelSelect(array('id'=>'account-access-level', 'label'=>'Access Level', 'default_option'=>$d != null ? $d['account_access_level'] : ''), false)
            .$passwordBlock
            .'</span>'
            .$f->closeFieldset()
            .$f->submit(array('value'=>$d != null ? 'Update Account' : 'Save Account', 'auto_line_break'=>false))
            .$cancelButton
            .$deactivateButton
            .$f->closeForm();
        return $output;
    }



    public function renderLoginForm () {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));
        $output = $f->openForm(array('id'=>'form-login', 'method'=>'post', 'action'=>URL_BASE.'accounts/login/', 'enctype'=>'multipart/form-data'))
            .$f->text(array('id'=>'username', 'label'=>'Username'))
            .$f->password(array('id'=>'password', 'label'=>'Password'))
            .$f->submit(array('value'=>'Login'))
            .$f->closeForm();
        return $output;
    }



    public function renderLoginWelcome () {
        $output = '<div id="form-login">Hello <b>'.$_SESSION['user']['name'].'</b><br />'.$_SESSION['user']['accessLevel'].'</div>';
        return $output;
    }



    public function renderChangePasswordForm ($accountId, $datas) {
        $d = $datas;
        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $output = '<h3>'.$d['account_username'].'</h3>'
            .$f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'accounts/update_password/save/', 'enctype'=>'multipart/form-data'))
            .$f->hidden(array('id'=>'account-id', 'value'=>$accountId))
            .$f->openFieldset(array('legend'=>'Change Password'))
            .'<span class="column">'
            .$f->password(array('id'=>'old-password', 'label'=>'Old Password'))
            .'<br />'
            .$f->password(array('id'=>'new-password', 'label'=>'New Password'))
            .$f->password(array('id'=>'new-password-confirm', 'label'=>'Confirm New Password'))
            .'</span>'
            .$f->closeFieldset()
            .$f->submit(array('value'=>'Save Changes', 'auto_line_break'=>false))
            .'<a href="'.URL_BASE.'accounts/read_account/'.$accountId.'/">'.$f->button(array('class'=>'btn-red', 'value'=>'Cancel')).'</a>'
            .$f->closeForm();
        return $output;
    }



    public function renderAccessLevelSelect ($options, $datas) {
        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $selectOptions = $f->generate(array(
            'type'=>'select_options'
            ,'datas'=>$datas
            ,'label'=>'access_level_label'
            ,'value'=>'access_level_id'));
        $options['select_options'] = $selectOptions;
        return $f->select($options);
    }



    public function renderAccountInformations ($datas) {
        if ($datas == null) return 'Error: This account is not available or do not exists on our system.';

        $d = $datas;
        $c_employees = new controller_employees();
        $accountStatus = $d['account_deactivated'] == '0' ? 'Activated' : 'Deactivated';
        $deactivateBtn = $d['account_deactivated'] == '0'
            ? '<a href="'.URL_BASE.'accounts/deactivate_account/'.$d['account_id'].'/"><input class="btn-red" type="button" value="Deactivate Account" /></a>'
            : '<a href="'.URL_BASE.'accounts/activate_account/'.$d['account_id'].'/"><input class="btn-green" type="button" value="Activate Account" /></a>';
        $accountOwnerName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];
        $accountOwnerNameLink = '<a href="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/"><input type="button" value="'.$accountOwnerName.'" /></a>';
        $output = '<h3>'.$d['account_username'].'</h3><hr />'
            .'<div class="accordion-title">Account Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Owner</th>'
                .'<td>'.$accountOwnerNameLink.'</td>'
                .'<th>Access Level</th>'
                .'<td>'.$d['access_level_label'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Status</th>'
                .'<td>'.$accountStatus.'</td>'
                .'<th>Is Employee</th>'
                .'<td>'.$c_employees->isEmployee($d['person_id'], false).'</td>'
            .'</tr>'
            .'</table>'
            .'</div>'
            .'<hr /><a href="'.URL_BASE.'accounts/update_account/'.$d['person_id'].'/'.$d['account_id'].'/"><input class="btn-green" type="button" value="Update Account" /></a>'
            .'<a href="'.URL_BASE.'accounts/update_password/'.$d['account_id'].'/"><input type="button" value="Change Password" /></a>'
            .$deactivateBtn;
        return $output;
    }



    public function renderPersonAccounts ($datas) {
        if ($datas == null) return 'This person do not have any accounts.';

        $output = '<table><tr>'
            .'<th>Username</th>'
            .'<th>Access Level</th>'
            .'<th>Account Status</th>'
            .'<th>Actions</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $accountStatus = $d['account_deactivated'] == '0' ? 'Activated' : 'Deactivated';
            $activationButton = $d['account_deactivated'] == '0'
                ? '<a href="'.URL_BASE.'accounts/deactivate_account/'.$d['account_id'].'/"><input class="btn-red" type="button" value="Deactivate" /></a>'
                : '<a href="'.URL_BASE.'accounts/activate_account/'.$d['account_id'].'/"><input class="btn-green" type="button" value="Activate" /></a>';
            $output .= '<tr class="data" data-url="'.URL_BASE.'accounts/read_account/'.$d['account_id'].'/">'
                .'<td>'.$d['account_username'].'</td>'
                .'<td>'.$d['access_level_label'].'</td>'
                .'<td>'.$accountStatus.'</td>'
                .'<td>'
                    .'<a href="'.URL_BASE.'accounts/update_account/'.$d['account_owner'].'/'.$d['account_id'].'/"><input class="btn-green" type="button" value="Update Account" /></a>'
                    .'<a href="'.URL_BASE.'accounts/update_password/'.$d['account_id'].'/"><input type="button" value="Change Password" /></a>'
                    .$activationButton
                .'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderAccountName ($datas) {
        $a = $datas;
        $output = $a != null ? $a['account_username'].' -- '.$a['person_lastname'].', '.$a['person_firstname'].' '.$a['person_middlename'].' '.$a['person_suffix'] : 'None';
        return $output;
    }

}