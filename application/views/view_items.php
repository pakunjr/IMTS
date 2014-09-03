<?php

class view_items {

    public function renderForm ($infos) {
        $i = $infos;
        $f = new form(array('auto_line_break'=>true,'auto_label'=>true));

        if ($i['item'] != null) {
            $itemName = '<h3>';
            $itemName .= $i['niboti']
                ? 'New Item Based On This Item<br />' : '';
            $itemName .= $i['item']['item_name'].'<br />'
                .'<small><span style="color: #03f;">Serial No</span>: '.$i['item']['item_serial_no'].'</small><br />'
                .'<small><span style="color: #f00;">Model No</span>: '.$i['item']['item_model_no'].'</small>'
                .'</h3>';
            $actionLink = URL_BASE.'inventory/update_item/save/';
            $submitBtn = $f->submit(array('value'=>'Save Changes','auto_line_break'=>false));
            $cancelBtn = $f->button(array('value'=>'Cancel'));
            $cancelBtn = '<a href="'.URL_BASE.'inventory/read_item/'.$i['item']['item_id'].'/">'.$cancelBtn.'</a>';
        } else {
            $itemName = '<h3>New Item</h3>';
            $actionLink = URL_BASE.'inventory/create_item/save/';
            $submitBtn = $f->submit(array('value'=>'Save Item','auto_line_break'=>false));
            $cancelBtn = '';
        }

        if ($i['niboti']) {
            $actionLink = URL_BASE.'inventory/create_item_niboti/save/';
            $submitBtn = $f->submit(array('value'=>'Save Item', 'auto_line_break'=>false));
        }

        $output = $itemName.$f->openForm(array('id'=>'form-item','method'=>'post','action'=>$actionLink,'enctype'=>'multipart/form-data'))
            .$this->renderFormItem($infos['item'])
            .$this->renderFormOwner($infos['owner'])
            .$submitBtn.$cancelBtn
            .$f->closeForm();
        return $output;
    }



    public function renderFormItem ($itemInfo) {
        $i = $itemInfo;
        $f = new form(array('auto_line_break'=>true,'auto_label'=>true));

        $c_items = new controller_items();
        $c_itemTypes = new controller_itemTypes();
        $c_itemStates = new controller_itemStates();
        $c_itemPackages = new controller_itemPackages();

        $itemIdHolder = $i != null ? $f->hidden(array('id'=>'item-id','value'=>$i['item_id'])) : '';

        if ($i != null) {
            $hasComponentsCheck = $i['item_has_components'] == '1' ? true : false;
        } else $hasComponentsCheck = false;

        $output = $f->openFieldset(array('legend'=>'Item Information'))
            .$itemIdHolder

            .'<span class="column">'
            .$f->text(array('id'=>'item-name','label'=>'Name','value'=>$i != null ? $i['item_name'] : ''))
            .$f->text(array('id'=>'item-serial-no','label'=>'Serial No','value'=>$i != null ? $i['item_serial_no'] : ''))
            .$f->text(array('id'=>'item-model-no','label'=>'Model No','value'=>$i != null ? $i['item_model_no'] : ''))
            .$c_itemTypes->displaySelectForm(
                array('label'=>'Type','default_option'=>$i != null ? $i['item_type'] : '')
                ,false)
            .'</span>'

            .'<span class="column">'
            .$c_itemStates->displaySelectForm(
                array('label'=>'State','default_option'=>$i != null ? $i['item_state'] : '')
                ,false)
            .$f->textarea(array('id'=>'item-description','label'=>'Description','value'=>$i != null ? $i['item_description'] : ''))
            .$f->text(array('id'=>'item-quantity','label'=>'Quantity','value'=>$i != null ? $i['item_quantity'] : '1 pc.'))
            .'</span>'

            .'<span class="column">'
            .$f->text(array('id'=>'item-date-of-purchase','class'=>'datepicker','label'=>'Date of Purchase','value'=>$i != null ? $i['item_date_of_purchase'] : '0000-00-00'))
            .$f->hidden(array('id'=>'item-package','value'=>$i != null ? $i['item_package'] : '0','data-url'=>URL_BASE.'inventory_packages/in_search/'))
            .$f->text(array('id'=>'item-package-label','label'=>'Package','value'=>$i != null ? $c_itemPackages->displayPackageName($i['item_package'], false) : ''))
            .$f->checkbox(array('id'=>'item-has-components','label'=>'Has Components','checked'=>$hasComponentsCheck))
            .$f->hidden(array('id'=>'item-component-of','value'=>$i != null ? $i['item_component_of'] : '0','data-url'=>URL_BASE.'inventory/in_search_componentHost/'))
            .$f->text(array('id'=>'item-component-of-label','label'=>'Component Of','value'=>$i != null ? $c_items->displayItemName($i['item_component_of'], false) : ''))
            .'</span>'
            .$f->closeFieldset();
        return $output;
    }



