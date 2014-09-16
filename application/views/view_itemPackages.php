<?php

class view_itemPackages {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderForm ($datas) {
        $d = $datas;

        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));

        $actionLink = $d != null
            ? URL_BASE.'inventory_packages/update_package/save/'
            : URL_BASE.'inventory_packages/create_package/save/';

        $packageName = $d != null
            ? '<h3>'.$d['package_name'].'<br /><small><span style="color: #03f;">Serial</span>: '.$d['package_serial_no'].'</small></h3>'
            : '<h3>New Package</h3>';

        $cancelButton = $d != null
            ? '<a href="'.URL_BASE.'inventory_packages/read_package/'.$d['package_id'].'/">'.$f->button(array('value'=>'Cancel')).'</a>'
            : '';

        $output = $packageName.$f->openForm(array('id'=>'', 'class'=>'main-form', 'method'=>'post', 'action'=>$actionLink, 'enctype'=>'multipart/form-data'))

            .$f->hidden(array('id'=>'package-id', 'value'=>$d != null ? $d['package_id'] : '0'))

            .$f->openFieldset(array('legend'=>'Package Information'))
            .'<span class="column">'
            .$f->text(array('id'=>'package-name', 'label'=>'Name', 'value'=>$d != null ? $d['package_name'] : ''))
            .$f->text(array('id'=>'package-serial-no', 'label'=>'Serial', 'value'=>$d != null ? $d['package_serial_no'] : ''))
            .$f->text(array('id'=>'package-date-of-purchase', 'class'=>'datepicker', 'label'=>'Date of Purchase', 'value'=>$d != null ? $d['package_date_of_purchase'] : '0000-00-00'))
            .'</span>'

            .'<span class="column">'
            .$f->textarea(array('id'=>'package-description', 'label'=>'Description', 'value'=>$d != null ? $d['package_description'] : ''))
            .'</span>'
            .$f->closeFieldset()

            .$f->submit(array('value'=>$d != null ? 'Update Package' : 'Save Package', 'auto_line_break'=>false))
            .$cancelButton
            .$f->closeForm();
        return $output;
    }
    


    public function renderSearchForm ($keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));
        $output = $f->openForm(array('id'=>'', 'action'=>URL_BASE.'inventory_packages/search_package/', 'method'=>'post', 'enctype'=>'multipart/form-data')).$f->text(array('id'=>'search-keyword', 'value'=>$keyword, 'label'=>'Search')).$f->submit(array('value'=>'Search')).$f->closeForm().'<div class="hr-light"></div>';
        return $output;
    }



    public function renderSearchResults ($results) {
        $fx = new myFunctions();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        if ($results != null) {
            $output = '<table><tr>'
                .'<th>Name</th>'
                .'<th>Description</th>'
                .'<th>Date of Purchase</th>';
            if (isset($_POST['search-keyword'])) {
                $output .= !in_array($accessLevel, array('Viewer'))
                    ? '<th>Actions</th>' : '';
            }
            $output .= '</tr>';
            foreach ($results as $r) {
                $output .= '<tr class="data" '
                    .'data-id="'.$r['package_id'].'" '
                    .'data-label="'.$r['package_name'].' ('.$r['package_serial_no'].')'.'" '
                    .'data-url="'.URL_BASE.'inventory_packages/read_package/'.$r['package_id'].'/">'
                    .'<td>'
                        .$r['package_name'].'<br />'
                        .'<span style="color: #03f;">Serial</span>: '.$r['package_serial_no']
                    .'</td>'
                    .'<td>'.$r['package_description'].'</td>'
                    .'<td>'.$fx->dateToWords($r['package_date_of_purchase']).'</td>';
                if (isset($_POST['search-keyword'])) {
                    $output .= !in_array($accessLevel, array('Viewer'))
                        ? '<td><a href="'.URL_BASE.'inventory_packages/update_package/'.$r['package_id'].'/"><input class="btn-green" type="button" value="Update Package" /></a></td>'
                        : '';
                }
                $output .= '</tr>';
            }
            $output .= '</table>'
                .'<div class="hr-light"></div><a href="'.URL_BASE.'inventory_packages/create_package/" target="_blank"><input class="btn-green" type="button" value="Add a Package" /></a>';
        } else {
            $output = 'There are no packages matching your keywords.<div class="hr-light"></div>';
            $output .= !in_array($accessLevel, array('Viewer'))
                ? '<a href="'.URL_BASE.'inventory_packages/create_package/" target="_blank"><input class="btn-green" type="button" value="Add a Package" /></a>'
                : '';
        }

        return $output;
    }



    public function renderPackageInformations ($datas) {
        if ($datas == null) return 'This package do not exists in the system.';

        $d = $datas;

        $fx = new myFunctions();
        $c_itemPackages = new controller_itemPackages();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<div class="accordion-title">Package Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Name</th>'
                .'<td>'.$d['package_name'].'</td>'
                .'<th>Description</th>'
                .'<td>'.nl2br($d['package_description']).'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Serial</th>'
                .'<td>'.$d['package_serial_no'].'</td>'
                .'<th>Date of Purchase</th>'
                .'<td>'.$fx->dateToWords($d['package_date_of_purchase']).'</td>'
            .'</tr>'
            .'</table>'
            .'</div>'

            .'<div class="accordion-title">Items</div><div class="accordion-content">'.$c_itemPackages->displayPackageItems($d['package_id'], false).'</div>'

            .'<div class="hr-light"></div>';
        $output .= !in_array($accessLevel, array('Viewer'))
            ? '<a href="'.URL_BASE.'inventory_packages/update_package/'.$d['package_id'].'/"><input class="btn-green" type="button" value="Update Package" /></a>'
                .'<a href="'.URL_BASE.'inventory/create_item/"><input type="button" value="Add Item" /></a>'
            : '';
        return $output;
    }



    public function renderPackageItems ($datas) {
        if ($datas == null) return 'This package do not have items.';

        $fx = new myFunctions();
        $c_items = new controller_items();
        $c_itemTypes = new controller_itemTypes();
        $c_itemStates = new controller_itemStates();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Type</th>'
            .'<th>State</th>'
            .'<th>Description</th>'
            .'<th>Quantity</th>'
            .'<th>Date of Purchase</th>'
            .'<th>Current Owner</th>'
            .'<th>Component Of</th>';
        $output .= !in_array($accessLevel, array('Viewer')) ? '<th>Actions</th>' : '';
        $output .= '</tr>';
        foreach ($datas as $d) {
            $componentName = $c_items->displayItemName($d['item_component_of'], false);
            $componentLink = $componentName != 'None'
                ? '<a href="'.URL_BASE.'inventory/read_item/'.$d['item_component_of'].'/"><input type="button" value="'.$componentName.'" /></a>'
                : $componentName;

            $actionButtons = $d['item_archive_state'] == '0'
                ? '<a href="'.URL_BASE.'inventory/update_item/'.$d['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>'
                    .'<a href="'.URL_BASE.'inventory/archive_item/'.$d['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
                : 'This item has been archived.';

            $output .= '<tr class="data" data-url="'.URL_BASE.'inventory/read_item/'.$d['item_id'].'/">'
                .'<td>'
                    .$d['item_name'].'<br />'
                    .'<span style="color: #03f;">Serial</span>: '.$d['item_serial_no'].'<br />'
                    .'<span style="color: #f00;">Model</span>: '.$d['item_model_no']
                .'</td>'
                .'<td>'.$c_itemTypes->displayItemTypeName($d['item_type'], false).'</td>'
                .'<td>'.$c_itemStates->displayItemStateName($d['item_state'], false).'</td>'
                .'<td>'.nl2br($d['item_description']).'</td>'
                .'<td>'.$d['item_quantity'].'</td>'
                .'<td>'.$fx->dateToWords($d['item_date_of_purchase']).'</td>'
                .'<td>'.$c_items->displayItemCurrentOwner($d['item_id'], false).'</td>'
                .'<td>'.$componentLink.'</td>';
            $output .= !in_array($accessLevel, array('Viewer')) ? '<td>'.$actionButtons.'</td>' : '';
            $output .= '</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderPackageName ($package) {
        if ($package == null) return 'None';

        $p = $package;
        $packageName = $p['package_name'].' ('.$package['package_serial_no'].')';
        return $packageName;
    }

}
