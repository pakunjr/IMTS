<?php

class view_itemPackages {
    
    public function renderSearchResults ($results) {
        $fx = new myFunctions();

        if ($results != null) {
            $output = '<table><tr>'
                .'<th>Name</th>'
                .'<th>Description</th>'
                .'<th>Date of Purchase</th>'
                .'</tr>';
            foreach ($results as $result) {
                $output .= '<tr class="data" data-id="'.$result['package_id'].'" data-label="'.$result['package_name'].' ('.$result['package_serial_no'].')'.'">'
                    .'<td>'
                        .$result['package_name'].' ('
                        .$result['package_serial_no'].')'
                    .'</td>'
                    .'<td>'.$result['package_description'].'</td>'
                    .'<td>'.$fx->dateToWords($result['package_date_of_purchase']).'</td>'
                    .'</tr>';
            }
            $output .= '</table>';
        } else $output = 'There are no packages matching your keywords.';

        return $output;
    }



    public function renderPackageName ($package) {
        if ($package == null) return 'None';

        $p = $package;
        $packageName = $p['package_name'].' ('.$package['package_serial_no'].')';
        return $packageName;
    }

}
