<?php

class ViewAccounts extends ModelAccounts
{
    
    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    protected function renderRegistrationForm ()
    {
        $core = new SystemCore();
        $f = new Form(array(
                'auto_line_break' => true,
                'auto_label' => true
            ));
        $formHtml = $f->openForm(array(
                'id' => 'registration-form',
                'method' => 'post',
                'action' => URL_BASE.'accounts/registration_save/',
                'enctype' => 'multipart/form-data'
            )).
            $f->openFieldset(array(
                    'legend' => 'Information',
                    'class' => 'fieldset-block'
                )).
            '<span class="field-column">'.
            $f->text(array(
                    'id' => 'account-owner',
                    'class' => 'text embedded-search',
                    'data-url' => URL_BASE.'accounts/search_account_owners/',
                    'label' => 'Owner'
                )).
            $f->text(array(
                    'id' => 'account-username',
                    'class' => 'text',
                    'label' => 'Username'
                )).
            $f->password(array(
                    'id' => 'account-password',
                    'class' => 'text',
                    'label' => 'Password'
                )).
            $f->password(array(
                    'id' => 'account-confirm-password',
                    'class' => 'text',
                    'label' => 'Confirm Password'
                )).
            $f->select(array(
                    'id' => 'account-access-level',
                    'class' => 'text',
                    'label' => 'Access Level',
                    'select_options' => $this->dbSelectOptions(
                        'admin_accounts',
                        'account_access_level',
                        'enum'
                        )
                )).
            '</span>'.
            $f->closeFieldset().
            $f->submit(array(
                    'class' => 'button-green',
                    'value' => 'Register'
                )).
            $f->closeForm();
        return $formHtml;
    }



    protected function renderCheckAccounts ()
    {
        $core = new SystemCore();
        $cPersons = new ControllerPersons();

        $pageTitle = $core->renderPageTitle('System account check');
        $accounts = $this->readAccounts();
        if (!empty($accounts) && is_array($accounts)) {
            $totalCount = count($accounts);
            $table = '<table class="table"><thead><tr>
            <th>#</th>
            <th>Username</th>
            <th>Owner</th>
            <th>Employments</th>
            <th>Access Level</th>
            <th>Status</th>
            <th>Actions</th>
            </tr></thead><tbody>';
            foreach ($accounts as $account) {
                $table .= '<tr>
                <td>'.$totalCount.'</td>
                <td>'.$account['account_username'].'</td>
                <td>'.
                    $account['person_lastname'].', '.
                    $account['person_firstname'].' '.
                    $account['person_middlename'].' '.
                    $account['person_suffix'].
                '</td>
                <td>'.$cPersons->getRenderedPersonEmployments($account['person_id']).'</td>
                <td>'.$account['account_access_level'].'</td>
                <td>'.$this->identifyAccountStatus($account['account_id']).'</td>
                <td></td>
                </tr>';
                $totalCount--;
            }
            $table .= '</tbody></table>';
            $html = $table;
            return $pageTitle.$html;
        } else {
            return $pageTitle.'The system cannot find any account on the system.';
        }
    }

}