    public function renderFormOwner ($ownerInfo) {
        $i = $ownerInfo;
        $f = new form(array('auto_line_break'=>true,'auto_label'=>true));
        $c_owners = new controller_owners();

        $output = $f->openFieldset(array('legend'=>'Current Owner'))
            .'<span class="column">'
            .$f->hidden(array('id'=>'ownership-owner','value'=>$i != null ? $i['ownership_owner'] : '0','data-url'=>URL_BASE.'owners/in_search/'))
            .$f->text(array('id'=>'ownership-owner-label','label'=>'Owner','placeholder'=>'ownership-owner','value'=>$i != null ? $c_owners->displayOwnerName($i['ownership_id'], false) : ''))
            .$f->select(array('id'=>'ownership-owner-type','label'=>'Type','select_options'=>array('Person'=>'Person','Department'=>'Department'),'default_option'=>$i != null ? $i['ownership_owner_type'] : ''))
            .'</span>'

            .'<span class="column">'
            .$f->text(array('id'=>'ownership-date-owned','class'=>'datepicker','label'=>'Date Owned','value'=>$i != null ? $i['ownership_date_owned'] : ''))
            .$f->text(array('id'=>'ownership-date-released','class'=>'datepicker','label'=>'Date Released','value'=>$i != null ? $i['ownership_date_released'] : ''))
            .'</span>'
            .$f->closeFieldset();
        return $output;
    }



