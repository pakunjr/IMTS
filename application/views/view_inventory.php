<?php

class view_inventory {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderInventory ($datas) {
        if ($datas == null)
            return 'There are no items in this inventory.';

        $fx = new myFunctions();
        $c_items = new controller_items();

        $items = array();
        $itemsCount = array(
            'hosts'=>0
            ,'components'=>0);
        foreach ($datas as $d) {
            if ($d['item_component_of'] == '0') {
                if (!isset($ownerType))
                    $ownerType = $d['ownership_owner_type'];

                if (!isset($ownerId))
                    $ownerId = $d['ownership_owner'];

                $itemId = $d['item_id'];
                $items[$itemId] = $d;
                $itemsCount['hosts']++;
            } else {
                $hostId = $d['item_component_of'];
                $itemId = $d['item_id'];
                $items[$hostId]['components'][$itemId] = $d;
                $itemsCount['components']++;
            }
        }

        $btnGenerateReport = '<a href="'.URL_BASE.'documents/inventory_report/'.$ownerType.'/'.$ownerId.'/" target="_blank">
            <input type="button" value="Generate Report" />
            </a>';
        $buttons = $btnGenerateReport;

        $output = $buttons.'
            <div class="hr-light"></div>
            <table>
            <tr>
            <th>Item/s</th>
            <th colspan="3">Component/s</th>
            </tr>';
        foreach ($items as $i) {
            if (isset($i['components']) && is_array($i['components'])) {
                $components = '</tr>';
                foreach ($i['components'] as $c) {
                    $componentDescription = strlen($c['item_description']) > 0
                        ? '<br />'.nl2br($c['item_description'])
                        : '';

                    $componentButtons = $c_items->displayItemButtons($c['item_id'], false);
                    $componentButtons = strlen($componentButtons) > 0 ? '<div class="hr-light"></div>'.$componentButtons : '';
                    $components .= '<tr class="data" data-url="'.URL_BASE.'inventory/read_item/'.$c['item_id'].'/">
                        <td>
                            <b>'.$c['item_name'].'</b>
                            <div class="data-more-details">
                                <b>'.$c['item_name'].'</b><br />
                                <small>
                                S/N: '.$c['item_serial_no'].'<br />
                                M/N: '.$c['item_model_no'].'
                                </small>
                                <div class="hr-light"></div>
                                State: '.$c['item_state_label'].'<br />
                                Owned since: '.$fx->dateToWords($c['ownership_date_owned']).'<br />
                                Released since: '.$fx->dateToWords($c['ownership_date_released']).'
                                '.$componentDescription.'
                                '.$componentButtons.'
                            </div>
                        </td>
                        <td>S/N: '.$c['item_serial_no'].'</td>
                        <td>M/N: '.$c['item_model_no'].'</td>
                        </tr>';
                }
                $rowspan = count($i['components']) + 1;
            } else {
                $components = '<td colspan="3">This item has no components</td></tr>';
                $rowspan = 1;
            }

            $itemDescription = strlen($i['item_description']) > 0
                ? '<br />'.nl2br($i['item_description'])
                : '';

            $itemButtons = $c_items->displayItemButtons($i['item_id'], false);
            $itemButtons = strlen($itemButtons) > 0 ? '<div class="hr-light"></div>'.$itemButtons : '';
            $output .= '<tr class="data" data-url="'.URL_BASE.'inventory/read_item/'.$i['item_id'].'/">
                <td rowspan="'.$rowspan.'">
                    <b>'.$i['item_name'].'</b><br />
                    Serial No.: '.$i['item_serial_no'].'<br />
                    Model No.: '.$i['item_model_no'].'
                    <div class="data-more-details">
                        <b>'.$i['item_name'].'</b><br />
                        <small>
                        S/N: '.$i['item_serial_no'].'<br />
                        M/N: '.$i['item_model_no'].'
                        </small>
                        <div class="hr-light"></div>
                        State: '.$i['item_state_label'].'<br />
                        Owned since: '.$fx->dateToWords($i['ownership_date_owned']).'<br />
                        Released since: '.$fx->dateToWords($i['ownership_date_released']).'
                        '.$itemDescription.'
                        '.$itemButtons.'
                    </div>
                </td>
                '.$components;
        }
        $output .= '</table>
            <div class="hr-light"></div>
            '.$buttons;
        return $output;
    }

}
