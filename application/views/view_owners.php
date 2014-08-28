<?php

class view_owners {
    
    public function renderSearchResults ($searchFor='Person', $results) {
        $fx = new myFunctions();
        $c_persons = new controller_persons();

        switch ($searchFor) {
            case 'Person':
                if ($results != null) {
                    $output = '<table><tr>'
                        .'<th>Name</th>'
                        .'<th>Gender</th>'
                        .'<th>Birthdate</th>'
                        .'</tr>';
                    foreach ($results as $result) {
                        $gender = $result['person_gender'] == 'f' ? 'Female' : 'Male';
                        $output .= '<tr class="data" data-id="'.$result['person_id'].'" data-label="'.$result['person_lastname'].', '.$result['person_firstname'].' '.$result['person_middlename'].' '.$result['person_suffix'].'">'
                            .'<td>'
                                .$result['person_lastname'].', '
                                .$result['person_firstname'].' '
                                .$result['person_middlename'].' '
                                .$result['person_suffix']
                            .'</td>'
                            .'<td>'.$gender.'</td>'
                            .'<td>'.$fx->dateToWords($result['person_birthdate']).'</td>'
                            .'</tr>';
                    }
                    $output .= '</table>'
                        .'<hr /><a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>';
                } else $output = 'There are no Person/s matching your keyword.';
                break;

            case 'Department':
                if ($results != null) {
                    $output = '<table><tr>'
                        .'<th>Short -- Name</th>'
                        .'<th>Head</th>'
                        .'<th>Description</th>'
                        .'</tr>';
                    foreach ($results as $result) {
                        $output .= '<tr class="data" data-id="'.$result['department_id'].'" data-label="'.$result['department_name_short'].' ('.$result['department_name'].')">'
                            .'<td>'.$result['department_name_short'].' -- '.$result['department_name'].'</td>'
                            .'<td>'.$c_persons->displayPersonName($result['department_head'], false).'</td>'
                            .'<td>'.nl2br($result['department_description']).'</td>'
                            .'</tr>';
                    }
                    $output .= '</table>'
                        .'<hr /><a href="'.URL_BASE.'departments/create_department/" target="_blank"><input type="button" value="Add a Department" /></a>';
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

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Type</th>'
            .'<th>State</th>'
            .'<th>Description</th>'
            .'<th>Quantity</th>'
            .'<th>Component Of</th>'
            .'<th>Package</th>'
            .'<th>Date Owned</th>'
            .'<th>Date Released</th>'
            .'<th>Actions</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $componentName = $c_items->displayItemName($d['item_component_of'], false);
            $componentNameLink = $componentName == 'None'
                ? $componentName : '<a href="'.URL_BASE.'inventory/read_item/'.$d['item_component_of'].'/"><input type="button" value="'.$componentName.'" /></a>';

            $actionButtons = $d['item_archive_state'] == '0'
                ? '<a href="'.URL_BASE.'inventory/update_item/'.$d['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>'
                    .'<a href="'.URL_BASE.'inventory/archive_item/'.$d['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
                : 'This item has been archived.';

            $output .= '<tr class="special-hover item-component-data" data-url="'.URL_BASE.'inventory/read_item/'.$d['item_id'].'/">'
                .'<td>'.$d['item_name'].'<br />'
                    .'<span style="color: #03f;">Serial No</span>: '.$d['item_serial_no'].'<br />'
                    .'<span style="color: #f00;">Model No</span>: '.$d['item_model_no'].'</td>'
                .'<td>'.$c_itemTypes->displayItemTypeName($d['item_type'], false).'</td>'
                .'<td>'.$c_itemStates->displayItemStateName($d['item_state'], false).'</td>'
                .'<td>'.$d['item_description'].'</td>'
                .'<td>'.$d['item_quantity'].'</td>'
                .'<td>'.$componentNameLink.'</td>'
                .'<td>'.$c_itemPackages->displayPackageName($d['item_package'], false).'</td>'
                .'<td>'.$fx->dateToWords($d['ownership_date_owned']).'</td>'
                .'<td>'.$fx->dateToWords($d['ownership_date_released']).'</td>'
                .'<td>'.$actionButtons.'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderOwnerName ($owner) {
        switch ($owner['owner_type']) {
            case 'Person':
                return $owner != null ? $owner['person_lastname'].', '
                    .$owner['person_firstname'].' '
                    .$owner['person_middlename'].' '
                    .$owner['person_suffix'] : 'Unknown Owner';
                break;

            case 'Department':
                return $owner != null ? $owner['department_name_short'].' ('.$owner['department_name'].')' : 'Unknown Owner';
                break;

            default:
                return 'Unknown Owner';
        }
    }

}