    public function renderItemInformation ($infos) {
        $i = $infos;
        $it = $i['item'];
        if ($it == null) {
            echo 'System Error: Such item do not exists in the system.';
            return;
        }

        $fx = new myFunctions();
        $c_items = new controller_items();
        $c_itemTypes = new controller_itemTypes();
        $c_itemStates = new controller_itemStates();
        $c_itemPackages = new controller_itemPackages();

        $itComponentHostName = $c_items->displayItemName($it['item_component_of'], false);
        $itComponentHostLink = $it['item_component_of'] != 0
            ? '<a href="'.URL_BASE.'inventory/read_item/'.$it['item_component_of'].'/"><input type="button" value="'.$itComponentHostName.'" /></a>'
            : 'None';

        $packageName = $c_itemPackages->displayPackageName($it['item_package'], false);
        $packageLink = $packageName != 'None'
            ? '<a href="'.URL_BASE.'inventory_packages/read_package/'.$it['item_package'].'/"><input type="button" value="'.$packageName.'" /></a>'
            : $packageName;

        $hasComponents = $it['item_has_components'] == '1' ? 'Yes' : 'No';

        $actionButtons = $i['item']['item_archive_state'] == '0'
            ? '<hr /><a href="'.URL_BASE.'inventory/update_item/'.$i['item']['item_id'].'/"><input class="btn-green" type="button" value="Update Informations" /></a>'
                .'<a href="'.URL_BASE.'inventory/create_item_niboti/'.$i['item']['item_id'].'/"><input type="button" value="NIBOTI" /></a>'
                .'<a href="'.URL_BASE.'inventory/archive_item/'.$i['item']['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
            : '<hr />This item has been archived.';

        $output = '<h3>'.$it['item_name'].'<br />'
            .'<small><span style="color: #03f;">Serial</span>: '.$it['item_serial_no'].'</small><br />'
            .'<small><span style="color: #f00;">Model</span>: '.$it['item_model_no'].'</small></h3>'
            .'<div class="accordion-title">Item Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Type</th>'
                .'<td>'.$c_itemTypes->displayItemTypeName($it['item_type'], false).'</td>'
                .'<th>Quantity</th>'
                .'<td>'.$it['item_quantity'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>State</th>'
                .'<td>'.$c_itemStates->displayItemStateName($it['item_state'], false).'</td>'
                .'<th>Component Of</th>'
                .'<td>'.$itComponentHostLink.'</td>'
            .'</tr>'
            .'<tr>'
                .'<th rowspan="4">Description</th>'
                .'<td rowspan="4">'.nl2br($it['item_description']).'</td>'
                .'<th>Date of Purchase</th>'
                .'<td>'.$fx->dateToWords($it['item_date_of_purchase']).'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Package</th>'
                .'<td>'.$packageLink.'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Current Owner</th>'
                .'<td>'.$c_items->displayItemCurrentOwner($it['item_id'], false).'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Has Component/s</th>'
                .'<td>'.$hasComponents.'</td>'
            .'</tr>'
            .'</table>'
            .'</div>'

            .'<div class="accordion-title">Component/s</div><div class="accordion-content">'.$this->renderItemComponents($i['components']).'</div>'

            .'<div class="accordion-title">Ownership/s History</div><div class="accordion-content">'.$this->renderItemOwnershipHistory($i['owners']).'</div>'

            .'<div class="accordion-title">Log</div><div class="accordion-content">'.$this->renderItemLog($i['item']['item_log']).'</div>'

            .$actionButtons;
        return $output;
    }



    public function renderItemComponents ($components) {
        if ($components != null) {
            $c_itemStates = new controller_itemStates();
            $c_itemTypes = new controller_itemTypes();
            $c_owners = new controller_owners();

            $output = '<table><tr>'
                .'<th>Name</th>'
                .'<th>Type</th>'
                .'<th>State</th>'
                .'<th>Description</th>'
                .'<th>Quantity</th>'
                .'<th>Current Owner</th>'
                .'<th>Action</th>'
                .'</tr>';
            foreach ($components as $component) {
                if ($component['ownership'] != null) {
                    $cOwnership = $component['ownership'];
                    $coName = $c_owners->displayOwnerName($cOwnership['ownership_id'], false);
                    $coLink = $cOwnership['ownership_owner_type'] == 'Person'
                        ? URL_BASE.'persons/read_person/'.$cOwnership['ownership_owner'].'/'
                        : URL_BASE.'departments/read_department/'.$cOwnership['ownership_owner'].'/';
                    $coLink = '<a href="'.$coLink.'"><input type="button" value="'.$coName.'" /></a>';
                } else {
                    $coName = 'None';
                    $coLink = $coName;
                }

                $actionButtons = $component['item_archive_state'] == '0'
                    ? '<a href="'.URL_BASE.'inventory/update_item/'.$component['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>'
                        .'<a href="'.URL_BASE.'inventory/archive_item/'.$component['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
                    : 'This item has been archived.';

                $output .= '<tr class="special-hover item-component-data" data-url="'.URL_BASE.'inventory/read_item/'.$component['item_id'].'/">'
                    .'<td>'
                        .$component['item_name'].'<br />'
                        .'<span style="color: #03f;">Serial</span>: '.$component['item_serial_no'].'<br />'
                        .'<span style="color: #f00;">Model</span>: '.$component['item_model_no']
                    .'</td>'
                    .'<td>'.$c_itemTypes->displayItemTypeName($component['item_type'], false).'</td>'
                    .'<td>'.$c_itemStates->displayItemStateName($component['item_state'], false).'</td>'
                    .'<td>'.nl2br($component['item_description']).'</td>'
                    .'<td>'.$component['item_quantity'].'</td>'
                    .'<td>'.$coLink.'</td>'
                    .'<td>'.$actionButtons.'</td>'
                    .'</tr>';
            }
            $output .= '</table>';
        } else $output = 'There are no component/s for this item.';
        return $output;
    }



    public function renderItemOwnershipHistory ($owners) {
        $fx = new myFunctions();
        $c_owners = new controller_owners();

        if ($owners != null) {
            $output = '<table><tr>'
                .'<th>Name</th>'
                .'<th>Type</th>'
                .'<th>Date Owned</th>'
                .'<th>Date Released</th>'
                .'<th>Action</th>'
                .'</tr>';
            foreach ($owners as $owner) {
                $ownerName = $c_owners->displayOwnerName($owner['ownership_id'], false);
                $dataUrl = $owner['ownership_owner_type'] == 'Person'
                    ? URL_BASE.'persons/read_person/'.$owner['ownership_owner'].'/'
                    : URL_BASE.'departments/read_department/'.$owner['ownership_owner'].'/';

                $ownerUpdateLink = $owner['ownership_owner_type'] == 'Person'
                    ? URL_BASE.'persons/update_person/'.$owner['ownership_owner'].'/'
                    : URL_BASE.'departments/update_department/'.$owner['ownership_owner'].'/';

                $output .= '<tr class="special-hover owner-data" data-url="'.$dataUrl.'">'
                    .'<td>'.$ownerName.'</td>'
                    .'<td>'.$owner['ownership_owner_type'].'</td>'
                    .'<td>'.$fx->dateToWords($owner['ownership_date_owned']).'</td>'
                    .'<td>'.$fx->dateToWords($owner['ownership_date_released']).'</td>'
                    .'<td><a href="'.$ownerUpdateLink.'"><input class="btn-green" type="button" value="Update Person" /></a></td>'
                    .'</tr>';
            }
            $output .= '</table>';
        } else $output = 'There are no owner history.';
        return $output;
    }



    public function renderItemLog ($log) {
        $log = unserialize($log);

        if (is_array($log)) {
            $fx = new myFunctions();

            arsort($log);

            $output = '<table><tr>'
                .'<th>Date</th>'
                .'<th>Time</th>'
                .'<th>User -- Account Owner</th>'
                .'<th>Log</th>'
                .'</tr>';
            foreach ($log as $l) {
                $output .= '<tr>'
                    .'<td>'.$fx->dateToWords($l['date']).'</td>'
                    .'<td>'.$l['time'].'</td>'
                    .'<td>'.$l['user'].'</td>'
                    .'<td>'.nl2br($l['log']).'</td>'
                    .'</tr>';
            }
            $output .= '</table>';
        } else $output = 'There are no logs for this item.';
        return $output;
    }



    public function renderItemName ($item) {
        return $item != null ? $item['item_name'].' ('.$item['item_serial_no'].', '.$item['item_model_no'].')' : 'None';
    }



    public function renderItemCurrentOwner ($datas) {
        $d = $datas;
        if ($d == null) return 'None';

        $c_owners = new controller_owners();
        $ownerName = $c_owners->displayOwnerName($d['ownership_id'], false);
        $link = $d['ownership_owner_type'] == 'Person' ? URL_BASE.'persons/read_person/'.$d['ownership_owner'].'/' : URL_BASE.'departments/read_department/'.$d['ownership_owner'].'/';
        $link = '<a href="'.$link.'"><input type="button" value="'.$ownerName.'" /></a>';
        return $link;
    }



    public function renderSearchForm ($keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));

        $output = $f->openForm(array('method'=>'post', 'action'=>URL_BASE.'inventory/search_item/', 'enctype'=>'multipart/form-data')).$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword)).$f->submit(array('value'=>'Search')).$f->closeForm().'<hr />';
        return $output;
    }



