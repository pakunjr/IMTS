<?php

class view_itemMaintenance {

    private $priorityLevel;

    public function __construct () {
        $this->priorityLevel = array(
            'Low' => 'Low'
            ,'Normal' => 'Normal'
            ,'High' => 'High'
            ,'Emergency' => 'Emergency');
    }



    public function __destruct () {

    }



    public function mainForm ($options=array()) {
        $f = new form(array(
            'auto_line_break' => true
            ,'auto_label' => true));
        $fx = new myFunctions();
        $c_items = new controller_items();

        $datas = isset($options['datas'])
            ? $options['datas']
            : null;

        $formAction = $datas === null
            ? URL_BASE.'inventory_maintenance/create_maintenance/save/'
            : URL_BASE.'inventory_maintenance/update_maintenance/save/';

        $itemId = isset($options['itemId'])
            ? $options['itemId']
            : 0;

        $o = $f->openForm(array(
                'id' => 'form-item-maintenance'
                ,'method' => 'post'
                ,'action' => $formAction
                ,'enctype' => 'multipart/form-data')).'
            '.$f->openFieldset(array(
                'legend' => 'Maintenance Information')).'
            <span class="column">
            '.$f->hidden(array(
                'id' => 'maintenance-item'
                ,'data-url' => URL_BASE.'inventory_maintenance/in_search_items/'
                ,'value' => $datas !== null
                    ? $datas['maintenance_item']
                    : $itemId)).'
            '.$f->text(array(
                'id' => 'maintenance-item-label'
                ,'label' => 'Item'
                ,'value' => $datas !== null
                    ? $c_items->displayItemName(
                        $datas['maintenance_item']
                        ,false)
                    : $c_items->displayItemName(
                        $itemId
                        ,false))).'
            '.$f->hidden(array(
                'id' => 'maintenance-assigned-staff'
                ,'data-url' => URL_BASE.'inventory_maintenance/in_search_staffs/'
                ,'value' => isset($_SESSION['user'])
                    ? $_SESSION['user']['personId']
                    : 0)).'
            '.$f->text(array(
                'id' => 'maintenance-assigned-staff-label'
                ,'label' => 'Assigned Staff'
                ,'value' => isset($_SESSION['user'])
                    ? $_SESSION['user']['name']
                    : 'None')).'
            '.$f->select(array(
                'id' => 'maintenance-priority-level'
                ,'label' => 'Priority Level'
                ,'select_options' => $this->priorityLevel
                ,'default_option' => $datas != null
                    ? $datas['maintenance_priority_level']
                    : '')).'
            '.$f->text(array(
                'id' => 'maintenance-date-due'
                ,'class' => 'datepicker'
                ,'label' => 'Deadline'
                ,'value' => $datas != null
                    ? $datas['maintenance_date_due']
                    : '0000-00-00')).'
            </span>

            <span class="column">
            '.$f->checkbox(array(
                'id' => 'maintenance-send-notice'
                ,'label' => 'Send Notice (email)')).'
            '.$f->textarea(array(
                'id' => 'maintenance-internal-note'
                ,'label' => 'Internal Note')).'
            '.$f->textarea(array(
                'id' => 'maintenance-detailed-report'
                ,'label' => 'Detailed Report')).'
            </span>
            '.$f->closeFieldset().'
            '.$f->submit(array('value' => 'Save Maintenance')).'
            '.$f->closeForm();
        return $o;
    }



    public function searchForm () {
        
    }



    public function information ($datas) {
        if ($datas === null)
            return 'This seems an invalid item maintenance.';

        $fx = new myFunctions();
        $c_itemMaintenance = new controller_itemMaintenance();

        $itemLink = '<a class="btn-blue" href="'.URL_BASE.'inventory/read_item/'.$datas['item_id'].'/">
            '.$datas['item_name'].'<br />
            S/N: '.$datas['item_serial_no'].'<br />
            M/N: '.$datas['item_model_no'].'
            </a>';

        $staffLink = '<a class="btn-blue" href="'.URL_BASE.'persons/read_person/'.$datas['person_id'].'/">
            '.$datas['person_lastname'].', '.$datas['person_firstname'].' '.$datas['person_middlename'].' '.$datas['person_suffix'].'
            </a>';

        $progressList = $this->progressForm($datas['maintenance_id']);

        $o = '<h3>Maintenance of '.$datas['item_name'].'<br />
            since '.$fx->dateToWords($datas['maintenance_date_submitted']).'.</h3>
            <div class="hr-light"></div>
            <div class="accordion-title">Information</div>
            <div class="accordion-content accordion-content-default">
                <table>
                    <tr>
                        <th>Item Name</th>
                        <td>'.$itemLink.'</td>
                        <th rowspan="4">Report</th>
                        <td rowspan="4">'.nl2br($datas['maintenance_detailed_report']).'</td>
                    </tr>
                    <tr>
                        <th>Assigned Staff</th>
                        <td>'.$staffLink.'</td>
                    </tr>
                    <tr>
                        <th>Date Submitted</th>
                        <td>'.$fx->dateToWords($datas['maintenance_date_submitted']).'</td>
                    </tr>
                    <tr>
                        <th>Date Cleared</th>
                        <td>'.$fx->dateToWords($datas['maintenance_date_cleared']).'</td>
                    </tr>
                </table>
            </div>

            <div class="accordion-title">Progress</div>
            <div class="accordion-content">
                '.$progressList.'
            </div>

            <div class="hr-light"></div>
            '.$this->buttons($datas);
        return $o;
    }



    public function progressList ($datas) {
        if ($datas === null)
            return 'There is no previous progresses for this maintenance.';

        $fx = new myFunctions();
        $c_persons = new controller_persons();

        $progressList = '';
        foreach ($datas as $d) {
            $staffName = $c_persons->displayPersonName($d['progress_submitted_by'], false);

            $dateSubmitted = $fx->dateToWords($d['progress_date_submitted']);

            $details = strlen($d['progress_details']) > 0
                ? nl2br($d['progress_details'])
                : '';

            $progressList .= '<tr>
                <td>
                    <div class="accordion-title">
                        <span style="float: right;">From '.$staffName.'</span>
                        '.$dateSubmitted.'
                    </div>
                    <div class="accordion-content accordion-content-default">'.$details.'</div>
                </td>
                </tr>';
        }

        $o = '<table>
            <tr>
                <th>Progress / Replies / Comments / Notice</th>
            </tr>
            '.$progressList.'
            </table>';
        return $o;
    }



    public function progressForm ($maintenanceId) {
        $f = new form(array(
            'auto_line_break' => true
            ,'auto_label' => true));
        $fx = new myFunctions();
        $c_itemMaintenance = new controller_itemMaintenance();

        $progressList = $c_itemMaintenance->fetchProgress($maintenanceId);
        $progressList = $this->progressList($progressList);

        $o = $progressList.'
            <div class="hr-light"></div>
            '.$f->openForm(array(
                'id' => 'maintenance-progress-form'
                ,'method' => 'post'
                ,'action' => ''
                ,'enctype' => 'multipart/form-data')).'
            <span class="column">
            '.$f->textarea(array(
                'id' => 'progress-details'
                ,'class' => 'block'
                ,'label' => 'Details'
                ,'placeholder' => 'Type your response here for this maintenance...')).'
            </span>
            <div class="hr-light"></div>
            '.$f->submit(array('value' => 'Post Reply')).'
            '.$f->closeForm();
        return $o;
    }



    public function history ($datas) {
        if ($datas === null) {
            return 'This item haven\'t undergo maintenance yet.';
        }

        $fx = new myFunctions();

        $maintenances = '';
        foreach ($datas as $d) {
            $itemName = $d['item_name'].'<br />
                    S/N: '.$d['item_serial_no'].'<br />
                    M/N: '.$d['item_model_no'];

            $personName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];
            $personLink = $d['person_id'] !== null || $d['person_id'] != 0
                ? '<a class="btn-blue" href="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">'.$personName.'</a>'
                : 'Unknown';

            $dataMoreDetails = '<div class="data-more-details">
                    <b>Maintenance for '.$d['item_name'].'</b><br />
                    '.$fx->dateToWords($d['maintenance_date_submitted']).' - '.$fx->dateToWords($d['maintenance_date_cleared']).'
                    <div class="hr-light"></div>
                    '.$this->buttons($d).'
                    </div>';

            $dataUrl = URL_BASE.'inventory_maintenance/read_maintenance/'.$d['maintenance_id'].'/';
            $maintenances .= '<tr class="data" data-url="'.$dataUrl.'">
                <td>'.$itemName.$dataMoreDetails.'</td>
                <td>'.$personLink.'</td>
                <td>'.$fx->dateToWords($d['maintenance_date_submitted']).'</td>
                <td>'.$fx->dateToWords($d['maintenance_date_cleared']).'</td>
                <td>'.$d['maintenance_detailed_report'].'</td>
                </tr>';
        }

        $o = '<table class="paged">
            <tr>
                <th>Item</th>
                <th>Assigned Staff</th>
                <th>Date Submitted</th>
                <th>Date Cleared</th>
                <th>Detailed Report</th>
            </tr>
            '.$maintenances.'
            </table>';

        return $o;
    }



    public function buttons ($datas) {
        if ($datas === null)
            return null;

        $fx = new myFunctions();

        $btnUpdate = $fx->isAccessible('Content Provider')
            ? '<a href="'.URL_BASE.'inventory_maintenance/update_maintenance/'.$datas['maintenance_id'].'/"><input type="button" value="Update Maintenance" /></a>'
            : '';
        $btnClear = $fx->isAccessible('Content Provider')
                && $datas['maintenance_date_cleared'] == '0000-00-00'
            ? '<a href="#"><input type="button" value="Clear Maintenance" /></a>'
            : '';
        $btnDelete = $fx->isAccessible('Administrator')
            ? '<a href="#"><input type="button" value="Delete Maintenance" /></a>'
            : '';

        $o = $btnUpdate
            .$btnClear
            .$btnDelete;
        return $o;
    }



    public function searchResults ($datas, $for='maintenance') {
        if ($datas === null)
            return 'Your keyword did not match any results.';

        $fx = new myFunctions();

        $headers = '';
        $searchResults = '';

        switch ($for) {
            case 'items':
                $headers = '<tr>
                    <th>Name</th>
                    </tr>';
                foreach ($datas as $d) {
                    $itemName = $d['item_name'].'<br />
                        S/N: '.$d['item_serial_no'].'<br />
                        M/N: '.$d['item_model_no'];

                    $searchResults .= '<tr>
                        <td>'.$itemName.'</td>
                        </tr>';
                }
                break;

            case 'staffs':
                $headers = '<tr>
                    <th>Name</th>
                    </tr>';
                foreach ($datas as $d) {
                    $staffName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];

                    $searchResults .= '<tr>
                        <td>'.$staffName.'</td>
                        </tr>';
                }
                break;

            case 'maintenance':
            default:
                $headers = '<tr>
                    <th>Item</th>
                    <th>Assigned Staff</th>
                    <th>Date Submitted</th>
                    <th>Date Cleared</th>
                    </tr>';
                foreach ($datas as $d) {
                    $itemName = $d['item_name'].'<br />
                        S/N: '.$d['item_serial_no'].'<br />
                        M/N: '.$d['item_model_no'];

                    $staffName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];

                    $searchResults .= '<tr>
                        <td>'.$itemName.'</td>
                        <td>'.$staffName.'</td>
                        <td>'.$fx->dateToWords($d['maintenance_date_submitted']).'</td>
                        <td>'.$fx->dateToWords($d['maintenance_date_cleared']).'</td>
                        </tr>';
                }
        }

        $o = '<table class="paged">
            '.$headers.'
            '.$searchResults.'
            </table>';
        return $o;
    }
    
}
