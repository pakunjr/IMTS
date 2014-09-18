<?php

class view_documents {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function pdfStylesheet () {
        $css = '
            #pdf-body {
                display: block;
                font-family: Helvetica;
                font-size: 12pt;
            }
            #pdf-header,
            #pdf-footer {
                font-family: Helvetica;
                font-size: 7pt;
            }

            .hr,
            .hr-light,
            .hr-heavy {
                display: block;
                height: 2px;
                margin: 5px 0px;
                border-radius: 4px;
                background: #333;
            }
            .hr-light {
                height: 1px;
            }
            .hr-heavy {
                height: 3px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
            table th,
            table td {
                padding: 5px 8px;
                border: 1px solid #333;
                font-family: Helvetica;
                font-size: 0.9em;
                word-wrap: break-word;
            }
            table td {
                font-size: 0.9em;
            }

            ol {
                font-size: 0.9em;
            }
            ol li {
                font-size: 0.95em;
            }
        ';
        return $css;
    }



    public function renderProfileCard ($datas) {
        if ($datas == null)
            exit('<span style="display: inline-block; color: #f00;">'
                .'USER ERROR: The item do not exists, you cannot generate this profile card.'
                .'<br />Exiting...'
                .'<br /><br /><a href="'.URL_BASE.'">Click here to go to <input type="button" value="Homepage" /></a>'
                .'</span>');

        $fx = new myFunctions();

        $itemId = $datas['item_id'];
        $itemName = $datas['item_name'];
        unset($datas['item_id']);
        unset($datas['item_name']);

        $host = array();
        $components = array();

        foreach ($datas as $d) {
            if ($d['item_component_of'] == 0) {
                $hId = $d['item_id'];
                $host[$hId] = $d;
            } else {
                $cId = $d['item_id'];
                $components[$cId] = $d;
            }
        }

        if (count($host) < 1)
            return '<div id="pdf-body">
                You cannot generate an Item Profile Card for this item.<br />
                Item requirements to be able to generate a Profile Card:<br />
                <ol>
                <li>It must be a host item that can have item components.</li>
                </ol>
                </div>';

        $output = '<div id="pdf-body">';
        foreach ($host as $h) {
            $output .= '<div class="hr-light"></div>
                Item Profile Card of '.$h['item_name'].'
                <div class="hr-light"></div>
                <table>
                <tr>
                <th>Serial No.</th>
                <td>'.$h['item_serial_no'].'</td>
                <th>Package</th>
                <td>'.$h['package_name'].'</td>
                <th rowspan="3">Description / Notes</th>
                <td rowspan="3">'.nl2br($h['item_description']).'</td>
                </tr>
                <tr>
                <th>Model No.</th>
                <td>'.$h['item_model_no'].'</td>
                <th>Cost</th>
                <td>'.$h['item_cost'].'</td>
                </tr>
                <tr>
                <th>Purchased</th>
                <td>'.$fx->dateToWords($h['item_date_of_purchase']).'</td>
                <th>Depreciation</th>
                <td>'.$h['item_depreciation'].'</td>
                </tr>';
            if (isset($components) && is_array($components)) {
                $output .= '<tr><th colspan="6">Components</th></tr>
                    <tr><td colspan="6" style="text-align: center;">
                    <table>
                    <tr>
                    <th>Name</th>
                    <th>Serial &amp; Model No.</th>
                    <th>Purchased</th>
                    </tr>';
                foreach ($components as $c) {
                    $output .= '<tr>
                        <td><div>'.$c['item_name'].'</div></td>
                        <td>
                        Serial No: '.$c['item_serial_no'].'<br />
                        Model No: '.$c['item_model_no'].'
                        </td>
                        <td>'.$fx->dateToWords($c['item_date_of_purchase']).'</td>
                        </tr>';
                }
                $output .= '</table>
                    </td></tr>';
            } else
                $output .= '<tr><td>This item has no components.</td></tr>';

            $output .= '</table>';
        }
        $docGenerator = isset($_SESSION['user']) ? $_SESSION['user']['name'] : 'Anonymous';
        $output .= '<div class="hr-light"></div>
            <div style="font-size: 0.7em;">
                Generated by '.$docGenerator.' as of '.$fx->dateToWords(date('Y-m-d')).' @ '.date('H:i:s').' (UTC+08:00)<br />
                '.SYSTEM_NAME.' '.SYSTEM_VERSION.' &copy; '.SYSTEM_YEAR_START.' - '.date('Y').'
            </div>
            <div class="hr-light"></div>
            </div>';

        return $output;
    }



    public function renderInventoryReport ($datas) {
        $ownershipId = $datas['ownership_id'];
        unset($datas['ownership_id']);

        $items = array();
        foreach ($datas as $d) {
            if ($d['item_component_of'] == 0) {
                $itemId = $d['item_id'];
                $items[$itemId] = $d;
                $items[$itemId]['components'] = array();
            } else {
                $hostId = $d['item_component_of'];
                $itemId = $d['item_id'];
                $items[$hostId]['components'][$itemId] = $d;
            }
        }

        $fx = new myFunctions();
        $c_owners = new controller_owners();

        $ownerName = $c_owners->displayOwnerName($ownershipId, false);
        $output = '<div id="pdf-body">
            Inventory report of items owned by '.$ownerName.'
            <div class="hr-light"></div>
            <table>
            <tr>
            <th>Name</th>
            <th colspan="2">Component/s</th>
            </tr>';
        foreach ($items as $i) {
            $itemDescription = strlen($i['item_description']) > 0
                ? '<br /><br />'.nl2br($i['item_description'])
                : '';

            $rowspan = count($i['components']) + 1;

            $output .= '<tr>
                <td rowspan="'.$rowspan.'">
                    <div style="font-weight: bold;">'.$i['item_name'].'</div>
                    Serial No.: '.$i['item_serial_no'].'<br />
                    Model No.: '.$i['item_model_no'].'<br />
                    State: '.$i['item_state_label'].'<br />
                    Cost: '.$i['item_cost'].'<br />
                    Depreciation: '.$i['item_depreciation'].'
                    '.$itemDescription.'
                </td>';
            $output .= count($i['components']) < 1
                ? '<td colspan="2">This item has no components</td>' : '';
            $output .= '</tr>';
            if (isset($i['components'])
                    && is_array($i['components'])
                    && count($i['components']) > 0) {
                foreach ($i['components'] as $c) {
                    $output .= '<tr>
                        <td>
                            <div style="font-weight: bold;">'.$c['item_name'].'</div>
                            Serial No.: '.$c['item_serial_no'].'<br />
                            Model No.: '.$c['item_model_no'].'<br />
                        </td>
                        <td>
                            State: '.$c['item_state_label'].'<br />
                            Cost: '.$c['item_cost'].'<br />
                            Depreciation: '.$c['item_depreciation'].'
                            '.nl2br($c['item_description']).'
                        </td>
                        </tr>';
                }
            }
        }
        $output .= '</table>
            </div>';
        return $output;
    }
    
}
