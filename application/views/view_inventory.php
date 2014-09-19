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

        $btnGenerateReport = '<a href="'.URL_BASE.'documents/inventory_report/'.$ownerType.'/'.$ownerId.'/">
            <input type="button" value="Generate Report" />
            </a>';
        $buttons = $btnGenerateReport;

        $output = $buttons.'
            <div class="hr-light"></div>
            <table>
            <tr>
            <th>Item</th>
            <th>Component/s</th>
            </tr>';
        foreach ($items as $i) {
            if (isset($i['components']) && is_array($i['components'])) {
                $components = '</tr>';
                foreach ($i['components'] as $c) {
                    $componentDescription = strlen($c['item_description']) > 0
                        ? '<br />'.nl2br($c['item_description'])
                        : '';
                    $components .= '<tr class="data" data-url="'.URL_BASE.'inventory/read_item/'.$c['item_id'].'/">
                        <td>
                            <b>'.$c['item_name'].'</b><br />
                            Serial No.: '.$c['item_serial_no'].'<br />
                            Model No.: '.$c['item_model_no'].'<br />
                            State: '.$c['item_state_label'].'<br />
                            Owned since: '.$fx->dateToWords($c['ownership_date_owned']).'<br />
                            Released since: '.$fx->dateToWords($c['ownership_date_released']).'
                            '.$componentDescription.'
                        </td>
                        </tr>';
                }
                $rowspan = count($i['components']) + 1;
            } else {
                $components = '<td>This item has no components</td></tr>';
                $rowspan = 1;
            }

            $itemDescription = strlen($i['item_description']) > 0
                ? '<br />'.nl2br($i['item_description'])
                : '';
            $output .= '<tr class="data" data-url="'.URL_BASE.'inventory/read_item/'.$i['item_id'].'/">
                <td rowspan="'.$rowspan.'">
                    <b>'.$i['item_name'].'</b><br />
                    Serial No.: '.$i['item_serial_no'].'<br />
                    Model No.: '.$i['item_model_no'].'<br />
                    State: '.$i['item_state_label'].'<br />
                    Owned since: '.$fx->dateToWords($i['ownership_date_owned']).'<br />
                    Released since: '.$fx->dateToWords($i['ownership_date_released']).'
                    '.$itemDescription.'
                </td>
                '.$components;
        }
        $output .= '</table>
            <div class="hr-light"></div>
            '.$buttons;
        return $output;
    }

}
