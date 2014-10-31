<?php

class ViewProfiles extends ModelProfiles
{
    
    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    protected function renderHomepage ()
    {
        $html = '<div class="action-block">
        <a class="button" href="'.URL_BASE.'user_settings/profile/update_profile/">
        Update Profile
        </a>
        </div>

        <div class="action-block">
        <a class="button" href="'.URL_BASE.'user_settings/profile/change_password/">
        Change Password
        </a>
        </div>';
        return $html;
    }



    protected function renderProfileForm ()
    {
        $core = new SystemCore();
        $f = new Form(array(
                'auto_line_break' => true,
                'auto_label' => true
            ));

        $formHtml = $f->openForm(array(
                'id' => 'profile-form',
                'method' => 'post',
                'action' => URL_BASE.'user_settings/save/',
                'enctype' => 'multipart/form-data'
            )).
            $f->openFieldset(array(
                    'legend' => 'Account Information',
                    'class' => 'fieldset-block'
                )).
            $f->closeFieldset().

            $f->openFieldset(array(
                    'legend' => 'User Information',
                    'class' => 'fieldset-block'
                )).
            $f->closeFieldset().
            $f->submit(array(
                    'value' => 'Update Profile',
                    'class' => 'button-green'
                )).
            $f->closeForm();
        return $formHtml;
    }



    protected function renderChangePasswordForm ()
    {
        $core = new SystemCore();
        $f = new Form(array(
                'auto_line_break' => true,
                'auto_label' => true
            ));

        $formHtml = $f->openForm(array(
                'id' => 'change-password-form',
                'method' => 'post',
                'action' => URL_BASE.'user_settings/profile/save_password/',
                'enctype' => 'multipart/form-data'
            )).
            $f->openFieldset(array(
                    'legend' => 'Password Information',
                    'class' => 'fieldset-block'
                )).
            '<span class="field-column">'.
            $f->password(array(
                    'id' => 'old-password',
                    'class' => 'text',
                    'label' => 'Old Password'
                )).
            $f->password(array(
                    'id' => 'new-password',
                    'class' => 'text',
                    'label' => 'New Password'
                )).
            $f->password(array(
                    'id' => 'confirm-new-password',
                    'class' => 'text',
                    'label' => 'Confirm New Password'
                )).
            '</span>'.
            $f->closeFieldset().
            $f->submit(array(
                    'value' => 'Save Changes',
                    'class' => 'button-green'
                ));
            $f->closeForm().'Testing.';
        return $formHtml;
    }

}
