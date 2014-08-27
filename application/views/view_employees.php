<?php

class view_employees {

    public function renderSearchResults ($datas) {
        if ($datas == null) return 'There are no employee matching your keyword.';

        $fx = new myFunctions();

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Job Position -- Description</th>'
            .'<th>Employed Date</th>'
            .'<th>Resignation / End of Contract Date</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-id="'.$d['person_id'].'" data-label="'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'">'
                .'<td>'
                    .$d['person_lastname'].', '
                    .$d['person_firstname'].' '
                    .$d['person_middlename'].' '
                    .$d['person_suffix']
                .'</td>'
                .'<td>'.$d['employee_job_label'].' -- '.$d['employee_job_description'].'</td>'
                .'<td>'.$fx->dateToWords($d['employee_employment_date']).'</td>'
                .'<td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }

}
