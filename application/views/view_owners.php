<?php

class view_owners {

    public function renderTrackForm ($searchFor, $keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));
        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'track/owner/', 'enctype'=>'multipart/form-data'))
            .$f->select(array('id'=>'search-for', 'label'=>'Owner Type', 'select_options'=>array('Person'=>'Person', 'Department'=>'Department'), 'default_option'=>$searchFor))
            .$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword))
            .$f->submit(array('value'=>'Search'))
            .$f->closeForm()
            .'<hr />';
        return $output;
    }
    


    public function renderSearchResults ($searchFor='Person', $results) {
        $fx = new myFunctions();
        $c_persons = new controller_persons();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        switch ($searchFor) {
            case 'Person':
                if ($results != null) {
                    $output = '<table><tr>'
                        .'<th>Name</th>'
                        .'<th>Gender</th>'
                        .'<th>Birthdate</th>'
                        .'</tr>';
                    foreach ($results as $r) {
                        $gender = $r['person_gender'] == 'f' ? 'Female' : 'Male';
                        $output .= '<tr class="data" '
                            .'data-id="'.$r['person_id'].'" '
                            .'data-label="'.$r['person_lastname'].', '.$r['person_firstname'].' '.$r['person_middlename'].' '.$r['person_suffix'].'" ';
                        $output .= !in_array($accessLevel, array('Viewer', 'Content Provider', 'Supervisor', 'Admin', 'Administrator'))
                            ? 'data-url="'.URL_BASE.'track/owner/person/'.$r['person_id'].'/"'
                            : 'data-url="'.URL_BASE.'persons/read_person/'.$r['person_id'].'/"';
                        $output .= '>'
                            .'<td>'
                                .$r['person_lastname'].', '
                                .$r['person_firstname'].' '
                                .$r['person_middlename'].' '
                                .$r['person_suffix']
                            .'</td>'
                            .'<td>'.$gender.'</td>'
                            .'<td>'.$fx->dateToWords($r['person_birthdate']).'</td>'
                            .'</tr>';
                    }
                    $output .= '</table>'
                        .'<hr />';
                    $output .= !in_array($accessLevel, array('Viewer'))
                        ? '<a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>'
                        : '';
                } else $output = 'There are no Person/s matching your keyword.';
                break;

            case 'Department':
                if ($results != null) {
                    $output = '<table><tr>'
                        .'<th>Short -- Name</th>'
                        .'<th>Head</th>'
                        .'<th>Description</th>'
                        .'</tr>';
                    foreach ($results as $r) {
                        $output .= '<tr class="data" '
                            .'data-id="'.$r['department_id'].'" '
                            .'data-label="'.$r['department_name_short'].' ('.$r['department_name'].')" ';
                        $output .= !in_array($accessLevel, array('Viewer', 'Content Provider', 'Supervisor', 'Admin', 'Administrator'))
                            ? 'data-url="'.URL_BASE.'track/owner/department/'.$r['department_id'].'/"'
                            : 'data-url="'.URL_BASE.'departments/read_department/'.$r['department_id'].'/"';
                        $output .= '>'
                            .'<td>'.$r['department_name_short'].' -- '.$r['department_name'].'</td>'
                            .'<td>'.$c_persons->displayPersonName($r['department_head'], false).'</td>'
                            .'<td>'.nl2br($r['department_description']).'</td>'
                            .'</tr>';
                    }
                    $output .= '</table>'
                        .'<hr />';
                    $output .= !in_array($accessLevel, array('Viewer'))
                        ? '<a href="'.URL_BASE.'departments/create_department/" target="_blank"><input type="button" value="Add a Department" /></a>'
                        : '';
                } else $output = 'There are no Department/s matching your keyword.';
                break;

            default:
                $output = 'Something went wrong.';
        }

        return $output;
    }



    public function renderOwnedItems ($datas) {
        if ($datas == null) return 'There are no owned items.';

        $fx = new myFunctions();
        $c_items = new controller_items();
        $c_itemStates = new controller_itemStates();
        $c_itemTypes = new controller_itemTypes();
        $c_itemPackages = new controller_itemPackages();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $itemCount = 1;
        $output = 'No. of Items: '.count($datas).'<br />'
            .'<table><tr>'
            .'<th>#</th>'
            .'<th>Name</th>'
            .'<th>Type</th>'
            .'<th>State</th>'
            .'<th>Description</th>'
            .'<th>Quantity</th>'
            .'<th>Component Of</th>'
            .'<th>Package</th>'
            .'<th>Date Owned</th>'
            .'<th>Date Released</th>';
        $output .= isset($_SESSION['user'])
            && !in_array($accessLevel, array('Viewer'))
                ? '<th>Actions</th>' : '';
        $output .= '</tr>';
        foreach ($datas as $d) {
            $componentName = $c_items->displayItemName($d['item_component_of'], false);
            if (isset($_SESSION['user']))
                $componentNameLink = $componentName == 'None'
                    ? $componentName
                    : '<a href="'.URL_BASE.'inventory/read_item/'.$d['item_component_of'].'/"><input type="button" value="'.$componentName.'" /></a>';
            else
                $componentNameLink = $componentName;

            $archiveButton = in_array($accessLevel, array('Administrator', 'Admin', 'Supervisor'))
                ? '<a href="'.URL_BASE.'inventory/archive_item/'.$d['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
                : '';
            $actionButtons = $d['item_archive_state'] == '0'
                ? '<a href="'.URL_BASE.'inventory/update_item/'.$d['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>'
                    .$archiveButton
                : 'This item has been archived.';

            $currentDate = date('Y-m-d');
            $redClass = $d['ownership_date_released'] < $currentDate
                && $d['ownership_date_released'] != '0000-00-00'
                ? 'red '
                : '';
            $disableClass = $d['item_archive_state'] == '1'
                ? 'disabled '
                : '';
            $dataClass = isset($_SESSION['user'])
                ? 'data'
                : '';

            $output .= '<tr class="'.$redClass.$disableClass.$dataClass.'" '
                .'data-url="'.URL_BASE.'inventory/read_item/'.$d['item_id'].'/">'
                .'<td>'.$itemCount.'</td>'
                .'<td>'.$d['item_name'].'<br />'
                    .'<span style="color: #03f;">Serial No</span>: '.$d['item_serial_no'].'<br />'
                    .'<span style="color: #f00;">Model No</span>: '.$d['item_model_no'].'</td>'
                .'<td>'.$c_itemTypes->displayItemTypeName($d['item_type'], false).'</td>'
                .'<td>'.$c_itemStates->displayItemStateName($d['item_state'], false).'</td>'
                .'<td>'.nl2br($d['item_description']).'</td>'
                .'<td>'.$d['item_quantity'].'</td>'
                .'<td>'.$componentNameLink.'</td>'
                .'<td>'.$c_itemPackages->displayPackageName($d['item_package'], false).'</td>'
                .'<td>'.$fx->dateToWords($d['ownership_date_owned']).'</td>'
                .'<td>'.$fx->dateToWords($d['ownership_date_released']).'</td>';
            $output .= isset($_SESSION['user'])
                && !in_array($accessLevel, array('Viewer'))
                    ? '<td>'.$actionButtons.'</td>' : '';
            $output .= '</tr>';
            $itemCount++;
        }
        $output .= '</table>';
        return $output;
    }



    public function renderOwnedItemsSummary ($datas) {
        if ($datas == null) return 'There are no items.';

        $fx = new myFunctions();
        $aLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $items = array();
        foreach ($datas as $d) {
            if ($d['item_component_of'] == '0')
                $items[$d['item_id']] = $d;
            else
                $items[$d['item_component_of']]['components'][$d['item_id']] = $d;
        }

        $itemCount = 1;
        $output = 'Total no. of items: '.count($items).'<hr />'
            .'<table><tr>'
            .'<th>No.</th>'
            .'<th>Name</th>'
            .'<th>Type</th>'
            .'<th>State</th>'
            .'<th>Date Owned</th>'
            .'<th>Date Released</th>'
            .'<th>Components</th>';
        $output .= isset($_SESSION['user']) && !in_array($aLevel, array('Viewer')) ? '<th>Actions</th>' : '';
        $output .= '</tr>';
        foreach ($items as $i) {
            $btnUpdate = !in_array($aLevel, array('View')) ? '<a href="'.URL_BASE.'inventory/update_item/'.$i['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>' : '';
            $btnArchive = in_array($aLevel, array('Administrator', 'Admin', 'Supervisor')) ? '<a href="'.URL_BASE.'inventory/archive_item/'.$i['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>' : '';
            $actionButtons = $btnUpdate.$btnArchive;
            $actionButtons = $i['item_archive_state'] == '0' ? $actionButtons : 'This item is already archived.';

            $output .= '<tr class="';
                $output .= isset($_SESSION['user']) ? 'data' : '';
                $output .= '" '
                .'data-url="'.URL_BASE.'inventory/read_item/'.$i['item_id'].'/">'
                .'<td>'.$itemCount.'</td>'
                .'<td>'
                    .'<b>'.$i['item_name'].'</b><br />'
                    .'Serial No.: '.$i['item_serial_no'].'<br />'
                    .'Model No.: '.$i['item_model_no']
                .'</td>'
                .'<td>'.$i['item_type_label'].'</td>'
                .'<td>'.$i['item_state_label'].'</td>'
                .'<td>'.$fx->dateToWords($i['ownership_date_owned']).'</td>'
                .'<td>'.$fx->dateToWords($i['ownership_date_released']).'</td>'
                .'<td>';
                if (isset($i['components'])
                    && is_array($i['components'])) {
                    foreach ($i['components'] as $c) {
                        $itemName = '<b>'.$c['item_name'].'</b><br />'
                            .'Serial No.: '.$c['item_serial_no'].'<br />'
                            .'Model No.: '.$c['item_model_no'];
                        $output .= isset($_SESSION['user'])
                            ? '<a class="btn-blue" href="'.URL_BASE.'inventory/read_item/'.$c['item_id'].'/">'.$itemName.'</a><br />'
                            : '<br />'.$itemName.'<br />';
                    }
                } else $output .= 'This item do not have any components.';
            $output .= '</td>';
            $output .= isset($_SESSION['user']) && !in_array($aLevel, array('Viewer')) ? '<td>'.$actionButtons.'</td>' : '';
            $output .= '</tr>';

            $itemCount++;
        }
        $output .= '</table><hr />'
            .'<a href="'.URL_BASE.'track/owner/'.strtolower($datas[0]['ownership_owner_type']).'_printable/'.$datas[0]['ownership_owner'].'/" target="_blank"><input type="button" value="Printable Version" /></a>';
        return $output;
    }



    public function renderPdfOwnedItems ($datas) {
        if ($datas == null) return '<page>'
            .'There are no items to display.'
            .'</page>';

        $fx = new myFunctions();
        $loggedUser = isset($_SESSION['user']) ? '<b>'.$_SESSION['user']['username'].'</b> :: <b>'.$_SESSION['user']['name'].'</b>' : 'an <b>Anonymous Person</b>';

        $content = '<page>'
            ."<style>
                @page {
                    display: block;
                    width: 8.5in;

                    @frame header {
                        -pdf-frame-content: header-content;
                    }

                    @frame footer {
                        -pdf-frame-content: footer-content;
                    }
                }

                #footer-content {
                    text-align: center;
                    font-size: 7.5pt;
                    line-height: 9.5pt;
                }

                table {
                    border-collapse: collapse;
                }

                table th,
                table td {
                    padding: 5px 8px;
                    border: 1px solid #ccc;
                }
            </style>"
            .'<div id="header-content">'
            .'<h2>Inventory Monitoring and Tracking System</h2>'
            .'</div>';
        if ($datas[0]['ownership_owner_type'] == 'Person') {
            $c_persons = new controller_persons();
            $content .= '<h3>'.$c_persons->displayPersonName($datas[0]['ownership_owner'], false).'</h3><hr />';
        } else {
            $c_departments = new controller_departments();
            $content .= '<h3>'.$c_departments->displayDepartmentName($datas[0]['ownership_owner'], false).'</h3><hr />';
        }
        $content .= '<span style="font-size: 8.5pt;">'.$this->renderOwnedItemsSummary($datas).'</span>'
            .'<br /><div id="footer-content">'
            .'This document is generated through the Inventory Monitoring and Tracking System.<br />'
            .'Date of Generation: '.$fx->dateToWords(date('Y-m-d')).' @ '.date('H:i:s').'<br />'
            .'Generated by '.$loggedUser.'<br />'
            .'Lorma Colleges &copy; 2014'
            .'</div>'
            .'</page>';
        return $content;
    }



    public function renderOwnerName ($owner) {
        switch ($owner['owner_type']) {
            case 'Person':
                return $owner != null ? $owner['person_lastname'].', '
                    .$owner['person_firstname'].' '
                    .$owner['person_middlename'].' '
                    .$owner['person_suffix'] : 'None';
                break;

            case 'Department':
                return $owner != null ? $owner['department_name_short'].' ('.$owner['department_name'].')' : 'None';
                break;

            default:
                return 'None';
        }
    }

}