    public function renderSearchResults ($results) {
        if ($results != null) {
            $c_items = new controller_items();
            $c_itemTypes = new controller_itemTypes();
            $c_itemStates = new controller_itemStates();
            $c_itemPackages = new controller_itemPackages();

            $output = '<table><tr>'
                .'<th>Name</th>'
                .'<th>Type</th>'
                .'<th>State</th>'
                .'<th>Description</th>';
            if (isset($_POST['search-keyword'])) {
                $output .= '<th>Current Owner</th>'
                    .'<th>Package</th>'
                    .'<th>Component Of</th>'
                    .'<th>Actions</th>';
            }
            $output .= '</tr>';
            foreach ($results as $result) {
                $packageName = $c_itemPackages->displayPackageName($result['item_package'], false);
                $packageLink = $packageName != 'None'
                    ? '<a href="'.URL_BASE.'inventory_packages/read_package/'.$result['item_package'].'/"><input type="button" value="'.$packageName.'" /></a>'
                    : $packageName;

                $componentHostName = $c_items->displayItemName($result['item_component_of'], false);
                $componentHostLink = $componentHostName != 'None'
                    ? '<a href="'.URL_BASE.'inventory/read_item/'.$result['item_component_of'].'/"><input type="button" value="'.$componentHostName.'" /></a>'
                    : $componentHostName;

                $rowClass = $result['item_archive_state'] == '0'
                    ? 'data'
                    : 'red disabled';

                $output .= '<tr class="'.$rowClass.'" '
                    .'data-id="'.$result['item_id'].'" '
                    .'data-label="'.$result['item_name'].' ('.$result['item_serial_no'].', '.$result['item_model_no'].')" '
                    .'data-url="'.URL_BASE.'inventory/read_item/'.$result['item_id'].'/">'
                    .'<td>'.$result['item_name'].'<br />'
                        .'<span style="color: #03f;">Serial</span>: '.$result['item_serial_no'].'<br />'
                        .'<span style="color: #f00;">Model</span>: '.$result['item_model_no']
                    .'</td>'
                    .'<td>'.$c_itemTypes->displayItemTypeName($result['item_type'], false).'</td>'
                    .'<td>'.$c_itemStates->displayItemStateName($result['item_state'], false).'</td>'
                    .'<td>'.nl2br($result['item_description']).'</td>';
                if (isset($_POST['search-keyword'])) {
                    $actionButtons = $result['item_archive_state'] == '0'
                        ? '<a href="'.URL_BASE.'inventory/update_item/'.$result['item_id'].'/"><input class="btn-green" type="button" value="Update Item" /></a>'
                            .'<a href="'.URL_BASE.'inventory/archive_item/'.$result['item_id'].'/"><input class="btn-red" type="button" value="Archive Item" /></a>'
                        : 'This item has been archived.';

                    $output .= '<td>'.$c_items->displayItemCurrentOwner($result['item_id'], false).'</td>'
                        .'<td>'.$packageLink.'</td>'
                        .'<td>'.$componentHostLink.'</td>'
                        .'<td>'.$actionButtons.'</td>';
                }
                $output .= '</tr>';
            }
            $output .= '</table>'
                .'<hr /><a href="'.URL_BASE.'inventory/create_item/" target="_blank"><input class="btn-green" type="button" value="Add an Item" /></a>';
        } else $output = 'There are no items matching your keywords.<hr /><a href="'.URL_BASE.'inventory/create_item/" target="_blank"><input class="btn-green" type="button" value="Add an Item" /></a>';
        return $output;
    }

}
