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

            .title {
                font-family: Times New Roman;
                font-size: 14pt;
                font-weight: bold;
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

            p {
                text-align: justify;
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
                <td rowspan="3"><p>'.nl2br($h['item_description']).'</p></td>
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
        if ($datas == null)
            return 'There is no data available to produce inventory report.';

        $ownershipId = $datas['ownership_id'];
        unset($datas['ownership_id']);

        $items = array();
        $itemCount = array(
            'hosts'=>0
            ,'components'=>0);
        foreach ($datas as $d) {
            if ($d['item_component_of'] == 0) {
                $itemId = $d['item_id'];
                $items[$itemId] = $d;
                $items[$itemId]['components'] = array();
                $itemCount['hosts']++;
            } else {
                $hostId = $d['item_component_of'];
                $itemId = $d['item_id'];
                $items[$hostId]['components'][$itemId] = $d;
                $itemCount['components']++;
            }
        }
        $itemCountTotal = $itemCount['hosts'] + $itemCount['components'];

        $fx = new myFunctions();
        $c_owners = new controller_owners();

        $output = '<div id="pdf-body">
            <table>
            <tr>
            <th>Item</th>
            <th colspan="2">Component/s</th>
            </tr>';
        foreach ($items as $i) {
            $itemDescription = strlen($i['item_description']) > 0
                ? '<br /><br /><p>'.nl2br($i['item_description']).'</p>'
                : '';

            $rowspan = count($i['components']) + 1;

            $output .= '<tr>
                <td rowspan="'.$rowspan.'">
                    <div style="font-weight: bold;">'.$i['item_name'].'</div>
                    Serial No.: '.$i['item_serial_no'].'<br />
                    Model No.: '.$i['item_model_no'].'<br />
                    State: '.$i['item_state_label'].'<br />
                    Owned since: '.$fx->dateToWords($i['ownership_date_owned']).'<br />
                    Released since: '.$fx->dateToWords($i['ownership_date_released']).'<br />
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
                    $componentDescription = strlen($c['item_description']) > 0
                        ? '<br />'.nl2br($c['item_description'])
                        : '';
                    $output .= '<tr>
                        <td>
                            <div style="font-weight: bold;">'.$c['item_name'].'</div>
                            Serial No.: '.$c['item_serial_no'].'<br />
                            Model No.: '.$c['item_model_no'].'<br />
                        </td>
                        <td>
                            Owned since: '.$fx->dateToWords($c['ownership_date_owned']).'<br />
                            Released since: '.$fx->dateToWords($c['ownership_date_released']).'<br />
                            State: '.$c['item_state_label'].'<br />
                            Cost: '.$c['item_cost'].'<br />
                            Depreciation: '.$c['item_depreciation'].'
                            '.$componentDescription.'
                        </td>
                        </tr>';
                }
            }
        }
        $output .= '</table>
            </div>';
        return $output;
    }



    public function renderInventoryStatistics ($datas) {
        if ($datas == null)
            return 'There is no data available to produce inventory statistical report.';

        $ownershipId = $datas['ownership_id'];
        unset($datas['ownership_id']);

        $fx = new myFunctions();
        $c_owners = new controller_owners();

        $itemCounts = array(
            'hosts'=>0
            ,'components'=>0);
        $items = array();
        $itemCountsTotal = 0;

        foreach ($datas as $d) {
            if ($d['item_component_of'] == 0) {
                $itemId = $d['item_id'];
                $items[$itemId] = $d;
                $itemCounts['hosts']++;
            } else {
                $itemId = $d['item_id'];
                $hostId = $d['item_component_of'];
                $items[$hostId][$itemId] = $d;
                $itemCounts['components']++;
            }
            $itemCountsTotal++;
        }

        $ownerName = $c_owners->displayOwnerName($ownershipId, false);
        $output = '<div class="title">Inventory Report</div>
            <div class="hr-light"></div>
            <div id="pdf-body">
                <table>
                <tr>
                    <th colspan="2">'.$ownerName.'</th>
                </tr>
                <tr>
                    <th>No. of Item/s</th>
                    <td>'.$itemCountsTotal.'</td>
                </tr>
                <tr>
                    <th>Main Item/s</th>
                    <td>'.$itemCounts['hosts'].'</td>
                </tr>
                <tr>
                    <th>Component/s</th>
                    <td>'.$itemCounts['components'].'</td>
                </tr>
                </table>
            </div>
            <pagebreak />';
        return $output;
    }
    
}
